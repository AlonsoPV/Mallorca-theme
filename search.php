<?php
/**
 * Search results.
 *
 * @package Mallorca
 */

get_header();
?>
<main id="primary" class="mallorca-main mallorca-container">
	<header class="mallorca-page-head">
		<h1><?php printf( esc_html__( 'Resultados para “%s”', 'mallorca' ), esc_html( get_search_query() ) ); ?></h1>
	</header>
	<?php if ( have_posts() ) : ?>
		<?php if ( class_exists( 'WooCommerce' ) && isset( $_GET['post_type'] ) && 'product' === $_GET['post_type'] ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
			<ul class="products columns-4 mallorca-products--grid">
				<?php
				while ( have_posts() ) :
					the_post();
					wc_get_template_part( 'content', 'product' );
				endwhile;
				?>
			</ul>
		<?php else : ?>
			<div class="mallorca-post-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', get_post_type() );
				endwhile;
				?>
			</div>
		<?php endif; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<div class="mallorca-empty mallorca-empty--page">
			<p><?php esc_html_e( 'No encontramos esa pieza. Prueba con pastel, ensaimada o pan.', 'mallorca' ); ?></p>
			<a class="mallorca-btn mallorca-btn--solid" href="<?php echo esc_url( mallorca_shop_url() ); ?>"><?php esc_html_e( 'Ver la pastelería', 'mallorca' ); ?></a>
		</div>
	<?php endif; ?>
</main>
<?php
get_footer();
