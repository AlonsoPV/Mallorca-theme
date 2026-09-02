<?php
/**
 * Archive.
 *
 * @package Mallorca
 */

get_header();
?>
<main id="primary" class="mallorca-main mallorca-container mallorca-archive">
	<header class="mallorca-page-head">
		<h1><?php echo wp_kses_post( get_the_archive_title() ); ?></h1>
		<?php the_archive_description( '<p>', '</p>' ); ?>
	</header>
	<?php if ( have_posts() ) : ?>
		<div class="mallorca-post-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', get_post_type() );
			endwhile;
			?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p class="mallorca-empty"><?php esc_html_e( 'Aún no hay contenido en este archivo.', 'mallorca' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();
