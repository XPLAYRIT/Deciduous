<?php
/**
 * Comments Extensions
 *
 * @package deciduousLibrary
 * @subpackage CommentsExtensions
 */


function deciduous_commentmeta( $print = true ) {
    $content = '<div class="comment-meta">';
    $content .= '<time datetime="'. get_comment_time( 'c' ). '">'; 
    $content .= sprintf( 
    				esc_html_x('Posted %s at %s', 'Posted {$date} at {$time}', 'deciduous') , 
    				get_comment_date(),
    				get_comment_time()
    			);
    $content .= '</time>';

    $content .= ' ' . deciduous_p_meta_separator( $class = 'comment-date') . ' ';
    $content .= sprintf( 
    				'<a href="%1$s">%2$s</a>',
    				'#comment-' . get_comment_ID(),
    				esc_html__( 'Permalink', 'deciduous' )
    			);
    					
    if ( get_edit_comment_link() ) {
    	$content .= ' ' . deciduous_p_meta_separator( $class = 'comment-link') . ' ';
    	$content .=	sprintf(
    					'<a class="comment-edit-link" href="%1$s">%2$s</a>',
    					get_edit_comment_link(),
    					esc_html__( 'Edit', 'deciduous' )
    				);
    	}
    
    $content .= '</div>' . "\n";
    	
    return $print ? print( apply_filters( 'deciduous_f_commentmeta', $content ) ) : apply_filters( 'deciduous_f_commentmeta', $content );

} // end deciduous_commentmeta

 
/**
 * Custom callback function to list comments in the deciduous style. 
 * 
 * If you want to use your own comments callback for wp_list_comments, filter list_comments_arg
 *
 * @param object $comment 
 * @param array $args 
 * @param int $depth 
 */
function deciduous_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $depth;
?>
    
	   	<li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
		
			<?php 
				// action hook for inserting content above #comment
				deciduous_do_before_comment();
			?>
			
			<article id="comment-body-<?php comment_ID() ?>" class="comment-body">
				<footer class="comment-utility">
					<div class="comment-author vcard"><?php deciduous_commenter_link() ?></div><!-- .comment-author -->
			
						<?php deciduous_commentmeta( true ); ?>
			
						<?php  
							if ( $comment->comment_approved == '0' ) {
								echo "\t\t\t\t\t" . '<span class="unapproved">';
								esc_html_e( 'Your comment is awaiting moderation', 'deciduous' );
								echo ".</span>\n";
							}
						?>
				</footer><!-- .comment-utility -->
				
		        <div class="comment-content">
		    		<?php comment_text() ?>
				</div><!-- .comment-content -->
			
				<?php 
				
					if( $args['type'] == 'all' || get_comment_type() == 'comment' ) {
						comment_reply_link( array_merge( $args, array(
							'add_below'  => 'comment-body',
							'reply_text' => esc_html__( 'Reply','deciduous' ), 
							'login_text' => esc_html__( 'Log in to reply.','deciduous' ),
							'depth'      => $depth,
							'before'     => '<div class="comment-replylink">', 
							'after'      => '</div>'
						)));
					}
				?>
			
			</article><!-- .comment-body -->
			
			<?php
				// action hook for inserting content above #comment
				deciduous_do_after_comment() 
			?>

<?php }

/**
 * Custom callback to list pings in the deciduous style
 *
 * @param object $comment 
 * @param array $args 
 * @param int $depth 
 */
function deciduous_pings($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	?>

    		<li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
    			<div class="comment-author">
    				<?php 
    					printf(
    						esc_html_x( 'By %1$s on %2$s at %3$s', 'By {$authorlink} on {$date} at {$time}', 'deciduous' ),
    							get_comment_author_link(),
    							get_comment_date(),
    							get_comment_time()
    						);
    							
    					edit_comment_link( 
    						esc_html__( 'Edit', 'deciduous' ),
    						' <span class="meta-sep">|</span>' . "\n\n\t\t\t\t\t\t" . '<span class="edit-link">',
    						'</span>');
    				?>
    			</div>
    			
    			<?php 
    				if ($comment->comment_approved == '0') {
    					echo "\t\t\t\t\t" . '<span class="unapproved">';
    					esc_html_e( 'Your trackback is awaiting moderation', 'deciduous' );
    					echo ".</span>\n";
    				}
    			?>
    			
            	<div class="comment-content">
       				<?php comment_text() ?>
				</div>
				

<?php }


/**
 * Provides Plugin Compatibility: Subscribe to Comments
 *
 * Adds the subscribe to comments button.
 *
 * @link http://wordpress.org/extend/plugins/subscribe-to-comments/ Subscribe to Comments Plugin Page
 */
