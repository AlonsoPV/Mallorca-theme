<?php
/**
 * Elementor: Season banner.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mallorca_Widget_Season extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mallorca_season';
	}

	public function get_title() {
		return __( 'Mallorca Temporada', 'mallorca' );
	}

	public function get_icon() {
		return 'eicon-image-box';
	}

	public function get_categories() {
		return array( 'mallorca' );
	}

	protected function register_controls() {
		$copy = mallorca_default_copy();
		$this->start_controls_section( 'content', array( 'label' => __( 'Contenido', 'mallorca' ) ) );
		$this->add_control( 'kicker', array( 'label' => __( 'Kicker', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $copy['season_kicker'] ) );
		$this->add_control( 'title', array( 'label' => __( 'Título', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $copy['season_title'] ) );
		$this->add_control( 'text', array( 'label' => __( 'Texto', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $copy['season_text'] ) );
		$this->add_control( 'cta', array( 'label' => __( 'CTA', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $copy['season_cta'] ) );
		$this->add_control( 'cta_url', array( 'label' => __( 'URL', 'mallorca' ), 'type' => \Elementor\Controls_Manager::URL ) );
		$this->add_control( 'image', array( 'label' => __( 'Fotografía', 'mallorca' ), 'type' => \Elementor\Controls_Manager::MEDIA ) );
		$this->end_controls_section();
	}

	protected function render() {
		get_template_part( 'template-parts/home/season', null, $this->get_settings_for_display() );
	}
}
