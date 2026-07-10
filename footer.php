<?php
/**
 * The footer for the custom-theme theme.
 *
 * @package custom-theme
 */

$footer_logo      = get_field( 'footer_logo', 'option' );
$footer_columns   = get_field( 'footer_columns', 'option' );
$social_links     = get_field( 'footer_social_links', 'option' );
$copyright_text   = get_field( 'footer_copyright_text', 'option' );
$current_year     = gmdate( 'Y' );
$site_title       = get_bloginfo( 'name' );
?>

</main>

<footer class="site-footer bg-primary text-base">
	<div class="mx-auto max-w-7xl px-4 py-12 lg:px-8">

		<?php if ( $footer_logo || $footer_columns ) : ?>
			<div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
				<div class="footer-logo">
					<?php if ( $footer_logo ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<?php
							echo wp_get_attachment_image(
								$footer_logo,
								'medium',
								false,
								array(
									'class' => 'h-auto max-w-40',
									'alt'   => esc_attr( $site_title ),
								)
							);
							?>
						</a>
					<?php endif; ?>
				</div>

				<?php
				if ( $footer_columns ) :
					foreach ( $footer_columns as $footer_column ) :
						$column_title = $footer_column['column_title'] ?? '';
						$menu_id      = $footer_column['column_menu'] ?? '';
						?>

						<div class="footer-menu-column">
							<?php if ( $column_title ) : ?>
								<h2 class="mb-4 font-heading text-lg font-semibold text-heading">
									<?php echo esc_html( $column_title ); ?>
								</h2>
							<?php endif; ?>

							<?php
							if ( $menu_id ) {
								wp_nav_menu(
									array(
										'menu'           => $menu_id,
										'container'      => false,
										'menu_class'     => 'space-y-2 text-sm',
										'fallback_cb'    => false,
										'depth'          => 1,
									)
								);
							}
							?>
						</div>

						<?php
					endforeach;
				endif;
				?>
			</div>
		<?php endif; ?>

		<div class="mt-10 border-t border-white/20 pt-6 md:flex md:items-center md:justify-between">
			<?php if ( $social_links ) : ?>
				<ul class="mb-6 flex items-center gap-4 md:mb-0">
					<?php foreach ( $social_links as $social_link ) : ?>
						<?php
						$icon = $social_link['icon_code'] ?? '';
						$url  = $social_link['url'] ?? '';
						?>

						<?php if ( $icon && $url ) : ?>
							<li>
								<a
									class="inline-flex size-10 items-center justify-center rounded-full border border-white/30 transition hover:bg-white/10"
									href="<?php echo esc_url( $url ); ?>"
									target="_blank"
									rel="noopener noreferrer"
								>
									<span class="sr-only">
										<?php esc_html_e( 'Social media link', 'custom-theme' ); ?>
									</span>

									<?php echo wp_kses_post( $icon ); ?>
								</a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<p class="text-sm">
				<?php
				if ( $copyright_text ) {
					echo esc_html(
						str_replace(
							array( '{year}', '{site_title}' ),
							array( $current_year, $site_title ),
							$copyright_text
						)
					);
				} else {
					printf(
						esc_html__( '© %1$s %2$s. All rights reserved.', 'custom-theme' ),
						esc_html( $current_year ),
						esc_html( $site_title )
					);
				}
				?>
			</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>