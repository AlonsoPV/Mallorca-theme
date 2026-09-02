<?php
/**
 * WooCommerce integration via hooks and light template overrides.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Declare WooCommerce support already in setup.php.
 * Additional loop and single customizations.
 */
function mallorca_wc_ready() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	add_action( 'woocommerce_before_main_content', 'mallorca_wc_wrapper_start', 10 );
	add_action( 'woocommerce_after_main_content', 'mallorca_wc_wrapper_end', 10 );

	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	add_action( 'woocommerce_before_shop_loop', 'mallorca_shop_toolbar', 20 );

	add_filter( 'loop_shop_columns', 'mallorca_loop_columns' );
	add_filter( 'loop_shop_per_page', 'mallorca_products_per_page' );

	add_action( 'wp_enqueue_scripts', 'mallorca_dequeue_wc_styles', 99 );

	add_filter( 'woocommerce_add_to_cart_fragments', 'mallorca_cart_fragments' );
	add_filter( 'woocommerce_product_tabs', 'mallorca_product_tabs', 20 );
	add_action( 'woocommerce_single_product_summary', 'mallorca_single_context_notes', 25 );
	add_action( 'woocommerce_after_single_product_summary', 'mallorca_sticky_atc', 5 );

	add_filter( 'woocommerce_output_related_products_args', 'mallorca_related_args' );
	add_filter( 'woocommerce_upsells_total', 'mallorca_upsells_total' );
	add_filter( 'woocommerce_product_add_to_cart_text', 'mallorca_loop_atc_text', 10, 2 );
	add_filter( 'woocommerce_get_script_data', 'mallorca_wc_script_data', 10, 2 );
	add_filter( 'woocommerce_add_to_cart_message_html', 'mallorca_add_to_cart_message', 10, 2 );
}
add_action( 'after_setup_theme', 'mallorca_wc_ready', 20 );

/**
 * Wrapper start.
 */
function mallorca_wc_wrapper_start() {
	echo '<main id="primary" class="mallorca-main mallorca-woo">';
}

/**
 * Wrapper end.
 */
function mallorca_wc_wrapper_end() {
	echo '</main>';
}

/**
 * Shop columns.
 *
 * @return int
 */
function mallorca_loop_columns() {
	return 4;
}

/**
 * Products per page.
 *
 * @return int
 */
function mallorca_products_per_page() {
	return 12;
}

/**
 * Keep WooCommerce core styles but our CSS wins.
 */
function mallorca_dequeue_wc_styles() {
	// Intentionally keep WooCommerce styles for plugin compatibility.
}

/**
 * Cart fragments for header count and mini cart.
 *
 * @param array $fragments Fragments.
 * @return array
 */
function mallorca_cart_fragments( $fragments ) {
	ob_start();
	mallorca_cart_count_markup();
	$fragments['.js-mallorca-cart-count'] = ob_get_clean();

	ob_start();
	get_template_part( 'template-parts/header/mini-cart-contents' );
	$fragments['.js-mallorca-mini-cart-body'] = ob_get_clean();

	return $fragments;
}

/**
 * Editorial “added to cart” notice.
 *
 * @param string $message  Default HTML.
 * @param array  $products Product quantities keyed by ID.
 * @return string
 */
function mallorca_add_to_cart_message( $message, $products ) {
	$count = is_array( $products ) ? array_sum( $products ) : 1;
	$names = array();

	if ( is_array( $products ) ) {
		foreach ( $products as $product_id => $qty ) {
			$product = wc_get_product( $product_id );
			if ( $product ) {
				$names[] = $product->get_name();
			}
		}
	}

	$title = $names ? implode( ', ', $names ) : __( 'Tu pieza', 'mallorca' );
	$copy  = $count > 1
		? sprintf( __( 'Añadimos %s a tu pedido.', 'mallorca' ), $title )
		: sprintf( __( '%s se añadió a tu pedido.', 'mallorca' ), $title );

	return sprintf(
		'<span class="mallorca-notice__text">%s</span><span class="mallorca-notice__actions"><a class="mallorca-btn mallorca-btn--ghost" href="%s">%s</a><a class="mallorca-btn mallorca-btn--solid" href="%s">%s</a></span>',
		esc_html( $copy ),
		esc_url( wc_get_cart_url() ),
		esc_html__( 'Ver carrito', 'mallorca' ),
		esc_url( wc_get_checkout_url() ),
		esc_html__( 'Finalizar pedido', 'mallorca' )
	);
}

