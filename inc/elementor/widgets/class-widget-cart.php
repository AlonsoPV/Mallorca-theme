<?php
/**
 * Elementor: Cart.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mallorca_Widget_Cart extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mallorca_cart';
	}

	public function get_title() {
		return __( 'Mallorca Carrito', 'mallorca' );
	}

	public function get_icon() {
		return 'eicon-cart';
	}

	public function get_categories() {
		return array( 'mallorca' );
	}

	public function get_keywords() {
		return array( 'cart', 'carrito', 'woocommerce' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => __( 'Carrito', 'mallorca' ) ) );
		$this->add_control(
			'note',
			array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Pedido, cantidades y resumen. Usa esta plantilla en la página de carrito de WooCommerce.', 'mallorca' ),
				'content_classes' => 'elementor-descriptor',
			)
		);
		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<p class="mallorca-empty">' . esc_html__( 'Activa WooCommerce para mostrar el carrito.', 'mallorca' ) . '</p>';
			return;
		}
		echo '<div class="mallorca-commerce">' . do_shortcode( '[woocommerce_cart]' ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
