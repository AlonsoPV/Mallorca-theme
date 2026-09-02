<?php
/**
 * Search form.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form class="mallorca-search-inline" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<label class="screen-reader-text" for="s-<?php echo esc_attr( uniqid() ); ?>"><?php esc_html_e( 'Buscar', 'mallorca' ); ?></label>
	<input id="s-<?php echo esc_attr( uniqid() ); ?>" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Buscar', 'mallorca' ); ?>" />
	<button class="mallorca-btn mallorca-btn--solid" type="submit"><?php esc_html_e( 'Buscar', 'mallorca' ); ?></button>
</form>
