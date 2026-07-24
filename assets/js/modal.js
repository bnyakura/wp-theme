/**
 * Modal controller — WordPress replacement for the React ModalContext.
 *
 * Contract:
 *   Trigger: <button data-modal-open="enlist-modal">…</button>
 *   Modal:   <div data-modal="enlist-modal">…<button data-modal-close>×</button>…</div>
 *
 * The open state is the `.is-open` class on the [data-modal] element.
 * Body scroll is locked while a modal is open, exactly like the old
 * openModal()/closeModal() in ModalContext.
 */
(function () {
	'use strict';

	function openModal(modal) {
		modal.classList.add('is-open');
		document.body.style.overflow = 'hidden';
	}

	function closeModal(modal) {
		modal.classList.remove('is-open');
		document.body.style.overflow = '';
	}

	document.addEventListener('click', function (event) {
		var opener = event.target.closest('[data-modal-open]');
		if (opener) {
			var modal = document.querySelector(
				'[data-modal="' + opener.getAttribute('data-modal-open') + '"]'
			);
			if (modal) {
				openModal(modal);
			}
			return;
		}

		var closer = event.target.closest('[data-modal-close]');
		if (closer) {
			var parent = closer.closest('[data-modal]');
			if (parent) {
				closeModal(parent);
			}
			return;
		}

		// Click directly on the backdrop closes the modal.
		if (event.target.matches('[data-modal].is-open')) {
			closeModal(event.target);
		}
	});

	document.addEventListener('keydown', function (event) {
		if (event.key === 'Escape') {
			document.querySelectorAll('[data-modal].is-open').forEach(closeModal);
		}
	});
})();
