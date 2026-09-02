<?php
/**
 * Comments (minimal, styled).
 *
 * @package Mallorca
 */

if ( post_password_required() ) {
	return;
}
?>
<div class="mallorca-comments">
	<?php if ( have_comments() ) : ?>
		<h2><?php esc_html_e( 'Comentarios', 'mallorca' ); ?></h2>
		<ol><?php wp_list_comments(); ?></ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>
	<?php comment_form(); ?>
</div>
