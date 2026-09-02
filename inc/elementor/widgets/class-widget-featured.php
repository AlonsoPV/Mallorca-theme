<?php
/**
 * Elementor: Featured products.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mallorca_Widget_Featured extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mallorca_featured';
	}

	public function get_title() {
		return __( 'Mallorca Favoritos', 'mallorca' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_categories() {
		return array( 'mallorca' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => __( 'Contenido', 'mallorca' ) ) );
		$this->add_control( 'title', array( 'label' => __( 'Título', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => mallorca_default_copy()['featured_title'] ) );
		$this->add_control( 'limit', array( 'label' => __( 'Productos', 'mallorca' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 8, 'min' => 4, 'max' => 16 ) );
		$this->end_controls_section();
	}

	protected function render() {
		get_template_part( 'template-parts/home/featured', null, $this->get_settings_for_display() );
	}
}
