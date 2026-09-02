<?php
/**
 * Single product.
 *
 * @package Mallorca
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
do_action( 'woocommerce_before_main_content' );

while ( have_posts() ) :
	the_post();
	?>
	<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'mallorca-single', get_the_ID() ); ?>>
		<div class="mallorca-single__grid">
			<div class="mallorca-single__gallery">
				<?php
				do_action( 'woocommerce_before_single_product_summary' );
				?>
			</div>
			<div id="mallorca-add-to-cart" class="mallorca-single__summary summary entry-summary">
				<?php if ( function_exists( 'woocommerce_breadcrumb' ) ) : ?>
					<div class="mallorca-breadcrumb"><?php woocommerce_breadcrumb(); ?></div>
				<?php endif; ?>
				<?php
				do_action( 'woocommerce_single_product_summary' );
				?>
			</div>
		</div>
		<div class="mallorca-single__after">
			<?php do_action( 'woocommerce_after_single_product_summary' ); ?>
		</div>
	</div>
	<?php
	do_action( 'woocommerce_after_single_product' );
endwhile;

do_action( 'woocommerce_after_main_content' );
get_footer( 'shop' );
