/**
 * Scroll-reveal — WordPress replacement for the React `.reveal` / `.active` hook.
 *
 * Elements with [data-reveal] start hidden (via Tailwind classes in the markup)
 * and get `.is-revealed` when they enter the viewport.
 */
(function () {
	'use strict';

	var els = document.querySelectorAll('[data-reveal]');

	if (!els.length) {
		return;
	}

	if (!('IntersectionObserver' in window)) {
		els.forEach(function (el) {
			el.classList.add('is-revealed');
		});
		return;
	}

	var observer = new IntersectionObserver(
		function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-revealed');
					observer.unobserve(entry.target);
				}
			});
		},
		{ threshold: 0.15 }
	);

	els.forEach(function (el) {
		observer.observe(el);
	});
})();
