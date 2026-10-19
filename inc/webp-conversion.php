<?php
/**
 * WebP image conversion.
 *
 * Two features:
 *
 *   1. Auto-convert on upload — new JPEG/PNG uploads are replaced with a WebP
 *      version before the attachment and its thumbnails are generated, so the
 *      whole media library stays WebP going forward.
 *
 *   2. Bulk "Convert existing images" button (Customize → WebP Conversion) —
 *      scans the media library, converts every remaining JPEG/PNG (original +
 *      all registered thumbnail sizes) to WebP, rewrites references to the old
 *      URLs in post content and post meta, and moves the originals to
 *      uploads/_webp-backup/ so the operation is reversible.
 *
 * Encoder backends, tried in this order (first one that can produce WebP wins):
 *   GD (imagewebp)  →  Imagick  →  cwebp binary  →  ImageMagick `convert`.
 *
 * On this XAMPP box GD/Imagick were compiled WITHOUT WebP, so it falls through
 * to the system ImageMagick `convert` binary (which has libwebp). On a normal
 * host with WebP-enabled GD it uses that instead — no config needed.
 *
 * @package custom-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------------------------
 * Settings helpers
 * ---------------------------------------------------------------------- */

/**
 * Whether new uploads should be auto-converted to WebP.
 *
 * @return bool
 */
function cilla_skyn_webp_auto_enabled(): bool {
	return (bool) get_theme_mod( 'cilla_skyn_webp_auto', true );
}

/**
 * The configured WebP quality (1–100), clamped. Default 82.
 *
 * @return int
 */
function cilla_skyn_webp_quality(): int {
	$q = (int) get_theme_mod( 'cilla_skyn_webp_quality', 82 );

	return max( 1, min( 100, $q ) );
}

/**
 * Source MIME types we convert. (GIF is skipped to preserve animation.)
 *
 * @return string[]
 */
function cilla_skyn_webp_source_mimes(): array {
	return array( 'image/jpeg', 'image/png' );
}

/* -------------------------------------------------------------------------
 * Encoder backend detection + encoding
 * ---------------------------------------------------------------------- */

/**
 * Locate an executable (cwebp / convert) on disk.
 *
 * Checks common install paths and lets a host override the path with a
 * `cilla_skyn_webp_<name>_bin` filter. Returns '' when not found.
 *
 * @param string $name Binary name, e.g. 'cwebp' or 'convert'.
 * @return string Absolute path, or ''.
 */
function cilla_skyn_webp_find_binary( string $name ): string {
	$override = apply_filters( "cilla_skyn_webp_{$name}_bin", '' );
	if ( $override && @is_executable( $override ) ) {
		return $override;
	}

	$candidates = array(
		'/usr/bin/' . $name,
		'/usr/local/bin/' . $name,
		'/opt/homebrew/bin/' . $name,
		'/bin/' . $name,
	);

	foreach ( $candidates as $path ) {
		if ( @is_executable( $path ) ) {
			return $path;
		}
	}

	return '';
}

/**
 * Whether a given CLI binary backend is usable (binary found + exec() allowed).
 *
 * @param string $name 'cwebp' or 'convert'.
 * @return string Binary path if usable, else ''.
 */
function cilla_skyn_webp_usable_binary( string $name ): string {
	static $exec_ok = null;

	if ( null === $exec_ok ) {
		$disabled = array_map( 'trim', explode( ',', (string) ini_get( 'disable_functions' ) ) );
		$exec_ok  = function_exists( 'exec' ) && ! in_array( 'exec', $disabled, true );
	}

	if ( ! $exec_ok ) {
		return '';
	}

	return cilla_skyn_webp_find_binary( $name );
}

/**
 * Detect the active encoder backend.
 *
 * @return array{id:string,bin:string,label:string} id is '' when none works.
 */
