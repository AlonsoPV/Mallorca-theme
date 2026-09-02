<?php
/**
 * Template helpers.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme mod with fallback.
 *
 * @param string $key     Mod key without prefix.
 * @param mixed  $default Default.
 * @return mixed
 */
function mallorca_mod( $key, $default = '' ) {
	return get_theme_mod( 'mallorca_' . $key, $default );
}

/**
 * Resolve a section argument from Elementor widget args or Customizer.
 *
 * @param array  $args     Template args.
 * @param string $key      Widget setting key.
 * @param string $mod_key  Theme mod key.
 * @param mixed  $default  Default.
 * @return mixed
 */
function mallorca_arg( $args, $key, $mod_key, $default = '' ) {
	if ( is_array( $args ) && isset( $args[ $key ] ) && '' !== $args[ $key ] && null !== $args[ $key ] ) {
		$value = $args[ $key ];
		if ( is_array( $value ) && isset( $value['url'] ) && ! isset( $value['id'] ) ) {
			return $value['url'];
		}
		return $value;
	}
	return mallorca_mod( $mod_key, $default );
}

/**
 * Attachment ID from Elementor media or Customizer.
 *
 * @param array  $args    Args.
 * @param string $key     Widget key.
 * @param string $mod_key Mod key.
 * @return int
 */
function mallorca_arg_image_id( $args, $key, $mod_key ) {
	if ( is_array( $args ) && ! empty( $args[ $key ]['id'] ) ) {
		return (int) $args[ $key ]['id'];
	}
	return (int) mallorca_mod( $mod_key, 0 );
}

/**
 * Cart, checkout or account screens.
 *
 * @return bool
 */
function mallorca_is_commerce_page() {
	if ( ! function_exists( 'is_woocommerce' ) ) {
		return false;
	}

	return is_cart() || is_checkout() || is_account_page() || is_wc_endpoint_url();
}

/**
 * Whether the current queried object was built with Elementor.
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function mallorca_is_elementor_page( $post_id = 0 ) {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return false;
	}

	$post_id = $post_id ? (int) $post_id : get_queried_object_id();
	if ( ! $post_id ) {
		return false;
	}

	return 'builder' === get_post_meta( $post_id, '_elementor_edit_mode', true ) && get_post_meta( $post_id, '_elementor_data', true );
}

/**
 * Attachment image HTML or theme demo fallback.
 *
 * @param int    $attachment_id Attachment ID.
 * @param string $size          Size.
 * @param string $fallback_rel  Relative path under theme.
 * @param array  $attr          Img attributes.
 * @return string
 */
function mallorca_image( $attachment_id, $size = 'large', $fallback_rel = '', $attr = array() ) {
	if ( $attachment_id ) {
		$html = wp_get_attachment_image( (int) $attachment_id, $size, false, $attr );
		if ( $html ) {
			return $html;
		}
	}

	if ( ! $fallback_rel ) {
		return '';
	}

	$src = MALLORCA_URI . $fallback_rel;
	$alt = isset( $attr['alt'] ) ? $attr['alt'] : '';
	$class = isset( $attr['class'] ) ? $attr['class'] : '';
	$loading = isset( $attr['loading'] ) ? $attr['loading'] : 'lazy';
	$fetch = isset( $attr['fetchpriority'] ) ? $attr['fetchpriority'] : '';

	$html  = '<img src="' . esc_url( $src ) . '" alt="' . esc_attr( $alt ) . '" class="' . esc_attr( $class ) . '" loading="' . esc_attr( $loading ) . '"';
	if ( $fetch ) {
		$html .= ' fetchpriority="' . esc_attr( $fetch ) . '"';
	}
	$html .= ' />';

	return $html;
}

/**
 * SVG icon.
 *
 * @param string $name Icon name.
 * @return string
 */
