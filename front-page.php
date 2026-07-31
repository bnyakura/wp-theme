<?php
/**
 * Front page template — hero + page content.
 *
 * @package IGA
 */

get_header();
?>

<main id="primary">

	<?php 
	    // get_template_part( 'template-parts/hero' ); 
	?>
	<?php 
	    //   require get_template_directory() . '/blocks/hero/render.php';
	    //   include get_template_directory() . '/blocks/hero/render.php'; 
	?>
	<?php 
	    // get_template_part( 'template-parts/statsBar' );
		// get_template_part( 'template-parts/Distinction' );
		// get_template_part( 'template-parts/Mission' );
		// get_template_part( 'template-parts/Forge' );
		// get_template_part( 'template-parts/Pricing' );
		// get_template_part( 'template-parts/Testimonials' );
		// get_template_part( 'template-parts/Contact' ); 
	?>

	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
	endif;
	?>

</main>

<?php
get_footer();