function deciduous_show_subscription_checkbox() {
    if( function_exists( 'show_subscription_checkbox' ) ) { 
		show_subscription_checkbox(); 
	}
}
add_action('comment_form', 'deciduous_show_subscription_checkbox', 98);


/**
 * Provides Plugin Compatibility: Subscribe to Comments
 *
 * Adds the subscribe without commenting button
 *
 * @link http://wordpress.org/extend/plugins/subscribe-to-comments/ Subscribe to Comments Plugin Page
 */
function deciduous_show_manual_subscription_form() {
    if( function_exists( 'show_manual_subscription_form' ) ) { 
		show_manual_subscription_form(); 
	}
}
add_action('deciduous_a_after_comments_form', 'deciduous_show_manual_subscription_form', 5);


/**
 * Filter: deciduous_single_comment_text
 *
 * Creates the standard text for one comment
 * Located in comments.php
 */
function deciduous_single_comment_text() {
    $content = 	sprintf(
    			 	esc_html_x(
    			 		'%1$sOne%2$s Comment' ,
    			 		'One Comment, where %$1s and %$2s are <span> tags',
    			 		'deciduous'
    				), 
    				'<span>' ,
    			 	'</span>'
    			);
    			
    return apply_filters( 'deciduous_f_single_comment_text', $content );
}

/**
 * Filter: deciduous_multiple_comments_text
 *
 * Creates the standard text for more than one comment
 * Located in comments.php
 */
function deciduous_multiple_comments_text() {
    $content = '<span>%d</span> ' . esc_html__('Comments', 'deciduous');
    return apply_filters( 'deciduous_f_multiple_comments_text', $content );
}


/**
 * Filter: list_comments_arg
 *
 * Creates the list comments arguments
 */
function deciduous_list_comments_arg() {
	$args = array(
		'type' => 'comment',
		'callback' => 'deciduous_comments'
	);
	return apply_filters( 'deciduous_f_list_comments_arg', $args );
}


/**
 * Filter: deciduous_postcomment_text
 *
 * Creates the standard text 'Post a Comment'
 * Located in comments.php
 */
function deciduous_postcomment_text() {
	/* translators: comment form title */
    $content = esc_html__('Post a Comment', 'deciduous');
    return apply_filters( 'deciduous_f_post_comment_text', $content );
}

/**
 * Filter: deciduous_postreply_text
 *
 * Creates the standard text 'Post a Reply to %s'
 * Located in comments.php
 */
function deciduous_postreply_text() {
	/* translators: comment reply form title, %s is author of comment */
    $content = esc_html__('Post a Reply to %s', 'deciduous');
    return apply_filters( 'deciduous_f_post_reply_text', $content );
}

/**
 * Filter: deciduous_commentbox_text
 *
 * Creates the standard text 'Comment' for the text box
 * Located in comments.php
 */
function deciduous_commentbox_text() {
	/* translators: label for comment form textarea */
	$content = esc_html_x('Comment', 'noun', 'deciduous');
    return apply_filters( 'deciduous_f_comment_box_text', $content );
}

/**
 * Filter: deciduous_cancelreply_text function.
 *
 * Creates the standard text 'Cancel reply'
 * Located in comments-extensions.php
 */
function deciduous_cancelreply_text() {
    $content = esc_html__('Cancel reply', 'deciduous');
    return apply_filters( 'deciduous_f_cancel_reply_text', $content );
}

/**
 * Filter: deciduous_commentbutton_text
 *
 * Creates the standard text 'Post Comment' for the send button
 * Located in comments.php
 */
function deciduous_commentbutton_text() {
	/* translators: text of comment button */
    $content = esc_attr__('Post Comment', 'deciduous');
    return apply_filters( 'deciduous_f_comment_button_text', $content );
}

/**
 * Function: deciduous_comment_form_args
 * Filter: comment_form_default_fields
 *
 * Creates the standard arguments for comment_form()
 * Located in comments.php
 */
