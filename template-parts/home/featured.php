<?php
/**
 * Featured products.
 *
 * @package Mallorca
 *
 * @var array $args Elementor settings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args  = isset( $args ) && is_array( $args ) ? $args : array();
$title = mallorca_arg( $args, 'title', 'featured_title', mallorca_default_copy()['featured_title'] );
$limit = isset( $args['limit'] ) ? (int) $args['limit'] : 8;
?>
<section class="mallorca-featured mallorca-reveal">
	<div class="mallorca-section-head">
		<h2><?php echo esc_html( $title ); ?></h2>
	</div>
	<?php if ( class_exists( 'WooCommerce' ) ) : ?>
		<div class="mallorca-products mallorca-products--grid">
			<?php
			$q = new WP_Query(
				array(
					'post_type'      => 'product',
					'posts_per_page' => $limit,
					'tax_query'      => array(
						array(
							'taxonomy' => 'product_visibility',
							'field'    => 'name',
							'terms'    => 'featured',
						),
					),
				)
			);
			if ( ! $q->have_posts() ) {
				$q = new WP_Query(
					array(
						'post_type'      => 'product',
						'posts_per_page' => $limit,
					)
				);
			}
			if ( $q->have_posts() ) {
				if ( function_exists( 'wc_setup_loop' ) ) {
					wc_setup_loop( array( 'columns' => 4 ) );
				}
				woocommerce_product_loop_start();
				while ( $q->have_posts() ) {
					$q->the_post();
					wc_get_template_part( 'content', 'product' );
				}
				woocommerce_product_loop_end();
				wp_reset_postdata();
				if ( function_exists( 'wc_reset_loop' ) ) {
					wc_reset_loop();
				}
			} else {
				echo '<p class="mallorca-empty">' . esc_html__( 'Los favoritos aparecerán aquí cuando WooCommerce tenga productos destacados.', 'mallorca' ) . '</p>';
			}
			?>
		</div>
	<?php else : ?>
		<p class="mallorca-empty"><?php esc_html_e( 'Activa WooCommerce para mostrar favoritos.', 'mallorca' ); ?></p>
	<?php endif; ?>
</section>
