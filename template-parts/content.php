<?php
/**
 * Generic content card.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article <?php post_class( 'mallorca-post-card' ); ?>>
	<a href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'mallorca-card' ); ?>
		<?php endif; ?>
		<h2><?php the_title(); ?></h2>
		<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
	</a>
</article>
