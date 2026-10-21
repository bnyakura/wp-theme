/**
 * Cilla Skyn Best Sellers slider — arrow buttons + optional autoplay for the
 * block's "Display as Slider" layout. The row itself is a native CSS
 * overflow-x + scroll-snap track (see the --slider rules in src/input.css);
 * this only adds click-to-slide arrows and auto-advance on top, so the row
 * still scrolls and swipes natively if the script never runs.
 *
 * Hooks (emitted by blocks/cilla-skyn-best-sellers/render.php):
 *   [data-cs-slider]                 root <section> of a slider-mode block
 *   [data-cs-slider-prev]/[-next]    arrow buttons (optional)
 *   [data-cs-slider-autoplay]        present when Auto Slide is on
 *   [data-cs-slider-interval]        autoplay interval in ms (default 4000)
 *
 * The scroll track is WooCommerce's own `ul.products` inside the section.
 * Autoplay pauses on hover and during touch, and both arrows and autoplay
 * wrap around at the ends.
 */
(function () {
	'use strict';

	document.querySelectorAll('[data-cs-slider]').forEach(function (root) {
		var track = root.querySelector('ul.products');
		if (!track) {
			return;
		}

		var prev = root.querySelector('[data-cs-slider-prev]');
		var next = root.querySelector('[data-cs-slider-next]');

		// One card plus its gap — measured from the live layout so it stays
		// correct across breakpoints and the editor's Column Spacing value.
		function step() {
			var items = track.querySelectorAll('li.product');
			if (items.length > 1) {
				return items[1].offsetLeft - items[0].offsetLeft;
			}
			return items.length ? items[0].offsetWidth : track.clientWidth;
		}

		function atStart() {
			return track.scrollLeft <= 2;
		}

		function atEnd() {
			return track.scrollLeft + track.clientWidth >= track.scrollWidth - 2;
		}

		function slideNext() {
			if (atEnd()) {
				track.scrollTo({ left: 0, behavior: 'smooth' });
			} else {
				track.scrollBy({ left: step(), behavior: 'smooth' });
			}
		}

		function slidePrev() {
			if (atStart()) {
				track.scrollTo({ left: track.scrollWidth, behavior: 'smooth' });
			} else {
				track.scrollBy({ left: -step(), behavior: 'smooth' });
			}
		}

		if (prev) {
			prev.addEventListener('click', slidePrev);
		}
		if (next) {
			next.addEventListener('click', slideNext);
		}

		if (root.hasAttribute('data-cs-slider-autoplay')) {
			var interval = parseInt(root.getAttribute('data-cs-slider-interval'), 10) || 4000;
			var timer = null;

			function startAuto() {
				stopAuto();
				timer = window.setInterval(slideNext, interval);
			}

			function stopAuto() {
				if (timer) {
					window.clearInterval(timer);
					timer = null;
				}
			}

			root.addEventListener('mouseenter', stopAuto);
			root.addEventListener('mouseleave', startAuto);
			track.addEventListener('touchstart', stopAuto, { passive: true });
			track.addEventListener('touchend', startAuto, { passive: true });

			startAuto();
		}
	});
})();