function cilla_skyn_webp_backend(): array {
	static $backend = null;

	if ( null !== $backend ) {
		return $backend;
	}

	// 1. GD with WebP support.
	if ( function_exists( 'imagewebp' ) ) {
		$backend = array(
			'id'    => 'gd',
			'bin'   => '',
			'label' => 'PHP GD (imagewebp)',
		);
		return $backend;
	}

	// 2. Imagick with WebP support.
	if ( class_exists( 'Imagick' ) ) {
		try {
			if ( ! empty( Imagick::queryFormats( 'WEBP' ) ) ) {
				$backend = array(
					'id'    => 'imagick',
					'bin'   => '',
					'label' => 'PHP Imagick',
				);
				return $backend;
			}
		} catch ( \Throwable $e ) {
			// Fall through.
		}
	}

	// 3. cwebp binary.
	$bin = cilla_skyn_webp_usable_binary( 'cwebp' );
	if ( $bin ) {
		$backend = array(
			'id'    => 'cwebp',
			'bin'   => $bin,
			'label' => 'cwebp binary (' . $bin . ')',
		);
		return $backend;
	}

	// 4. ImageMagick `convert` binary.
	$bin = cilla_skyn_webp_usable_binary( 'convert' );
	if ( $bin ) {
		$backend = array(
			'id'    => 'convert',
			'bin'   => $bin,
			'label' => 'ImageMagick convert binary (' . $bin . ')',
		);
		return $backend;
	}

	// Nothing available.
	$backend = array(
		'id'    => '',
		'bin'   => '',
		'label' => 'No WebP encoder available',
	);
	return $backend;
}

/**
 * Whether the server can produce WebP at all.
 *
 * @return bool
 */
function cilla_skyn_webp_can_convert(): bool {
	return '' !== cilla_skyn_webp_backend()['id'];
}

/**
 * Encode a source image to WebP using the active backend.
 *
 * @param string $src     Absolute path to the source JPEG/PNG.
 * @param string $dest    Absolute destination path (…\.webp).
 * @param int    $quality 1–100.
 * @return bool True on success.
 */
function cilla_skyn_webp_encode( string $src, string $dest, int $quality ): bool {
	if ( ! is_readable( $src ) ) {
		return false;
	}

	$quality = max( 1, min( 100, $quality ) );
	$backend = cilla_skyn_webp_backend();

	switch ( $backend['id'] ) {
		case 'gd':
			$ok = cilla_skyn_webp_encode_gd( $src, $dest, $quality );
			break;
		case 'imagick':
			$ok = cilla_skyn_webp_encode_imagick( $src, $dest, $quality );
			break;
		case 'cwebp':
			$cmd = escapeshellarg( $backend['bin'] ) . ' -quiet -q ' . (int) $quality
				. ' ' . escapeshellarg( $src ) . ' -o ' . escapeshellarg( $dest ) . ' 2>&1';
			$ok  = cilla_skyn_webp_exec( $cmd, $dest );
			break;
		case 'convert':
			$cmd = escapeshellarg( $backend['bin'] ) . ' ' . escapeshellarg( $src )
				. ' -quality ' . (int) $quality . ' ' . escapeshellarg( 'webp:' . $dest ) . ' 2>&1';
			$ok  = cilla_skyn_webp_exec( $cmd, $dest );
			break;
		default:
			$ok = false;
	}

	if ( ! $ok && file_exists( $dest ) && 0 === @filesize( $dest ) ) {
		@unlink( $dest ); // Clean up a zero-byte failure.
	}

	return $ok;
}

/**
 * Run an encoder command and verify it produced a non-empty file.
 *
 * @param string $cmd  Full shell command (already escaped).
 * @param string $dest Expected output path.
 * @return bool
 */
function cilla_skyn_webp_exec( string $cmd, string $dest ): bool {
	$output = array();
	$return = 1;
	@exec( $cmd, $output, $return );

	return 0 === $return && file_exists( $dest ) && @filesize( $dest ) > 0;
}

/**
 * GD encoder (used only when imagewebp() exists).
 *
 * @param string $src     Source path.
 * @param string $dest    Destination path.
 * @param int    $quality 1–100.
 * @return bool
 */
