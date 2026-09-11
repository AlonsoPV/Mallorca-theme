<?php
/**
 * Front page. Uses Elementor content when the page is built with the editor.
 *
 * @package Mallorca
 */

get_header();

if ( mallorca_is_elementor_page() ) :
	?>
	<main id="primary" class="mallorca-main mallorca-main--elementor">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</main>
	<?php
else :
	?>
	<main id="primary" class="mallorca-main">
		<?php
		get_template_part( 'template-parts/home/hero' );
		get_template_part( 'template-parts/home/featured' );
		get_template_part( 'template-parts/home/story' );
		get_template_part( 'template-parts/home/season' );
		get_template_part( 'template-parts/home/experience' );
		get_template_part( 'template-parts/home/locations' );
		get_template_part( 'template-parts/home/instagram' );
		?>
	</main>
	<?php
endif;

get_footer();
