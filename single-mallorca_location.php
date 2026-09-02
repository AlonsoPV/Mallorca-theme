<?php
/**
 * Single location.
 *
 * @package Mallorca
 */

get_header();
?>
<main id="primary" class="mallorca-main mallorca-container">
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/location/card' );
		if ( get_the_content() ) {
			echo '<div class="mallorca-prose">';
			the_content();
			echo '</div>';
		}
	endwhile;
	?>
</main>
<?php
get_footer();