function cilla_skyn_webp_encode_gd( string $src, string $dest, int $quality ): bool {
	$info = @getimagesize( $src );
	if ( ! $info ) {
		return false;
	}

	switch ( $info['mime'] ) {
		case 'image/jpeg':
			$image = @imagecreatefromjpeg( $src );
			break;
		case 'image/png':
			$image = @imagecreatefrompng( $src );
			if ( $image ) {
				imagepalettetotruecolor( $image );
				imagealphablending( $image, false );
				imagesavealpha( $image, true );
			}
			break;
		default:
			return false;
	}

	if ( ! $image ) {
		return false;
	}

	$ok = imagewebp( $image, $dest, $quality );
	imagedestroy( $image );

	return $ok && file_exists( $dest );
}

/**
 * Imagick encoder (used only when Imagick supports WEBP).
 *
 * @param string $src     Source path.
 * @param string $dest    Destination path.
 * @param int    $quality 1–100.
 * @return bool
 */
function cilla_skyn_webp_encode_imagick( string $src, string $dest, int $quality ): bool {
	try {
		$im = new Imagick( $src );
		$im->setImageFormat( 'webp' );
		$im->setImageCompressionQuality( $quality );
		$im->setOption( 'webp:method', '6' );
		$ok = $im->writeImage( $dest );
		$im->clear();
		$im->destroy();

		return $ok && file_exists( $dest );
	} catch ( \Throwable $e ) {
		return false;
	}
}

/* -------------------------------------------------------------------------
 * Feature 1 — auto-convert new uploads
 * ---------------------------------------------------------------------- */

/**
 * Convert a new upload to WebP after WordPress has generated its thumbnails.
 *
 * We hook metadata generation (not wp_handle_upload) deliberately: WordPress's
 * image editor builds every thumbnail size in the ORIGINAL format first — a
 * format it can always read — and only then do we re-encode the original and
 * each size to WebP with cilla_skyn_webp_encode(). That keeps thumbnail
 * generation working even where PHP's GD/Imagick can't handle WebP and we fall
 * back to the ImageMagick binary (as on this server).
 *
 * @param array $metadata      Attachment metadata (sizes already generated).
 * @param int   $attachment_id Attachment ID.
 * @return array Modified (or original) metadata.
 */
function cilla_skyn_webp_on_generate_metadata( $metadata, $attachment_id ) {
	if ( ! cilla_skyn_webp_auto_enabled() || ! cilla_skyn_webp_can_convert() ) {
		return $metadata;
	}
	if ( ! in_array( get_post_mime_type( $attachment_id ), cilla_skyn_webp_source_mimes(), true ) ) {
		return $metadata;
	}

	// New upload: no references exist yet, so skip the (expensive) rewrite.
	$result = cilla_skyn_webp_convert_meta( (int) $attachment_id, (array) $metadata, false );

	return is_wp_error( $result ) ? $metadata : $result;
}
add_filter( 'wp_generate_attachment_metadata', 'cilla_skyn_webp_on_generate_metadata', 20, 2 );

/* -------------------------------------------------------------------------
 * Feature 2 — bulk convert existing images
 * ---------------------------------------------------------------------- */

/**
 * Number of attachments converted per AJAX batch. Conversions regenerate all
 * thumbnail sizes + rewrite references, so keep batches small.
 *
 * @return int
 */
function cilla_skyn_webp_batch_size(): int {
	return (int) apply_filters( 'cilla_skyn_webp_batch_size', 4 );
}

/**
 * Build the WP_Query args that match "still-convertible" attachments:
 * JPEG/PNG images that haven't previously failed.
 *
 * @param int $limit posts_per_page.
 * @param bool $count_mode When true, configures the query to expose found_posts.
 * @return array
 */
