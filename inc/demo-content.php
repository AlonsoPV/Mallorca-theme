<?php
/**
 * Optional demo importer: products, sucursales, pages, Elementor home.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin page.
 */
function mallorca_demo_menu() {
	add_theme_page(
		__( 'Mallorca demo', 'mallorca' ),
		__( 'Mallorca demo', 'mallorca' ),
		'manage_options',
		'mallorca-demo',
		'mallorca_demo_page'
	);
}
add_action( 'admin_menu', 'mallorca_demo_menu' );

/**
 * Render page.
 */
function mallorca_demo_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$done = get_option( 'mallorca_demo_imported' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Mallorca — contenido demo', 'mallorca' ); ?></h1>
		<p><?php esc_html_e( 'Crea páginas, sucursales, menús y productos ficticios. Si Elementor está activo, arma la portada, la tienda, el producto, el carrito y el checkout con widgets Mallorca.', 'mallorca' ); ?></p>
		<?php if ( $done ) : ?>
			<p><strong><?php esc_html_e( 'El contenido demo ya se importó. Puedes volver a importar para completar lo que falte (es idempotente).', 'mallorca' ); ?></strong></p>
		<?php endif; ?>
		<form method="post">
			<?php wp_nonce_field( 'mallorca_import_demo', 'mallorca_demo_nonce' ); ?>
			<p><button class="button button-primary" type="submit" name="mallorca_import_demo" value="1"><?php esc_html_e( 'Importar contenido demo', 'mallorca' ); ?></button></p>
		</form>
		<p><?php esc_html_e( 'Plugins recomendados: Elementor, WooCommerce, un plugin de add-ons, delivery slots / local pickup, y tu pasarela mexicana.', 'mallorca' ); ?></p>
	</div>
	<?php
}

/**
 * Handle import.
 */
function mallorca_handle_demo_import() {
	if ( ! is_admin() || ! isset( $_POST['mallorca_import_demo'] ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( ! isset( $_POST['mallorca_demo_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mallorca_demo_nonce'] ) ), 'mallorca_import_demo' ) ) {
		return;
	}

	mallorca_import_demo_content();
	wp_safe_redirect( add_query_arg( array( 'page' => 'mallorca-demo', 'imported' => '1' ), admin_url( 'themes.php' ) ) );
	exit;
}
add_action( 'admin_init', 'mallorca_handle_demo_import' );

/**
 * Import.
 */
function mallorca_import_demo_content() {
	$images = mallorca_demo_sideload_images();
	$pages  = mallorca_demo_pages();
	mallorca_demo_locations( $images );
	mallorca_demo_products( $images );
	mallorca_demo_menus( $pages );
	mallorca_demo_customizer( $images, $pages );
	mallorca_demo_elementor_home( $pages['home'], $images );
	mallorca_demo_elementor_woocommerce();
	update_option( 'mallorca_demo_imported', 1 );
	flush_rewrite_rules();
}

/**
 * Sideload demo images once.
 *
 * @return array
 */
