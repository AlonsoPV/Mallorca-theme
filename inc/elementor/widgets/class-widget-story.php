<?php
/**
 * Elementor: Story.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mallorca_Widget_Story extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mallorca_story';
	}

	public function get_title() {
		return __( 'Mallorca Historia', 'mallorca' );
	}

	public function get_icon() {
		return 'eicon-text-area';
	}

	public function get_categories() {
		return array( 'mallorca' );
	}

	protected function register_controls() {
		$copy = mallorca_default_copy();
		$this->start_controls_section( 'content', array( 'label' => __( 'Contenido', 'mallorca' ) ) );
		$this->add_control( 'kicker', array( 'label' => __( 'Kicker', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $copy['story_kicker'] ) );
		$this->add_control( 'title', array( 'label' => __( 'Título', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $copy['story_title'] ) );
		$this->add_control( 'text', array( 'label' => __( 'Párrafo 1', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $copy['story_text'] ) );
		$this->add_control( 'text_2', array( 'label' => __( 'Párrafo 2', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $copy['story_text_2'] ) );
		$this->add_control( 'cta', array( 'label' => __( 'CTA', 'mallorca' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $copy['story_cta'] ) );
		$this->add_control( 'cta_url', array( 'label' => __( 'URL', 'mallorca' ), 'type' => \Elementor\Controls_Manager::URL ) );
		$this->add_control( 'image', array( 'label' => __( 'Fotografía', 'mallorca' ), 'type' => \Elementor\Controls_Manager::MEDIA ) );
		$this->end_controls_section();
	}

	protected function render() {
		get_template_part( 'template-parts/home/story', null, $this->get_settings_for_display() );
	}
}
