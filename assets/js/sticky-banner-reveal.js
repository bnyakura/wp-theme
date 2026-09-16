/**
 * Cilla Skyn Sticky Banner — reveal-through-transparency once pinned, then
 * a clean hand-off once the pin releases.
 *
 * .cilla-skyn-sticky-banner-pin (blocks/cilla-skyn-sticky-banner/render.php)
 * is `position: sticky`. Two things need detecting, each via the standard
 * "sentinel" trick (a zero-footprint marker watched by IntersectionObserver
 * — the instant it scrolls out of view, something specific just happened):
 *
 * 1. .cilla-skyn-sticky-banner-sentinel sits at the pin's un-stuck (natural)
 *    position. Once it scrolls out of view, the pin must have just locked
 *    to the top of the viewport, so `.is-stuck` is added (style.css owns
 *    the opacity transition that triggers).
 *
 * 2. .cilla-skyn-sticky-banner-bottom-sentinel sits at the wrapper's own
 *    bottom edge — exactly where the pin duration ends. Once it scrolls
 *    out of view, `position: sticky` has released, but per spec the pin
 *    doesn't return to its original position; it settles flush against
 *    the *bottom* of its containing block, which (deliberately, so the
 *    next block on the page can overlap it while it's still stuck) is the
 *    same spot that next block has been pulled up to. Left alone, the
 *    released pin would sit there permanently, ghosting over that block's
 *    content indefinitely instead of handing off cleanly. `.is-past` forces
 *    it invisible at exactly that moment instead (style.css again).
 */
(function () {
	'use strict';

	var sections = document.querySelectorAll( '.wp-theme-cilla-skyn-sticky-banner' );

	if ( ! sections.length ) {
		return;
	}

	// Inside the Gutenberg block-editor iframe, scroll position doesn't
	// reflect the live site — leave every banner fully opaque and visible
	// there rather than guessing at a stuck/past state that doesn't apply.
	if ( document.body.classList.contains( 'block-editor-iframe__body' ) ) {
		return;
	}

	if ( ! ( 'IntersectionObserver' in window ) ) {
		return;
	}

	sections.forEach( function ( section ) {
		var sentinel = section.querySelector( '.cilla-skyn-sticky-banner-sentinel' );
		var bottomSentinel = section.querySelector( '.cilla-skyn-sticky-banner-bottom-sentinel' );
		var pin = section.querySelector( '.cilla-skyn-sticky-banner-pin' );

		if ( ! pin ) {
			return;
		}

		if ( sentinel ) {
			new IntersectionObserver(
				function ( entries ) {
					entries.forEach( function ( entry ) {
						pin.classList.toggle( 'is-stuck', ! entry.isIntersecting );
					} );
				},
				{ threshold: 0, rootMargin: '-1px 0px 0px 0px' }
			).observe( sentinel );
		}

		if ( bottomSentinel ) {
			new IntersectionObserver(
				function ( entries ) {
					entries.forEach( function ( entry ) {
						pin.classList.toggle( 'is-past', ! entry.isIntersecting );
					} );
				},
				{ threshold: 0, rootMargin: '-1px 0px 0px 0px' }
			).observe( bottomSentinel );
		}
	} );
})();