/**
 * Cart count badge markup.
 */
function mallorca_cart_count_markup() {
	$count = mallorca_cart_count();
	$class = $count ? 'is-visible' : '';
	echo '<span class="mallorca-cart-count js-mallorca-cart-count ' . esc_attr( $class ) . '" data-count="' . esc_attr( (string) $count ) . '">' . esc_html( (string) $count ) . '</span>';
}

/**
 * Shop toolbar: filters + orderby.
 */
function mallorca_shop_toolbar() {
	if ( ! function_exists( 'woocommerce_catalog_ordering' ) ) {
		return;
	}
	echo '<div class="mallorca-shop-toolbar">';
	get_template_part( 'template-parts/product/filters' );
	echo '<div class="mallorca-shop-ordering">';
	woocommerce_catalog_ordering();
	echo '</div></div>';
}

/**
 * Product tabs as accordion content sources.
 *
 * @param array $tabs Tabs.
 * @return array
 */
function mallorca_product_tabs( $tabs ) {
	global $product;
	if ( ! $product ) {
		return $tabs;
	}

	$id = $product->get_id();
	if ( mallorca_product_extra( $id, 'ingredients' ) ) {
		$tabs['ingredients'] = array(
			'title'    => __( 'Ingredientes', 'mallorca' ),
			'priority' => 15,
			'callback' => 'mallorca_tab_ingredients',
		);
	}
	if ( mallorca_product_extra( $id, 'allergens' ) ) {
		$tabs['allergens'] = array(
			'title'    => __( 'Alérgenos', 'mallorca' ),
			'priority' => 16,
			'callback' => 'mallorca_tab_allergens',
		);
	}
	$tabs['delivery'] = array(
		'title'    => __( 'Entrega y recolección', 'mallorca' ),
		'priority' => 25,
		'callback' => 'mallorca_tab_delivery',
	);

	return $tabs;
}

/**
 * Ingredients tab.
 */
function mallorca_tab_ingredients() {
	echo wp_kses_post( wpautop( mallorca_product_extra( get_the_ID(), 'ingredients' ) ) );
}

/**
 * Allergens tab.
 */
function mallorca_tab_allergens() {
	echo wp_kses_post( wpautop( mallorca_product_extra( get_the_ID(), 'allergens' ) ) );
}

/**
 * Delivery tab.
 */
function mallorca_tab_delivery() {
	$note = mallorca_product_extra( get_the_ID(), 'delivery_note' );
	if ( $note ) {
		echo wp_kses_post( wpautop( $note ) );
		return;
	}
	echo '<p>' . esc_html__( 'Entrega a domicilio y recolección en sucursal según los métodos de envío activos en la tienda. Las tartas y piezas de temporada pueden requerir fecha de entrega.', 'mallorca' ) . '</p>';
}

/**
 * Contextual notes under short description.
 */
function mallorca_single_context_notes() {
	$servings = mallorca_product_extra( get_the_ID(), 'servings' );
	$weight   = mallorca_product_extra( get_the_ID(), 'weight' );
	$cons     = mallorca_product_extra( get_the_ID(), 'conservation' );

	echo '<ul class="mallorca-product-notes">';
	echo '<li><span>' . esc_html__( 'Entrega', 'mallorca' ) . '</span> ' . esc_html__( 'Programada en el checkout.', 'mallorca' ) . '</li>';
	echo '<li><span>' . esc_html__( 'Recolección', 'mallorca' ) . '</span> ' . esc_html__( 'Reforma y Lomas, según disponibilidad.', 'mallorca' ) . '</li>';
	if ( $cons ) {
		echo '<li><span>' . esc_html__( 'Conservación', 'mallorca' ) . '</span> ' . esc_html( $cons ) . '</li>';
	} else {
		echo '<li><span>' . esc_html__( 'Conservación', 'mallorca' ) . '</span> ' . esc_html__( 'Mejor el mismo día. Refrigerar si aplica.', 'mallorca' ) . '</li>';
	}
	if ( $servings ) {
		echo '<li><span>' . esc_html__( 'Porciones', 'mallorca' ) . '</span> ' . esc_html( $servings ) . '</li>';
	}
	if ( $weight ) {
		echo '<li><span>' . esc_html__( 'Peso', 'mallorca' ) . '</span> ' . esc_html( $weight ) . '</li>';
	}
	echo '</ul>';
}

