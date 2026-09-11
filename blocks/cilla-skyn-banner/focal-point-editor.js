/**
 * Cilla Skyn Banner block — drag-and-drop focal point picker.
 *
 * Block-editor-only enhancement (enqueued by
 * inc/cilla-skyn-banner-focal-point.php on enqueue_block_editor_assets).
 * ACF has no built-in focal-point/crop-position field, so this overlays a
 * draggable crosshair directly on top of the block's own "Background Image
 * (Desktop)" image preview and drives the two plain "image_focal_x" /
 * "image_focal_y" ACF range fields underneath it -- dragging the crosshair
 * just sets those two range inputs' values and fires the same "input"
 * event a manual slider drag would, so render.php and ACF's own save
 * logic never need to know this overlay exists. The two sliders stay
 * fully usable on their own (e.g. on a touchscreen where dragging over the
 * small preview is fiddly), so this is a progressive enhancement, not the
 * only way to set the position.
 *
 * Relies on ACF's classic-admin field markup (.acf-field[data-key], an
 * .image-wrap containing img.image, input[type=range]) rather than a
 * formal ACF JS API -- ACF has no supported way to attach custom behaviour
 * to an existing field type from the outside, only to register a whole
 * new one. This structure has been stable across ACF 5.x/6.x.
 */
( function () {
	'use strict';

	var IMAGE_KEY = 'field_cilla_skyn_banner_background_image';
	var FOCAL_X_KEY = 'field_cilla_skyn_banner_image_focal_x';
	var FOCAL_Y_KEY = 'field_cilla_skyn_banner_image_focal_y';

	function fieldByKey( root, key ) {
		return root.querySelector( '.acf-field[data-key="' + key + '"]' );
	}

	function clamp( value, min, max ) {
		return Math.min( max, Math.max( min, value ) );
	}

	function setRangeValue( input, value ) {
		input.value = value;
		input.dispatchEvent( new Event( 'input', { bubbles: true } ) );
		input.dispatchEvent( new Event( 'change', { bubbles: true } ) );
	}

	function setUpFocalPicker( imageFieldEl ) {
		if ( imageFieldEl.dataset.cillaSkynFocalWired ) {
			return;
		}

		// The two range fields live in the same block instance's settings
		// form as the image field, under a shared .acf-fields ancestor.
		var blockFields = imageFieldEl.closest( '.acf-fields' ) || document;
		var xField = fieldByKey( blockFields, FOCAL_X_KEY );
		var yField = fieldByKey( blockFields, FOCAL_Y_KEY );
		var xInput = xField ? xField.querySelector( 'input[type="range"]' ) : null;
		var yInput = yField ? yField.querySelector( 'input[type="range"]' ) : null;

		if ( ! xInput || ! yInput ) {
			return; // Focal point fields aren't part of this field group -- nothing to drive.
		}

		imageFieldEl.dataset.cillaSkynFocalWired = '1';

		function attach() {
			var wrap = imageFieldEl.querySelector( '.image-wrap' );
			var img = wrap ? wrap.querySelector( 'img.image' ) : null;

			var existingOverlay = imageFieldEl.querySelector( '.cilla-skyn-focal-overlay' );
			if ( existingOverlay ) {
				existingOverlay.remove();
			}

			if ( ! wrap || ! img ) {
				return; // No image chosen yet -- nothing to drag over.
			}

			wrap.classList.add( 'cilla-skyn-focal-wrap' );

			var overlay = document.createElement( 'div' );
			overlay.className = 'cilla-skyn-focal-overlay';
			overlay.title = 'Drag to choose which part of the image stays in view';

			var marker = document.createElement( 'div' );
			marker.className = 'cilla-skyn-focal-marker';
			overlay.appendChild( marker );
			wrap.appendChild( overlay );

			function positionMarker() {
				var x = clamp( parseFloat( xInput.value ) || 0, 0, 100 );
				var y = clamp( parseFloat( yInput.value ) || 0, 0, 100 );
				marker.style.left = x + '%';
				marker.style.top = y + '%';
			}
			positionMarker();

			function updateFromEvent( event ) {
				var rect = overlay.getBoundingClientRect();
				var point = event.touches ? event.touches[ 0 ] : event;
				var x = clamp( ( ( point.clientX - rect.left ) / rect.width ) * 100, 0, 100 );
				var y = clamp( ( ( point.clientY - rect.top ) / rect.height ) * 100, 0, 100 );

				marker.style.left = x + '%';
				marker.style.top = y + '%';

				setRangeValue( xInput, Math.round( x ) );
				setRangeValue( yInput, Math.round( y ) );
			}

			var dragging = false;

			function startDrag( event ) {
				dragging = true;
				overlay.classList.add( 'is-dragging' );
				updateFromEvent( event );
				event.preventDefault();
			}

			function moveDrag( event ) {
				if ( ! dragging ) {
					return;
				}
				updateFromEvent( event );
				event.preventDefault();
			}

			function endDrag() {
				dragging = false;
				overlay.classList.remove( 'is-dragging' );
			}

			overlay.addEventListener( 'mousedown', startDrag );
			window.addEventListener( 'mousemove', moveDrag );
			window.addEventListener( 'mouseup', endDrag );
			overlay.addEventListener( 'touchstart', startDrag, { passive: false } );
			window.addEventListener( 'touchmove', moveDrag, { passive: false } );
			window.addEventListener( 'touchend', endDrag );

			// Keep the marker in sync when the sliders are moved directly.
			xInput.addEventListener( 'input', positionMarker );
			yInput.addEventListener( 'input', positionMarker );
		}

		attach();

		// ACF swaps the whole .image-wrap markup in when an image is picked,
		// replaced, or removed -- re-attach the overlay whenever that happens.
		new MutationObserver( attach ).observe( imageFieldEl, { childList: true, subtree: true } );
	}

	function scan( root ) {
		root.querySelectorAll( '.acf-field[data-key="' + IMAGE_KEY + '"]' ).forEach( setUpFocalPicker );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		scan( document );
	} );

	if ( window.acf && typeof window.acf.addAction === 'function' ) {
		window.acf.addAction( 'append', function ( $el ) {
			scan( $el && $el[ 0 ] ? $el[ 0 ] : document );
		} );
	}

	// Fallback for whenever the block's settings form renders without
	// firing an ACF 'append' action we catch above (e.g. a new block
	// instance inserted after the page has already loaded). Batched to one
	// scan per animation frame so it stays cheap during normal editing.
	var scanScheduled = false;
	new MutationObserver( function () {
		if ( scanScheduled ) {
			return;
		}
		scanScheduled = true;
		window.requestAnimationFrame( function () {
			scanScheduled = false;
			scan( document );
		} );
	} ).observe( document.body, { childList: true, subtree: true } );
} )();