function cilla_skyn_webp_query_args( int $limit, bool $count_mode = false ): array {
	return array(
		'post_type'              => 'attachment',
		'post_status'            => 'inherit',
		'post_mime_type'         => cilla_skyn_webp_source_mimes(),
		'posts_per_page'         => $limit,
		'fields'                 => 'ids',
		'orderby'                => 'ID',
		'order'                  => 'ASC',
		'no_found_rows'          => ! $count_mode,
		'update_post_term_cache' => false,
		// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- one-off admin tool.
		'meta_query'             => array(
			array(
				'key'     => '_cilla_webp_failed',
				'compare' => 'NOT EXISTS',
			),
		),
	);
}

/**
 * How many convertible images remain.
 *
 * @return int
 */
function cilla_skyn_webp_remaining_count(): int {
	$q = new WP_Query( cilla_skyn_webp_query_args( 1, true ) );

	return (int) $q->found_posts;
}

/**
 * Convert a single existing attachment to WebP (bulk-tool entry point).
 *
 * @param int $attachment_id Attachment post ID.
 * @return true|WP_Error
 */
function cilla_skyn_webp_convert_attachment( int $attachment_id ) {
	$mime = get_post_mime_type( $attachment_id );
	if ( ! in_array( $mime, cilla_skyn_webp_source_mimes(), true ) ) {
		return new WP_Error( 'skip', __( 'Not a convertible image.', 'cilla-skyn' ) );
	}

	$meta   = wp_get_attachment_metadata( $attachment_id );
	$result = cilla_skyn_webp_convert_meta( $attachment_id, is_array( $meta ) ? $meta : array(), true );

	if ( is_wp_error( $result ) ) {
		return $result;
	}

	wp_update_attachment_metadata( $attachment_id, $result );

	return true;
}

/**
 * Re-encode an attachment's original file and every already-generated
 * thumbnail size to WebP, repoint the attachment, back up the source files,
 * and (optionally) rewrite references.
 *
 * Never invokes WordPress's image editor on WebP: it only re-encodes the
 * existing JPEG/PNG size files that the editor already produced, so it works
 * regardless of whether GD/Imagick support WebP.
 *
 * Returns the updated metadata array (the caller decides whether to persist it
 * — the upload filter returns it to core, the bulk tool saves it itself).
 *
 * @param int   $attachment_id Attachment ID.
 * @param array $meta          Current/in-flight attachment metadata.
 * @param bool  $rewrite_refs  Whether to rewrite old-URL references in content/meta.
 * @return array|WP_Error Updated metadata, or WP_Error on failure.
 */
function cilla_skyn_webp_convert_meta( int $attachment_id, array $meta, bool $rewrite_refs = true ) {
	if ( ! cilla_skyn_webp_can_convert() ) {
		return new WP_Error( 'no_backend', __( 'No WebP encoder is available on this server.', 'cilla-skyn' ) );
	}

	$old_file = get_attached_file( $attachment_id );
	if ( ! $old_file || ! is_readable( $old_file ) ) {
		return new WP_Error( 'missing', __( 'Source file is missing on disk.', 'cilla-skyn' ) );
	}

	$dir     = dirname( $old_file );
	$uploads = wp_get_upload_dir();
	$quality = cilla_skyn_webp_quality();

	// 1. Convert the original / full-size file. The .webp keeps the source's
	// exact base name (just a new extension) so reference rewriting is a clean
	// .jpg/.png -> .webp swap. Source base names are already unique, so the
	// sibling is unique too; we don't use wp_unique_filename (it would append a
	// "-1" because the same-base source file still exists at this moment).
	$full_name = pathinfo( $old_file, PATHINFO_FILENAME ) . '.webp';
	$full_webp = trailingslashit( $dir ) . $full_name;

	if ( ! cilla_skyn_webp_encode( $old_file, $full_webp, $quality ) ) {
		return new WP_Error( 'encode_failed', __( 'The encoder could not produce a WebP file.', 'cilla-skyn' ) );
	}

	$backup = array( $old_file );

	// 2. Re-encode each already-generated thumbnail size in place.
	if ( ! empty( $meta['sizes'] ) && is_array( $meta['sizes'] ) ) {
		foreach ( $meta['sizes'] as $name => $size ) {
			if ( empty( $size['file'] ) ) {
				continue;
			}
			$size_src = trailingslashit( $dir ) . $size['file'];
			if ( ! is_readable( $size_src ) ) {
				continue;
			}

			$size_name = pathinfo( $size_src, PATHINFO_FILENAME ) . '.webp';
			$size_webp = trailingslashit( $dir ) . $size_name;

			if ( cilla_skyn_webp_encode( $size_src, $size_webp, $quality ) ) {
				$backup[]                            = $size_src;
				$meta['sizes'][ $name ]['file']      = $size_name;
				$meta['sizes'][ $name ]['mime-type'] = 'image/webp';
			}
		}
	}

	// 3. The un-scaled original (big-image uploads) becomes an orphan too.
	if ( ! empty( $meta['original_image'] ) ) {
		$backup[] = trailingslashit( $dir ) . $meta['original_image'];
		unset( $meta['original_image'] );
	}

	// 4. Repoint the attachment at the WebP original + fix its MIME type.
	$new_relative = _wp_relative_upload_path( $full_webp );
	$meta['file'] = $new_relative;
	update_attached_file( $attachment_id, $full_webp );
	wp_update_post(
		array(
			'ID'             => $attachment_id,
			'post_mime_type' => 'image/webp',
			'guid'           => trailingslashit( $uploads['baseurl'] ) . $new_relative,
		)
	);

	// 5. Rewrite URL references (existing images only — new uploads have none).
	if ( $rewrite_refs ) {
		cilla_skyn_webp_rewrite_references( $old_file );
	}

	// 6. Back up + remove the orphaned source files.
	cilla_skyn_webp_backup_files( array_unique( $backup ), $uploads['basedir'] );

	update_post_meta( $attachment_id, '_cilla_webp_converted', time() );

	return $meta;
}

