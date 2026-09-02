<?php
/**
 * Elementor: Hero.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mallorca_Widget_Hero extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mallorca_hero';
	}

	public function get_title() {
		return __( 'Mallorca Hero', 'mallorca' );
	}

	public function get_icon() {
		return 'eicon-banner';
	}

	public function get_categories() {
		return array( 'mallorca' );
	}

	protected function register_controls() {
		$copy = mallorca_default_copy();
		$this->start_controls_section( 'content', array( 'label' => __( 'Contenido', 'mallorca' ) ) );
		$this->add_control( 'kicker', array( 'label' => __( 'Kicker', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $copy['hero_kicker'] ) );
		$this->add_control( 'title', array( 'label' => __( 'Título', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $copy['hero_title'] ) );
		$this->add_control( 'subtitle', array( 'label' => __( 'Subtítulo', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $copy['hero_subtitle'] ) );
		$this->add_control( 'cta', array( 'label' => __( 'CTA principal', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $copy['hero_cta'] ) );
		$this->add_control( 'cta_url', array( 'label' => __( 'URL principal', 'mallorca' ), 'type' => \Elementor\Controls_Manager::URL ) );
		$this->add_control( 'cta2', array( 'label' => __( 'CTA secundario', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $copy['hero_cta2'] ) );
		$this->add_control( 'cta2_url', array( 'label' => __( 'URL secundaria', 'mallorca' ), 'type' => \Elementor\Controls_Manager::URL ) );
		$this->add_control( 'image', array( 'label' => __( 'Fotografía', 'mallorca' ), 'type' => \Elementor\Controls_Manager::MEDIA ) );
		$this->end_controls_section();
	}

	protected function render() {
		get_template_part( 'template-parts/home/hero', null, $this->get_settings_for_display() );
	}
}
