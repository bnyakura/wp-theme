/**
 * Floating WhatsApp chat button (footer.php) — opens a small panel with a
 * textarea; on submit, builds a wa.me link from the form's
 * data-whatsapp-url (the configured WhatsApp number, no message) plus the
 * typed text, and opens it in a new tab. WhatsApp itself handles the
 * actual send from there — there's no server-side messaging here.
 */
(function () {
	'use strict';

	var toggle  = document.getElementById('whatsapp-chat-toggle');
	var panel   = document.getElementById('whatsapp-chat-panel');
	var closer  = document.getElementById('whatsapp-chat-close');
	var form    = document.getElementById('whatsapp-chat-form');
	var message = document.getElementById('whatsapp-chat-message');

	if (!toggle || !panel || !form || !message) {
		return;
	}

	function openPanel() {
		panel.hidden = false;
		toggle.setAttribute('aria-expanded', 'true');
		message.focus();
	}

	function closePanel() {
		panel.hidden = true;
		toggle.setAttribute('aria-expanded', 'false');
	}

	toggle.addEventListener('click', function () {
		if (panel.hidden) {
			openPanel();
		} else {
			closePanel();
		}
	});

	if (closer) {
		closer.addEventListener('click', closePanel);
	}

	document.addEventListener('keydown', function (event) {
		if (event.key === 'Escape' && !panel.hidden) {
			closePanel();
			toggle.focus();
		}
	});

	// Click outside the panel/toggle closes it, same as a normal dropdown.
	document.addEventListener('click', function (event) {
		if (panel.hidden) {
			return;
		}
		if (panel.contains(event.target) || toggle.contains(event.target)) {
			return;
		}
		closePanel();
	});

	form.addEventListener('submit', function (event) {
		event.preventDefault();

		var baseUrl = form.getAttribute('data-whatsapp-url');
		if (!baseUrl) {
			return;
		}

		var text = message.value.trim();
		var url  = text ? baseUrl + '?text=' + encodeURIComponent(text) : baseUrl;

		window.open(url, '_blank', 'noopener');
		message.value = '';
		closePanel();
	});
})();
