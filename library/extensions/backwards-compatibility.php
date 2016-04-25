<?php
/**
 * Deciduous backwards compatibility functionality
 *
 * Prevents Deciduous from running on WordPress versions prior to 4.5
 *
 * @package DeciduousLibrary
 * @subpackage BackwardsCompatibility
 */

/**
 * Prevent switching to Deciduous on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @return void
 */
function deciduous_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'deciduous_upgrade_notice' );
}
add_action( 'after_switch_theme', 'deciduous_switch_theme' );

/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * deciduous on WordPress versions prior to 4.5.
 *
 *
 * @return void
 */
function deciduous_upgrade_notice() {
	$message = sprintf( esc_html__( 'Deciduous requires at least WordPress version 4.5. You are running version %s. Please upgrade and try again.', 'thematic' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}