/**
 * WebP Conversion — Customizer control.
 *
 * Drives the "Convert existing images now" button: posts batches to
 * admin-ajax.php, loops until the Media Library is fully converted, and shows
 * a progress bar + log. See inc/webp-conversion.php.
 *
 * @package custom-theme
 */
( function ( $ ) {
	'use strict';

	var cfg = window.cillaSkynWebP || {};

	/**
	 * sprintf-lite: replaces %s / %1$d / %2$d placeholders in order.
	 *
	 * @param {string} tpl  Template string.
	 * @param {...*}   args Replacement values.
	 * @return {string}
	 */
	function format( tpl ) {
		var args = Array.prototype.slice.call( arguments, 1 );
		var i = 0;
		return String( tpl )
			.replace( /%(\d+)\$[ds]/g, function ( _, n ) {
				return args[ n - 1 ];
			} )
			.replace( /%[ds]/g, function () {
				return args[ i++ ];
			} );
	}

	$( function () {
		var $btn       = $( '#cilla-webp-convert' );
		var $reset     = $( '#cilla-webp-reset' );
		var $progress  = $( '#cilla-webp-progress' );
		var $bar       = $( '#cilla-webp-bar' );
		var $status    = $( '#cilla-webp-status' );
		var $log       = $( '#cilla-webp-log' );
		var $remaining = $( '#cilla-webp-remaining' );

		if ( ! $btn.length ) {
			return;
		}

		var totals = { converted: 0, failed: 0, total: 0 };

		/**
		 * Append one or more lines to the log pane.
		 *
		 * @param {string[]} lines Lines to append.
		 */
		function appendLog( lines ) {
			if ( ! lines || ! lines.length ) {
				return;
			}
			$log.show();
			$log.text( ( $log.text() ? $log.text() + '\n' : '' ) + lines.join( '\n' ) );
			$log.scrollTop( $log[ 0 ].scrollHeight );
		}

		/**
		 * Update the progress bar from totals.
		 *
		 * @param {number} remaining Remaining image count.
		 */
		function updateBar( remaining ) {
			if ( ! totals.total ) {
				return;
			}
			var done = Math.max( 0, totals.total - remaining );
			var pct  = Math.round( ( done / totals.total ) * 100 );
			$bar.css( 'width', pct + '%' );
		}

		/**
		 * Request + process the next batch, then recurse until done.
		 *
		 * @param {boolean} init True on the first request (asks server for the total).
		 */
		function runBatch( init ) {
			$.post( cfg.ajaxUrl, {
				action: 'cilla_skyn_webp_convert_batch',
				nonce: cfg.nonce,
				init: init ? 1 : 0,
				total: totals.total
			} )
				.done( function ( res ) {
					if ( ! res || ! res.success ) {
						$status.text( ( res && res.data && res.data.message ) || cfg.i18n.error );
						appendLog( [ ( res && res.data && res.data.message ) || cfg.i18n.error ] );
						finish();
						return;
					}

					var d = res.data;
					if ( init ) {
						totals.total = d.total;
					}
					totals.converted += d.converted;
					totals.failed    += d.failed;

					appendLog( d.log );
					updateBar( d.remaining );
					$remaining.html( format( cfg.i18n.remaining, '<strong>' + d.remaining + '</strong>' ) );

					if ( d.done ) {
						finish();
					} else {
						runBatch( false );
					}
				} )
				.fail( function () {
					$status.text( cfg.i18n.error );
					finish();
				} );
		}

		/**
		 * Reset the UI to its finished state.
		 */
		function finish() {
			$bar.css( 'width', '100%' );
			$status.text(
				format( cfg.i18n.doneCount, totals.converted, totals.failed )
			);
			$btn.prop( 'disabled', false ).text( $btn.data( 'label' ) );
		}

		$btn.on( 'click', function () {
			if ( ! window.confirm( cfg.i18n.confirm ) ) {
				return;
			}
			totals = { converted: 0, failed: 0, total: 0 };
			$btn.data( 'label', $btn.text() ).prop( 'disabled', true ).text( cfg.i18n.working );
			$progress.show();
			$bar.css( 'width', '0' );
			$log.hide().text( '' );
			$status.text( cfg.i18n.working );
			runBatch( true );
		} );

		$reset.on( 'click', function ( e ) {
			e.preventDefault();
			$.post( cfg.ajaxUrl, {
				action: 'cilla_skyn_webp_reset_failed',
				nonce: cfg.nonce
			} ).done( function ( res ) {
				if ( res && res.success ) {
					$remaining.html(
						format( cfg.i18n.remaining, '<strong>' + res.data.remaining + '</strong>' )
					);
					$status.text( '' );
				}
			} );
		} );
	} );
} )( jQuery );
