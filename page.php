<?php
/**
 * Page.
 *
 * @package Mallorca
 */

get_header();
?>
<main id="primary" class="mallorca-main">
	<?php
	while ( have_posts() ) :
		the_post();
		if ( mallorca_is_elementor_page() ) {
			the_content();
		} elseif ( mallorca_is_commerce_page() ) {
			echo '<div class="mallorca-commerce">';
			the_content();
			echo '</div>';
		} else {
			?>
			<article <?php post_class( 'mallorca-page mallorca-container' ); ?>>
				<header class="mallorca-page-head">
					<h1><?php the_title(); ?></h1>
				</header>
				<div class="mallorca-prose">
					<?php the_content(); ?>
				</div>
			</article>
			<?php
		}
	endwhile;
	?>
</main>
<?php
get_footer();
