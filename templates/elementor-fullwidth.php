<?php
/**
 * Elementor full width with theme header/footer.
 *
 * Template Name: Mallorca / Elementor ancho completo
 *
 * @package Mallorca
 */

get_header();
?>
<main id="primary" class="mallorca-main mallorca-main--elementor mallorca-main--full">
	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>
</main>
<?php
get_footer();
