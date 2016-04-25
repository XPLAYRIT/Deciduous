<?php
/**
 * Action Hooks
 *
 * @package DeciduousLibrary
 * @subpackage Actions
 */

/**
 * Register action hook: deciduous_a_before
 * 
 * Located in header.php, just after the body tag, before the opening #wrapper div
 */
function deciduous_do_before_wrapper() {
    do_action( 'deciduous_a_before_wrapper' );
}

/**
 * Register action hook: deciduous_a_before_header
 * 
 * Located in header.php, before the header div
 */
function deciduous_do_before_header() {
    do_action( 'deciduous_a_before_header' );
}

/**
 * Register action hook: deciduous_a_before_branding
 * 
 * Located in header.php, inside the header div before #branding
 */
function deciduous_do_before_branding() {
    do_action( 'deciduous_a_before_branding' );
}

/**
 * Register action hook: deciduous_a_after_branding
 * 
 * Located in header.php, inside the header div after #branding
 */
function deciduous_do_after_branding() {
    do_action( 'deciduous_a_after_branding' );
}

/**
 * Register action hook: deciduous_a_after_main_nav
 * 
 * Located in header.php, inside the header div after #access
 */
function deciduous_do_after_main_nav() {
    do_action( 'deciduous_a_after_main_nav' );
}

/**
 * Register action hook: deciduous_a_after_header
 * 
 * Located in header.php, just after the header div
 */
function deciduous_do_after_header() {
    do_action( 'deciduous_a_after_header' );
}


/**
 * Register action hook: deciduous_a_before_container
 * 
 * Located in  index.php, archive.php, page.php, single.php, template-page-archives.php, template-page-fullwidth.php
 * Just between #main and #container
 */
function deciduous_do_before_container() {
    do_action('deciduous_a_before_container');
}


/**
 * Register action hook: deciduous_a_before_content
 *
 * Located in  index.php, archive.php, page.php, single.php, template-page-archives.php, template-page-fullwidth.php
 * Just between #main and #container
 */
function deciduous_do_before_content() {
    do_action('deciduous_a_before_content');
}


/**
 * Register action hook: deciduous_a_before_post 
 *
 * Located in loop.php, content-page.php, content-single.php, content-attachment.php, content-none.php
 * Just before #post
 */
function deciduous_do_before_post() {
    do_action('deciduous_a_before_post');
} // end deciduous_a_beforepost


/**
 * Register action hooks before loop depanding on what type of page is being displayed.
 *
 * Located in index.php and archive.php
 * Just before the loop
 */
function deciduous_do_before_x_loop( $actions = array() ) {
	do_action( 'deciduous_a_before_loop' );

    if( is_home() ) {
    	$actions[] = 'blog';
    } elseif( is_search() ) {
    	$actions[] = 'search';
    } elseif( is_404() ) {
    	$actions[] = '404';
    } elseif( is_archive() ) {
    	$actions[] = 'archive';
    	if (is_category() ) {
    		$actions[] = 'category';
    	} elseif (is_tag() ) {
    		$actions[] = 'tag';
       	} elseif (is_tax() ) {
    		$actions[] = 'tax';
    	} elseif( is_author() ) {
    		$actions[] = 'author';
    	} elseif( is_date() ) {
    		$actions[] = 'date';
    	} elseif( is_post_type_archive() ) {
    		$actions[] = get_post_type();
    	}
    }
    foreach ($actions as $action) {
    	do_action( "deciduous_a_before_{$action}_loop" );
    }
}


/**
 * Register action hook: deciduous_a_after_index_loop 
 *
 * Located in index.php
 * Just after the loop
 */
function deciduous_do_after_x_loop( $actions = array() ) {
	
    if( is_home() ) {
    	$actions[] = 'blog';
    } elseif( is_search() ) {
    	$actions[] = 'search';
    } elseif( is_404() ) {
    	$actions[] = '404';
    } elseif( is_archive() ) {
		$actions[] = 'archive';
    	if (is_category() ) {
    		$actions[] = 'category';
    	} elseif (is_tag() ) {
    		$actions[] = 'tag';
       	} elseif (is_tax() ) {
    		$actions[] = 'tax';
    	} elseif( is_author() ) {
    		$actions[] = 'author';
    	} elseif( is_date() ) {
    		$actions[] = 'date';
    	} elseif( is_post_type_archive() ) {
    		$actions[] = get_post_type();
    	}
    }

    foreach ($actions as $action) {
    	do_action( "deciduous_a_after_{$action}_loop" );
    }
    
	do_action( 'deciduous_a_after_loop' );

}


