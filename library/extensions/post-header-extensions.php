<?php
/**
 * Content Extensions
 *
 * @package deciduousLibrary
 * @subpackage ContentExtensions
 *
 */


if( ! function_exists( 'deciduous_p_page_title' ) ):
/**
 * Create the page title.
 * 
 * Echoes the title of the webpage for specific queries. The markup is conditionally set using template tags.
 * Located in templates: archive.php, attachement.php, author.php, category.php, search.php, tag.php
 * 
 * Filter: deciduous_page_title 
 * 
 * @todo review and remove possiblity for displaying an empty div for archive-meta
 */
function deciduous_p_page_title() {
    global $post;

    $content = "\t\t\t\t";
    if ( is_attachment() ) {
    		$content .= '<h2 class="page-title"><a href="';
    		$content .= apply_filters( 'the_permalink', get_permalink( $post->post_parent ) );
    		$content .= '"><span class="meta-nav">&laquo; </span>';
    		$content .= get_the_title( $post->post_parent );
    		$content .= '</a></h2>';
    } elseif ( is_author() ) {
    		$content .= '<h1 class="page-title author">';
    		$author = get_the_author_meta( 'display_name', $post->post_author );
    		$content .= esc_html__( 'Author Archives:', 'deciduous' );
    		$content .= ' <span>' . $author .'</span>';
    		$content .= '</h1>';
    } elseif ( is_category() ) {
    		$content .= '<h1 class="page-title">';
    		$content .= esc_html__( 'Category Archives:', 'deciduous' );
    		$content .= ' <span>' . single_cat_title( '', FALSE ) .'</span>';
    		$content .= '</h1>' . "\n";
    		$content .= "\n\t\t\t\t" . '<div class="archive-meta">';
    		if ( !( ''== category_description() ) ) { 
    			$content .= apply_filters( 'archive_meta', category_description() ); 
    		}
    		$content .= '</div>';
    } elseif ( is_search() ) {
    		$content .= '<h1 class="page-title">';
    		$content .= esc_html__( 'Search Results for:', 'deciduous' );
    		$content .= ' <span id="search-terms">' . get_search_query() .'</span>';
    		$content .= '</h1>';
    } elseif ( is_tag() ) {
    		$content .= '<h1 class="page-title">';
    		$content .= esc_html__( 'Tag Archives:', 'deciduous' );
    		$content .= ' <span>';
    		$content .= single_tag_title( '', false );
    		$content .= '</span></h1>';
    } elseif ( is_tax() ) {
    	    global $taxonomy;
    		$content .= '<h1 class="page-title">';
    		$tax = get_taxonomy( $taxonomy );
    		$content .= $tax->labels->singular_name . ' ';
    		$content .= esc_html__( 'Archives:', 'deciduous' );
    		$content .= ' <span>' . deciduous_get_term_name() .'</span>';
    		$content .= '</h1>';
    } elseif ( is_post_type_archive() ) { 
    		$content .= '<h1 class="page-title">';
    		$post_type_obj = get_post_type_object( get_post_type() );
    		$post_type_name = $post_type_obj->labels->singular_name;
    		$content .= esc_html__( 'Archives:', 'deciduous' );
    		$content .= ' <span>' . $post_type_name . '</span>';
    		$content .= '</h1>';	
    } elseif ( is_day() ) {
    		$content .= '<h1 class="page-title">';
    		$content .= sprintf( esc_html__( 'Daily Archives: %s', 'deciduous' ), '<span>' . get_the_time( get_option( 'date_format' ) ) ) . '</span>';
    		$content .= '</h1>';
    } elseif ( is_month( )) {
    		$content .= '<h1 class="page-title">';
    		$content .= sprintf( esc_html__( 'Monthly Archives: %s', 'deciduous' ) , '<span>' . get_the_time( 'F Y' ) ) . '</span>';
    		$content .= '</h1>';
    } elseif ( is_year() ) {
    		$content .= '<h1 class="page-title">';
    		$content .= sprintf( esc_html__( 'Yearly Archives: %s', 'deciduous' ), '<span>' . get_the_time( 'Y' ) ) . '</span>';
    		$content .= '</h1>';
    }
    $content .= "\n";
    echo apply_filters( 'deciduous_f_page_title', $content );
}

endif;


if( ! function_exists( 'deciduous_p_postheader' ) ) :
/**
 * Create the post header
 * 
 * Filter: deciduous_f_postheader
 */
function deciduous_p_postheader() {
	global $post;
	
	if ( is_404() || $post->post_type == 'page') {
	       $postheader = '<header class="entry-header">' . deciduous_postheader_posttitle() . "</header><!-- .entry-header -->\n";        
	} else {
	       $postheader = '<header class="entry-header">' . deciduous_postheader_posttitle() . deciduous_postheader_postmeta() . "</header><!-- .entry-header -->\n";    
	}
	   
	echo apply_filters( 'deciduous_f_postheader', $postheader ); 
}

