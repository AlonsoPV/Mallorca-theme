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
	add_filter( 'woocommerce_product_tabs', 'mallorca_product_tabs', 98 );
	add_filter( 'woocommerce_product_tabs', 'mallorca_strip_default_product_tabs', 99 );

	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

	// WooCommerce classic priorities.
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 30 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 60 );

	add_action( 'woocommerce_single_product_summary', 'mallorca_single_breadcrumb', 4 );
	add_action( 'woocommerce_single_product_summary', 'mallorca_single_category', 6 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 8 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 12 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 18 );

	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	add_action( 'woocommerce_single_product_summary', 'mallorca_single_purchase', 22 );

	add_action( 'woocommerce_before_add_to_cart_quantity', 'mallorca_single_purchase_actions_open', 5 );
	add_action( 'woocommerce_after_add_to_cart_quantity', 'mallorca_single_purchase_qty_close', 99 );
	add_action( 'woocommerce_after_add_to_cart_button', 'mallorca_single_purchase_actions_close', 99 );
	add_action( 'woocommerce_before_add_to_cart_button', 'mallorca_single_purchase_button_row_open', 4 );

	add_action( 'woocommerce_single_product_summary', 'mallorca_single_context_notes', 40 );
	add_action( 'woocommerce_single_product_summary', 'mallorca_single_meta_slim', 50 );

	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

	add_action( 'woocommerce_after_single_product_summary', 'mallorca_sticky_atc', 5 );
	add_action( 'woocommerce_after_single_product_summary', 'mallorca_single_details_open', 10 );
	add_action( 'woocommerce_after_single_product_summary', 'mallorca_single_long_description', 12 );
	add_action( 'woocommerce_after_single_product_summary', 'mallorca_single_accordions', 14 );
	add_action( 'woocommerce_after_single_product_summary', 'mallorca_single_details_close', 16 );
	add_action( 'woocommerce_after_single_product_summary', 'mallorca_single_related_section', 20 );

	add_filter( 'woocommerce_output_related_products_args', 'mallorca_related_args' );
	add_filter( 'woocommerce_product_related_products_heading', 'mallorca_related_heading' );
	add_filter( 'woocommerce_upsells_total', 'mallorca_upsells_total' );
	add_filter( 'woocommerce_product_add_to_cart_text', 'mallorca_loop_atc_text', 10, 2 );
	add_filter( 'woocommerce_product_single_add_to_cart_text', 'mallorca_single_atc_text' );
	add_filter( 'woocommerce_get_script_data', 'mallorca_wc_script_data', 10, 2 );
	add_filter( 'woocommerce_add_to_cart_message_html', 'mallorca_add_to_cart_message', 10, 2 );
	add_filter( 'woocommerce_get_breadcrumb', 'mallorca_simplify_product_breadcrumb' );
	add_action( 'woocommerce_before_quantity_input_field', 'mallorca_qty_minus' );
	add_action( 'woocommerce_after_quantity_input_field', 'mallorca_qty_plus' );
	add_filter( 'woocommerce_quantity_input_args', 'mallorca_single_quantity_args', 10, 2 );
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
 * Product tabs metadata (used for accordions; default tabs UI is removed).
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
	$cons = mallorca_product_extra( $id, 'conservation' );
	if ( $cons ) {
		$tabs['conservation'] = array(
			'title'    => __( 'Conservación', 'mallorca' ),
			'priority' => 17,
			'callback' => 'mallorca_tab_conservation',
		);
	}
	$delivery = mallorca_product_extra( $id, 'delivery_note' );
	if ( $delivery ) {
		$tabs['delivery'] = array(
			'title'    => __( 'Entrega y recolección', 'mallorca' ),
			'priority' => 25,
			'callback' => 'mallorca_tab_delivery',
		);
	}

	return $tabs;
}

/**
 * Keep only Mallorca informational tabs for accordion rendering.
 *
 * @param array $tabs Tabs.
 * @return array
 */