function mallorca_icon( $name ) {
	$icons = array(
		'search'   => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.2-3.2"/></svg>',
		'cart'     => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M6 7h15l-1.4 8.2a2 2 0 0 1-2 1.8H9.2a2 2 0 0 1-2-1.7L5 4H2"/><circle cx="10" cy="20" r="1.3"/><circle cx="18" cy="20" r="1.3"/></svg>',
		'user'     => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><circle cx="12" cy="8" r="3.2"/><path d="M5 19c1.4-3 3.8-4.5 7-4.5S17.6 16 19 19"/></svg>',
		'menu'     => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h10"/></svg>',
		'close'    => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>',
		'pin'      => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M12 21s7-6.2 7-11a7 7 0 1 0-14 0c0 4.8 7 11 7 11z"/><circle cx="12" cy="10" r="2"/></svg>',
		'whatsapp' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.33 4.94L2 22l5.4-1.41a10 10 0 0 0 4.64 1.12h.01c5.46 0 9.89-4.4 9.89-9.83C21.94 6.4 17.5 2 12.04 2zm5.72 13.98c-.24.67-1.4 1.28-1.94 1.36-.5.08-1.12.11-1.81-.11-.42-.13-.95-.31-1.64-.6-2.89-1.25-4.77-4.15-4.92-4.35-.14-.2-1.18-1.57-1.18-3 0-1.42.74-2.12 1.01-2.41.26-.28.58-.35.77-.35h.56c.18 0 .42-.07.66.5.24.58.82 2 .89 2.15.07.14.12.31.02.5-.1.2-.15.31-.3.48-.14.16-.3.36-.43.49-.14.14-.29.29-.12.56.16.28.73 1.2 1.56 1.95 1.07.96 1.97 1.26 2.25 1.4.28.14.44.12.6-.07.16-.2.7-.81.88-1.09.18-.28.37-.23.62-.14.26.09 1.63.77 1.91.91.28.14.46.21.53.33.07.12.07.67-.17 1.34z"/></svg>',
		'instagram'=> '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.8" fill="currentColor"/></svg>',
		'facebook' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 9h3V6h-3c-2.2 0-4 1.8-4 4v2H8v3h2v7h3v-7h3l1-3h-4V10c0-.6.4-1 1-1z"/></svg>',
		'arrow'    => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>',
		'clock'    => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><circle cx="12" cy="12" r="8"/><path d="M12 8v4.5l3 1.5"/></svg>',
		'phone'    => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M7.2 3.8h2.4l1.1 3.3-1.6 1.1a12 12 0 0 0 5.7 5.7l1.1-1.6 3.3 1.1v2.4c0 .7-.6 1.3-1.3 1.3C10.4 17.1 6.9 13.6 6 7.1c0-.7.6-1.3 1.2-1.3z"/></svg>',
		'mail'     => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><rect x="3.5" y="5.5" width="17" height="13" rx="1.5"/><path d="M4 7l8 6 8-6"/></svg>',
		'comment'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M5 16.5V7.8A2.3 2.3 0 0 1 7.3 5.5h9.4A2.3 2.3 0 0 1 19 7.8v6.2a2.3 2.3 0 0 1-2.3 2.3H9.2L5 19.2v-2.7z"/></svg>',
		'linkedin' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.2 9.2H3.7V20h2.5V9.2zM5 3.5A1.6 1.6 0 1 0 5 6.7 1.6 1.6 0 0 0 5 3.5zM20.3 20h-2.5v-5.6c0-1.7-.7-2.3-1.8-2.3s-1.8.9-1.8 2.3V20h-2.5V9.2h2.5v1.5c.5-.9 1.7-1.8 3.2-1.8 2.2 0 3 1.5 3 4.3V20z"/></svg>',
		'tripadvisor' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><circle cx="8" cy="12" r="3.1"/><circle cx="16" cy="12" r="3.1"/><circle cx="8" cy="12" r="1" fill="currentColor" stroke="none"/><circle cx="16" cy="12" r="1" fill="currentColor" stroke="none"/><path d="M2.8 12h2.1M19.1 12h2.1M8 8.9 12 5.8l4 3.1"/></svg>',
		'flag'     => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M6 20V5.5h11l-2.2 3.2 2.2 3.3H6"/></svg>',
		'invoice'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M7 3.8h10v16.4l-2-1.2-3 1.5-3-1.5-2 1.2V3.8z"/><path d="M9 8h6M9 11.5h6M9 15h3.5"/></svg>',
		'briefcase'=> '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><rect x="3.5" y="8" width="17" height="11.5" rx="1.2"/><path d="M8.5 8V6.2A1.7 1.7 0 0 1 10.2 4.5h3.6A1.7 1.7 0 0 1 15.5 6.2V8M3.5 13h17"/></svg>',
	);

	return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

/**
 * Cart item count.
 *
 * @return int
 */
function mallorca_cart_count() {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return 0;
	}
	return (int) WC()->cart->get_cart_contents_count();
}

