<?php
/**
 * Customizer: identity, home sections, social.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function mallorca_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'mallorca_panel',
		array(
			'title'       => __( 'Mallorca', 'mallorca' ),
			'description' => __( 'Identidad, portada, sucursales y redes. Si la portada se edita con Elementor, los widgets del tema tienen prioridad sobre estas secciones.', 'mallorca' ),
			'priority'    => 30,
		)
	);

	mallorca_customizer_colors( $wp_customize );
	mallorca_customizer_type( $wp_customize );
	mallorca_customizer_hero( $wp_customize );
	mallorca_customizer_story( $wp_customize );
	mallorca_customizer_season( $wp_customize );
	mallorca_customizer_experience( $wp_customize );
	mallorca_customizer_social( $wp_customize );
	mallorca_customizer_newsletter( $wp_customize );
	mallorca_customizer_instagram( $wp_customize );
	mallorca_customizer_footer( $wp_customize );
}
add_action( 'customize_register', 'mallorca_customize_register' );

/**
 * Color settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function mallorca_customizer_colors( $wp_customize ) {
	$wp_customize->add_section( 'mallorca_colors', array( 'title' => __( 'Colores', 'mallorca' ), 'panel' => 'mallorca_panel' ) );
	$colors = array(
		'color_ivory'     => array( __( 'Marfil', 'mallorca' ), '#F6F1E8' ),
		'color_bone'      => array( __( 'Hueso', 'mallorca' ), '#EBE4D8' ),
		'color_cream'     => array( __( 'Crema', 'mallorca' ), '#F3EDE3' ),
		'color_ink'       => array( __( 'Tinta', 'mallorca' ), '#2B2118' ),
		'color_burgundy'  => array( __( 'Rojo Mallorca', 'mallorca' ), '#DC1427' ),
		'color_chocolate' => array( __( 'Chocolate', 'mallorca' ), '#3D2418' ),
		'color_olive'     => array( __( 'Oliva', 'mallorca' ), '#5A5840' ),
		'color_sand'      => array( __( 'Arena', 'mallorca' ), '#C9BBA6' ),
	);
	foreach ( $colors as $id => $data ) {
		$wp_customize->add_setting( 'mallorca_' . $id, array( 'default' => $data[1], 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'refresh' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mallorca_' . $id, array( 'label' => $data[0], 'section' => 'mallorca_colors' ) ) );
	}
}

/**
 * Type presets.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function mallorca_customizer_type( $wp_customize ) {
	$wp_customize->add_section( 'mallorca_type', array( 'title' => __( 'Tipografía', 'mallorca' ), 'panel' => 'mallorca_panel' ) );
	$wp_customize->add_setting( 'mallorca_type_preset', array( 'default' => 'editorial', 'sanitize_callback' => 'sanitize_key' ) );
	$wp_customize->add_control(
		'mallorca_type_preset',
		array(
			'label'   => __( 'Estilo tipográfico', 'mallorca' ),
			'section' => 'mallorca_type',
			'type'    => 'select',
			'choices' => array(
				'editorial'      => __( 'Editorial (serif + sans)', 'mallorca' ),
				'clasica'        => __( 'Clásica', 'mallorca' ),
				'contemporanea'  => __( 'Contemporánea (sans)', 'mallorca' ),
			),
		)
	);
}

/**
 * Hero.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function mallorca_customizer_hero( $wp_customize ) {
	$copy = mallorca_default_copy();
	$wp_customize->add_section( 'mallorca_hero', array( 'title' => __( 'Hero', 'mallorca' ), 'panel' => 'mallorca_panel' ) );
	mallorca_customizer_text( $wp_customize, 'hero_kicker', __( 'Kicker', 'mallorca' ), 'mallorca_hero', $copy['hero_kicker'] );
	mallorca_customizer_text( $wp_customize, 'hero_title', __( 'Título', 'mallorca' ), 'mallorca_hero', $copy['hero_title'] );
	mallorca_customizer_textarea( $wp_customize, 'hero_subtitle', __( 'Subtítulo', 'mallorca' ), 'mallorca_hero', $copy['hero_subtitle'] );
	mallorca_customizer_text( $wp_customize, 'hero_cta', __( 'CTA principal', 'mallorca' ), 'mallorca_hero', $copy['hero_cta'] );
	mallorca_customizer_text( $wp_customize, 'hero_cta_url', __( 'URL CTA principal', 'mallorca' ), 'mallorca_hero', '' );
	mallorca_customizer_text( $wp_customize, 'hero_cta2', __( 'CTA secundario', 'mallorca' ), 'mallorca_hero', $copy['hero_cta2'] );
	mallorca_customizer_text( $wp_customize, 'hero_cta2_url', __( 'URL CTA secundario', 'mallorca' ), 'mallorca_hero', '' );
	$wp_customize->add_setting( 'mallorca_hero_image', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'mallorca_hero_image', array( 'label' => __( 'Fotografía', 'mallorca' ), 'section' => 'mallorca_hero', 'mime_type' => 'image' ) ) );
}

/**
 * Story.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function mallorca_customizer_story( $wp_customize ) {
	$copy = mallorca_default_copy();
	$wp_customize->add_section( 'mallorca_story', array( 'title' => __( 'Historia', 'mallorca' ), 'panel' => 'mallorca_panel' ) );
	mallorca_customizer_text( $wp_customize, 'story_kicker', __( 'Kicker', 'mallorca' ), 'mallorca_story', $copy['story_kicker'] );
	mallorca_customizer_text( $wp_customize, 'story_title', __( 'Título', 'mallorca' ), 'mallorca_story', $copy['story_title'] );
	mallorca_customizer_textarea( $wp_customize, 'story_text', __( 'Párrafo 1', 'mallorca' ), 'mallorca_story', $copy['story_text'] );
	mallorca_customizer_textarea( $wp_customize, 'story_text_2', __( 'Párrafo 2', 'mallorca' ), 'mallorca_story', $copy['story_text_2'] );
	mallorca_customizer_text( $wp_customize, 'story_cta', __( 'CTA', 'mallorca' ), 'mallorca_story', $copy['story_cta'] );
	mallorca_customizer_text( $wp_customize, 'story_cta_url', __( 'URL', 'mallorca' ), 'mallorca_story', '' );
	$wp_customize->add_setting( 'mallorca_story_image', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'mallorca_story_image', array( 'label' => __( 'Fotografía', 'mallorca' ), 'section' => 'mallorca_story', 'mime_type' => 'image' ) ) );
}

/**
 * Season banner.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function mallorca_customizer_season( $wp_customize ) {
	$copy = mallorca_default_copy();
	$wp_customize->add_section( 'mallorca_season', array( 'title' => __( 'Colección de temporada', 'mallorca' ), 'panel' => 'mallorca_panel' ) );
	mallorca_customizer_text( $wp_customize, 'season_kicker', __( 'Kicker', 'mallorca' ), 'mallorca_season', $copy['season_kicker'] );
	mallorca_customizer_text( $wp_customize, 'season_title', __( 'Título', 'mallorca' ), 'mallorca_season', $copy['season_title'] );
	mallorca_customizer_textarea( $wp_customize, 'season_text', __( 'Texto', 'mallorca' ), 'mallorca_season', $copy['season_text'] );
	mallorca_customizer_text( $wp_customize, 'season_cta', __( 'CTA', 'mallorca' ), 'mallorca_season', $copy['season_cta'] );
	mallorca_customizer_text( $wp_customize, 'season_cta_url', __( 'URL', 'mallorca' ), 'mallorca_season', '' );
	$wp_customize->add_setting( 'mallorca_season_image', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'mallorca_season_image', array( 'label' => __( 'Fotografía', 'mallorca' ), 'section' => 'mallorca_season', 'mime_type' => 'image' ) ) );
	$wp_customize->add_setting( 'mallorca_season_category', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
	$choices = array( 0 => __( '— Categoría WooCommerce —', 'mallorca' ) );
	if ( taxonomy_exists( 'product_cat' ) ) {
		$terms = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false ) );
		if ( ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$choices[ $term->term_id ] = $term->name;
			}
		}
	}
	$wp_customize->add_control(
		'mallorca_season_category',
		array(
			'label'   => __( 'Colección (categoría)', 'mallorca' ),
			'section' => 'mallorca_season',
			'type'    => 'select',
			'choices' => $choices,
		)
	);
}

/**
 * Experience photos.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function mallorca_customizer_experience( $wp_customize ) {
	$copy = mallorca_default_copy();
	$wp_customize->add_section( 'mallorca_experience', array( 'title' => __( 'Experiencia', 'mallorca' ), 'panel' => 'mallorca_panel' ) );
	mallorca_customizer_text( $wp_customize, 'exp_title', __( 'Título', 'mallorca' ), 'mallorca_experience', $copy['exp_title'] );
	for ( $i = 1; $i <= 3; $i++ ) {
		mallorca_customizer_text( $wp_customize, 'exp_' . $i, sprintf( __( 'Leyenda %d', 'mallorca' ), $i ), 'mallorca_experience', $copy[ 'exp_' . $i ] );
		$wp_customize->add_setting( 'mallorca_exp_image_' . $i, array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'mallorca_exp_image_' . $i, array( 'label' => sprintf( __( 'Foto %d', 'mallorca' ), $i ), 'section' => 'mallorca_experience', 'mime_type' => 'image' ) ) );
	}
}

/**
 * Social / WhatsApp.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function mallorca_customizer_social( $wp_customize ) {
	$wp_customize->add_section( 'mallorca_social', array( 'title' => __( 'Redes y WhatsApp', 'mallorca' ), 'panel' => 'mallorca_panel' ) );
	mallorca_customizer_url( $wp_customize, 'instagram_url', __( 'Instagram', 'mallorca' ), 'mallorca_social' );
	mallorca_customizer_url( $wp_customize, 'facebook_url', __( 'Facebook', 'mallorca' ), 'mallorca_social' );
	mallorca_customizer_url( $wp_customize, 'linkedin_url', __( 'LinkedIn', 'mallorca' ), 'mallorca_social' );
	mallorca_customizer_url( $wp_customize, 'tripadvisor_url', __( 'Trip Advisor', 'mallorca' ), 'mallorca_social' );
	mallorca_customizer_text( $wp_customize, 'whatsapp', __( 'WhatsApp (número)', 'mallorca' ), 'mallorca_social', '' );
	mallorca_customizer_text( $wp_customize, 'phone', __( 'Teléfono', 'mallorca' ), 'mallorca_social', '' );
}

/**
 * Newsletter.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function mallorca_customizer_newsletter( $wp_customize ) {
	$copy = mallorca_default_copy();
	$wp_customize->add_section( 'mallorca_newsletter', array( 'title' => __( 'Newsletter', 'mallorca' ), 'panel' => 'mallorca_panel' ) );
	mallorca_customizer_text( $wp_customize, 'news_title', __( 'Título', 'mallorca' ), 'mallorca_newsletter', $copy['news_title'] );
	mallorca_customizer_textarea( $wp_customize, 'news_text', __( 'Texto', 'mallorca' ), 'mallorca_newsletter', $copy['news_text'] );
	mallorca_customizer_text( $wp_customize, 'news_cta', __( 'Botón', 'mallorca' ), 'mallorca_newsletter', $copy['news_cta'] );
	mallorca_customizer_textarea( $wp_customize, 'news_shortcode', __( 'Shortcode (Mailchimp / Brevo / Fluent Forms)', 'mallorca' ), 'mallorca_newsletter', '' );
}

/**
 * Instagram grid images.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function mallorca_customizer_instagram( $wp_customize ) {
	$copy = mallorca_default_copy();
	$wp_customize->add_section( 'mallorca_instagram', array( 'title' => __( 'Instagram', 'mallorca' ), 'panel' => 'mallorca_panel' ) );
	mallorca_customizer_text( $wp_customize, 'ig_title', __( 'Título', 'mallorca' ), 'mallorca_instagram', $copy['ig_title'] );
	mallorca_customizer_textarea( $wp_customize, 'ig_shortcode', __( 'Shortcode de plugin (opcional)', 'mallorca' ), 'mallorca_instagram', '' );
	for ( $i = 1; $i <= 6; $i++ ) {
		$wp_customize->add_setting( 'mallorca_ig_image_' . $i, array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'mallorca_ig_image_' . $i, array( 'label' => sprintf( __( 'Imagen %d', 'mallorca' ), $i ), 'section' => 'mallorca_instagram', 'mime_type' => 'image' ) ) );
	}
}

/**
 * Footer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function mallorca_customizer_footer( $wp_customize ) {
	$wp_customize->add_section(
		'mallorca_footer',
		array(
			'title'       => __( 'Footer', 'mallorca' ),
			'description' => __( 'Si un enlace queda vacío, no se muestra. Las sucursales salen del CPT; elige cuáles aparecen en las columnas 3 y 4.', 'mallorca' ),
			'panel'       => 'mallorca_panel',
		)
	);
	mallorca_customizer_url( $wp_customize, 'footer_comments_url', __( 'URL de comentarios', 'mallorca' ), 'mallorca_footer' );
	mallorca_customizer_url( $wp_customize, 'espana_url', __( 'Mallorca España', 'mallorca' ), 'mallorca_footer' );
	mallorca_customizer_url( $wp_customize, 'factura_url', __( 'Factura', 'mallorca' ), 'mallorca_footer' );
	mallorca_customizer_url( $wp_customize, 'jobs_url', __( 'Bolsa de trabajo', 'mallorca' ), 'mallorca_footer' );

	$choices = mallorca_footer_location_choices();
	$wp_customize->add_setting( 'mallorca_footer_location_1', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control(
		'mallorca_footer_location_1',
		array(
			'label'   => __( 'Sucursal columna 3', 'mallorca' ),
			'section' => 'mallorca_footer',
			'type'    => 'select',
			'choices' => $choices,
		)
	);
	$wp_customize->add_setting( 'mallorca_footer_location_2', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control(
		'mallorca_footer_location_2',
		array(
			'label'   => __( 'Sucursal columna 4', 'mallorca' ),
			'section' => 'mallorca_footer',
			'type'    => 'select',
			'choices' => $choices,
		)
	);
}

/**
 * Text control helper.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 * @param string               $id           Key.
 * @param string               $label        Label.
 * @param string               $section      Section.
 * @param string               $default      Default.
 */