/**
 * Move a list of now-orphaned source files into uploads/_webp-backup/,
 * preserving their year/month subpath, then remove them from the live tree.
 *
 * @param string[] $files    Absolute file paths.
 * @param string   $basedir  Uploads base directory.
 * @return void
 */
function cilla_skyn_webp_backup_files( array $files, string $basedir ): void {
	$backup_root = trailingslashit( $basedir ) . '_webp-backup';

	foreach ( $files as $file ) {
		if ( ! $file || ! file_exists( $file ) ) {
			continue;
		}

		// Relative path inside uploads, e.g. 2026/09/image.jpg.
		$relative = ltrim( str_replace( $basedir, '', $file ), '/\\' );
		$target   = trailingslashit( $backup_root ) . $relative;

		wp_mkdir_p( dirname( $target ) );

		if ( ! @rename( $file, $target ) ) {
			// If the move failed but we have a copy elsewhere, drop the orphan.
			@unlink( $file );
		}
	}
}

/**
 * Rewrite references to a converted image's old URLs (full size + every
 * -WxH size) so they point at the new .webp files.
 *
 * Operates host/scheme-agnostically by matching the uploads-relative path
 * fragment. Post content is updated as a plain string; post meta is handled
 * serialization-safely (unserialize → walk → let core re-serialize).
 *
 * @param string $old_file Absolute path of the pre-conversion original.
 * @return void
 */
