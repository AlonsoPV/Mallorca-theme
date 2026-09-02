<?php
/**
 * Experience photography.
 *
 * @package Mallorca
 *
 * @var array $args Elementor settings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args  = isset( $args ) && is_array( $args ) ? $args : array();
$copy  = mallorca_default_copy();
$title = mallorca_arg( $args, 'title', 'exp_title', $copy['exp_title'] );
$items = array(
	array( mallorca_arg( $args, 'caption_1', 'exp_1', $copy['exp_1'] ), mallorca_arg_image_id( $args, 'image_1', 'exp_image_1' ), 'experience-mesa.jpg' ),
	array( mallorca_arg( $args, 'caption_2', 'exp_2', $copy['exp_2'] ), mallorca_arg_image_id( $args, 'image_2', 'exp_image_2' ), 'experience-cafe.jpg' ),
	array( mallorca_arg( $args, 'caption_3', 'exp_3', $copy['exp_3'] ), mallorca_arg_image_id( $args, 'image_3', 'exp_image_3' ), 'experience-bolleria.jpg' ),
);
?>
<section class="mallorca-exp">
	<div class="mallorca-section-head">
		<h2><?php echo esc_html( $title ); ?></h2>
	</div>
	<div class="mallorca-exp__grid">
		<?php foreach ( $items as $item ) : ?>
			<figure class="mallorca-exp__item">
				<?php
				echo mallorca_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					$item[1],
					'mallorca-editorial',
					'/assets/images/demo/' . $item[2],
					array(
						'alt'   => $item[0],
						'class' => 'mallorca-exp__img',
					)
				);
				?>
				<figcaption><?php echo esc_html( $item[0] ); ?></figcaption>
			</figure>
		<?php endforeach; ?>
	</div>
</section>
