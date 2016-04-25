<?php
/**
 * Dynamic Classes
 *
 * @package DeciduousLibrary
 * @subpackage DynamicClasses
 */

if ( ! function_exists( 'deciduous_p_body_class' ) ) :

function deciduous_p_body_class( $classes ) {

    /**
     * Filter to control the theme layout
     *
     * Accepts any string that is part of deciduous_available_theme_layouts(). Note that
     * the filter overrides the layout defined in the Theme Customizer. Any invalid
     * layout string will be ignored and the theme's default layout will be used.
     *
     * @see deciduous_available_theme_layouts()
     *
     *
     * @param string $current_layout
     */
    $current_layout = apply_filters( 'deciduous_current_theme_layout', deciduous_get_theme_opt( 'layout' ) );

    if ( is_page_template( 'template-page-fullwidth.php' ) ) {
    	$classes[] = 'full-width';
    } elseif( in_array( $current_layout, deciduous_available_layout_slugs() ) ) {
    	$classes[] = $current_layout;
    } else {
    	$classes[] = deciduous_default_theme_layout();
    }
    
    
    /**
    * Filter the body classes
    * 
    * @param array $classes
    */
    return apply_filters( 'deciduous_f_body_class', $classes );	
}

endif;
	
/**
 * Add deciduous body classes
 * 
 */
function deciduous_activate_body_classes() {
	
	add_filter( 'body_class', 'deciduous_p_body_class' );

}
add_action( 'init', 'deciduous_activate_body_classes' );



if ( ! function_exists( 'deciduous_p_post_class' ) ) :
/**
 * Generates semantic classes for each post DIV element
 */
function deciduous_p_post_class( $c ) {

	global $post, $page, $deciduous_post_alt, $deciduous_content_length;
	// Author for the post queried
	$c[] = 'author-' . sanitize_title_with_dashes( strtolower( get_the_author_meta( 'display_name' ) ) );

	$deciduous_paged = preg_match( '/<!--nextpage(.*?)-->/', $post->post_content );
		
	if ( $deciduous_paged ) {
		$c[] = 'next-paged';
		$c[] = 'page-' . $page;
	}
		
	$deciduous_excerpt_more = preg_match( '/<!--more(.*?)-->/', $post->post_content );

	// For posts displayed as excerpts
	if ( $deciduous_content_length == 'excerpt' || ( !is_single() && $deciduous_excerpt_more ) ) {
		$c[] = 'is-excerpt';
		if ( has_excerpt() ) {
			// For wp-admin Write Page generated excerpts
			$c[] = 'custom-excerpt';
		} elseif ( $deciduous_excerpt_more ) {
			// For  more tag
			$c[] = 'moretag-excerpt';
		} else {
			// For auto generated excerpts
			$c[] = 'auto-excerpt';
		}
	// For posts displayed as full content
	} elseif (  $deciduous_content_length == 'full'  )  {
			$c[] = 'is-full-length';
	}

    				
    // For posts with comments open or closed
    if ( comments_open() ) {
    	$c[] = 'comments-open';		
    } else {
    	$c[] = 'comments-closed';
    }

    // For posts with pings open or closed
    if ( pings_open() ) {
    	$c[] = 'pings-open';
    } else {
    	$c[] = 'pings-closed';
    }

    // For password-protected posts
    if ( $post->post_password ) {
    	$c[] = 'protected';
    }

    // If it's the other to the every, then add 'alt' class
    if ( !is_singular()  &&  ++$deciduous_post_alt % 2 ) {
    	$c[] = 'post-alt';
    }

    // And tada!
    return array_unique( apply_filters( 'deciduous_f_post_class', $c ) );
}

endif;

/**
 * Add deciduous post classes
 */
add_filter( 'post_class', 'deciduous_p_post_class', 20 );


/**
 * Define the num val for 'alt' classes (for article .post)
 * 
 * @var int  (default value: 1)
 */
$deciduous_post_alt = 1;

?>