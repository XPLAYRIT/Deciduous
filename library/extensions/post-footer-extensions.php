<?php
/**
 * Content Extensions
 *
 * @package deciduousLibrary
 * @subpackage ContentExtensions
 *
 */

if ( ! function_exists( 'deciduous_p_postfooter' ) ) :
/**
 * Create the post footer
 * 
 * Filter: deciduous_postfooter
 */
function deciduous_p_postfooter() {
    $post_type = get_post_type();
    $post_type_obj = get_post_type_object( $post_type );
    
    // Check for "Page" post-type and logged in user to show edit link
    if ( $post_type == 'page' && current_user_can( 'edit_posts' ) ) {
        $postfooter = '<footer class="entry-utility">' . deciduous_postfooter_posteditlink();
        $postfooter .= '</footer><!-- .entry-utility -->';
        $postfooter .= "\n";
    
    // Display no edit link for logged out users on a "Page" post-type 
    } elseif ( $post_type == 'page' ) {
        $postfooter = '';
    
    // For post-types other than "Pages" press on
    } else {
    	$postfooter = '<footer class="entry-utility">';
       
        if ( is_single() ) {
        	if ( deciduous_is_custom_post_type() && $post_type_obj->has_archive ) {
        		$post_type_archive_link = get_post_type_archive_link( $post_type );
    
    			/* translators: %s is custom post type singular name, wrapped in link tags */
    			$postfooter .= 	sprintf( 
									esc_html__( 'Browse the %s archive.', 'deciduous' ), 
    								' <a href="' . esc_url( $post_type_archive_link ) . '">' . $post_type_obj->labels->singular_name . '</a> '
    							);
        	}
        	
        	$postfooter .= 	deciduous_postfooter_posttax();
    		$postfooter .= 	sprintf( 
    							esc_html_x ( 
    								'Bookmark the %1$spermalink%2$s.',
    								'1s and 2s are the a href link wrappers, do not reverse them', 'deciduous'
    							), 
    							sprintf( 
    								'<a href="%s">',
    								apply_filters( 'the_permalink', get_permalink() ) 
    							), 
    							'</a>'
    						);
			$postfooter .= ' ';
			
    		if ( post_type_supports( $post_type, 'comments' ) ) {
            	$postfooter .= deciduous_postfooter_postconnect();
            }
            	
        } elseif ( post_type_supports( $post_type, 'comments' ) ) {
        	$postfooter .= deciduous_postfooter_posttax();
            $postfooter .= ' ' . deciduous_postfooter_postcomments();
        }
        
       	// Display edit link
    	if ( current_user_can( 'edit_posts' ) ) {
    		if ( ! is_single() && post_type_supports( $post_type, 'comments' ) ) {
        		$postfooter .= "\n\n\t\t\t\t\t\t" ;
        		$postfooter .= deciduous_p_meta_separator( $class = 'comments');
        	} 
        	$postfooter .= ' ' . deciduous_postfooter_posteditlink();
    	}   
    	$postfooter .= "\n\t\t\t\t\t";
    	$postfooter .= '</footer><!-- .entry-utility -->';
    	$postfooter .= "\n";    
    }

    echo apply_filters( 'deciduous_f_postfooter', $postfooter );
}

endif;

/**
 * Create the post edit link for the post footer
 * 
 * Filter: deciduous_postfooter_posteditlink
 */
function deciduous_postfooter_posteditlink() {
    $posteditlink = sprintf( 
    					'<a href="%s" class="edit">%s</a>' , 
    	    			get_edit_post_link(),
    					/* translators: post edit link */
    	    			esc_html__('Edit', 'deciduous')
    	    		);

    return apply_filters( 'deciduous_f_postfooter_posteditlink', $posteditlink ); 
}


/**
 * Create the taxonomy list for the post footer
 * 
 * Lists categories, tags, and custom taxonomies
 * 
 * Filter: deciduous_postfooter_posttax
 */
