<?php
/**
 * Helper Functions
 *
 * @package DeciduousLibrary
 * @subpackage Helpers
 */



/**
 * Displays a filterable Search Form
 *
 * This function is called from the searchform.php template. 
 * That template is called by the WP function get_search_form()
 *
 * Filter: search_field_value Controls the input element's size attribute <br>
 * Filter: deciduous_search_submit Controls the form's "submit" input element <br>
 * Filters: deciduous_search_form Controls the entire from output just before display <br>
 *
 * @link http://codex.wordpress.org/Function_Reference/get_search_form Codex: get_search_form()
 */
function deciduous_search_form() {
	$search_form_length = apply_filters('deciduous_f_search_form_length', '32');
	$search_form  = "\n\t\t\t\t\t\t";
	$search_form .= '<form id="searchform" method="get" action="' . home_url() .'/">';
	$search_form .= "\n\n\t\t\t\t\t\t\t";
	$search_form .= '<div>';
	$search_form .= "\n\t\t\t\t\t\t\t\t";
	if (is_search()) {
	    	$search_form .= '<input id="s" name="s" type="text" value="' . esc_html ( stripslashes( $_GET['s'] ) ) .'" size="' . $search_form_length . '" tabindex="1" />';
	} else {
	    	$value = __( 'To search, type and hit enter', 'deciduous' );
	    	$value = apply_filters( 'search_field_value',$value );
	    	$search_form .= '<input id="s" name="s" type="text" value="' . $value . '" onfocus="if (this.value == \'' . $value . '\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \'' . $value . '\';}" size="'. $search_form_length .'" tabindex="1" />';
	}
	$search_form .= "\n\n\t\t\t\t\t\t\t\t";
	
	$search_submit = '<input id="searchsubmit" name="searchsubmit" type="submit" value="' . __('Search', 'deciduous') . '" tabindex="2" />';
	
	$search_form .= apply_filters('deciduous_search_submit', $search_submit);
	
	$search_form .= "\n\t\t\t\t\t\t\t";
	$search_form .= '</div>';
	
	$search_form .= "\n\n\t\t\t\t\t\t";
	$search_form .= '</form>' . "\n\n\t\t\t\t\t";
	
	echo apply_filters('deciduous_f_search_form', $search_form);
}
 
/**
 * Add a wrapping div to tables
 * 
 */
function deciduous_table_wrap( $content ) {
	
	$search = array( '<table>','</table>' );
	$replace = array( '<div class="table_wrap"><table>', '</table></div>' );
	$content = str_replace( $search, $replace, $content );
	
    return $content;
}
add_filter('the_content','deciduous_table_wrap');


if ( ! function_exists( 'deciduous_p_meta_separator' ) ) :
/**
 * Returns a filterable meta separator
 *
 */
function deciduous_p_meta_separator( $class ) {
	$separator = apply_filters( 'deciduous_f_meta_separator' , $separator = '|' );
	
	$meta_sep = '<span class="meta-sep meta-sep-' . $class .'">' . $separator . '</span>';
	
	return $meta_sep;
}
endif;


/**
 * Returns or echoes a theme option value by its key
 * or returns false if no value is found
 *
 * @uses deciduous_get_wp_opt()
 */
function deciduous_get_theme_opt( $opt_key, $echo = false ) {
	
	$theme_opt =  wp_parse_args ( get_theme_mod( 'deciduous_theme_opt' ) , deciduous_default_opt() ); 
	// using the $deafult arg for get_theme_mod() makes the cusomizer bail on the index-insert default setting
	// so I am using wp_parse_args which seems to correct this. check again in a future release
	
	if ( !isset( $theme_opt[$opt_key] ) ) {
		echo('false');return false;
	}

	if ( false === $echo ) {
		return $theme_opt[$opt_key];
	} else {
		echo $theme_opt[$opt_key];
	}

}



/**
 * Returns default theme options.
 *
 * Filter: deciduous_theme_default_opt
 *
 */
function deciduous_default_opt() {


	$footer_text = sprintf( __( 'Powered by %s', 'deciduous' ), '<a href="' . esc_url( __( 'https://wordpress.org/', 'deciduous' ) ) . '">WordPress' ) . '</a>. ' . sprintf( __( 'Built with the %sDeciduous Theme%s', 'deciduous' ), '<a href="http://d.eciduo.us">', '</a>.' );
	
	$deciduous_default_opt = array(
		'index_insert' 	=> 2,
		'author_info'  	=> 0, // 0 = not checked 1 = checked
		'footer_txt' 	=> $footer_text,
		'layout'        => deciduous_default_theme_layout()
	);

	return apply_filters( 'deciduous_f_theme_default_opt', $deciduous_default_opt );
}	



/**
 * Specifies the available layouts for the theme
 *
 * @return array $layouts
 */
function deciduous_available_theme_layouts() {
	$layouts = array(
		'left-sidebar' => array(
			'slug'  => 'left-sidebar',
			'title' => __( 'Left Sidebar', 'deciduous' )
		),
		'right-sidebar' => array(
			'slug' => 'right-sidebar',
			'title' => __( 'Right Sidebar', 'deciduous' )
		),
		'three-columns' => array(
			'slug' => 'three-columns',
			'title' => __( 'Three columns', 'deciduous' )
		),
		'full-width' => array(
			'slug' => 'full-width',
			'title' => __( 'Full width', 'deciduous' )
		)
	);

	return apply_filters( 'deciduous_f_available_theme_layouts', $layouts );
}


/**
 * Create a simple array of the available layout strings
 *
 * @return array $layouts
 */
function deciduous_available_layout_slugs() {
	$possible_layouts = deciduous_available_theme_layouts();
	$available_layouts = array();
	foreach( $possible_layouts as $layout) {
		$available_layouts[] = $layout['slug'];
	}

	return $available_layouts;
}


