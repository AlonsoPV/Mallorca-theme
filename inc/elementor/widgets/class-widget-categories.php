<?php
/**
 * Elementor: Categories.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mallorca_Widget_Categories extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mallorca_categories';
	}

	public function get_title() {
		return __( 'Mallorca Categorías', 'mallorca' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return array( 'mallorca' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => __( 'Contenido', 'mallorca' ) ) );
		$this->add_control( 'title', array( 'label' => __( 'Título', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => mallorca_default_copy()['cats_title'] ) );
		$this->add_control(
			'limit',
			array(
				'label'   => __( 'Número de categorías', 'mallorca' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 2,
				'max'     => 12,
			)
		);
		$this->end_controls_section();
	}

	protected function render() {
		get_template_part( 'template-parts/home/categories', null, $this->get_settings_for_display() );
	}
}
