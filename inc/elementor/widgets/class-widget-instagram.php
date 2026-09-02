<?php
/**
 * Elementor: Instagram grid.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mallorca_Widget_Instagram extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mallorca_instagram';
	}

	public function get_title() {
		return __( 'Mallorca Instagram', 'mallorca' );
	}

	public function get_icon() {
		return 'eicon-instagram-gallery';
	}

	public function get_categories() {
		return array( 'mallorca' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => __( 'Contenido', 'mallorca' ) ) );
		$this->add_control( 'title', array( 'label' => __( 'Título', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => mallorca_default_copy()['ig_title'] ) );
		$this->add_control( 'shortcode', array( 'label' => __( 'Shortcode de plugin', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXT ) );
		$this->add_control(
			'gallery',
			array(
				'label' => __( 'Imágenes', 'mallorca' ),
				'type'  => \Elementor\Controls_Manager::GALLERY,
			)
		);
		$this->end_controls_section();
	}

	protected function render() {
		get_template_part( 'template-parts/home/instagram', null, $this->get_settings_for_display() );
	}
}