function mallorca_demo_sideload_images() {
	$map   = (array) get_option( 'mallorca_demo_images', array() );
	$files = array(
		'hero'        => 'hero.jpg',
		'ensaimada'   => 'product-ensaimada.jpg',
		'santiago'    => 'product-santiago.jpg',
		'croissant'   => 'product-croissant.jpg',
		'palmera'     => 'product-palmera.jpg',
		'frutos'      => 'product-frutos.jpg',
		'pan'         => 'product-pan.jpg',
		'caja'        => 'product-caja.jpg',
		'tarta'       => 'product-tarta.jpg',
		'cafe'        => 'experience-cafe.jpg',
		'mesa'        => 'experience-mesa.jpg',
		'bolleria'    => 'experience-bolleria.jpg',
		'story'       => 'story-oven.jpg',
		'location'    => 'location-interior.jpg',
	);

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	foreach ( $files as $key => $file ) {
		if ( ! empty( $map[ $key ] ) && wp_attachment_is_image( $map[ $key ] ) ) {
			continue;
		}
		$path = MALLORCA_DIR . '/assets/images/demo/' . $file;
		if ( ! file_exists( $path ) ) {
			continue;
		}
		$tmp = wp_tempnam( $file );
		copy( $path, $tmp ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_copy
		$id = media_handle_sideload(
			array(
				'name'     => $file,
				'tmp_name' => $tmp,
			),
			0,
			$key
		);
		if ( ! is_wp_error( $id ) ) {
			$map[ $key ] = (int) $id;
		}
	}

	update_option( 'mallorca_demo_images', $map );
	return $map;
}

/**
 * Pages.
 *
 * @return array
 */
function mallorca_demo_pages() {
	$defs = array(
		'home'     => array( __( 'Inicio', 'mallorca' ), '' ),
		'historia' => array(
			__( 'Nuestra historia', 'mallorca' ),
			'',
		),
		'restaurante' => array(
			__( 'Restaurante', 'mallorca' ),
			'<p>' . esc_html__( 'Desayunos, comidas y cenas con raíz española y acento mexicano. Reserva en Reforma o Lomas.', 'mallorca' ) . '</p>',
		),
		'privacidad' => array( __( 'Aviso de privacidad', 'mallorca' ), '<p>' . esc_html__( 'Texto legal de ejemplo. Reemplázalo con tu aviso real.', 'mallorca' ) . '</p>' ),
		'terminos'   => array( __( 'Términos', 'mallorca' ), '<p>' . esc_html__( 'Términos de ejemplo. Reemplázalos antes de publicar.', 'mallorca' ) . '</p>' ),
		'factura'    => array( __( 'Factura', 'mallorca' ), '<p>' . esc_html__( 'Página de ejemplo para solicitar factura. Sustitúyela por tu flujo real.', 'mallorca' ) . '</p>' ),
		'empleo'     => array( __( 'Bolsa de trabajo', 'mallorca' ), '<p>' . esc_html__( 'Página de ejemplo para vacantes. Sustitúyela por tu convocatoria real.', 'mallorca' ) . '</p>' ),
	);

	$ids = (array) get_option( 'mallorca_demo_pages', array() );
	foreach ( $defs as $key => $data ) {
		if ( ! empty( $ids[ $key ] ) && get_post( $ids[ $key ] ) ) {
			continue;
		}
		$ids[ $key ] = wp_insert_post(
			array(
				'post_title'   => $data[0],
				'post_content' => $data[1],
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_name'    => sanitize_title( $data[0] ),
			)
		);
	}

	if ( ! empty( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', (int) $ids['home'] );
	}

	if ( ! empty( $ids['historia'] ) ) {
		update_post_meta( (int) $ids['historia'], '_wp_page_template', 'templates/template-historia.php' );
	}

	update_option( 'mallorca_demo_pages', $ids );
	return $ids;
}

/**
 * Locations.
 *
 * @param array $images Image map.
 */
function mallorca_demo_locations( $images ) {
	$locations = array(
		array(
			'title' => 'Reforma',
			'meta'  => array(
				'location_name'   => 'Reforma',
				'address'         => 'Av. Paseo de la Reforma 365, Cuauhtémoc, 06500',
				'google_maps_url' => 'https://maps.google.com/?q=Paseo+de+la+Reforma+365+Ciudad+de+Mexico',
				'phone'           => '55 1268 5557',
				'email'           => 'reforma@pasteleria-mallorca.mx',
				'whatsapp'        => '525512685557',
				'schedule'        => __( 'Lunes a domingo · 7:00 a 22:00', 'mallorca' ),
				'reservation_url' => '',
				'order_url'       => '',
			),
		),
		array(
			'title' => 'Lomas',
			'meta'  => array(
				'location_name'   => 'Lomas',
				'address'         => 'Av. Explanada 710, Lomas - Virreyes, Lomas de Chapultepec IV Secc, Miguel Hidalgo, 11000',
				'google_maps_url' => 'https://maps.google.com/?q=Av+Explanada+710+Lomas+de+Chapultepec',
				'phone'           => '55 9131 7108',
				'email'           => 'explanada@pasteleria-mallorca.mx',
				'whatsapp'        => '525591317108',
				'schedule'        => __( 'Lunes a domingo · 7:00 a 22:00', 'mallorca' ),
				'reservation_url' => '',
				'order_url'       => '',
			),
		),
	);

	foreach ( $locations as $loc ) {
		$existing = mallorca_find_post( $loc['title'], 'mallorca_location' );
		if ( $existing ) {
			$id = $existing->ID;
		} else {
			$id = wp_insert_post(
				array(
					'post_title'  => $loc['title'],
					'post_status' => 'publish',
					'post_type'   => 'mallorca_location',
				)
			);
		}
		foreach ( $loc['meta'] as $key => $value ) {
			update_post_meta( $id, '_mallorca_' . $key, $value );
		}
		if ( ! empty( $images['location'] ) ) {
			set_post_thumbnail( $id, (int) $images['location'] );
		}
	}
}

/**
 * WooCommerce products.
 *
 * @param array $images Images.
 */
function mallorca_demo_products( $images ) {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$cats = array(
		'pasteles'  => __( 'Pasteles', 'mallorca' ),
		'bolleria'  => __( 'Bollería', 'mallorca' ),
		'panaderia' => __( 'Panadería', 'mallorca' ),
		'salados'   => __( 'Salados', 'mallorca' ),
		'regalos'   => __( 'Regalos', 'mallorca' ),
		'temporada' => __( 'Temporada', 'mallorca' ),
	);
	$term_ids = array();
	foreach ( $cats as $slug => $name ) {
		$term = term_exists( $slug, 'product_cat' );
		if ( ! $term ) {
			$term = wp_insert_term( $name, 'product_cat', array( 'slug' => $slug ) );
		}
		if ( ! is_wp_error( $term ) ) {
			$term_ids[ $slug ] = (int) $term['term_id'];
		}
	}

	$products = array(
		array( 'Ensaimada de almendra', 'ensaimada', array( 'bolleria' ), 85, true, false, 'Masa de hojaldre, almendra, azúcar. Contiene gluten y frutos secos.' ),
		array( 'Tarta de Santiago', 'santiago', array( 'pasteles' ), 620, true, false, 'Almendra, huevo, limón. Sin harina de trigo. Contiene frutos secos y huevo.' ),
		array( 'Croissant de almendra', 'croissant', array( 'bolleria' ), 72, true, false, 'Mantequilla, almendra, masa laminada. Contiene gluten, lácteos y frutos secos.' ),
		array( 'Palmera de chocolate', 'palmera', array( 'bolleria' ), 48, false, true, 'Hojaldre y chocolate. Contiene gluten y lácteos.' ),
		array( 'Tarta de frutos del bosque', 'frutos', array( 'pasteles', 'temporada' ), 740, true, false, 'Crema, frutos rojos, bizcocho. Contiene gluten, lácteos y huevo.' ),
		array( 'Pan de masa madre', 'pan', array( 'panaderia' ), 65, false, false, 'Harina, agua, sal, masa madre. Contiene gluten.' ),
		array( 'Caja de bollería', 'caja', array( 'regalos' ), 390, true, false, 'Selección del día. Consultar alérgenos según piezas.' ),
		array( 'Tarta de sobremesa', 'tarta', array( 'pasteles' ), 890, true, false, 'Bizcocho, crema y temporada. Contiene gluten, lácteos y huevo.' ),
	);

	foreach ( $products as $item ) {
		$existing = mallorca_find_post( $item[0], 'product' );
		if ( $existing ) {
			$id = $existing->ID;
		} else {
			$id = wp_insert_post(
				array(
					'post_title'   => $item[0],
					'post_content' => __( 'Elaborada en obrador. Mejor el mismo día.', 'mallorca' ),
					'post_excerpt' => __( 'Horneada cada día.', 'mallorca' ),
					'post_status'  => 'publish',
					'post_type'    => 'product',
				)
			);
		}
		if ( is_wp_error( $id ) || ! $id ) {
			continue;
		}

		wp_set_object_terms( $id, array_map( static function ( $slug ) use ( $term_ids ) {
			return isset( $term_ids[ $slug ] ) ? $term_ids[ $slug ] : $slug;
		}, $item[2] ), 'product_cat' );

		update_post_meta( $id, '_regular_price', (string) $item[3] );
		update_post_meta( $id, '_price', (string) $item[3] );
		update_post_meta( $id, '_mallorca_ingredients', $item[6] );
		update_post_meta( $id, '_mallorca_allergens', __( 'Ver ingredientes. Informa alergias al pedir.', 'mallorca' ) );
		update_post_meta( $id, '_mallorca_conservation', __( 'Conservar en fresco. Consumir el mismo día o al siguiente.', 'mallorca' ) );
		update_post_meta( $id, '_visibility', 'visible' );

		if ( ! empty( $images[ $item[1] ] ) ) {
			set_post_thumbnail( $id, (int) $images[ $item[1] ] );
		}
		if ( $item[4] ) {
			update_post_meta( $id, '_featured', 'yes' );
			wp_set_object_terms( $id, 'featured', 'product_visibility', true );
		}
		if ( $item[5] ) {
			update_post_meta( $id, '_sale_price', '39' );
			update_post_meta( $id, '_price', '39' );
		}

		if ( 'Tarta de sobremesa' === $item[0] ) {
			wp_set_object_terms( $id, 'variable', 'product_type' );
			update_post_meta( $id, '_mallorca_servings', '8, 12 o 16 porciones' );
		} elseif ( 'Pan de masa madre' === $item[0] ) {
			update_post_meta( $id, '_stock_status', 'outofstock' );
		} else {
			wp_set_object_terms( $id, 'simple', 'product_type' );
		}
	}

	mallorca_demo_variable_product();
}

/**
 * Create size variations for the celebration cake.
 */
function mallorca_demo_variable_product() {
	if ( ! function_exists( 'wc_get_product_id_by_sku' ) ) {
		return;
	}
	$product = mallorca_find_post( 'Tarta de sobremesa', 'product' );
	if ( ! $product || ! function_exists( 'wc_create_attribute' ) ) {
		return;
	}

	$attr = 'pa_tamano';
	if ( ! taxonomy_exists( $attr ) ) {
		$attribute_id = wc_create_attribute(
			array(
				'name'         => __( 'Tamaño', 'mallorca' ),
				'slug'         => 'tamano',
				'type'         => 'select',
				'order_by'     => 'menu_order',
				'has_archives' => false,
			)
		);
		if ( ! is_wp_error( $attribute_id ) ) {
			register_taxonomy(
				$attr,
				'product',
				array(
					'hierarchical' => false,
					'label'        => __( 'Tamaño', 'mallorca' ),
					'query_var'    => true,
					'rewrite'      => false,
				)
			);
		}
	}

	$sizes = array( '8 porciones', '12 porciones', '16 porciones' );
	$ids   = array();
	foreach ( $sizes as $size ) {
		$term = term_exists( $size, $attr );
		if ( ! $term && taxonomy_exists( $attr ) ) {
			$term = wp_insert_term( $size, $attr );
		}
		if ( $term && ! is_wp_error( $term ) ) {
			$ids[] = (int) $term['term_id'];
		}
	}
	if ( $ids && taxonomy_exists( $attr ) ) {
		wp_set_object_terms( $product->ID, $ids, $attr );
		$product_attrs = array(
			$attr => array(
				'name'         => $attr,
				'value'        => '',
				'position'     => 0,
				'is_visible'   => 1,
				'is_variation' => 1,
				'is_taxonomy'  => 1,
			),
		);
		update_post_meta( $product->ID, '_product_attributes', $product_attrs );
	}
}

/**
 * Menus.
 *
 * @param array $pages Pages.
 */
function mallorca_demo_menus( $pages ) {
	$shop = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
	$left = mallorca_demo_create_menu(
		'Mallorca izquierda',
		'primary_left',
		array(
			array( __( 'Tienda', 'mallorca' ), $shop ),
			array( __( 'Pastelería', 'mallorca' ), $shop ),
			array( __( 'Restaurante', 'mallorca' ), get_permalink( $pages['restaurante'] ) ),
			array( __( 'Nuestra historia', 'mallorca' ), get_permalink( $pages['historia'] ) ),
		)
	);
	mallorca_demo_create_menu(
		'Mallorca derecha',
		'primary_right',
		array(
			array( __( 'Sucursales', 'mallorca' ), get_post_type_archive_link( 'mallorca_location' ) ),
		)
	);
	mallorca_demo_create_menu(
		'Mallorca móvil',
		'mobile',
		array(
			array( __( 'Tienda', 'mallorca' ), $shop ),
			array( __( 'Restaurante', 'mallorca' ), get_permalink( $pages['restaurante'] ) ),
			array( __( 'Nuestra historia', 'mallorca' ), get_permalink( $pages['historia'] ) ),
			array( __( 'Sucursales', 'mallorca' ), get_post_type_archive_link( 'mallorca_location' ) ),
		)
	);

	unset( $left );
}

/**
 * Create a menu.
 *
 * @param string $name     Name.
 * @param string $location Location.
 * @param array  $items    Items.
 * @return int
 */
function mallorca_demo_create_menu( $name, $location, $items ) {
	$menu = wp_get_nav_menu_object( $name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $name );
	} else {
		$menu_id = (int) $menu->term_id;
	}

	$existing = wp_get_nav_menu_items( $menu_id );
	if ( empty( $existing ) ) {
		foreach ( $items as $item ) {
			if ( ! $item[1] ) {
				continue;
			}
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'  => $item[0],
					'menu-item-url'    => $item[1],
					'menu-item-status' => 'publish',
					'menu-item-type'   => 'custom',
				)
			);
		}
	}

	$locations              = (array) get_theme_mod( 'nav_menu_locations' );
	$locations[ $location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
	return $menu_id;
}

