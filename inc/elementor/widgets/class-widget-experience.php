<?php
/**
 * Elementor: Experience.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mallorca_Widget_Experience extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mallorca_experience';
	}

	public function get_title() {
		return __( 'Mallorca Experiencia', 'mallorca' );
	}

	public function get_icon() {
		return 'eicon-image-hotspot';
	}

	public function get_categories() {
		return array( 'mallorca' );
	}

	protected function register_controls() {
		$copy = mallorca_default_copy();
		$this->start_controls_section( 'content', array( 'label' => __( 'Contenido', 'mallorca' ) ) );
		$this->add_control( 'title', array( 'label' => __( 'Título', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $copy['exp_title'] ) );
		for ( $i = 1; $i <= 3; $i++ ) {
			$this->add_control( 'caption_' . $i, array( 'label' => sprintf( __( 'Leyenda %d', 'mallorca' ), $i ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $copy[ 'exp_' . $i ] ) );
			$this->add_control( 'image_' . $i, array( 'label' => sprintf( __( 'Foto %d', 'mallorca' ), $i ), 'type' => \Elementor\Controls_Manager::MEDIA ) );
		}
		$this->end_controls_section();
	}

	protected function render() {
		get_template_part( 'template-parts/home/experience', null, $this->get_settings_for_display() );
	}
}
