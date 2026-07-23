<?php
/**
 * Front page template — hero + page content.
 *
 * @package IGA
 */

get_header();
?>

<main id="primary">

	<?php get_template_part( 'template-parts/hero' ); ?>
	<?php get_template_part( 'template-parts/statsBar' ); ?>
	<?php get_template_part( 'template-parts/Distinction' ); ?>
	<?php get_template_part( 'template-parts/Mission' ); ?>
	<?php get_template_part( 'template-parts/Forge' ); ?>
	<?php get_template_part( 'template-parts/Pricing' ); ?>
	<?php get_template_part( 'template-parts/Testimonials' ); ?>
	<?php get_template_part( 'template-parts/Contact' ); ?>

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