/**
 * Shop URL.
 *
 * @return string
 */
function mallorca_shop_url() {
	if ( function_exists( 'wc_get_page_permalink' ) ) {
		return wc_get_page_permalink( 'shop' );
	}
	return home_url( '/' );
}

/**
 * Account URL.
 *
 * @return string
 */
function mallorca_account_url() {
	if ( function_exists( 'wc_get_page_permalink' ) ) {
		return wc_get_page_permalink( 'myaccount' );
	}
	return wp_login_url();
}

/**
 * Cart URL.
 *
 * @return string
 */
function mallorca_cart_url() {
	if ( function_exists( 'wc_get_cart_url' ) ) {
		return wc_get_cart_url();
	}
	return home_url( '/' );
}

/**
 * Checkout URL.
 *
 * @return string
 */
function mallorca_checkout_url() {
	if ( function_exists( 'wc_get_checkout_url' ) ) {
		return wc_get_checkout_url();
	}
	return home_url( '/' );
}

/**
 * Historia page URL.
 *
 * @return string
 */
function mallorca_historia_url() {
	$page = get_page_by_path( 'nuestra-historia' );
	if ( $page instanceof WP_Post ) {
		return get_permalink( $page );
	}
	return home_url( '/nuestra-historia/' );
}

/**
 * Locations archive URL.
 *
 * @return string
 */
function mallorca_locations_url() {
	$archive = get_post_type_archive_link( 'mallorca_location' );
	return $archive ? $archive : home_url( '/sucursales/' );
}

/**
 * Permalink for a page slug, with fallback.
 *
 * @param string $slug    Page slug.
 * @param string $fallback Fallback URL.
 * @return string
 */
function mallorca_page_url( $slug, $fallback = '' ) {
	$page = get_page_by_path( $slug );
	if ( $page instanceof WP_Post ) {
		return get_permalink( $page );
	}
	return $fallback ? $fallback : home_url( '/' . trim( $slug, '/' ) . '/' );
}

/**
 * Discover links for the footer "Conoce más" column.
 * Empty URLs are omitted.
 *
 * @return array
 */
function mallorca_footer_discover_links() {
	$links = array(
		array(
			'icon'  => 'instagram',
			'label' => __( 'Instagram', 'mallorca' ),
			'url'   => mallorca_mod( 'instagram_url' ),
		),
		array(
			'icon'  => 'linkedin',
			'label' => __( 'LinkedIn', 'mallorca' ),
			'url'   => mallorca_mod( 'linkedin_url' ),
		),
		array(
			'icon'  => 'tripadvisor',
			'label' => __( 'Trip Advisor', 'mallorca' ),
			'url'   => mallorca_mod( 'tripadvisor_url' ),
		),
		array(
			'icon'  => 'flag',
			'label' => __( 'Mallorca España', 'mallorca' ),
			'url'   => mallorca_mod( 'espana_url' ),
		),
		array(
			'icon'  => 'invoice',
			'label' => __( 'Factura', 'mallorca' ),
			'url'   => mallorca_mod( 'factura_url' ),
		),
		array(
			'icon'  => 'briefcase',
			'label' => __( 'Bolsa de trabajo', 'mallorca' ),
			'url'   => mallorca_mod( 'jobs_url' ),
		),
	);

	return array_values(
		array_filter(
			$links,
			static function ( $item ) {
				return ! empty( $item['url'] );
			}
		)
	);
}

/**
 * Whether a URL points outside this site.
 *
 * @param string $url URL.
 * @return bool
 */
function mallorca_is_external_url( $url ) {
	if ( ! $url || 0 !== strpos( $url, 'http' ) ) {
		return false;
	}
	$home_host = wp_parse_url( home_url(), PHP_URL_HOST );
	$link_host = wp_parse_url( $url, PHP_URL_HOST );
	return $home_host && $link_host && 0 !== strcasecmp( $home_host, $link_host );
}