/**
 * Register action hook: deciduous_a_after_post 
 *
 * Located in loop.php, content-page.php, content-single.php, content-attachment.php, content-none.php
 * Just after #post
 */
function deciduous_do_after_post() {
    do_action('deciduous_a_after_post');
}


/**
 * Register action hook: deciduous_a_after_content 
 *
 * Located in  index.php, archive.php, page.php, single.php, template-page-archives.php, template-page-fullwidth.php
 * Just after #content
 */
function deciduous_do_after_content() {
    do_action('deciduous_a_after_content');
}


/**
 * Register action hook: deciduous_a_after_container 
 *
 * Located in  index.php, archive.php, page.php, single.php, template-page-archives.php, template-page-fullwidth.php
 * Just after #container
 */
function deciduous_do_after_container() {
    do_action('deciduous_a_after_container');
}


/**
 * Action Hook: deciduous_a_before_comments
 *
 * Located in comments.php
 * Just before #comments
 */
function deciduous_do_before_comments() {
    do_action('deciduous_a_before_comments');
}

/**
 * Action Hook: deciduous_a_beforecommentslist
 *
 * Located in comments.php
 * Just before #comments-list
 */
function deciduous_do_before_comments_list() {
    do_action('deciduous_a_before_comments_list');
}

/**
 * Register action hook: deciduous_a_before_comment
 * 
 * Located in comments.php, at the beginning of the li#comment-[id] element.
 * Note that this is *per comment*
 */
function deciduous_do_before_comment() {
	do_action('deciduous_a_before_comment');
}

/**
 * Register action hook: deciduous_a_after_comment
 * 
 * Located comments.php, just after the comment reply link.
 * Note that this is *per comment*:
 */
function deciduous_do_after_comment() {
	do_action('deciduous_a_after_comment');
}

/**
 * Action Hook: deciduous_a_after_comments_list
 *
 * Located in comments.php
 * Just after #comments-list
 */
function deciduous_do_after_comments_list() {
    do_action('deciduous_a_after_comments_list');
}

/**
 * Action Hook: deciduous_a_before_trackbacks_list
 *
 * Located in comments.php
 * Just before #trackbacks-list
 */
function deciduous_do_before_trackbacks_list() {
    do_action('deciduous_a_before_trackbacks_list');
}

/**
 * Action Hook: deciduous_a_after_trackbacks_list
 *
 * Located in comments.php
 * Just after #trackbacks-list
 */
function deciduous_do_after_trackbacks_list() {
    do_action('deciduous_a_after_trackbacks_list');
}

/**
 * Action Hook: deciduous_a_before_comments_form
 *
 * Located in comments.php
 * Just before the comments form
 */
function deciduous_do_before_comments_form() {
    do_action('deciduous_a_before_comments_form');
}

/**
 * Action Hook: deciduous_a_after_comments_form
 *
 * Located in comments.php
 * Just after the comments form
 */
function deciduous_do_after_comments_form() {
    do_action('deciduous_a_after_comments_form');
}

/**
 * Action Hook: deciduous_a_after_comments
 *
 * Located in comments.php
 * Just after #comments
 */
function deciduous_do_after_comments() {
    do_action('deciduous_a_after_comments');
}

/**
 * Action Hook: deciduous_a_comments_template
 */
function deciduous_do_comments_template() {
	do_action('deciduous_a_comments_template');
}

/**
 * Main Aside Hooks
 */


/**
 * Register action hook: deciduous_a_before_primary_aside 
 *
 * Located in primary.php
 * Just before the primary aside
 */
function deciduous_do_before_primary_aside() {
    do_action('deciduous_a_before_primary_aside');
}


/**
 * Register action hook: deciduous_a_between_primary_aside 
 *
 * Located in secondary.php
 * Just after the primary aside
 */
