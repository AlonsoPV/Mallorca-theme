<?php
/**
 * Locations.
 *
 * @package Mallorca
 *
 * @var array $args Elementor settings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args  = isset( $args ) && is_array( $args ) ? $args : array();
$title = mallorca_arg( $args, 'title', 'loc_title', mallorca_default_copy()['loc_title'] );
$query = new WP_Query(
	array(
		'post_type'      => 'mallorca_location',
		'posts_per_page' => 6,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
	)
);
?>
<section class="mallorca-locations mallorca-reveal">
	<div class="mallorca-section-head">
		<h2><?php echo esc_html( $title ); ?></h2>
	</div>
	<div class="mallorca-locations__grid">
		<?php if ( $query->have_posts() ) : ?>
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				get_template_part( 'template-parts/location/card' );
			endwhile;
			wp_reset_postdata();
			?>
		<?php else : ?>
			<p class="mallorca-empty"><?php esc_html_e( 'Añade sucursales desde el menú Sucursales. Los datos no están fijos en el tema.', 'mallorca' ); ?></p>
		<?php endif; ?>
	</div>
</section>
