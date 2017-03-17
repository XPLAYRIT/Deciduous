<?php
/**
 * Header Template
 *
 * This template calls a series of functions that output the head tag of the document
 * as well as the header and opening div #main.
 *
 * @package Deciduous
 * @subpackage Templates
 */
?>
<!DOCTYPE html>

<?php
	/**
	 * Outputs the html tag with filterable class attribute using the filter: deciduous_f_html_class
	 *
	 * Found in /library/header-extensions.php
	 */
	deciduous_html();
?>

<head>
<meta charset="<?php echo ( get_bloginfo( 'charset' ) ) ?>" />
<meta name="viewport" content="<?php echo apply_filters( 'deciduous_f_meta_viewport_content', 'width=device-width,initial-scale=1' ) ?>"/>	
<link rel="profile" href="http://gmpg.org/xfn/11" />	

<?php
	/**
 	 * Output the pingback adress
	 *
	 * Switch off by returning FALSE to the filter: deciduous_f_show_pingback_url
	 *
	 * Found in /library/header-extensions.php
	 */
	deciduous_pingback_url();

	/**
 	 * The Action Hook wp_head() loads Deciduous' stylesheets and scripts:
 	 * style.css, sf-menu.js, menu-toggle.js, html5shiv.min.js, superfish.min.js
 	 *
 	 * All of which are enqueued in /library/extensions/header-extensions.php
 	 *
	 */
	wp_head();
?>

</head>

<body <?php body_class() ?>>

	<?php
		// Load the action hook: deciduous_a_before_wrapper
		deciduous_do_before_wrapper();
	?>
	
	<div id="wrapper" class="hfeed site-wrapper">
	
		<a class="skip-link screen-reader-text" tabindex="1" href="#content"><?php esc_html_e( 'Skip to content', 'deciduous' ); ?></a>

    	<?php
			// Load the action hook: deciduous_a_before_header
			deciduous_do_before_header();
		?>
	
		<header id="header" class="site-header" role="banner">
    	
    		<?php
				// Load the action hook: deciduous_a_before_branding
				deciduous_do_before_branding();
 
				// Load the template for the site branding
				locate_template( array( 'template-parts/branding/branding.php' ), true );

				// Load the action hook: deciduous_a_after_branding
				deciduous_do_after_branding();
			?>
			
			<?php 
				/**
				 * Test for Menus or published pages before including nav-access.php
				 * deciduous_has_menu() is found in /library/extensions/helpers.php
				 */ 
				if( deciduous_has_menu( apply_filters( 'deciduous_f_primary_menu_id', 'primary' ) ) ) {
					// Load the template for the main navigation
					locate_template( array( 'template-parts/navigation/nav-access.php' ), true );
				}
				
				// Load the action hook: deciduous_a_after_main_nav
				deciduous_do_after_main_nav();
			?>

		</header><!-- .site-header-->
	
		<?php
			// Load the action hook: deciduous_a_after_header
			deciduous_do_after_header();
		?>

		<div id="main" class="site-main">
