<?php
/**
 * Elementor integration: locations, kit, widgets.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Boot Elementor layer when the plugin is active.
 */
function mallorca_elementor_init() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	add_action( 'elementor/elements/categories_registered', 'mallorca_elementor_category' );
	add_action( 'elementor/widgets/register', 'mallorca_elementor_widgets' );
	add_action( 'elementor/theme/register_locations', 'mallorca_elementor_locations' );
	add_action( 'elementor/preview/enqueue_styles', 'mallorca_elementor_preview_styles' );
}
add_action( 'init', 'mallorca_elementor_init' );

/**
 * Widget category.
 *
 * @param \Elementor\Elements_Manager $elements_manager Manager.
 */
function mallorca_elementor_category( $elements_manager ) {
	$elements_manager->add_category(
		'mallorca',
		array(
			'title' => __( 'Mallorca', 'mallorca' ),
			'icon'  => 'fa fa-coffee',
		)
	);
}

/**
 * Theme Builder locations (Elementor Pro) and free-compatible fallbacks.
 *
 * @param object $elementor_theme_manager Locations manager.
 */
function mallorca_elementor_locations( $elementor_theme_manager ) {
	if ( method_exists( $elementor_theme_manager, 'register_all_core_location' ) ) {
		$elementor_theme_manager->register_all_core_location();
	}
}

/**
 * Register widgets.
 *
 * @param \Elementor\Widgets_Manager $widgets_manager Manager.
 */
function mallorca_elementor_widgets( $widgets_manager ) {
	$files = array(
		'class-widget-hero.php',
		'class-widget-categories.php',
		'class-widget-featured.php',
		'class-widget-story.php',
		'class-widget-season.php',
		'class-widget-experience.php',
		'class-widget-locations.php',
		'class-widget-instagram.php',
		'class-widget-newsletter.php',
		'class-widget-cta.php',
	);

	foreach ( $files as $file ) {
		$path = MALLORCA_DIR . '/inc/elementor/widgets/' . $file;
		if ( file_exists( $path ) ) {
			require_once $path;
		}
	}

	$classes = array(
		'Mallorca_Widget_Hero',
		'Mallorca_Widget_Categories',
		'Mallorca_Widget_Featured',
		'Mallorca_Widget_Story',
		'Mallorca_Widget_Season',
		'Mallorca_Widget_Experience',
		'Mallorca_Widget_Locations',
		'Mallorca_Widget_Instagram',
		'Mallorca_Widget_Newsletter',
		'Mallorca_Widget_Cta',
	);

	foreach ( $classes as $class ) {
		if ( class_exists( $class ) ) {
			$widgets_manager->register( new $class() );
		}
	}
}

/**
 * Preview CSS.
 */
function mallorca_elementor_preview_styles() {
	wp_enqueue_style( 'mallorca-elementor' );
}

/**
 * Sync Elementor kit colors once when possible.
 */
function mallorca_sync_elementor_kit() {
	if ( ! class_exists( '\Elementor\Plugin' ) ) {
		return;
	}
	if ( get_option( 'mallorca_elementor_kit_synced' ) ) {
		return;
	}
	if ( ! isset( \Elementor\Plugin::$instance->kits_manager ) ) {
		return;
	}

	$kit = \Elementor\Plugin::$instance->kits_manager->get_active_kit();
	if ( ! $kit ) {
		return;
	}

	$kit->update_settings(
		array(
			'system_colors' => array(
				array( '_id' => 'primary', 'title' => 'Primary', 'color' => mallorca_mod( 'color_burgundy', '#DC1427' ) ),
				array( '_id' => 'secondary', 'title' => 'Secondary', 'color' => mallorca_mod( 'color_chocolate', '#3D2418' ) ),
				array( '_id' => 'text', 'title' => 'Text', 'color' => mallorca_mod( 'color_ink', '#2B2118' ) ),
				array( '_id' => 'accent', 'title' => 'Accent', 'color' => mallorca_mod( 'color_burgundy', '#DC1427' ) ),
			),
			'system_typography' => array(
				array(
					'_id'            => 'primary',
					'title'          => 'Primary',
					'typography_font_family' => 'Cormorant Garamond',
					'typography_font_weight' => '500',
				),
				array(
					'_id'            => 'secondary',
					'title'          => 'Secondary',
					'typography_font_family' => 'Figtree',
					'typography_font_weight' => '400',
				),
				array(
					'_id'            => 'text',
					'title'          => 'Text',
					'typography_font_family' => 'Figtree',
					'typography_font_weight' => '400',
				),
				array(
					'_id'            => 'accent',
					'title'          => 'Accent',
					'typography_font_family' => 'Figtree',
					'typography_font_weight' => '500',
				),
			),
			'body_color'                => mallorca_mod( 'color_ink', '#2B2118' ),
			'body_background_color'     => mallorca_mod( 'color_ivory', '#F6F1E8' ),
			'button_background_color'   => mallorca_mod( 'color_burgundy', '#DC1427' ),
			'button_text_color'         => mallorca_mod( 'color_ivory', '#F6F1E8' ),
			'button_border_radius'      => array(
				'unit'   => 'px',
				'top'    => '0',
				'right'  => '0',
				'bottom' => '0',
				'left'   => '0',
			),
			'container_padding'         => array(
				'unit'   => 'px',
				'top'    => '0',
				'right'  => '0',
				'bottom' => '0',
				'left'   => '0',
				'isLinked' => true,
			),
		)
	);

	update_option( 'mallorca_elementor_kit_synced', 1 );
}
add_action( 'elementor/init', 'mallorca_sync_elementor_kit', 20 );

/**
 * Page templates for Elementor canvas / full width.
 *
 * @param array $templates Templates.
 * @return array
 */
function mallorca_elementor_page_templates( $templates ) {
	$templates['templates/elementor-fullwidth.php'] = __( 'Mallorca / Elementor ancho completo', 'mallorca' );
	$templates['templates/elementor-canvas.php']    = __( 'Mallorca / Elementor canvas', 'mallorca' );
	return $templates;
}
add_filter( 'theme_page_templates', 'mallorca_elementor_page_templates' );
add_filter( 'theme_post_templates', 'mallorca_elementor_page_templates' );