function mallorca_strip_default_product_tabs( $tabs ) {
	$keep = array( 'ingredients', 'allergens', 'conservation', 'delivery' );
	foreach ( array_keys( (array) $tabs ) as $key ) {
		if ( ! in_array( $key, $keep, true ) ) {
			unset( $tabs[ $key ] );
		}
	}
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
 * Conservation tab.
 */
function mallorca_tab_conservation() {
	echo wp_kses_post( wpautop( mallorca_product_extra( get_the_ID(), 'conservation' ) ) );
}

/**
 * Delivery tab.
 */
function mallorca_tab_delivery() {
	echo wp_kses_post( wpautop( mallorca_product_extra( get_the_ID(), 'delivery_note' ) ) );
}

/**
 * Simplified breadcrumb on single product.
 */
function mallorca_single_breadcrumb() {
	if ( ! function_exists( 'woocommerce_breadcrumb' ) ) {
		return;
	}
	echo '<div class="mallorca-breadcrumb mallorca-single__crumb">';
	woocommerce_breadcrumb(
		array(
			'delimiter'   => '<span class="mallorca-breadcrumb__sep" aria-hidden="true">/</span>',
			'wrap_before' => '<nav class="woocommerce-breadcrumb" aria-label="' . esc_attr__( 'Ruta', 'mallorca' ) . '">',
			'wrap_after'  => '</nav>',
		)
	);
	echo '</div>';
}

/**
 * Drop product name from breadcrumb crumbs.
 *
 * @param array $crumbs Crumbs.
 * @return array
 */
function mallorca_simplify_product_breadcrumb( $crumbs ) {
	if ( ! is_product() || count( $crumbs ) < 2 ) {
		return $crumbs;
	}
	array_pop( $crumbs );
	return $crumbs;
}

/**
 * Primary product category label.
 */
function mallorca_single_category() {
	global $product;
	if ( ! $product ) {
		return;
	}
	$terms = get_the_terms( $product->get_id(), 'product_cat' );
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return;
	}
	$term = array_shift( $terms );
	echo '<p class="mallorca-single__cat"><a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a></p>';
}

/**
 * Slim meta without repeating category.
 */
function mallorca_single_meta_slim() {
	global $product;
	if ( ! $product ) {
		return;
	}
	$sku = $product->get_sku();
	if ( ! $sku && ! $product->get_tag_ids() ) {
		return;
	}
	echo '<div class="product_meta mallorca-single__meta">';
	if ( $sku ) {
		echo '<span class="sku_wrapper">' . esc_html__( 'SKU', 'mallorca' ) . ': <span class="sku">' . esc_html( $sku ) . '</span></span>';
	}
	echo '</div>';
}

/**
 * Whether long description is meaningfully different from short.
 *
 * @param WC_Product $product Product.
 * @return bool
 */
function mallorca_product_has_unique_long_description( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return false;
	}
	$long  = trim( wp_strip_all_tags( $product->get_description() ) );
	$short = trim( wp_strip_all_tags( $product->get_short_description() ) );
	if ( '' === $long ) {
		return false;
	}
	if ( '' === $short ) {
		return true;
	}
	$norm = static function ( $text ) {
		$text = strtolower( $text );
		$text = preg_replace( '/\s+/u', ' ', $text );
		return trim( (string) $text );
	};
	$a = $norm( $long );
	$b = $norm( $short );
	if ( $a === $b ) {
		return false;
	}
	similar_text( $a, $b, $percent );
	return $percent < 92;
}

/**
 * Editorial long description block.
 */
function mallorca_single_long_description() {
	global $product;
	if ( ! $product || ! mallorca_product_has_unique_long_description( $product ) ) {
		return;
	}

	$content = apply_filters( 'the_content', $product->get_description() );

	echo '<section class="mallorca-single-about">';
	echo '<div class="mallorca-single-about__head">';
	echo '<p class="mallorca-single-about__kicker">' . esc_html__( 'Descripción', 'mallorca' ) . '</p>';
	echo '<h2 class="mallorca-single-about__title">' . esc_html__( 'Sobre este producto', 'mallorca' ) . '</h2>';
	echo '</div>';
	echo '<div class="mallorca-single-about__body mallorca-prose">' . wp_kses_post( $content ) . '</div>';
	echo '</section>';
}

/**
 * Open details column (description + accordions).
 */
function mallorca_single_details_open() {
	echo '<div class="mallorca-single__details">';
}

/**
 * Close details column.
 */
function mallorca_single_details_close() {
	echo '</div>';
}

/**
 * Related products in a dedicated section.
 */
function mallorca_single_related_section() {
	if ( ! is_product() ) {
		return;
	}

	ob_start();
	woocommerce_output_related_products();
	$related = trim( (string) ob_get_clean() );

	if ( '' === $related ) {
		return;
	}

	echo '<section class="mallorca-single-related" aria-labelledby="mallorca-related-heading">';
	echo '<div class="mallorca-single-related__inner">';
	echo '<header class="mallorca-single-related__head">';
	echo '<p class="mallorca-single-related__kicker">' . esc_html__( 'Descubre más', 'mallorca' ) . '</p>';
	echo '<h2 id="mallorca-related-heading" class="mallorca-single-related__title">' . esc_html( mallorca_related_heading() ) . '</h2>';
	echo '</header>';
	echo $related; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '</div>';
	echo '</section>';
}

