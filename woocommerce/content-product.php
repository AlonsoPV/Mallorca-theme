<?php
/**
 * Product card.
 *
 * @package Mallorca
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$gallery = $product->get_gallery_image_ids();
$second  = $gallery ? $gallery[0] : 0;
$servings = mallorca_product_extra( $product->get_id(), 'servings' );
$weight   = mallorca_product_extra( $product->get_id(), 'weight' );
?>
<li <?php wc_product_class( 'mallorca-card', $product ); ?>>
	<a class="mallorca-card__media woocommerce-LoopProduct-link" href="<?php echo esc_url( $product->get_permalink() ); ?>">
		<?php
		if ( $product->is_on_sale() ) {
			echo '<span class="mallorca-badge mallorca-badge--sale">' . esc_html__( 'Oferta', 'mallorca' ) . '</span>';
		}
		if ( ! $product->is_in_stock() ) {
			echo '<span class="mallorca-badge mallorca-badge--oos">' . esc_html__( 'Agotado', 'mallorca' ) . '</span>';
		}
		echo $product->get_image( 'mallorca-card', array( 'class' => 'mallorca-card__img mallorca-card__img--primary' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		if ( $second ) {
			echo wp_get_attachment_image( $second, 'mallorca-card', false, array( 'class' => 'mallorca-card__img mallorca-card__img--hover', 'alt' => $product->get_name() ) );
		}
		?>
	</a>
	<div class="mallorca-card__body">
		<h2 class="woocommerce-loop-product__title"><a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h2>
		<?php if ( $servings || $weight ) : ?>
			<p class="mallorca-card__meta"><?php echo esc_html( trim( $servings . ' ' . $weight ) ); ?></p>
		<?php endif; ?>
		<span class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
		<div class="mallorca-card__cta">
			<?php
			woocommerce_template_loop_add_to_cart(
				array(
					'class' => implode(
						' ',
						array_filter(
							array(
								'mallorca-btn',
								$product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() ? 'mallorca-btn--text js-mallorca-quick-add add_to_cart_button ajax_add_to_cart' : 'mallorca-btn--text',
							)
						)
					),
				)
			);
			?>
		</div>
	</div>
</li>
