<?php
/**
 * Elementor: Newsletter.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mallorca_Widget_Newsletter extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mallorca_newsletter';
	}

	public function get_title() {
		return __( 'Mallorca Newsletter', 'mallorca' );
	}

	public function get_icon() {
		return 'eicon-email-field';
	}

	public function get_categories() {
		return array( 'mallorca' );
	}

	protected function register_controls() {
		$copy = mallorca_default_copy();
		$this->start_controls_section( 'content', array( 'label' => __( 'Contenido', 'mallorca' ) ) );
		$this->add_control( 'title', array( 'label' => __( 'Título', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $copy['news_title'] ) );
		$this->add_control( 'text', array( 'label' => __( 'Texto', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $copy['news_text'] ) );
		$this->add_control( 'cta', array( 'label' => __( 'Botón', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $copy['news_cta'] ) );
		$this->add_control( 'shortcode', array( 'label' => __( 'Shortcode del formulario', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXTAREA ) );
		$this->end_controls_section();
	}

	protected function render() {
		get_template_part( 'template-parts/home/newsletter', null, $this->get_settings_for_display() );
	}
}
