<?php
/**
 * Template Name: Mallorca / Carrito
 *
 * @package Mallorca
 */

get_header();
?>
<main id="primary" class="mallorca-main mallorca-woo<?php echo mallorca_is_elementor_page() ? ' mallorca-main--elementor' : ''; ?>">
	<?php
	while ( have_posts() ) :
		the_post();
		if ( mallorca_is_elementor_page() ) {
			the_content();
		} else {
			echo '<div class="mallorca-commerce">';
			the_content();
			echo '</div>';
		}
	endwhile;
	?>
</main>
<?php
get_footer();