function deciduous_postfooter_posttax() {		
    $post_type_tax = get_post_taxonomies();
    $post_tax_list = ''; 
    
    if ( isset( $post_type_tax ) && $post_type_tax ) { 
    	foreach ( $post_type_tax as $tax  )   {
    		if ( $tax  == 'category' && deciduous_categorized_blog() ) {
    			$post_tax_list .= deciduous_postfooter_postcategory();
    		} elseif ( $tax  == 'post_tag' ) {
    			$post_tax_list .= deciduous_postfooter_posttags();
    		} elseif ( $tax  != 'category' ) {
    			$post_tax_list .= deciduous_postfooter_postterms( $tax );
    		}
    	}
    }
    return apply_filters( 'deciduous_f_postfooter_posttax', $post_tax_list );
}


/**
 * Create the list of custom taxonomy terms for post footer
 *
 * Filter: deciduous_postfooter_postterms
 * 
 * @param string $tax The taxonomy that the terms will be fetched from
 */
function deciduous_postfooter_postterms( $tax ) {
    global $post;
    
    if ( $tax == 'post_format' ) {
    	return;
    }
    $tax_terms = '';	
    $tax_obj = get_taxonomy( $tax );
    
    if ( wp_get_object_terms( $post->ID, $tax ) ) {
    	$term_list = get_the_term_list( 0, $tax, '' , ', ', '' );		
    	$tax_terms = '<span class="' . $tax . '-links"> ';
    	
    	if ( strpos( $term_list, ',' ) ) {
    		$tax_terms .= $tax_obj->labels->name . ': ';
    	} else {
    		$tax_terms .= $tax_obj->labels->singular_name . ': ';
    	}
    	
    	$tax_terms .= $term_list;

    	if ( is_single() ) { 
     		$tax_terms .= '. ';
     		$tax_terms .= '</span> ';
    	} else {
    		$tax_terms .= '</span> ';
    		$tax_terms .= "\n\n\t\t\t\t\t\t";
    		$tax_terms .= deciduous_p_meta_separator( $class = $tax_obj->labels->singular_name );
    	}
    	
    }
    
    return apply_filters( 'deciduous_f_postfooter_postterms', $tax_terms ); // Filter for custom taxonomy terms
}


/**
 * Create the category list for post footer
 * 
 * Filter: deciduous_postfooter_postcategory
 */
function deciduous_postfooter_postcategory() {
	$postcategory = "\n\t\t\t\t\t\t";
    $postcategory .= '<span class="cat-links">';
    
    if ( is_single() ) {
    	/* translators: %s is postfooter categories */
        $postcategory .= sprintf( 
        					esc_html__( 'This entry was posted in %s', 'deciduous' ), 
        					get_the_category_list( ', ' )
        				);
        $postcategory .= '</span>';
        
        // Checking to see if tags will follow categories
        $posttags = get_the_tags();
    	
    	if ( !$posttags ) {
    		$postcategory .= '. ';
    	} else {
    		$postcategory .= ' ';
    	}

    } elseif ( is_category() && $cats_meow = deciduous_cats_meow( ', ' ) ) {
    	/* translators: %s is postfooter categories */
        $postcategory .= 	sprintf( 
        						esc_html__( 'Also posted in %s', 'deciduous' ),
        						$cats_meow 
        					);
        					
        $postcategory .= '</span>';
        
    } else {
    	
    	/* translators: %s is postfooter categories */
        $postcategory .= sprintf(	esc_html__( 
        								'Posted in %s', 'deciduous' ), 
        								get_the_category_list( ', ' )
        							);
        $postcategory .= '</span> ';
        $postcategory .= deciduous_p_meta_separator( $class = 'category' );
    }
    return apply_filters( 'deciduous_f_postfooter_postcategory', $postcategory ); 
    
}


