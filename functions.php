<?php
/**
 * Theme Functions
 *
 * This file is used by WordPress to initialize the theme.
 * Deciduous is designed to be used as a theme framework and this file should not be modified.
 * You should use a Child Theme to make your customizations. A sample child theme is provided
 * as an example in root directory of this theme. You can move it into the wp-content/themes to
 * enable activation of the child theme. <br>
 *
 * @link http://codex.wordpress.org/Child_Themes Codex: Child Themes
 * 
 * @package Deciduous
 * @subpackage ThemeInit
 */


/**
 * Deciduous only works in WordPress 4.4 or later.
 * 
 */
if ( version_compare( $GLOBALS['wp_version'], '4.5', '<' ) ) {
	require get_template_directory() . '/library/extensions/backwards-compatibility.php';
}


/**
 * Registers action hook: deciduous_init 
 * 
 */
function deciduous_init() {
	do_action('deciduous_init');
}

if ( ! function_exists( 'deciduous_theme_setup' ) ) :
/**
 * deciduous_theme_setup
 *
 */
function deciduous_p_theme_setup() {
    global $content_width;

    /**
     * Set the content width based on the theme's design and stylesheet.
     *
     * Used to set the width of images and content. Should be equal to the width the theme
     * is designed for, generally via the style.css stylesheet.
     *
     */
    if ( !isset( $content_width ) ) {
    	$content_width = 600;
    }
    
    // WordPress Core Theme Support
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array(
    	'comment-list', 
    	'comment-form',
    	'search-form',
    	'gallery',
    	'caption'
    ) );
	add_theme_support( 'custom-header', apply_filters( 'deciduous_f_custom_header_args', array(
		'width'                  => 960,
		'height'                 => 240,
		'flex-height'            => true,
		'wp-head-callback'       => 'deciduous_p_custom_header_bodyclass', // in library/extensions/header-extensions.php
		'header-text'            => false
	) ) );

	
    add_theme_support( 'deciduous_s_author_info' );
    add_theme_support( 'deciduous_s_superfish' );
    add_theme_support( 'deciduous_s_customizer_layout' );
    add_theme_support( 'deciduous_s_nav_after_content' );
    	
    // Path constants
    define( 'DECIDUOUS_LIB',  get_template_directory() .  '/library' );
    
    // Load Action Hooks
    require_once ( DECIDUOUS_LIB . '/extensions/actions.php' );
    
    require_once ( DECIDUOUS_LIB . '/extensions/helpers.php' );

    require_once ( DECIDUOUS_LIB . '/extensions/header-extensions.php' );

    require_once ( DECIDUOUS_LIB . '/extensions/post-header-extensions.php' );

    require_once ( DECIDUOUS_LIB . '/extensions/post-content-extensions.php' );
    
    require_once ( DECIDUOUS_LIB . '/extensions/post-footer-extensions.php' );

    require_once ( DECIDUOUS_LIB . '/extensions/post-comments-extensions.php' );

    require_once ( DECIDUOUS_LIB . '/extensions/widget-area-extensions.php' );

    require_once ( DECIDUOUS_LIB . '/extensions/dynamic-classes.php' );

    require_once ( DECIDUOUS_LIB . '/extensions/customizer.php' );
    
    // Adds filters for the description/meta content in archive templates
    add_filter( 'archive_meta', 'wptexturize' );
    add_filter( 'archive_meta', 'convert_smilies' );
    add_filter( 'archive_meta', 'convert_chars' );
    add_filter( 'archive_meta', 'wpautop' );


    // Load the textdomain
    load_theme_textdomain( 'deciduous', DECIDUOUS_LIB . '/languages' );

    $locale = get_locale();
    $locale_file = DECIDUOUS_LIB . "/languages/$locale.php";
    if ( is_readable($locale_file) ) {
    	require_once ($locale_file);
    }
}

endif;

add_action('after_setup_theme', 'deciduous_p_theme_setup', 10);




/**
 * Registers action hook: deciduous_childtheme_init
 * 
 */
function deciduous_do_childtheme_init() {
	do_action('deciduous_a_childtheme_init');
}

add_action('after_setup_theme', 'deciduous_do_childtheme_init', 20);


if ( ! function_exists( 'deciduous_p_register_navmenu' ) ) :
/**
 * Register primary nav menu
 * 
 * Filter: deciduous_primary_menu_id
 * Filter: deciduous_primary_menu_name
 */

function deciduous_p_register_navmenu() {
	register_nav_menu( apply_filters( 'deciduous_f_primary_menu_id', 'primary' ), apply_filters( 'deciduous_f_primary_menu_name', esc_html__( 'Primary Menu', 'deciduous' ) ) );
}

endif;

add_action( 'init', 'deciduous_p_register_navmenu' );