function cilla_skyn_webp_rewrite_references( string $old_file ): void {
	global $wpdb;

	$uploads   = wp_get_upload_dir();
	$base_path = wp_parse_url( $uploads['baseurl'], PHP_URL_PATH ); // e.g. /wp-content/uploads
	$relative  = ltrim( str_replace( $uploads['basedir'], '', $old_file ), '/\\' );
	$rel_noext = preg_replace( '/\.(jpe?g|png)$/i', '', $relative );

	// e.g. /wp-content/uploads/2026/09/image  (no extension, no size suffix).
	$fragment = rtrim( (string) $base_path, '/' ) . '/' . $rel_noext;

	// Matches the full size and every -WxH size of THIS image only.
	$pattern = '#' . preg_quote( $fragment, '#' ) . '(-\d+x\d+)?\.(?:jpe?g|png)#i';
	$replace = static function ( array $m ) use ( $fragment ): string {
		return $fragment . ( $m[1] ?? '' ) . '.webp';
	};

	$like = '%' . $wpdb->esc_like( $fragment ) . '%';

	// --- Post content + excerpts (not serialized; safe plain update). ---
	$posts = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT ID, post_content, post_excerpt FROM {$wpdb->posts}
			 WHERE post_content LIKE %s OR post_excerpt LIKE %s",
			$like,
			$like
		)
	);

	foreach ( $posts as $post ) {
		$new_content = preg_replace_callback( $pattern, $replace, (string) $post->post_content );
		$new_excerpt = preg_replace_callback( $pattern, $replace, (string) $post->post_excerpt );

		if ( $new_content !== $post->post_content || $new_excerpt !== $post->post_excerpt ) {
			wp_update_post(
				array(
					'ID'           => (int) $post->ID,
					'post_content' => wp_slash( $new_content ),
					'post_excerpt' => wp_slash( $new_excerpt ),
				)
			);
		}
	}

	// --- Post meta (may be serialized; walk the structure, never the bytes). ---
	$rows = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT meta_id, meta_value FROM {$wpdb->postmeta} WHERE meta_value LIKE %s",
			$like
		)
	);

	foreach ( $rows as $row ) {
		$value   = maybe_unserialize( $row->meta_value );
		$updated = cilla_skyn_webp_deep_replace( $value, $pattern, $replace );

		if ( maybe_serialize( $updated ) !== maybe_serialize( $value ) ) {
			update_metadata_by_mid( 'post', $row->meta_id, $updated );
		}
	}
}

/**
 * Recursively apply a regex replacement to every string leaf of a value,
 * without touching serialized bytes (caller re-serializes via core).
 *
 * @param mixed    $data    Scalar, array, or object.
 * @param string   $pattern Regex pattern.
 * @param callable $replace preg_replace_callback callback.
 * @return mixed
 */
function cilla_skyn_webp_deep_replace( $data, string $pattern, callable $replace ) {
	if ( is_string( $data ) ) {
		return preg_replace_callback( $pattern, $replace, $data );
	}

	if ( is_array( $data ) ) {
		foreach ( $data as $key => $value ) {
			$data[ $key ] = cilla_skyn_webp_deep_replace( $value, $pattern, $replace );
		}
		return $data;
	}

	if ( is_object( $data ) ) {
		foreach ( get_object_vars( $data ) as $key => $value ) {
			$data->$key = cilla_skyn_webp_deep_replace( $value, $pattern, $replace );
		}
		return $data;
	}

	return $data;
}

/* -------------------------------------------------------------------------
 * AJAX — process one batch of existing images
 * ---------------------------------------------------------------------- */

/**
 * AJAX handler: convert the next batch of existing images.
 *
 * @return void Sends a JSON response.
 */
function cilla_skyn_webp_ajax_convert_batch(): void {
	check_ajax_referer( 'cilla_skyn_webp', 'nonce' );

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => __( 'You are not allowed to do this.', 'cilla-skyn' ) ), 403 );
	}

	if ( ! cilla_skyn_webp_can_convert() ) {
		wp_send_json_error( array( 'message' => __( 'No WebP encoder is available on this server.', 'cilla-skyn' ) ), 400 );
	}

	$is_init = ! empty( $_POST['init'] );
	$total   = $is_init ? cilla_skyn_webp_remaining_count() : (int) ( $_POST['total'] ?? 0 );

	$ids = ( new WP_Query( cilla_skyn_webp_query_args( cilla_skyn_webp_batch_size() ) ) )->posts;

	$log       = array();
	$converted = 0;
	$failed    = 0;

	foreach ( $ids as $id ) {
		$id     = (int) $id;
		$result = cilla_skyn_webp_convert_attachment( $id );

		if ( is_wp_error( $result ) ) {
			// Flag so this attachment is skipped next time (prevents an endless loop).
			update_post_meta( $id, '_cilla_webp_failed', $result->get_error_message() );
			++$failed;
			$log[] = sprintf(
				/* translators: 1: attachment ID, 2: error message. */
				__( '#%1$d — skipped: %2$s', 'cilla-skyn' ),
				$id,
				$result->get_error_message()
			);
		} else {
			++$converted;
			$log[] = sprintf(
				/* translators: %s: attachment title or ID. */
				__( '#%1$d — converted (%2$s)', 'cilla-skyn' ),
				$id,
				get_the_title( $id ) ?: __( 'untitled', 'cilla-skyn' )
			);
		}
	}

	$remaining = cilla_skyn_webp_remaining_count();

	wp_send_json_success(
		array(
			'total'     => $total,
			'remaining' => $remaining,
			'converted' => $converted,
			'failed'    => $failed,
			'done'      => empty( $ids ) || 0 === $remaining,
			'log'       => $log,
		)
	);
}
add_action( 'wp_ajax_cilla_skyn_webp_convert_batch', 'cilla_skyn_webp_ajax_convert_batch' );

