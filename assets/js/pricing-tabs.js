/**
 * Pricing tab toggle — WordPress replacement for the React `tab` state.
 *
 * Hooks (all within a [data-pricing-tabs] root):
 *   [data-pricing-tab="monthly|dropin"]   tab buttons; active gets `.is-active`
 *   [data-pricing-panel="monthly|dropin"] panels; active gets `.is-active`
 *   [data-pricing-goto="monthly|dropin"]  cross-links inside the notes
 *
 * Initial state comes from the server-rendered `.is-active` classes
 * (supports the template's forced_tab arg with no extra JS).
 */
(function () {
	'use strict';

	document.querySelectorAll('[data-pricing-tabs]').forEach(function (root) {
		function activate(name) {
			root.querySelectorAll('[data-pricing-tab]').forEach(function (btn) {
				btn.classList.toggle('is-active', btn.getAttribute('data-pricing-tab') === name);
			});
			root.querySelectorAll('[data-pricing-panel]').forEach(function (panel) {
				panel.classList.toggle('is-active', panel.getAttribute('data-pricing-panel') === name);
			});
		}

		root.querySelectorAll('[data-pricing-tab]').forEach(function (btn) {
			btn.addEventListener('click', function () {
				activate(btn.getAttribute('data-pricing-tab'));
			});
		});

		root.querySelectorAll('[data-pricing-goto]').forEach(function (btn) {
			btn.addEventListener('click', function () {
				activate(btn.getAttribute('data-pricing-goto'));
			});
		});
	});
})();
