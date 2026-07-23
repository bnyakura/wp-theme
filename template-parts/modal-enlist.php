<?php
/**
 * Enlist modal.
 *
 * Hidden by default; assets/js/modal.js toggles `.is-open` when a
 * [data-modal-open="enlist-modal"] trigger is clicked. This markup uses
 * Tailwind equivalents of the old .modal-bg / .modal / .mhead / .mbody CSS.
 *
 * @package IGA
 */

?>
<div
	data-modal="enlist-modal"
	role="dialog"
	aria-modal="true"
	aria-label="<?php esc_attr_e( 'Enlist Now', 'iga' ); ?>"
	class="fixed inset-0 z-[3000] hidden items-center justify-center bg-black/[0.92] p-5 backdrop-blur-md [&.is-open]:flex"
>
	<div class="flex max-h-[90vh] w-full max-w-[960px] flex-col overflow-hidden rounded-[18px] border border-line bg-s1">

		<div class="flex items-center justify-between border-b border-line px-6 py-[18px]">
			<h3 class="font-display text-2xl tracking-[2px] text-white">
				<?php esc_html_e( 'Enlist Now', 'iga' ); ?>
			</h3>
			<button
				type="button"
				data-modal-close
				aria-label="<?php esc_attr_e( 'Close', 'iga' ); ?>"
				class="flex h-9 w-9 items-center justify-center rounded-full border border-line bg-s3 text-xl text-muted transition-colors duration-200 hover:text-white"
			>
				<i class="fa-solid fa-xmark" aria-hidden="true"></i>
			</button>
		</div>

		<div class="flex-1 overflow-y-auto bg-s1">
			<?php
			// Enlist form markup, shortcode, or iframe goes here, e.g.:
			// echo do_shortcode( '[contact-form-7 id="123" title="Enlist"]' );
			?>
		</div>

	</div>
</div>
