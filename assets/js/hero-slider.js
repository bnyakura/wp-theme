/**
 * Hero slider — WordPress replacement for the React Hero component's state.
 *
 * Hooks:
 *   [data-hero-slider]        root <section>, optional data-hero-interval (ms, default 6000)
 *   [data-hero-slide]         slide wrapper; active slide gets `.is-active`
 *   [data-hero-prev]/[data-hero-next]  arrow buttons
 *   [data-hero-dot]           dot buttons (index = DOM order); active gets `.is-active`
 *   [data-hero-progress]      progress wrapper (hidden while paused)
 *   [data-hero-progress-fill] fill bar, animated via `animate-slide-progress`
 *
 * Behaviour mirrors the original React component: 6s autoplay, pause on
 * hover (progress bar unmounts → restarts fresh on resume), swipe with a
 * 40px threshold, wrap-around navigation.
 */
(function () {
	'use strict';

	document.querySelectorAll('[data-hero-slider]').forEach(function (root) {
		var slides = Array.prototype.slice.call(root.querySelectorAll('[data-hero-slide]'));
		var dots = Array.prototype.slice.call(root.querySelectorAll('[data-hero-dot]'));
		var prev = root.querySelector('[data-hero-prev]');
		var next = root.querySelector('[data-hero-next]');
		var progress = root.querySelector('[data-hero-progress]');
		var fill = progress ? progress.querySelector('[data-hero-progress-fill]') : null;

		if (!slides.length) {
			return;
		}

		var interval = parseInt(root.getAttribute('data-hero-interval'), 10) || 6000;
		var active = 0;
		var timer = null;
		var touchStartX = 0;

		function restartProgress() {
			if (!fill) {
				return;
			}
			fill.classList.remove('animate-slide-progress');
			void fill.offsetWidth; // force reflow so the animation restarts at 0
			fill.classList.add('animate-slide-progress');
		}

		function render() {
			slides.forEach(function (slide, i) {
				slide.classList.toggle('is-active', i === active);
			});
			dots.forEach(function (dot, i) {
				dot.classList.toggle('is-active', i === active);
			});
			restartProgress();
		}

		function goTo(i) {
			active = ((i % slides.length) + slides.length) % slides.length;
			render();
		}

		function start() {
			stop();
			timer = window.setInterval(function () {
				goTo(active + 1);
			}, interval);
			if (progress) {
				progress.classList.remove('hidden');
			}
			restartProgress();
		}

		function stop() {
			if (timer) {
				window.clearInterval(timer);
				timer = null;
			}
			if (progress) {
				progress.classList.add('hidden');
			}
		}

		root.addEventListener('mouseenter', stop);
		root.addEventListener('mouseleave', start);

		if (prev) {
			prev.addEventListener('click', function () {
				goTo(active - 1);
			});
		}
		if (next) {
			next.addEventListener('click', function () {
				goTo(active + 1);
			});
		}

		dots.forEach(function (dot, i) {
			dot.addEventListener('click', function () {
				goTo(i);
			});
		});

		root.addEventListener('touchstart', function (event) {
			touchStartX = event.touches[0].clientX;
		}, { passive: true });

		root.addEventListener('touchend', function (event) {
			var delta = touchStartX - event.changedTouches[0].clientX;
			if (Math.abs(delta) > 40) {
				goTo(active + (delta > 0 ? 1 : -1));
			}
		}, { passive: true });

		render();
		start();
	});
})();
