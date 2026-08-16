<?php
$message    = get_field( 'message' );
$type       = get_field( 'type' ) ?: 'info';
$dismissible = get_field( 'dismissible' ) ?: false;

if ( empty( $message ) ) {
    return;
}

$wrapper_attributes = get_block_wrapper_attributes( array(
    'class' => 'toaster-block toaster-' . esc_attr( $type ),
    'role'  => 'alert',
) );

$dismiss_button = '';
if ( $dismissible ) {
    $dismiss_button = sprintf(
        '<button class="toaster-dismiss" aria-label="%s">&times;</button>',
        esc_attr__( 'Dismiss', 'custom-theme' )
    );
}
?>
<div <?php echo $wrapper_attributes; ?>>
    <?php echo $dismiss_button; ?>
    <div class="toaster-content"><?php echo wp_kses_post( wpautop( $message ) ); ?></div>
</div>