/**
 * Accordion details for bakery meta.
 */
function mallorca_single_accordions() {
	$tabs = apply_filters( 'woocommerce_product_tabs', array() );
	if ( empty( $tabs ) ) {
		return;
	}
	uasort(
		$tabs,
		static function ( $a, $b ) {
			return (int) ( $a['priority'] ?? 50 ) <=> (int) ( $b['priority'] ?? 50 );
		}
	);
	echo '<section class="mallorca-single-accords" aria-label="' . esc_attr__( 'Detalles del producto', 'mallorca' ) . '">';
	foreach ( $tabs as $key => $tab ) {
		if ( empty( $tab['callback'] ) || ! is_callable( $tab['callback'] ) ) {
			continue;
		}
		echo '<details class="mallorca-single-accord" name="mallorca-product-details">';
		echo '<summary>' . esc_html( $tab['title'] ) . '</summary>';
		echo '<div class="mallorca-single-accord__body">';
		call_user_func( $tab['callback'], $key, $tab );
		echo '</div></details>';
	}
	echo '</section>';
}

/**
 * Purchase block wrapper (quantity + add to cart).
 */
function mallorca_single_purchase() {
	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}

	echo '<section class="mallorca-single__purchase" id="mallorca-purchase" aria-label="' . esc_attr__( 'Añadir al carrito', 'mallorca' ) . '">';
	echo '<h2 class="mallorca-single__purchase-title screen-reader-text">' . esc_html__( 'Añadir a tu pedido', 'mallorca' ) . '</h2>';

	woocommerce_template_single_add_to_cart();

	echo '</section>';
}

/**
 * Open purchase actions row (quantity + button).
 */
function mallorca_single_purchase_actions_open() {
	global $product;

	if ( ( $product instanceof WC_Product && $product->is_type( 'grouped' ) ) || mallorca_purchase_actions_opened() ) {
		return;
	}
	mallorca_mark_purchase_actions_opened();

	echo '<div class="mallorca-single__purchase-actions">';
	echo '<div class="mallorca-single__purchase-qty">';
	echo '<span class="mallorca-single__purchase-qty-label" id="mallorca-qty-label">' . esc_html__( 'Cantidad', 'mallorca' ) . '</span>';
}

/**
 * Close quantity column.
 */
function mallorca_single_purchase_qty_close() {
	if ( ! mallorca_purchase_actions_opened() || mallorca_purchase_qty_closed() ) {
		return;
	}
	mallorca_mark_purchase_qty_closed();

	echo '</div>';
}

/**
 * Close purchase actions row.
 */
function mallorca_single_purchase_actions_close() {
	if ( ! mallorca_purchase_actions_opened() || mallorca_purchase_actions_closed() ) {
		return;
	}
	mallorca_mark_purchase_actions_closed();

	echo '</div>';
}

/**
 * Button-only row for external / products without quantity field.
 */
function mallorca_single_purchase_button_row_open() {
	global $product;

	if ( ( $product instanceof WC_Product && $product->is_type( 'grouped' ) ) || mallorca_purchase_actions_opened() ) {
		return;
	}
	mallorca_mark_purchase_actions_opened();

	echo '<div class="mallorca-single__purchase-actions mallorca-single__purchase-actions--solo">';
}

/**
 * Whether purchase actions row was opened.
 *
 * @return bool
 */
function mallorca_purchase_actions_opened() {
	return ! empty( $GLOBALS['mallorca_purchase_actions'] );
}

/**
 * Mark purchase actions row as opened.
 */
function mallorca_mark_purchase_actions_opened() {
	$GLOBALS['mallorca_purchase_actions'] = array(
		'qty_closed' => false,
		'closed'     => false,
	);
}

/**
 * Whether quantity column was closed.
 *
 * @return bool
 */
function mallorca_purchase_qty_closed() {
	return ! empty( $GLOBALS['mallorca_purchase_actions']['qty_closed'] );
}

/**
 * Mark quantity column as closed.
 */
function mallorca_mark_purchase_qty_closed() {
	$GLOBALS['mallorca_purchase_actions']['qty_closed'] = true;
}

/**
 * Whether purchase actions row was closed.
 *
 * @return bool
 */
