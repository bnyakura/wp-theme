<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package custom-theme
 */

get_header();
?>
    <section id="404" class="text-primary">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-10">
                    <h1><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'custom-theme' ); ?></h1>
                    <p><?php echo 'It looks like nothing was found at this location. Why not go back to the <a href="/" title="Home page">home page</a>?';?></p>
                </div>
            </div>
        </div>
    </section>
<?php
get_footer();