/**
 * Create the tags list for post footer
 * 
 * Filter: deciduous_postfooter_posttags
 */
function deciduous_postfooter_posttags() {

    if ( is_single() && !is_object_in_taxonomy( get_post_type(), 'category' ) ) {
        $tagtext = esc_html__( 'This entry is tagged', 'deciduous' ) . ' ';
       
        $posttags = get_the_tag_list( "<span class=\"tag-links\"> $tagtext ", ', ', '</span>. ' );
	
	} elseif ( is_single() ) {
		if ( deciduous_categorized_blog() ) {
			$tagtext = esc_html__( 'and tagged', 'deciduous' ) . ' ';
		} else {
    		$tagtext = esc_html__( 'Tagged', 'deciduous' ) . ' ';
        }
        
        $posttags = get_the_tag_list( "<span class=\"tag-links\"> $tagtext ", ', ', '</span>. ' );
	
	} elseif ( is_tag() && $tag_ur_it = deciduous_tag_ur_it( ', ' ) ) {
        $posttags = '<span class="tag-links">';
        $posttags .= esc_html__( 'Also tagged', 'deciduous' );
        $posttags .= ' ' . $tag_ur_it . '</span>';
        $posttags .= "\n\n\t\t\t\t\t";
        $posttags .= deciduous_p_meta_separator( $class = 'tag' );
    
    } else {
        $tagtext = esc_html__( 'Tagged', 'deciduous' ) . ' ';
        
        $posttags = $list = get_the_tag_list( "<span class=\"tag-links\"> $tagtext ", ', ', '</span>' );
        	if( $list ) {
        		$posttags .=  "\n\n\t\t\t\t\t\t";
        		$posttags .=  deciduous_p_meta_separator( $class = 'tag' );
        	}
    }
    
    return apply_filters( 'deciduous_f_postfooter_posttags', $posttags ); 

}


/**
 * Create the comments link for the post footer on archive pages
 * 
 * Filter: deciduous_postfooter_postcomments
 */
function deciduous_postfooter_postcomments() {
    if ( comments_open() ) {
        $postcommentnumber = get_comments_number();

        if ( $postcommentnumber > '0' ) {
        	$postcomments = sprintf( '<span class="comments-link"><a href="%s" rel="bookmark">%s</a></span>',
        						apply_filters( 'the_permalink', get_permalink() ) . '#respond',
    							/* translators: number of comments and trackbacks */
        						sprintf( 
        							_n( '%s Response', '%s Responses', $postcommentnumber, 'deciduous' ),
        							number_format_i18n( $postcommentnumber )
        						)
        					);
    	} else {
            $postcomments = sprintf( '<span class="comments-link"><a href="%s" rel="bookmark">%s</a></span>',
        						apply_filters( 'the_permalink', get_permalink() ) . '#respond',
        						esc_html__( 'Leave a comment', 'deciduous' )
        					);
        }
        
    } else {
        $postcomments = '<span class="comments-link comments-closed-link">';
        $postcomments .= esc_html__( 'Comments closed', 'deciduous' );
        $postcomments .= '</span>';
    }  
             
    return apply_filters( 'deciduous_f_postfooter_postcomments', $postcomments ); 
}


/**
 * Create the comments link for the post footer on single posts
 * 
 * Filter: deciduous_postfooter_postconnect
 */
