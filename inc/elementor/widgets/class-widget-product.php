<?php
/**
 * Elementor: Single product.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mallorca_Widget_Product extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mallorca_product';
	}

	public function get_title() {
		return __( 'Mallorca Producto', 'mallorca' );
	}

	public function get_icon() {
		return 'eicon-product-info';
	}

	public function get_categories() {
		return array( 'mallorca' );
	}

	public function get_keywords() {
		return array( 'product', 'producto', 'woocommerce' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => __( 'Producto', 'mallorca' ) ) );
		$this->add_control(
			'note',
			array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Galería, precio, notas de entrega y añadir al carrito. En el editor se previsualiza el primer producto publicado.', 'mallorca' ),
				'content_classes' => 'elementor-descriptor',
			)
		);
		$this->end_controls_section();
	}

	protected function render() {
		get_template_part( 'template-parts/woocommerce/product' );
	}
}