function mallorca_customizer_text( $wp_customize, $id, $label, $section, $default ) {
	$wp_customize->add_setting( 'mallorca_' . $id, array( 'default' => $default, 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'mallorca_' . $id, array( 'label' => $label, 'section' => $section, 'type' => 'text' ) );
}

/**
 * Textarea control helper.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 * @param string               $id           Key.
 * @param string               $label        Label.
 * @param string               $section      Section.
 * @param string               $default      Default.
 */
function mallorca_customizer_textarea( $wp_customize, $id, $label, $section, $default ) {
	$wp_customize->add_setting( 'mallorca_' . $id, array( 'default' => $default, 'sanitize_callback' => 'sanitize_textarea_field' ) );
	$wp_customize->add_control( 'mallorca_' . $id, array( 'label' => $label, 'section' => $section, 'type' => 'textarea' ) );
}

/**
 * URL control helper.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 * @param string               $id           Key.
 * @param string               $label        Label.
 * @param string               $section      Section.
 * @param string               $default      Default.
 */
function mallorca_customizer_url( $wp_customize, $id, $label, $section, $default = '' ) {
	$wp_customize->add_setting( 'mallorca_' . $id, array( 'default' => $default, 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( 'mallorca_' . $id, array( 'label' => $label, 'section' => $section, 'type' => 'url' ) );
}