function deciduous_postfooter_postconnect() {
    if ( ( comments_open() ) && ( pings_open() ) ) { /* Comments are open */
        $postconnect = 	sprintf( 
        					_x( '%1$sPost a comment%2$s or leave a trackback: %3$s', '1s and 2s are the a href link wrappers, do not reverse them. 3s is trackback url.', 'deciduous' ),
    						'<a class="comment-link" href="#respond">', 
    						'</a>' ,
    						sprintf( 
    							'<a class="trackback-link" href="%s" rel="trackback">%s</a>.', 
    							get_trackback_url(),
    				 			esc_html__( 'Trackback URL', 'deciduous' )
    				 		)
    					);
    					
    } elseif ( ! ( comments_open() ) && ( pings_open() ) ) { /* Only trackbacks are open */
        $postconnect = 	sprintf( 
        					esc_html_x( 'Comments are closed, but you can leave a trackback: %s', '%s is trackback url, wrapped in link tags', 'deciduous' ),
    						sprintf( '<a class="trackback-link" href="%s" rel="trackback">%s</a>.', 
    							get_trackback_url(), 
    							esc_html__( 'Trackback URL', 'deciduous' )
    						)
    					);
    					
    } elseif ( ( comments_open() ) && ! (pings_open() ) ) { /* Only comments open */
        $postconnect = 	sprintf(
        					esc_html_x( 'Trackbacks are closed, but you can %1$spost a comment%2$s.', '1s and 2s are the a href link wrappers, do not reverse them', 'deciduous' ),
        					'<a class="comment-link" href="#respond">',
        					'</a>' 
        				);
        				
    } elseif ( ! (comments_open() ) && ! (pings_open() ) ) { /* Comments and trackbacks closed */
        $postconnect = esc_html__( 'Both comments and trackbacks are currently closed.', 'deciduous' );
    }
    
    return apply_filters( 'deciduous_f_postfooter_postconnect', $postconnect ); 
}


/**
 * Create the previous post link on single pages
 * 
 * Filter: deciduous_previous_post_link_args
 */
function deciduous_previous_post_link() {
	$previous_marker =  apply_filters( 'deciduous_f_previous_marker', $marker = '&laquo;' );
	
    $args = array ( 
    	'format'              => '%link',
    	'link'                => '<span class="meta-nav">' . $previous_marker . '</span> %title',
    	'in_same_cat'         => false,
    	'excluded_categories' => ''
    );
    				
    $args = apply_filters( 'deciduous_f_previous_post_link_args', $args );
    
    previous_post_link( $args['format'], $args['link'], $args['in_same_cat'], $args['excluded_categories'] );
}


/**
 * Create the next post link on single pages
 * 
 * Filter: deciduous_next_post_link_args
 */
function deciduous_next_post_link() {
	$next_marker =  apply_filters( 'deciduous_f_next_marker', $marker = '&raquo;' );
	
    $args = array (
    	'format' => '%link',
    	'link' => '%title <span class="meta-nav">' . $next_marker . '</span>',
    	'in_same_cat' => false,
    	'excluded_categories' => ''
    );
    
    $args = apply_filters( 'deciduous_f_next_post_link_args', $args );
    next_post_link( $args['format'], $args['link'], $args['in_same_cat'], $args['excluded_categories'] );
}


/**
 * Create a category list with all categories except the current one
 * 
 * Used in post footer on category archives (redundant)
 * 
 */
function deciduous_cats_meow( $glue ) {
    $current_cat = single_cat_title( '', false );
    $separator = "\n";
    $cats = explode( $separator, get_the_category_list( $separator ) );
    foreach ( $cats as $i => $str ) {
    	if ( strpos( $str, ">$current_cat<" ) > 0) {
    		unset( $cats[$i] );
    		break;
    	}
    }
    if ( empty( $cats ) ) {
    	return false;
	}
    return trim(join( $glue, $cats ));
}


/**
 * Create a tag list with all tags except the current one
 * 
 * Used in post footer on tag archives (redundant)
 * 
 */
function deciduous_tag_ur_it( $glue ) {
    $current_tag = single_tag_title( '', '',  false );
    $separator = "\n";
    $tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
    foreach ( $tags as $i => $str ) {
    	if ( strpos( $str, ">$current_tag<" ) > 0 ) {
    		unset($tags[$i]);
    		break;
    	}
    }
    if ( empty( $tags ) )
    	return false;
    
    return trim( join( $glue, $tags ) );
}

?>