function mallorca_purchase_actions_closed() {
	return ! empty( $GLOBALS['mallorca_purchase_actions']['closed'] );
}

/**
 * Mark purchase actions row as closed.
 */
function mallorca_mark_purchase_actions_closed() {
	$GLOBALS['mallorca_purchase_actions']['closed'] = true;
}

/**
 * Reset purchase actions flags before each add-to-cart render.
 */
function mallorca_reset_purchase_actions_state() {
	unset( $GLOBALS['mallorca_purchase_actions'] );
}
add_action( 'woocommerce_before_add_to_cart_form', 'mallorca_reset_purchase_actions_state', 1 );

/**
 * Product specs under add to cart (conservation, servings, weight).
 */
function mallorca_single_context_notes() {
	$servings = mallorca_product_extra( get_the_ID(), 'servings' );
	$weight   = mallorca_product_extra( get_the_ID(), 'weight' );
	$cons     = mallorca_product_extra( get_the_ID(), 'conservation' );

	$items = array(
		array(
			'label' => __( 'Conservación', 'mallorca' ),
			'value' => $cons ? $cons : __( 'Mejor el mismo día. Refrigerar si aplica.', 'mallorca' ),
		),
	);

	if ( $servings ) {
		$items[] = array(
			'label' => __( 'Porciones', 'mallorca' ),
			'value' => $servings,
		);
	}

	if ( $weight ) {
		$items[] = array(
			'label' => __( 'Peso', 'mallorca' ),
			'value' => $weight,
		);
	}

	if ( empty( $items ) ) {
		return;
	}

	echo '<div class="mallorca-product-specs" aria-label="' . esc_attr__( 'Detalles del producto', 'mallorca' ) . '">';
	echo '<dl class="mallorca-product-specs__list">';

	foreach ( $items as $item ) {
		echo '<div class="mallorca-product-specs__item">';
		echo '<dt class="mallorca-product-specs__label">' . esc_html( $item['label'] ) . '</dt>';
		echo '<dd class="mallorca-product-specs__value">' . esc_html( $item['value'] ) . '</dd>';
		echo '</div>';
	}

	echo '</dl>';
	echo '</div>';
}

/**
 * Sticky add to cart on single product (mobile).
 */
function mallorca_sticky_atc() {
	if ( ! is_product() ) {
		return;
	}
	global $product;
	if ( ! $product || ! $product->is_purchasable() ) {
		return;
	}
	echo '<div class="mallorca-sticky-atc js-mallorca-sticky-bar" hidden>';
	echo '<div class="mallorca-sticky-atc__info">';
	echo '<span class="mallorca-sticky-atc__price">' . wp_kses_post( $product->get_price_html() ) . '</span>';
	echo '</div>';
	echo '<button type="button" class="mallorca-btn mallorca-btn--solid js-mallorca-sticky-atc">' . esc_html__( 'Añadir', 'mallorca' ) . '</button>';
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
 * Related heading.
 *
 * @return string
 */
function mallorca_related_heading() {
	return __( 'También te puede gustar', 'mallorca' );
}

/**
 * Single ATC label.
 *
 * @return string
 */
function mallorca_single_atc_text() {
	return __( 'Añadir al carrito', 'mallorca' );
}

/**
 * Quantity field args on single product.
 *
 * @param array      $args    Args.
 * @param WC_Product $product Product.
 * @return array
 */
function mallorca_single_quantity_args( $args, $product ) {
	if ( ! is_product() ) {
		return $args;
	}

	$args['input_id']     = 'mallorca-qty';
	$args['label']        = __( 'Cantidad', 'mallorca' );
	$args['classes']      = array( 'input-text', 'qty', 'text' );
	$args['input_value']  = max( 1, (int) ( $args['input_value'] ?? 1 ) );
	$args['autocomplete'] = 'off';

	return $args;
}

/**
 * Quantity minus control.
 */
function mallorca_qty_minus() {
	echo '<button type="button" class="mallorca-qty__btn mallorca-qty__btn--minus js-mallorca-qty" data-dir="-1" aria-label="' . esc_attr__( 'Disminuir cantidad', 'mallorca' ) . '">−</button>';
}

/**
 * Quantity plus control.
 */
function mallorca_qty_plus() {
	echo '<button type="button" class="mallorca-qty__btn mallorca-qty__btn--plus js-mallorca-qty" data-dir="1" aria-label="' . esc_attr__( 'Aumentar cantidad', 'mallorca' ) . '">+</button>';
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
	return __( 'Añadir +', 'mallorca' );
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