/**
 * Visible heading for a location in the footer.
 *
 * @param string $name Location name.
 * @return string
 */
function mallorca_footer_location_heading( $name ) {
	$name = trim( (string) $name );
	if ( '' === $name ) {
		return __( 'Mallorca', 'mallorca' );
	}
	if ( 0 === stripos( $name, 'mallorca' ) ) {
		return $name;
	}
	return sprintf( __( 'Mallorca %s', 'mallorca' ), $name );
}

/**
 * Demo fallbacks when no sucursales exist yet.
 *
 * @return array
 */
function mallorca_footer_location_fallbacks() {
	return array(
		array(
			'id'        => 0,
			'heading'   => __( 'Mallorca Lomas', 'mallorca' ),
			'phone'     => '55 9131 7108',
			'email'     => 'explanada@pasteleria-mallorca.mx',
			'address'   => 'Av. Explanada 710, Lomas - Virreyes, Lomas de Chapultepec IV Secc, Miguel Hidalgo, 11000',
			'maps'      => 'https://maps.google.com/?q=Av+Explanada+710+Lomas+de+Chapultepec',
			'permalink' => mallorca_locations_url(),
		),
		array(
			'id'        => 0,
			'heading'   => __( 'Mallorca Reforma', 'mallorca' ),
			'phone'     => '55 1268 5557',
			'email'     => 'reforma@pasteleria-mallorca.mx',
			'address'   => 'Av. Paseo de la Reforma 365, Cuauhtémoc, 06500',
			'maps'      => 'https://maps.google.com/?q=Paseo+de+la+Reforma+365+Ciudad+de+Mexico',
			'permalink' => mallorca_locations_url(),
		),
	);
}

/**
 * Footer location payload from a CPT post.
 *
 * @param int $post_id Post ID.
 * @return array|null
 */
function mallorca_footer_location_from_id( $post_id ) {
	$post_id = (int) $post_id;
	if ( ! $post_id ) {
		return null;
	}
	$post = get_post( $post_id );
	if ( ! $post || 'mallorca_location' !== $post->post_type || 'publish' !== $post->post_status ) {
		return null;
	}

	$name = mallorca_location_meta( $post_id, 'location_name' );
	$name = $name ? $name : $post->post_title;

	return array(
		'id'        => $post_id,
		'heading'   => mallorca_footer_location_heading( $name ),
		'phone'     => mallorca_location_meta( $post_id, 'phone' ),
		'email'     => mallorca_location_meta( $post_id, 'email' ),
		'address'   => mallorca_location_meta( $post_id, 'address' ),
		'maps'      => mallorca_location_meta( $post_id, 'google_maps_url' ),
		'permalink' => get_permalink( $post ),
	);
}

/**
 * Two sucursales for the footer, from Customizer then CPT then demo fallbacks.
 *
 * @return array
 */
function mallorca_footer_selected_locations() {
	$selected = array(
		(int) mallorca_mod( 'footer_location_1', 0 ),
		(int) mallorca_mod( 'footer_location_2', 0 ),
	);
	$out      = array();
	$used     = array();

	foreach ( $selected as $id ) {
		$data = mallorca_footer_location_from_id( $id );
		if ( $data ) {
			$out[]  = $data;
			$used[] = (int) $data['id'];
		}
	}

	if ( count( $out ) < 2 ) {
		$posts = get_posts(
			array(
				'post_type'      => 'mallorca_location',
				'post_status'    => 'publish',
				'posts_per_page' => 4,
				'orderby'        => array(
					'menu_order' => 'ASC',
					'title'      => 'ASC',
				),
				'post__not_in'   => $used,
				'no_found_rows'  => true,
			)
		);
		foreach ( $posts as $post ) {
			if ( count( $out ) >= 2 ) {
				break;
			}
			$data = mallorca_footer_location_from_id( $post->ID );
			if ( $data ) {
				$out[]  = $data;
				$used[] = (int) $data['id'];
			}
		}
	}

	if ( count( $out ) < 2 ) {
		foreach ( mallorca_footer_location_fallbacks() as $fallback ) {
			if ( count( $out ) >= 2 ) {
				break;
			}
			$out[] = $fallback;
		}
	}

	return array_slice( $out, 0, 2 );
}

