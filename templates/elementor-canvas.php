<?php
/**
 * Elementor canvas with persistent Mallorca header.
 *
 * Template Name: Mallorca / Elementor canvas
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="primary" class="mallorca-main mallorca-main--elementor mallorca-main--canvas">
	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>
</main>
<?php
get_footer();