/**
 * Sticky add to cart on single product (mobile).
 */
function mallorca_sticky_atc() {
	if ( ! is_product() ) {
		return;
	}
	global $product;
	if ( ! $product ) {
		return;
	}
	echo '<div class="mallorca-sticky-atc">';
	echo '<div class="mallorca-sticky-atc__info"><strong>' . esc_html( $product->get_name() ) . '</strong> ';
	echo wp_kses_post( $product->get_price_html() );
	echo '</div>';
	echo '<a class="mallorca-btn mallorca-btn--solid js-mallorca-sticky-atc" href="#mallorca-add-to-cart">' . esc_html__( 'Agregar al carrito', 'mallorca' ) . '</a>';
	echo '</div>';
}

/**
 * Related products args.
 *
 * @param array $args Args.
 * @return array
 */
function mallorca_related_args( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns']        = 4;
	return $args;
}

/**
 * Upsells total.
 *
 * @return int
 */
function mallorca_upsells_total() {
	return 4;
}

/**
 * Loop button text.
 *
 * @param string     $text    Text.
 * @param WC_Product $product Product.
 * @return string
 */
function mallorca_loop_atc_text( $text, $product ) {
	if ( $product && $product->is_type( 'variable' ) ) {
		return __( 'Seleccionar opciones', 'mallorca' );
	}
	return __( 'Añadir', 'mallorca' );
}

/**
 * Disable cart redirect so mini cart can open.
 *
 * @param array  $params Params.
 * @param string $handle Handle.
 * @return array
 */
function mallorca_wc_script_data( $params, $handle ) {
	if ( 'wc-add-to-cart' === $handle ) {
		$params['cart_redirect_after_add'] = 'no';
	}
	return $params;
}

add_filter(
	'woocommerce_add_to_cart_redirect',
	static function () {
		return false;
	}
);

add_filter(
	'woocommerce_get_availability_text',
	static function ( $text, $product ) {
		if ( $product && ! $product->is_in_stock() ) {
			return __( 'Agotado por hoy', 'mallorca' );
		}
		return $text;
	},
	10,
	2
);

add_filter(
	'woocommerce_sale_flash',
	static function () {
		return '<span class="mallorca-badge mallorca-badge--sale">' . esc_html__( 'Oferta', 'mallorca' ) . '</span>';
	}
);

add_filter(
	'woocommerce_catalog_orderby',
	static function ( $options ) {
		return array(
			'menu_order' => __( 'Destacados', 'mallorca' ),
			'popularity' => __( 'Más vendidos', 'mallorca' ),
			'date'       => __( 'Más recientes', 'mallorca' ),
			'price'      => __( 'Precio: menor a mayor', 'mallorca' ),
			'price-desc' => __( 'Precio: mayor a menor', 'mallorca' ),
		);
	}
);

add_action(
	'woocommerce_product_query',
	static function ( $query ) {
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}
		if ( ! empty( $_GET['product_cat'] ) && ( is_shop() || is_post_type_archive( 'product' ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$tax   = (array) $query->get( 'tax_query' );
			$tax[] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => sanitize_title( wp_unslash( $_GET['product_cat'] ) ), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			);
			$query->set( 'tax_query', $tax );
		}
		if ( isset( $_GET['in_stock'] ) && '1' === $_GET['in_stock'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$query->set(
				'meta_query',
				array(
					array(
						'key'   => '_stock_status',
						'value' => 'instock',
					),
				)
			);
		}
		if ( ! empty( $_GET['min_price'] ) || ! empty( $_GET['max_price'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$min = isset( $_GET['min_price'] ) ? floatval( wp_unslash( $_GET['min_price'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$max = isset( $_GET['max_price'] ) ? floatval( wp_unslash( $_GET['max_price'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$mq  = (array) $query->get( 'meta_query' );
			if ( $min ) {
				$mq[] = array(
					'key'     => '_price',
					'value'   => $min,
					'compare' => '>=',
					'type'    => 'NUMERIC',
				);
			}
			if ( $max ) {
				$mq[] = array(
					'key'     => '_price',
					'value'   => $max,
					'compare' => '<=',
					'type'    => 'NUMERIC',
				);
			}
			$query->set( 'meta_query', $mq );
		}
	}
);
