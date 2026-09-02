<?php
/**
 * Elementor: Shop.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mallorca_Widget_Shop extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mallorca_shop';
	}

	public function get_title() {
		return __( 'Mallorca Tienda', 'mallorca' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_categories() {
		return array( 'mallorca' );
	}

	public function get_keywords() {
		return array( 'shop', 'tienda', 'woocommerce', 'productos' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => __( 'Tienda', 'mallorca' ) ) );
		$this->add_control(
			'note',
			array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Muestra el catálogo Mallorca: filtros, orden y tarjetas de producto.', 'mallorca' ),
				'content_classes' => 'elementor-descriptor',
			)
		);
		$this->end_controls_section();
	}

	protected function render() {
		get_template_part( 'template-parts/woocommerce/shop' );
	}
}
