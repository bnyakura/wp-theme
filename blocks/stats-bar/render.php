<?php
$stats = get_field( 'stats' );

if ( empty( $stats ) ) {
    return;
}

$wrapper_attributes = get_block_wrapper_attributes( array(
    'class' => 'w-full border-y border-[rgba(58,125,68,0.5)] bg-[#111111] px-[5vw]',
) );
?>
<div <?php echo $wrapper_attributes; ?> aria-label="Community stats">
    <div class="mx-auto grid w-full max-w-[1100px] grid-cols-1 gap-0 min-[481px]:grid-cols-2 min-[1081px]:grid-cols-4">
        <?php foreach ( $stats as $i => $stat ) : ?>
            <div class="relative flex flex-col items-center px-5 py-9 text-center <?php echo $i > 0 ? 'border-l border-[rgba(58,125,68,0.3)]' : ''; ?>">
                <span class="font-display text-[clamp(2.4rem,4.5vw,3.2rem)] leading-none tracking-[1px] text-green">
                    <?php echo esc_html( $stat['value'] ); ?>
                </span>
                <span class="mt-[10px] text-[0.7rem] font-medium uppercase tracking-[2.5px] text-[#cccccc]">
                    <?php echo esc_html( $stat['label'] ); ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
</div>
