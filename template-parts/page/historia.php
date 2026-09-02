<?php
/**
 * Editorial historia / quiénes somos.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$copy     = mallorca_default_copy();
$title    = get_the_title() ? get_the_title() : __( 'Nuestra historia', 'mallorca' );
$image_id = (int) mallorca_mod( 'story_image', 0 );
if ( ! $image_id && has_post_thumbnail() ) {
	$image_id = (int) get_post_thumbnail_id();
}

$moments = array(
	array(
		'year'  => __( 'El obrador', 'mallorca' ),
		'title' => __( 'Una pastelería de ritmo lento', 'mallorca' ),
		'text'  => __( 'Mallorca nace del horno: masas que reposan, azúcar que cae y el oficio de una pastelería española. El sabor se construye con tiempo, no con prisa.', 'mallorca' ),
	),
	array(
		'year'  => '2016',
		'title' => __( 'Ciudad de México', 'mallorca' ),
		'text'  => __( 'Esa tradición se sienta a la mesa en México. No es una réplica: es un encuentro entre el obrador europeo y la hospitalidad de esta ciudad.', 'mallorca' ),
	),
	array(
		'year'  => __( 'Hoy', 'mallorca' ),
		'title' => __( 'Mesa, café y sobremesa', 'mallorca' ),
		'text'  => __( 'Pastelería, bollería y restaurante conviven bajo el mismo techo. Horneamos cada día para la mesa de todos los días y para las mesas que se celebran.', 'mallorca' ),
	),
);

$values = array(
	array(
		'kicker' => __( '01', 'mallorca' ),
		'title'  => __( 'El horno', 'mallorca' ),
		'text'   => __( 'Cada pieza sale del obrador. La masa, el reposo y el fuego marcan el día.', 'mallorca' ),
	),
	array(
		'kicker' => __( '02', 'mallorca' ),
		'title'  => __( 'La mesa', 'mallorca' ),
		'text'   => __( 'Un café, una ensaimada, una sobremesa. Mallorca se entiende sentados.', 'mallorca' ),
	),
	array(
		'kicker' => __( '03', 'mallorca' ),
		'title'  => __( 'La ciudad', 'mallorca' ),
		'text'   => __( 'Una pastelería española, hecha en la Ciudad de México. El sabor de siempre, horneado aquí.', 'mallorca' ),
	),
);
?>
<main id="primary" class="mallorca-main mallorca-historia">
	<section class="mallorca-historia__intro">
		<div class="mallorca-container mallorca-historia__intro-inner">
			<p class="mallorca-kicker mallorca-kicker--accent"><?php esc_html_e( 'Quiénes somos', 'mallorca' ); ?></p>
			<h1><?php echo esc_html( $title ); ?></h1>
			<p class="mallorca-historia__lead"><?php echo esc_html( $copy['story_text'] ); ?></p>
		</div>
	</section>

	<section class="mallorca-historia__media" aria-hidden="true">
		<?php
		echo mallorca_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$image_id,
			'mallorca-editorial',
			'/assets/images/demo/story-oven.jpg',
			array(
				'alt'           => $title,
				'class'         => 'mallorca-historia__img',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
			)
		);
		?>
	</section>

	<section class="mallorca-historia__quote">
		<div class="mallorca-container">
			<blockquote>
				<p><?php echo esc_html( $copy['story_text_2'] ); ?></p>
			</blockquote>
		</div>
	</section>

	<section class="mallorca-historia__timeline">
		<div class="mallorca-container">
			<p class="mallorca-kicker mallorca-kicker--accent"><?php esc_html_e( 'El camino', 'mallorca' ); ?></p>
			<h2><?php esc_html_e( 'De un obrador a esta ciudad.', 'mallorca' ); ?></h2>
			<ol class="mallorca-historia__moments">
				<?php foreach ( $moments as $moment ) : ?>
					<li>
						<p class="mallorca-historia__year"><?php echo esc_html( $moment['year'] ); ?></p>
						<h3><?php echo esc_html( $moment['title'] ); ?></h3>
						<p><?php echo esc_html( $moment['text'] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<section class="mallorca-historia__values">
		<div class="mallorca-container">
			<p class="mallorca-kicker mallorca-kicker--accent"><?php esc_html_e( 'Lo que nos define', 'mallorca' ); ?></p>
			<h2><?php esc_html_e( 'Tres gestos, cada día.', 'mallorca' ); ?></h2>
			<div class="mallorca-historia__values-grid">
				<?php foreach ( $values as $value ) : ?>
					<article>
						<p class="mallorca-historia__index"><?php echo esc_html( $value['kicker'] ); ?></p>
						<h3><?php echo esc_html( $value['title'] ); ?></h3>
						<p><?php echo esc_html( $value['text'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php
	$content = trim( (string) get_the_content() );
	if ( $content ) :
		?>
		<section class="mallorca-historia__prose">
			<div class="mallorca-container mallorca-prose">
				<?php the_content(); ?>
			</div>
		</section>
	<?php endif; ?>

	<section class="mallorca-historia__cta">
		<div class="mallorca-container">
			<p class="mallorca-kicker mallorca-kicker--light"><?php esc_html_e( 'Visítanos', 'mallorca' ); ?></p>
			<h2><?php esc_html_e( 'El horno sigue encendido.', 'mallorca' ); ?></h2>
			<p><?php esc_html_e( 'Pasa a la pastelería o siéntate a la mesa. Mallorca se prueba mejor en persona.', 'mallorca' ); ?></p>
			<div class="mallorca-historia__actions">
				<a class="mallorca-btn mallorca-btn--solid" href="<?php echo esc_url( mallorca_shop_url() ); ?>"><?php esc_html_e( 'Ver la pastelería', 'mallorca' ); ?></a>
				<a class="mallorca-btn mallorca-btn--light" href="<?php echo esc_url( mallorca_locations_url() ); ?>"><?php esc_html_e( 'Sucursales', 'mallorca' ); ?></a>
			</div>
		</div>
	</section>
</main>
