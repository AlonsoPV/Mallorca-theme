<?php
/**
 * Elementor: Locations.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mallorca_Widget_Locations extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mallorca_locations';
	}

	public function get_title() {
		return __( 'Mallorca Sucursales', 'mallorca' );
	}

	public function get_icon() {
		return 'eicon-google-maps';
	}

	public function get_categories() {
		return array( 'mallorca' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => __( 'Contenido', 'mallorca' ) ) );
		$this->add_control( 'title', array( 'label' => __( 'Título', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => mallorca_default_copy()['loc_title'] ) );
		$this->end_controls_section();
	}

	protected function render() {
		get_template_part( 'template-parts/home/locations', null, $this->get_settings_for_display() );
	}
}
