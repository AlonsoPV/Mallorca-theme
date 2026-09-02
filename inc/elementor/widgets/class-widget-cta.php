<?php
/**
 * Elementor: CTA.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mallorca_Widget_Cta extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mallorca_cta';
	}

	public function get_title() {
		return __( 'Mallorca CTA', 'mallorca' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return array( 'mallorca' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => __( 'Contenido', 'mallorca' ) ) );
		$this->add_control( 'kicker', array( 'label' => __( 'Kicker', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'La mesa está lista', 'mallorca' ) ) );
		$this->add_control( 'title', array( 'label' => __( 'Título', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => __( 'Pasa por el obrador o pide en línea.', 'mallorca' ) ) );
		$this->add_control( 'cta', array( 'label' => __( 'Botón', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Comprar online', 'mallorca' ) ) );
		$this->add_control( 'cta_url', array( 'label' => __( 'URL', 'mallorca' ), 'type' => \Elementor\Controls_Manager::URL ) );
		$this->end_controls_section();
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$url    = ! empty( $s['cta_url']['url'] ) ? $s['cta_url']['url'] : mallorca_shop_url();
		$target = ! empty( $s['cta_url']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
		echo '<section class="mallorca-cta-band">';
		echo '<p class="mallorca-kicker">' . esc_html( $s['kicker'] ) . '</p>';
		echo '<h2>' . esc_html( $s['title'] ) . '</h2>';
		echo '<a class="mallorca-btn mallorca-btn--solid" href="' . esc_url( $url ) . '"' . $target . '>' . esc_html( $s['cta'] ) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</section>';
	}
}