/**
 * Customizer defaults.
 *
 * @param array $images Images.
 * @param array $pages  Pages.
 */
function mallorca_demo_customizer( $images, $pages ) {
	$map = array(
		'hero_image'     => 'hero',
		'story_image'    => 'story',
		'season_image'   => 'frutos',
		'exp_image_1'    => 'mesa',
		'exp_image_2'    => 'cafe',
		'exp_image_3'    => 'bolleria',
		'ig_image_1'     => 'ensaimada',
		'ig_image_2'     => 'croissant',
		'ig_image_3'     => 'santiago',
		'ig_image_4'     => 'cafe',
		'ig_image_5'     => 'palmera',
		'ig_image_6'     => 'caja',
	);
	foreach ( $map as $mod => $key ) {
		if ( ! empty( $images[ $key ] ) ) {
			set_theme_mod( 'mallorca_' . $mod, (int) $images[ $key ] );
		}
	}
	if ( ! empty( $pages['historia'] ) ) {
		set_theme_mod( 'mallorca_story_cta_url', get_permalink( $pages['historia'] ) );
	}
	if ( ! empty( $pages['factura'] ) ) {
		set_theme_mod( 'mallorca_factura_url', get_permalink( $pages['factura'] ) );
	}
	if ( ! empty( $pages['empleo'] ) ) {
		set_theme_mod( 'mallorca_jobs_url', get_permalink( $pages['empleo'] ) );
	}
	set_theme_mod( 'mallorca_footer_comments_url', home_url( '/#newsletter' ) );
	$lomas   = mallorca_find_post( 'Lomas', 'mallorca_location' );
	$reforma = mallorca_find_post( 'Reforma', 'mallorca_location' );
	if ( $lomas ) {
		set_theme_mod( 'mallorca_footer_location_1', (int) $lomas->ID );
	}
	if ( $reforma ) {
		set_theme_mod( 'mallorca_footer_location_2', (int) $reforma->ID );
	}
}

