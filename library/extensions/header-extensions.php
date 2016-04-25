<?php
/**
 * Header Extensions
 *
 * @package DeciduousLibrary
 * @subpackage HeaderExtensions
 */

function deciduous_custom_header_style() {
if ( get_header_image() ) :
?>
<style type="text/css" id="deciduous-header-image-style">
.branding {
    padding-bottom: 2em;
    padding-top: 3em;
}

.header-image {
	margin-top: 1em;
}
</style>
<?php
endif;
}

/**
* Display the html tag and attributes
*
* Filter: deciduous_html_class for including a class attribute string
*/
function deciduous_html( $class_att = FALSE ) {
	$html_class = apply_filters( 'deciduous_f_html_class' , $class_att );
?>
<!--[if lt IE 7]><html class="<?php if ( $html_class ) { echo( $html_class . ' ' ); } ?>lt-ie9 lt-ie8 lt-ie7" <?php language_attributes() ?>><![endif]-->
<!--[if IE 7]><html class="<?php 	if ( $html_class ) { echo( $html_class . ' ' ); } ?>ie7 lt-ie9 lt-ie8" ' <?php language_attributes() ?>><![endif]-->
<!--[if IE 8]><html class="<?php 	if ( $html_class ) { echo( $html_class . ' ' ); } ?>ie8 lt-ie9" <?php language_attributes() ?>><![endif]-->
<!--[if gt IE 8]><!-->
<html class="<?php 	if ( $html_class ) { echo $html_class; } ?>" <?php language_attributes() ?>><!--<![endif]-->

<?php
}



/**
 * Switch deciduous's SEO functions on or off
 * 
 * Provides compatibility with SEO plugins: All in One SEO Pack, HeadSpace, 
 * Platinum SEO Pack, wpSEO and Yoast SEO. Default: ON
 * 
 * Filter: deciduous_f_seo_switch
 */
function deciduous_seo_switch() {
	if ( class_exists( 'All_in_One_SEO_Pack' ) || class_exists( 'HeadSpace_Plugin' ) || class_exists( 'Platinum_SEO_Pack' ) || class_exists( 'wpSEO' ) || defined( 'WPSEO_VERSION' ) ) {
		$content = false;
	} else {
		$content = true;
	}
		return apply_filters( 'deciduous_f_seo_switch', $content );
}


/**
 * Switch use of deciduous_the_excerpt() in the meta-tag description
 * 
 * Default: ON
 * 
 * Filter: deciduous_use_excerpt
 */
function deciduous_use_excerpt() {
    $display = TRUE;
    $display = apply_filters( 'deciduous_f_use_excerpt', $display );
    return $display;
}


/**
 * Switch use of deciduous_use_autoexcerpt() in the meta-tag description
 * 
 * Default: OFF
 * 
 * Filter: deciduous_use_autoexcerpt
 */
function deciduous_use_autoexcerpt() {
    $display = FALSE;
    $display = apply_filters( 'deciduous_f_use_autoexcerpt', $display );
    return $display;
}

	
/**
 * Display the meta-tag description
 * 
 * This can be switched off by filtering either deciduous_seo or deciduous_show_description and returning FALSE
 * 
 * Filter: deciduous_f_meta_description_switch boolean filter to to output the meta description defaults to ON
 * Filter: deciduous_use_autoexcerpt  boolean filter to switch ON auto-excerpted descriptions defaults to OFF
 * Filter: deciduous_use_autoexcerpt  boolean filter to switch OFF auto-excerpted descriptions defaults to ON
 * Filter: deciduous_create_description
 */
function deciduous_meta_description() {
	if ( deciduous_seo_switch() ) {
		$display = apply_filters( 'deciduous_f_meta_description_switch', $display = TRUE );
		if ( $display ) {
			$content = '';
    		if ( is_single() || is_page() ) {
      			if ( have_posts() ) {
          			while ( have_posts() ) {
            			the_post();
						if ( deciduous_the_excerpt() == "" ) {
							if ( apply_filters( 'deciduous_f_use_autoexcerpt', $display = FALSE ) ) {
					    		$content = '<meta name="description" content="';
                    			$content .= deciduous_excerpt_rss();
                    			$content .= '" />';
                    			$content .= "\n";
							}
						} else {
							if ( apply_filters( 'deciduous_f_use_excerpt', $display = TRUE ) ) {
                    			$content = '<meta name="description" content="';
                    			$content .= deciduous_the_excerpt();
                    			$content .= '" />';
                    			$content .= "\n";
                        	}
                		}
            		}
        		}
        	} elseif ( is_home() || is_front_page() ) {
    			$content = '<meta name="description" content="';
    			$content .= get_bloginfo( 'description', 'display' );
    			$content .= '" />';
    			$content .= "\n";
        	}
			echo apply_filters ( 'deciduous_f_meta_description', $content );
		}
	} // end deciduous_meta_description
}


/**
 * Create the robots meta-tag
 * 
 * This can be switched off by filtering either deciduous_seo or deciduous_show_robots and returning FALSE
 * 
 * Filter: deciduous_meta_robots_switch
 * Filter: deciduous_create_robots
 */
function deciduous_meta_robots() {
	global $paged;
	if ( deciduous_seo_switch() && get_option( 'blog_public' ) ) {
		$display = apply_filters( 'deciduous_f_meta_robots_switch', $display = TRUE );
		if ( $display ) {
    		if ( ( is_home() && ( $paged < 2 ) ) || is_front_page() || is_single() || is_page() || is_attachment() ) {
				$content = '';
    		} elseif ( is_search() ) {
        		$content = '<meta name="robots" content="noindex,nofollow" />';
    		} else {	
        		$content = '<meta name="robots" content="noindex,follow" />';
    		}
    	$content .= "\n";
    	echo apply_filters( 'deciduous_f_meta_robots', $content );
    	}
	}
}// end deciduous_meta_robots