function deciduous_comment_form_args( $post_id = null ) {
	global $user_identity, $id;

	if ( null === $post_id ) {
		$post_id = $id;
	} else {
		$id = $post_id;
	}

	$req = get_option( 'require_name_email' );

	$commenter = wp_get_current_commenter();

	$aria_req = ( $req ? " aria-required='true'" : '' );

	$fields =  array(
		'author' => '<div id="form-section-author" class="form-section"><div class="form-label">' . '<label for="author">' . __( 'Name', 'deciduous' ) . '</label> ' . ( $req ? '<span class="required">' . esc_html_x( '*', 'denotes required field', 'deciduous' ) . '</span>' : '' ) . '</div>' . '<div class="form-input">' . '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' .  ' maxlength="20" tabindex="3"' . $aria_req . ' /></div></div><!-- #form-section-author .form-section -->',
		'email'  => '<div id="form-section-email" class="form-section"><div class="form-label"><label for="email">' . __( 'Email', 'deciduous' ) . '</label> ' . ( $req ? '<span class="required">' . esc_html_x( '*', 'denotes required field', 'deciduous' ) . '</span>' : '' ) . '</div><div class="form-input">' . '<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" maxlength="50" tabindex="4"' . $aria_req . ' /></div></div><!-- #form-section-email .form-section -->',
		'url'    => '<div id="form-section-url" class="form-section"><div class="form-label"><label for="url">' . esc_html__( 'Website', 'deciduous' ) . '</label></div>' . '<div class="form-input"><input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="50" tabindex="5" /></div></div><!-- #form-section-url .form-section -->',
	);


	$args = array(
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field'        => '<div id="form-section-comment" class="form-section"><div class="form-label"><label for="comment">' . deciduous_commentbox_text() . '</label></div><div class="form-textarea"><textarea id="comment" name="comment" cols="45" rows="8" tabindex="6" aria-required="true"></textarea></div></div><!-- #form-section-comment .form-section -->',

		'comment_notes_before' => '<p class="comment-notes">' . sprintf( esc_html_x( 'Your email is %1$snever%2$s published nor shared.' , '%$1s and %$2s are <em> tags for emphasis on never', 'deciduous' ), '<em>' , '</em>' ) . ( $req ? ' ' . sprintf( esc_html_x('Required fields are marked %1$s*%2$s', '%$1s and %$2s are <span> tags', 'deciduous'), '<span class="required">', '</span>' ) : '' ) . '</p>',

		'must_log_in'          => '<p id="login-req">' .  sprintf( __('You must be %1$slogged in%2$s to post a comment.', 'deciduous'), sprintf('<a href="%s" title ="%s">', esc_attr( wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ), esc_attr__( 'Log in', 'deciduous' ) ), '</a>' ). '</p>',

		'logged_in_as'         => '<p id="login"><span class="loggedin">' . sprintf( __('Logged in as %s', 'deciduous' ), sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'profile.php' ), $user_identity ) ) .'</span>. <span class="logout">' . sprintf('<a href="%s">%s</a>' , esc_attr( wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ), esc_html__('Log out?', 'deciduous' ) ) . '</span></p>',

		'comment_notes_after'  => '<div id="form-allowed-tags" class="form-section"><p><span>' . sprintf( esc_html_x('You may use these %1$sHTML%2$s tags and attributes:', '%$1s and %$2s are <abbr> tags', 'deciduous'), '<abbr title="HyperText Markup Language">', '</abbr>' ) . '</span> <code>' . allowed_tags() . '</code></p></div>',

		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => deciduous_postcomment_text(),
		'title_reply_to'       => deciduous_postreply_text(),
		'cancel_reply_link'    => deciduous_cancelreply_text(),
		'label_submit'         => deciduous_commentbutton_text(),

	);
	return apply_filters( 'deciduous_f_comment_form_args', $args );
}

/**
 * Produces an avatar image with the hCard-compliant photo class
 */
function deciduous_commenter_link() {
	$commenter = get_comment_author_link();
	$avatar_email = get_comment_author_email();
	$avatar_size = apply_filters( 'avatar_size', '80' ); // Available filter: avatar_size
	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, $avatar_size ) );
	echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
}


function deciduous_get_comment_link( $link , $comment, $args ) {
	global  $wp_rewrite;

	$args['type'] = 'comment';
	$args['page'] = get_page_of_comment( $comment->comment_ID, $args );

	if ( $args['per_page'] ) {
		if ( '' == $args['page'] ) {
			$args['page'] = ( !empty($in_comment_loop) ) ? get_query_var('cpage') : get_page_of_comment( $comment->comment_ID, $args );
		}

		if ( $wp_rewrite->using_permalinks() ) {
			$link = user_trailingslashit( trailingslashit( get_permalink( $comment->comment_post_ID ) ) . 'comment-page-' . $args['page'], 'comment' );
		} else {
			$link = add_query_arg( 'cpage', $args['page'], get_permalink( $comment->comment_post_ID ) );
		}
	} else {
		$link = get_permalink( $comment->comment_post_ID );
	}

	return $link . '#comment-' . $comment->comment_ID;
}
add_filter( 'get_comment_link', 'deciduous_get_comment_link', 10, 3 );

?>