endif;


/**
 * Create the post title
 * 
 * Filter: deciduous_postheader_posttitle
 */
function deciduous_postheader_posttitle() {
    $posttitle = "\n\n\t\t\t\t\t\t\t";
    
    if ( ! $title_content = get_the_title() )  {
    	$title_content = '<a href="' . get_permalink() . '">' . esc_html_x( '(Untitled)', 'Default title for untitled posts', 'deciduous' ) . '</a>';
    }
    
    if (is_single() || is_page()) {
        $posttitle .= '<h1 class="entry-title">' . $title_content . "</h1>\n\n\t\t\t\t\t\t";
    
    } elseif (is_404()) {    
        $posttitle .= '<h1 class="entry-title">' . esc_html__( 'Not Found', 'deciduous' ) . "</h1>\n\n\t\t\t\t\t\t";
    
    } else {
        $posttitle .= '<h1 class="entry-title">';
        $posttitle .= sprintf('<a href="%s" rel="bookmark">%s</a>',
        						apply_filters( 'the_permalink', get_permalink() ),
        						$title_content
        						);   
        $posttitle .= "</h1>\n\n\t\t\t\t\t\t";
    }
    
    return apply_filters( 'deciduous_f_postheader_posttitle', $posttitle ); 

} 


/**
 * Create the post meta
 * 
 * Filter: deciduous_postheader_postmeta
 */
function deciduous_postheader_postmeta() {
    $postmeta  = "\n\t\t\t\t\t\t";
    $postmeta .= '<div class="entry-meta">';
    $postmeta .= "\n\t\t\t\t\t\t\t";
    $postmeta .= deciduous_postmeta_authorlink();
    $postmeta .= "\n\t\t\t\t\t\t\t";
    $postmeta .= deciduous_p_meta_separator( $class='author' );
    $postmeta .= "\n\t\t\t\t\t\t\t";
    $postmeta .= deciduous_postmeta_entrydate();
    $postmeta .= "\n\t\t\t\t\t\t\t";
    $postmeta .= deciduous_postmeta_editlink();
    $postmeta .= "\n\t\t\t\t\t\t";
    $postmeta .= '</div><!-- .entry-meta -->';
    $postmeta .= "\n\n\t\t\t\t\t";
    
    return apply_filters( 'deciduous_f_postheader_postmeta', $postmeta ); 

}


/**
 * Create the author link for post meta
 * 
 * Filter: deciduous_postmeta_authorlink
 */
function deciduous_postmeta_authorlink() {
    global $authordata;

    $author_prep = '<span class="meta-prep meta-prep-author">' . esc_html__( 'By', 'deciduous' ) . ' </span>';
    
    if ( deciduous_is_custom_post_type() && !current_theme_supports( 'deciduous_s_post_type_author_link' ) ) {
    	$author_info  = '<span class="vcard"><span class="fn nickname">';
    	$author_info .= get_the_author_meta( 'display_name' ) ;
    	$author_info .= '</span></span>';
    } else {
    	$author_info  = '<span class="author vcard">';
    	$author_info .= sprintf('<a class="url fn n" href="%s">%s</a>',
    							get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
    							get_the_author_meta( 'display_name' ) );
    	$author_info .= '</span>';
    }
    
    $author_credit = $author_prep . $author_info ;
    
    return apply_filters( 'deciduous_f_postmeta_authorlink', $author_credit );
}


/**
 * Create entry date for post meta
 * 
 * Filter: deciduous_postmeta_entrydate
 */ 
function deciduous_postmeta_entrydate() {
    $entrydate = '<span class="meta-prep meta-prep-entry-date">' . esc_html__('Published:', 'deciduous') . ' </span>';
    $entrydate .= '<time class="entry-date published updated" datetime=';
    $entrydate .= get_the_time( 'c' ) . '>';
    $entrydate .= get_the_time( deciduous_time_display() );
    $entrydate .= '</time>';
    
    return apply_filters( 'deciduous_f_postmeta_entrydate', $entrydate );
   
}


/**
 * Filter: deciduous_time_display
 * 
 * Create the time displayed in the post header
 */
function deciduous_time_display() {
	$time_display = get_option( 'date_format' );
	$time_display = apply_filters( 'deciduous_f_time_display', $time_display );
	return $time_display;
}


/**
 * Create edit link for post meta
 * 
 * Filter: deciduous_postmeta_editlink
 */
function deciduous_postmeta_editlink() {
    // Display edit link
    if ( current_user_can( 'edit_posts' ) ) {
        $editlink = deciduous_p_meta_separator( $class = 'date') . ' ';
        $editlink .= sprintf( '<a href="%s" class="edit">%s</a>' , 
    	    			get_edit_post_link(),
    					/* translators: post edit link */
    	    			esc_html__( 'Edit', 'deciduous' )
    	    		);
        return apply_filters( 'deciduous_f_postmeta_editlink', $editlink );
    }               
}
?>