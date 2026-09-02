<?php
/**
 * Single post.
 *
 * @package Mallorca
 */

get_header();
?>
<main id="primary" class="mallorca-main mallorca-container">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class( 'mallorca-page' ); ?>>
			<header class="mallorca-page-head">
				<h1><?php the_title(); ?></h1>
				<p class="mallorca-meta"><?php echo esc_html( get_the_date() ); ?></p>
			</header>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="mallorca-page-hero"><?php the_post_thumbnail( 'mallorca-editorial' ); ?></div>
			<?php endif; ?>
			<div class="mallorca-prose">
				<?php the_content(); ?>
			</div>
		</article>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
