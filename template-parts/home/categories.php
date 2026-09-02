<?php
/**
 * Category editorial grid.
 *
 * @package Mallorca
 *
 * @var array $args Elementor settings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args  = isset( $args ) && is_array( $args ) ? $args : array();
$title = mallorca_arg( $args, 'title', 'cats_title', mallorca_default_copy()['cats_title'] );
$limit = isset( $args['limit'] ) ? (int) $args['limit'] : 6;
$terms = array();

if ( taxonomy_exists( 'product_cat' ) ) {
	$terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
			'number'     => $limit,
			'exclude'    => array( get_option( 'default_product_cat' ) ),
		)
	);
	if ( is_wp_error( $terms ) ) {
		$terms = array();
	}
}

$fallback = array(
	array( __( 'Pasteles', 'mallorca' ), 'product-tarta.jpg' ),
	array( __( 'Bollería', 'mallorca' ), 'product-ensaimada.jpg' ),
	array( __( 'Panadería', 'mallorca' ), 'product-pan.jpg' ),
	array( __( 'Salados', 'mallorca' ), 'experience-mesa.jpg' ),
	array( __( 'Regalos', 'mallorca' ), 'product-caja.jpg' ),
	array( __( 'Temporada', 'mallorca' ), 'product-frutos.jpg' ),
);
?>
<section class="mallorca-cats">
	<div class="mallorca-section-head">
		<h2><?php echo esc_html( $title ); ?></h2>
	</div>
	<div class="mallorca-cats__grid">
		<?php if ( $terms ) : ?>
			<?php foreach ( $terms as $index => $term ) : ?>
				<?php
				$thumb_id = (int) get_term_meta( $term->term_id, 'thumbnail_id', true );
				$fb       = isset( $fallback[ $index ] ) ? $fallback[ $index ][1] : 'product-ensaimada.jpg';
				?>
				<a class="mallorca-cats__item" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
					<?php
					echo mallorca_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						$thumb_id,
						'mallorca-card',
						'/assets/images/demo/' . $fb,
						array(
							'alt'   => $term->name,
							'class' => 'mallorca-cats__img',
						)
					);
					?>
					<span><?php echo esc_html( $term->name ); ?></span>
				</a>
			<?php endforeach; ?>
		<?php else : ?>
			<?php foreach ( $fallback as $item ) : ?>
				<a class="mallorca-cats__item" href="<?php echo esc_url( mallorca_shop_url() ); ?>">
					<?php
					echo mallorca_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						0,
						'mallorca-card',
						'/assets/images/demo/' . $item[1],
						array(
							'alt'   => $item[0],
							'class' => 'mallorca-cats__img',
						)
					);
					?>
					<span><?php echo esc_html( $item[0] ); ?></span>
				</a>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</section>
