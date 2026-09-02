<?php
/**
 * Locations archive.
 *
 * @package Mallorca
 */

get_header();
?>
<main id="primary" class="mallorca-main mallorca-container">
	<header class="mallorca-page-head">
		<h1><?php esc_html_e( 'Sucursales', 'mallorca' ); ?></h1>
		<p><?php esc_html_e( 'Dos mesas en la Ciudad de México. La misma masa, el mismo horno.', 'mallorca' ); ?></p>
	</header>
	<div class="mallorca-locations__grid">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/location/card' );
			}
		}
		?>
	</div>
</main>
<?php
get_footer();