function deciduous_do_after_primary_aside() {
    do_action('deciduous_a_after_primary_aside');
}


/**
 * Register action hook: deciduous_a_secondary_aside 
 *
 * Located in secondary.php
 * Just before the secondary aside
 */
function deciduous_do_before_secondary_aside() {
    do_action('deciduous_a_before_secondary_aside');
}


/**
 * Register action hook: deciduous_a_after_secondary_aside 
 *
 * Located in secondary.php
 * Just after the secondary aside
 */
function deciduous_do_after_secondary_aside() {
    do_action('deciduous_a_after_secondary_aside');
}


/*
 * Subsidiary Aside Hooks
 */


/**
 * Register action hook: deciduous_a_before_sub_asides
 *
 * Located in subsidiary.php
 * Just before the subsidiary widget areas
 */
function deciduous_do_before_sub_asides() {
    do_action('deciduous_a_before_sub_asides');
}


/**
 * Register action hook: deciduous_a_before_1st_subsidiary 
 *
 * Located in subsidiary.php
 * Just before the first subsidiary widget area
 */
function deciduous_do_before_1st_subsidiary() {
    do_action('deciduous_a_before_1st_subsidiary');
}


/**
 * Register action hook: deciduous_a_after_1st_subsidiary 
 *
 * Located in subsidiary.php
 * Just after the first subsidiary widget areas
 */
function deciduous_do_after_1st_subsidiary() {
    do_action('deciduous_a_after_1st_subsidiary');
}


/**
 * Register action hook: deciduous_a_subsidiaries 
 *
 * Located in subsidiary.php
 * Regular hook before the second subsidiary widget area
 */
function deciduous_do_before_2nd_subsidiary() {
    do_action('deciduous_a_before_2nd_subsidiary');
}


/**
 * Register action hook: deciduous_a_subsidiaries 
 *
 * Located in subsidiary.php
 * Regular hook after the second subsidiary widget area
 */
function deciduous_do_after_2nd_subsidiary() {
    do_action('deciduous_a_after_2nd_subsidiary');
}


/**
 * Register action hook: deciduous_a_before_3rd_subsidiary
 *
 * Located in subsidiary.php
 * Regular hook before the 3rd subsidiary widget area
 */
function deciduous_do_before_3rd_subsidiary() {
    do_action('deciduous_a_before_3rd_subsidiary');
}


/**
 * Register action hook: deciduous_a_after_3rd_subsidiary
 *
 * Located in subsidiary.php
 * Regular hook after the third subsidiary widget area
 */
function deciduous_do_after_3rd_subsidiary() {
    do_action('deciduous_a_after_3rd_subsidiary');
}	


/**
 * Register action hook: deciduous_a_after_sub_asides
 *
 * Located in subsidiary.php
 * Just after the subsidiary widget areas
 */
function deciduous_do_after_sub_asides() {
    do_action('deciduous_a_after_sub_asides');
}


/**
 * Register action hook: deciduous_before_main_close
 * 
 * Located in footer.php, just before the closing of the main div
 */
function deciduous_do_before_main_close() {
    do_action('deciduous_a_before_main_close');
}


/**
 * Register action hook: deciduous_before_footer
 * 
 * Located in footer.php, just before the footer div
 */
function deciduous_do_before_footer() {
    do_action('deciduous_a_before_footer');
}


/**
 * Register action hook: deciduous_before_siteinfo
 * 
 * Located in footer.php, inside the footer div
 */
function deciduous_do_before_siteinfo() {
    do_action('deciduous_a_before_siteinfo');
}

/**
 * Register action hook: deciduous_after_siteinfo
 * 
 * Located in footer.php, inside the footer div
 */
function deciduous_do_after_siteinfo() {
    do_action('deciduous_a_after_siteinfo');
}

/**
 * Register action hook: deciduous_after_footer
 * 
 * Located in footer.php, just after the footer div
 */
function deciduous_do_after_footer() {
    do_action('deciduous_a_after_footer');
}


/**
 * Register action hook: deciduous_after
 * 
 * Located in footer.php, just before the closing body tag, after everything else.
 */
function deciduous_do_after_wrapper() {
    do_action('deciduous_a_after_wrapper');
}
