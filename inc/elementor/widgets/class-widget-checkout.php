<?php
/**
 * Elementor: Checkout.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mallorca_Widget_Checkout extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mallorca_checkout';
	}

	public function get_title() {
		return __( 'Mallorca Checkout', 'mallorca' );
	}

	public function get_icon() {
		return 'eicon-checkout';
	}

	public function get_categories() {
		return array( 'mallorca' );
	}

	public function get_keywords() {
		return array( 'checkout', 'pago', 'woocommerce' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => __( 'Checkout', 'mallorca' ) ) );
		$this->add_control(
			'note',
			array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Contacto, entrega y pago. Usa esta plantilla en la página de checkout de WooCommerce.', 'mallorca' ),
				'content_classes' => 'elementor-descriptor',
			)
		);
		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<p class="mallorca-empty">' . esc_html__( 'Activa WooCommerce para mostrar el checkout.', 'mallorca' ) . '</p>';
			return;
		}
		echo '<div class="mallorca-commerce">' . do_shortcode( '[woocommerce_checkout]' ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