/**
 * Decide the default layout of the theme
 *
 * @return string $default_layout
 */
function deciduous_default_theme_layout() {

	$options = get_theme_mod( 'deciduous_theme_opt', array() );

	// use a default layout of right-sidebar if no theme option has been set
	$deciduous_default_layout = isset( $options['layout'] ) ? $options['layout'] : 'right-sidebar';

	/**
	 * Filter for the default layout
	 *
	 * Specifies the theme layout upon first setup. The returned string need to match 
	 * one of the available layout slugs. Any invalid slug will be ignored.
	 *
	 * @see deciduous_available_layout_slugs()
	 *
	 * @param string $deciduous_default_layout
	 */
	$deciduous_possible_default_layout = apply_filters( 'deciduous_f_default_theme_layout', $deciduous_default_layout );

	// only use the filtered layout if it is a valid layout
	if ( in_array( $deciduous_possible_default_layout, deciduous_available_layout_slugs() ) ) {
		$deciduous_default_layout = $deciduous_possible_default_layout;
	}

	return $deciduous_default_layout;
}

 

/**
 * Create bullet-proof excerpt for meta name="description"
 * 
 * @param mixed $text
 * @return $text
 */
function deciduous_trim_excerpt($text) {
	if ( '' == $text ) {
		$text = get_the_content('');

		$text = strip_shortcodes( $text );

		$text = str_replace(']]>', ']]&gt;', $text);
		$text = strip_tags($text);
	  $text = str_replace('"', '\'', $text);
		$excerpt_length = apply_filters('excerpt_length', 55);
		$words = explode(' ', $text, $excerpt_length + 1);
		if (count($words) > $excerpt_length) {
			array_pop($words);
			array_push($words, '[...]');
			$text = implode(' ', $words);
		}
	}
	return $text;
}


/**
 * deciduous_the_excerpt function.
 * 
 * @return $output
 */
function deciduous_the_excerpt() {
	global $post;
	$output = '';
	$output = strip_tags( $post->post_excerpt );
	$output = str_replace( '"', '\'', $output );
	if ( post_password_required($post) ) {
		$output = __( 'There is no excerpt because this is a protected post.', 'deciduous');
		return $output;
	}

	return $output;
	
}


/**
 * deciduous_excerpt_rss function.
 *
 * @return $output
 */
function deciduous_excerpt_rss() {
	global $post;
	$output = '';
	$output = strip_tags( $post->post_excerpt );
	if ( post_password_required( $post ) ) {
		$output = __( 'There is no excerpt because this is a protected post.', 'deciduous' );
		return $output;	
	}

	return apply_filters( 'deciduous_excerpt_rss', $output );

}

add_filter( 'deciduous_excerpt_rss', 'deciduous_trim_excerpt' );


/**
 * Create nice multi_tag_title
 */
function deciduous_tag_query() {
	$nice_tag_query = get_query_var( 'tag' ); // tags in current query
	$nice_tag_query = str_replace(' ', '+', $nice_tag_query); // get_query_var returns ' ' for AND, replace by +
	$tag_slugs = preg_split('%[,+]%', $nice_tag_query, -1, PREG_SPLIT_NO_EMPTY); // create array of tag slugs
	$tag_ops = preg_split('%[^,+]*%', $nice_tag_query, -1, PREG_SPLIT_NO_EMPTY); // create array of operators

	$tag_ops_counter = 0;
	$nice_tag_query = '';

	foreach ($tag_slugs as $tag_slug) { 
		$tag = get_term_by('slug', $tag_slug ,'post_tag');
		// prettify tag operator, if any
		if ( isset($tag_ops[$tag_ops_counter])  &&  $tag_ops[$tag_ops_counter] == ',') {
			$tag_ops[$tag_ops_counter] = ', ';
		} elseif ( isset( $tag_ops[$tag_ops_counter])  &&  $tag_ops[$tag_ops_counter] == '+') {
			$tag_ops[$tag_ops_counter] = ' + ';
		}
		// concatenate display name and prettified operators
		if ( isset( $tag_ops[$tag_ops_counter] ) ) {
			$nice_tag_query = $nice_tag_query.$tag->name.$tag_ops[$tag_ops_counter];
			$tag_ops_counter += 1;
		} else {
			$nice_tag_query = $nice_tag_query.$tag->name;
			$tag_ops_counter += 1;
		}
	}
	return $nice_tag_query;
}


/**
 * Gets the term name of the current post
 *
 * @return $term->name
 */
function deciduous_get_term_name() {
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
	return $term->name;
}


/**
 * Check to see if the current post is a custom post type
 * 
 * @return bool
 */
function deciduous_is_custom_post_type() {
	global $post; 

	if ( ! in_array(  $post->post_type , get_post_types( array( '_builtin' => true ) ) ) ) {
		return true;
 	}
 	return false;
}


/**
 * Returns true if a a nav menu is set to the primary location
 * or if the blog has published pages
 *
 * @return bool
 */
 function deciduous_has_menu( $menu_id ) {
	if ( has_nav_menu( $menu_id ) ) {
		return true;
	}	
	$page_count_obj = wp_count_posts( 'page' );
		
	if( $page_count_obj->publish > 0 ) {
		return true;
	}
	return false;
}

/**
 * Props _s theme 
 *
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function deciduous_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'deciduous_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'deciduous_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so _s_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so _s_categorized_blog should return false.
		return false;
	}
}

/**
 * Props _s theme 
 *
 * Flush out the transients used in deciduous_categorized_blog.
 */
function deciduous_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'deciduous_categories' );
}
add_action( 'edit_category', 'deciduous_category_transient_flusher' );
add_action( 'save_post_post',     'deciduous_category_transient_flusher' );

?>