/**
 * Display pingback link
 * 
 * This can be switched on or off using deciduous_f_pingback_url_switch. Default: ON
 * 
 * Filter: deciduous_f_pingback_url_switch
 */
function deciduous_pingback_url() {
    $display = apply_filters( 'deciduous_f_pingback_url_switch', $display = TRUE );
    if ( $display ) {
        $content = '<link rel="pingback" href="';
        $content .= get_bloginfo( 'pingback_url' );
        $content .= '" />';
        echo $content;
    }
}


/**
 * Add html5 shiv for older browser compatibility
 * Don't add if modernizr is in use
 * 
 * Filter: deciduous_f_html5_script_handles
 * Filter: deciduous_f_html5shiv_switch
 *
 */
function deciduous_add_html5shiv() {
	
	$use_shiv = true;
	
	// List of handles to look for. These scripts make the html5shiv unnecessary
	$possible_handles = array(
		'html5shiv',
		'modernizr',
		'modernizr-js'
	);
	
	/**
	 * Filter the possible script handles that makes the html5 shiv unnecessary.
	 * 
	 * The handles are strings used as id in the call to <code>wp_enqueue_script()</code>.
	 * If a script with any of these handles is enqueued by a child theme or plugin, deciduous
	 * will not add the html5 shiv.
	 * 
	 * @param  array  $possible_handles  Array of handle names
	 */
	$possible_handles = apply_filters( 'deciduous_f_html5_script_handles', $possible_handles );
	
	// Check if any other scripts has been enqueued
	foreach( $possible_handles as $handle) {
		if( wp_script_is( $handle, 'queue' ) ) {
			$use_shiv = false;
		}
	}
	
	/**
	 * Decide whether to use the html5shiv or not
	 * 
	 * Provides a shortcut to switch off the shiv. Defaults to true,
	 * unless modernizr is detected.
	 * 
	 * @since 2.0.0
	 * 
	 * @param  boolean  $use_shiv
	 */
	$use_shiv = apply_filters( 'deciduous_f_html5shiv_switch', $use_shiv );
	
	// Output script link
	if( $use_shiv ) {
		wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/library/js/html5shiv.min.js', array(), '3.7.0', false );
		wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
	}
	
}

add_action( 'wp_enqueue_scripts', 'deciduous_add_html5shiv' );


/**
 * Add the default stylesheet to the head of the document.
 *
 */
function deciduous_create_stylesheet() {
	wp_enqueue_style( 'deciduous_style', get_stylesheet_uri() );
}
add_action('wp_enqueue_scripts','deciduous_create_stylesheet');




/**
 * Adds comment reply and navigation menu scripts to the head of the document.
 *
 * Child themes should use wp_dequeue_scripts to remove individual scripts.
 * Larger changes can be made using the override.
 *
 * For Reference: {@link http://users.tpg.com.au/j_birch/plugins/superfish/#getting-started Superfish Jquery Plugin}
 *
 * @since 1.0.0
 */
if ( !function_exists( 'deciduous_p_head_scripts' ) )  {
    function deciduous_p_head_scripts() {
		$template = wp_get_theme( 'deciduous' );

		// Enqueue comment reply script on posts and pages when option is set
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Enqueue jquery and superfish associated plugins when theme support is active
		if ( current_theme_supports( 'deciduous_s_superfish' ) ) {
			wp_enqueue_script( 'superfish', get_template_directory_uri() . '/library/js/superfish.min.js', array( 'jquery', 'hoverIntent' ), '1.7.8', true );
			// Enqueue sf-menu options
			wp_enqueue_script( 'sf-menu', get_template_directory_uri() . '/library/js/sf-menu.js', array( 'jquery' ), $template->Version, true );
		}
			// Enqueue menu toggle
			wp_enqueue_script( 'menu-toggle', get_template_directory_uri() . '/library/js/menu-toggle.js', array( 'jquery' ), $template->Version, true );
								
		$deciduous_javascript_options = array( 
			'mobileMenuBreakpoint' => 600,
			'superfish' => array(
				// These are the options for the superfish dropdown menus
				// see http://users.tpg.com.au/j_birch/plugins/superfish/options/ for more details
				'animation'    => array( 'opacity' => 'show', 'height' => 'show' ), // animation on opening the submenu
				'hoverClass'   => 'sfHover',           // the class applied to hovered list items
				'pathClass'    => 'overideThisToUse',  // the class you have applied to list items that lead to the current page
				'pathLevels'   => 1,                   // the number of levels of submenus that remain open or are restored using pathClass
				'delay'        => 400,                 // the delay in milliseconds that the mouse can remain outside a submenu without it closing
				'speed'        => 'slow',              // speed of the opening animation. Equivalent to second parameter of jQuery’s .animate() method
				'cssArrows'    => false,               // set to false if you want to remove the CSS-based arrow triangles
				'disableHI'    => false                // set to true to disable hoverIntent detection
			) 
		);
		
		/**
		 * Filter the variables sent to wp_localize_script
		 * 
		 * @since 2.0.0
		 * 
		 * @param array $deciduous_javascript_options
		 */
		$deciduous_javascript_options = apply_filters( 'deciduous_f_javascript_options', $deciduous_javascript_options );
		
		wp_localize_script( 'sf-menu', 'deciduousOptions', $deciduous_javascript_options );
 	}
 }

add_action( 'wp_enqueue_scripts','deciduous_p_head_scripts' );

?>