/**
 * AJAX handler: clear the "failed" flags so previously failed images are retried.
 *
 * @return void
 */
function cilla_skyn_webp_ajax_reset_failed(): void {
	check_ajax_referer( 'cilla_skyn_webp', 'nonce' );

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => __( 'You are not allowed to do this.', 'cilla-skyn' ) ), 403 );
	}

	delete_post_meta_by_key( '_cilla_webp_failed' );

	wp_send_json_success( array( 'remaining' => cilla_skyn_webp_remaining_count() ) );
}
add_action( 'wp_ajax_cilla_skyn_webp_reset_failed', 'cilla_skyn_webp_ajax_reset_failed' );

/* -------------------------------------------------------------------------
 * Customizer — section, settings, and the "Convert existing images" button
 * ---------------------------------------------------------------------- */

/**
 * Register the WebP Conversion section, settings, and custom button control.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 * @return void
 */
function cilla_skyn_webp_customize_register( $wp_customize ): void {
	// Custom control: a button that bulk-converts existing images via AJAX.
	if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Cilla_Skyn_WebP_Button_Control' ) ) {
		/**
		 * Renders the bulk-convert button, progress bar, and log.
		 */
		class Cilla_Skyn_WebP_Button_Control extends WP_Customize_Control {
			/** @var string */
			public $type = 'cilla_skyn_webp_button';

			/**
			 * Render the control's content.
			 *
			 * @return void
			 */
			public function render_content() {
				$backend = cilla_skyn_webp_backend();
				$can     = '' !== $backend['id'];
				$remaining = cilla_skyn_webp_remaining_count();
				?>
				<span class="customize-control-title"><?php esc_html_e( 'Convert existing images', 'cilla-skyn' ); ?></span>
				<span class="description customize-control-description">
					<?php esc_html_e( 'Converts every JPEG/PNG in the Media Library (and all thumbnail sizes) to WebP, updates links in your content, and moves the originals to uploads/_webp-backup/ so it can be undone.', 'cilla-skyn' ); ?>
				</span>

				<p style="margin:.75em 0;">
					<strong><?php esc_html_e( 'Encoder:', 'cilla-skyn' ); ?></strong>
					<?php echo esc_html( $backend['label'] ); ?>
				</p>

				<?php if ( ! $can ) : ?>
					<p class="notice notice-error" style="padding:.5em .75em;">
						<?php esc_html_e( 'This server has no WebP encoder (no WebP-enabled GD/Imagick, and no cwebp/convert binary). Conversion is disabled.', 'cilla-skyn' ); ?>
					</p>
				<?php else : ?>
					<p>
						<button type="button" class="button button-primary" id="cilla-webp-convert">
							<?php esc_html_e( 'Convert existing images now', 'cilla-skyn' ); ?>
						</button>
						<button type="button" class="button-link" id="cilla-webp-reset" style="margin-left:.5em;">
							<?php esc_html_e( 'Retry failed', 'cilla-skyn' ); ?>
						</button>
					</p>
					<p id="cilla-webp-remaining" style="margin:.5em 0;">
						<?php
						printf(
							/* translators: %s: number of images. */
							esc_html__( 'Images still to convert: %s', 'cilla-skyn' ),
							'<strong>' . esc_html( (string) $remaining ) . '</strong>'
						);
						?>
					</p>
					<div id="cilla-webp-progress" style="display:none;background:#e5e5e5;border-radius:3px;overflow:hidden;height:16px;">
						<div id="cilla-webp-bar" style="height:100%;width:0;background:#2271b1;transition:width .25s;"></div>
					</div>
					<p id="cilla-webp-status" style="margin:.5em 0;font-weight:600;"></p>
					<pre id="cilla-webp-log" style="display:none;max-height:180px;overflow:auto;background:#1e1e1e;color:#e0e0e0;padding:.6em;font-size:11px;line-height:1.5;border-radius:3px;"></pre>
				<?php endif; ?>
				<?php
			}
		}
	}

	$wp_customize->add_section(
		'cilla_skyn_webp',
		array(
			'title'       => __( 'WebP Conversion', 'cilla-skyn' ),
			'description' => __( 'Serve lighter, faster images. New uploads can be auto-converted to WebP, and you can bulk-convert everything already in the Media Library.', 'cilla-skyn' ),
			'priority'    => 210,
		)
	);

	$wp_customize->add_setting(
		'cilla_skyn_webp_auto',
		array(
			'default'           => true,
			'sanitize_callback' => 'rest_sanitize_boolean',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'cilla_skyn_webp_auto',
		array(
			'label'       => __( 'Auto-convert new uploads to WebP', 'cilla-skyn' ),
			'description' => __( 'When on, any JPEG or PNG you upload is replaced with a WebP version automatically.', 'cilla-skyn' ),
			'section'     => 'cilla_skyn_webp',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'cilla_skyn_webp_quality',
		array(
			'default'           => 82,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'cilla_skyn_webp_quality',
		array(
			'label'       => __( 'WebP quality (1–100)', 'cilla-skyn' ),
			'description' => __( 'Higher = better quality but larger files. 82 is a good balance.', 'cilla-skyn' ),
			'section'     => 'cilla_skyn_webp',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 1,
				'max'  => 100,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_control(
		new Cilla_Skyn_WebP_Button_Control(
			$wp_customize,
			'cilla_skyn_webp_bulk',
			array(
				'section'  => 'cilla_skyn_webp',
				'settings' => array(), // Button only — no setting to store.
			)
		)
	);
}
add_action( 'customize_register', 'cilla_skyn_webp_customize_register' );

/**
 * Enqueue the Customizer control script that drives the bulk-convert button.
 *
 * @return void
 */
function cilla_skyn_webp_customize_assets(): void {
	$rel = '/assets/js/webp-customizer.js';
	$abs = get_template_directory() . $rel;

	if ( ! file_exists( $abs ) ) {
		return;
	}

	wp_enqueue_script(
		'cilla-skyn-webp-customizer',
		get_template_directory_uri() . $rel,
		array( 'jquery', 'customize-controls' ),
		filemtime( $abs ),
		true
	);

	wp_localize_script(
		'cilla-skyn-webp-customizer',
		'cillaSkynWebP',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'cilla_skyn_webp' ),
			'i18n'    => array(
				'working'   => __( 'Converting…', 'cilla-skyn' ),
				'done'      => __( 'Done.', 'cilla-skyn' ),
				'doneCount' => __( 'Finished: %1$d converted, %2$d skipped.', 'cilla-skyn' ),
				'error'     => __( 'Something went wrong. Check the log below.', 'cilla-skyn' ),
				'remaining' => __( 'Images still to convert: %s', 'cilla-skyn' ),
				'confirm'   => __( 'Convert all JPEG/PNG images to WebP now? Originals are backed up to uploads/_webp-backup/.', 'cilla-skyn' ),
			),
		)
	);
}
add_action( 'customize_controls_enqueue_scripts', 'cilla_skyn_webp_customize_assets' );