/**
 * Choices for footer location dropdowns.
 *
 * @return array
 */
function mallorca_footer_location_choices() {
	$choices = array( 0 => __( '— Automático —', 'mallorca' ) );
	$posts   = get_posts(
		array(
			'post_type'      => 'mallorca_location',
			'post_status'    => 'publish',
			'posts_per_page' => 50,
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);
	foreach ( $posts as $post ) {
		$choices[ (int) $post->ID ] = $post->post_title;
	}
	return $choices;
}

/**
 * Render a nav menu or a fallback list of links.
 *
 * @param string $location Menu location.
 * @param array  $fallback Fallback items key => url.
 */
function mallorca_nav( $location, $fallback = array() ) {
	if ( has_nav_menu( $location ) ) {
		wp_nav_menu(
			array(
				'theme_location' => $location,
				'container'      => false,
				'menu_class'     => 'mallorca-nav-list',
				'fallback_cb'    => false,
				'depth'          => 2,
			)
		);
		return;
	}

	if ( empty( $fallback ) ) {
		return;
	}

	echo '<ul class="mallorca-nav-list">';
	foreach ( $fallback as $label => $url ) {
		echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Location meta.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Meta key without prefix.
 * @return string
 */
function mallorca_location_meta( $post_id, $key ) {
	return (string) get_post_meta( $post_id, '_mallorca_' . $key, true );
}

/**
 * Product extra meta.
 *
 * @param int    $product_id Product ID.
 * @param string $key        Meta key.
 * @return string
 */
function mallorca_product_extra( $product_id, $key ) {
	return (string) get_post_meta( $product_id, '_mallorca_' . $key, true );
}

/**
 * Default copy used until Customizer is saved.
 *
 * @return array
 */
function mallorca_default_copy() {
	return array(
		'hero_kicker'     => __( 'Pastelería Mallorca', 'mallorca' ),
		'hero_title'      => __( 'Tradición española.', 'mallorca' ),
		'hero_subtitle'   => __( 'Horneada cada día en México.', 'mallorca' ),
		'hero_cta'        => __( 'Descubrir la pastelería', 'mallorca' ),
		'hero_cta2'       => __( 'Comprar online', 'mallorca' ),
		'story_kicker'    => __( 'Quiénes somos', 'mallorca' ),
		'story_title'     => __( 'De Madrid a México.', 'mallorca' ),
		'story_text'      => __( 'Mallorca nace del obrador: masas que reposan, azúcar que cae y el ritmo de una pastelería española. En la Ciudad de México esa tradición se sienta a la mesa con hospitalidad local, entre el café, la bollería y la sobremesa.', 'mallorca' ),
		'story_text_2'    => __( 'No es una réplica. Es un encuentro: el sabor de siempre, horneado aquí cada día.', 'mallorca' ),
		'story_cta'       => __( 'Nuestra historia', 'mallorca' ),
		'featured_title'  => __( 'Favoritos de Mallorca', 'mallorca' ),
		'cats_title'      => __( 'El obrador', 'mallorca' ),
		'season_kicker'   => __( 'Colección', 'mallorca' ),
		'season_title'    => __( 'El calendario también se hornea', 'mallorca' ),
		'season_text'     => __( 'Roscas, cajas de temporada y mesas que se visten según el mes. Una colección para regalar o sentarse a la mesa.', 'mallorca' ),
		'season_cta'      => __( 'Ver la colección', 'mallorca' ),
		'exp_title'       => __( 'La experiencia Mallorca', 'mallorca' ),
		'exp_1'           => __( 'Una mesa', 'mallorca' ),
		'exp_2'           => __( 'Un café', 'mallorca' ),
		'exp_3'           => __( 'Una pieza de bollería', 'mallorca' ),
		'loc_title'       => __( 'Sucursales', 'mallorca' ),
		'ig_title'        => __( 'En la mesa y en el obrador', 'mallorca' ),
		'news_title'      => __( 'Un poco de Mallorca en tu correo.', 'mallorca' ),
		'news_text'       => __( 'Temporadas, hornadas y mesas. Sin ruido.', 'mallorca' ),
		'news_cta'        => __( 'Suscribirme', 'mallorca' ),
	);
}
