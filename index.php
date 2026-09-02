<?php
/**
 * Default index.
 *
 * @package Mallorca
 */

get_header();
?>
<main id="primary" class="mallorca-main mallorca-container mallorca-archive">
	<?php if ( have_posts() ) : ?>
		<header class="mallorca-page-head">
			<h1><?php echo wp_kses_post( get_the_archive_title() ); ?></h1>
		</header>
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
		<div class="mallorca-empty mallorca-empty--page">
			<h1><?php esc_html_e( 'Nada por aquí', 'mallorca' ); ?></h1>
			<p><?php esc_html_e( 'Prueba otra búsqueda o vuelve a la pastelería.', 'mallorca' ); ?></p>
			<a class="mallorca-btn mallorca-btn--solid" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Volver al inicio', 'mallorca' ); ?></a>
		</div>
	<?php endif; ?>
</main>
<?php
get_footer();
