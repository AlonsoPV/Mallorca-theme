<?php
/**
 * Template Name: Nuestra historia
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
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/page/historia' );
	endwhile;
endif;

get_footer();
