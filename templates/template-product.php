<?php
/**
 * Template Name: Mallorca / Producto
 *
 * Usar en Theme Builder de Elementor o como base. El producto real
 * se renderiza desde WooCommerce / la plantilla single-product.
 *
 * @package Mallorca
 */

get_header();
?>
<main id="primary" class="mallorca-main mallorca-woo<?php echo mallorca_is_elementor_page() ? ' mallorca-main--elementor' : ''; ?>">
	<?php
	if ( mallorca_is_elementor_page() ) {
		while ( have_posts() ) {
			the_post();
			the_content();
		}
	} else {
		get_template_part( 'template-parts/woocommerce/product' );
	}
	?>
</main>
<?php
get_footer();
