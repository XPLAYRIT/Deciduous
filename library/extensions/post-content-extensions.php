<?php
/**
 * Post Content Extensions
 *
 * @package deciduousLibrary
 * @subpackage ContentExtensions
 *
 */


/**
 * Set up the post content to use excerpt or full posts
 * 
 * Uses conditional template tags to decide whether posts should be displayed using excerpts or the full content
 * 
 * Filter: deciduous_f_content_length
 */
function deciduous_set_content_length() {
    global $deciduous_content_length;
    
    if ( is_home() || is_front_page() || is_single() ) { 
    	$content = 'full';
    } else {
    	$content = 'excerpt'; 
    }
    
    $deciduous_content_length = apply_filters( 'deciduous_f_content_length', $content );
    
}

add_action( 'deciduous_a_before_post','deciduous_set_content_length' );



if ( ! function_exists( 'deciduous_p_content' ) ) :
/**
 * Create the post content
 *
 * Detects whether to use the full length or excerpt of a post and displays it.
 * 
 * Filter: deciduous_f_post 
 */
function deciduous_p_content() {
    global $deciduous_content_length;

    if ( strtolower( $deciduous_content_length ) == 'full' ) {
    	$post = get_the_content( deciduous_more_text() );
    	$post = apply_filters( 'the_content', $post );
    	$post = str_replace( ']]>', ']]&gt;', $post );
    	if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail() ) {
			$post = deciduous_p_featured_image() . $post;
    	}

    } elseif ( strtolower( $deciduous_content_length ) == 'excerpt' ) {
    	$post = '';
    	$post .= get_the_excerpt();
    	$post = apply_filters('the_excerpt',$post);
    	if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail() ) {
			$post = deciduous_p_featured_image() . $post;
    	}		
    } else {
    	$post = get_the_content( deciduous_more_text() );
    	$post = apply_filters( 'the_content', $post );
    	$post = str_replace( ']]>', ']]&gt;', $post );
    }
    echo apply_filters( 'deciduous_f_post', $post );
} 

endif;


if( ! function_exists( 'deciduous_p_featured_image' ) ) :
/**
 * Returns Featured Images
 *
 * Filter: deciduous_f_post_thumb_size <br>
 * Filter: deciduous_f_post_thumb_attr 
 */
function deciduous_p_featured_image() {
		$post_title = get_the_title();
		$size = apply_filters( 'deciduous_f_post_thumb_size' , array( '600','9999' ) );
		$attr = apply_filters( 'deciduous_f_post_thumb_attr', array( 'title'	=> sprintf( esc_attr__( 'Permalink to %s', 'deciduous' ), the_title_attribute( 'echo=0' ) ) ) );
		$post = sprintf( '<a class="post-thumb-featured" href="%s">%s</a>',
									get_permalink() ,
									get_the_post_thumbnail( get_the_ID(), $size, $attr ) );
		return $post;
				
}

endif;


/**
 * Create the $more_link_text for the_content
 * 
 * Used on posts that are divided using the more tag in post editor
 * 
 * Filter: more_text
 *
 */
function deciduous_more_text() {
	/* translators: %s is right angle brackets */
	$content = sprintf ( esc_html__( 'Read More %s', 'deciduous' ), ' <span class="meta-nav">&raquo;</span>' );
	return apply_filters( 'more_text', $content );
}

?>