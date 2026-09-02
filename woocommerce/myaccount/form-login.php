<?php
/**
 * Login / register.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_user_logged_in() ) {
	return;
}
?>
<div class="mallorca-account-auth u-columns col2-set" id="customer_login">
	<div class="u-column1 col-1">
		<h2><?php esc_html_e( 'Entrar', 'mallorca' ); ?></h2>
		<form class="woocommerce-form woocommerce-form-login login" method="post">
			<?php do_action( 'woocommerce_login_form_start' ); ?>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="username"><?php esc_html_e( 'Usuario o correo', 'mallorca' ); ?></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /> <?php // phpcs:ignore WordPress.Security.NonceVerification.Missing ?>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password"><?php esc_html_e( 'Contraseña', 'mallorca' ); ?></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
			</p>
			<?php do_action( 'woocommerce_login_form' ); ?>
			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<button type="submit" class="mallorca-btn mallorca-btn--solid woocommerce-button" name="login" value="<?php esc_attr_e( 'Entrar', 'mallorca' ); ?>"><?php esc_html_e( 'Entrar', 'mallorca' ); ?></button>
			</p>
			<p class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( '¿Olvidaste tu contraseña?', 'mallorca' ); ?></a>
			</p>
			<?php do_action( 'woocommerce_login_form_end' ); ?>
		</form>
	</div>
	<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
		<div class="u-column2 col-2">
			<h2><?php esc_html_e( 'Crear cuenta', 'mallorca' ); ?></h2>
			<form method="post" class="woocommerce-form woocommerce-form-register register">
				<?php do_action( 'woocommerce_register_form_start' ); ?>
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_email"><?php esc_html_e( 'Correo', 'mallorca' ); ?></label>
					<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" />
				</p>
				<?php do_action( 'woocommerce_register_form' ); ?>
				<p class="woocommerce-form-row form-row">
					<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
					<button type="submit" class="mallorca-btn mallorca-btn--ghost woocommerce-button" name="register" value="<?php esc_attr_e( 'Registrarse', 'mallorca' ); ?>"><?php esc_html_e( 'Registrarse', 'mallorca' ); ?></button>
				</p>
				<?php do_action( 'woocommerce_register_form_end' ); ?>
			</form>
		</div>
	<?php endif; ?>
</div>