/**
 * Build Elementor document on the front page.
 *
 * @param int   $page_id Page ID.
 * @param array $images  Images.
 */
function mallorca_demo_elementor_home( $page_id, $images ) {
	if ( ! $page_id || ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	$widgets = array( 'mallorca_hero', 'mallorca_categories', 'mallorca_featured', 'mallorca_story', 'mallorca_season', 'mallorca_experience', 'mallorca_locations', 'mallorca_instagram', 'mallorca_newsletter', 'mallorca_cta' );
	$data    = array();
	foreach ( $widgets as $widget ) {
		$data[] = mallorca_elementor_section( $widget, $images );
	}

	update_post_meta( $page_id, '_elementor_edit_mode', 'builder' );
	update_post_meta( $page_id, '_elementor_template_type', 'wp-page' );
	update_post_meta( $page_id, '_elementor_version', '3.20.0' );
	update_post_meta( $page_id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
	update_post_meta( $page_id, '_wp_page_template', 'templates/elementor-fullwidth.php' );
}

/**
 * Elementor documents for shop, product, cart and checkout.
 */
function mallorca_demo_elementor_woocommerce() {
	if ( ! did_action( 'elementor/loaded' ) || ! function_exists( 'wc_get_page_id' ) ) {
		return;
	}

	$map = array(
		'shop'     => array( 'mallorca_shop', 'templates/template-shop.php' ),
		'cart'     => array( 'mallorca_cart', 'templates/template-cart.php' ),
		'checkout' => array( 'mallorca_checkout', 'templates/template-checkout.php' ),
	);

	foreach ( $map as $page => $data ) {
		$id = wc_get_page_id( $page );
		if ( $id && $id > 0 ) {
			mallorca_apply_elementor_widget_document( $id, $data[0] );
			update_post_meta( $id, '_wp_page_template', $data[1] );
		}
	}

	$product_id = (int) get_option( 'mallorca_elementor_product_template', 0 );
	if ( ! $product_id || ! get_post( $product_id ) ) {
		$post_type  = post_type_exists( 'elementor_library' ) ? 'elementor_library' : 'page';
		$product_id = wp_insert_post(
			array(
				'post_title'  => __( 'Mallorca — Producto', 'mallorca' ),
				'post_status' => 'publish',
				'post_type'   => $post_type,
				'post_name'   => 'mallorca-producto',
			)
		);
	}

	if ( $product_id && ! is_wp_error( $product_id ) ) {
		$type = post_type_exists( 'elementor_library' ) ? 'product' : 'wp-page';
		mallorca_apply_elementor_widget_document( (int) $product_id, 'mallorca_product', $type );
		update_post_meta( (int) $product_id, '_mallorca_wc_template', 'product' );
		if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			update_post_meta( (int) $product_id, '_elementor_conditions', array( 'include/woocommerce/product' ) );
		}
		update_option( 'mallorca_elementor_product_template', (int) $product_id );
	}
}

/**
 * One full-width Elementor section wrapping a Mallorca widget.
 *
 * @param string $widget Widget name.
 * @param array  $images Images.
 * @return array
 */
function mallorca_elementor_section( $widget, $images ) {
	$settings = array();
	if ( 'mallorca_hero' === $widget && ! empty( $images['hero'] ) ) {
		$settings['image'] = array( 'id' => (int) $images['hero'], 'url' => wp_get_attachment_url( $images['hero'] ) );
	}
	if ( 'mallorca_story' === $widget && ! empty( $images['story'] ) ) {
		$settings['image'] = array( 'id' => (int) $images['story'], 'url' => wp_get_attachment_url( $images['story'] ) );
	}
	if ( 'mallorca_season' === $widget && ! empty( $images['frutos'] ) ) {
		$settings['image'] = array( 'id' => (int) $images['frutos'], 'url' => wp_get_attachment_url( $images['frutos'] ) );
	}

	return array(
		'id'       => substr( md5( $widget . wp_rand() ), 0, 7 ),
		'elType'   => 'section',
		'isInner'  => false,
		'settings' => array(
			'layout'          => 'full_width',
			'stretch_section' => 'section-stretched',
			'gap'             => 'no',
		),
		'elements' => array(
			array(
				'id'       => substr( md5( $widget . 'col' . wp_rand() ), 0, 7 ),
				'elType'   => 'column',
				'isInner'  => false,
				'settings' => array( '_column_size' => 100 ),
				'elements' => array(
					array(
						'id'         => substr( md5( $widget . 'w' . wp_rand() ), 0, 7 ),
						'elType'     => 'widget',
						'widgetType' => $widget,
						'settings'   => $settings,
						'elements'   => array(),
					),
				),
			),
		),
	);
}

add_action(
	'after_switch_theme',
	static function () {
		flush_rewrite_rules();
	}
);

/**
 * Find a post by title and type.
 *
 * @param string $title Title.
 * @param string $type  Post type.
 * @return WP_Post|null
 */
function mallorca_find_post( $title, $type ) {
	$query = new WP_Query(
		array(
			'post_type'              => $type,
			'title'                  => $title,
			'posts_per_page'         => 1,
			'post_status'            => 'any',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);
	return $query->have_posts() ? $query->posts[0] : null;
}
