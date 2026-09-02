<?php
/**
 * Template Name: Mallorca / Tienda
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
			get_template_part( 'template-parts/woocommerce/shop' );
		}
	endwhile;
	?>
</main>
<?php
get_footer();
