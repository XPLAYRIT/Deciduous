<?php
/**
 * Comments Template
 *
 * Lists the comments and displays the comments form. 
 * 
 * @package Deciduous
 * @subpackage Templates
 *
 * @todo chase the invalid counts & pagination for comments/trackbacks
 */
?>

					<?php
						// action hook for inserting content above #comments
						deciduous_do_before_comments() 
					?>
				
					<div id="comments">
	
					<?php 
						// Disable direct access to the comments script
						if ( 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
					 	   die ( __('Please do not load this page directly.', 'deciduous')  );
						}
					
						// Set required varible from options
						$req = get_option('require_name_email');
					
						// Check post password and cookies
						if ( post_password_required() ) :
					?>
	
						<div class="nopassword"><?php _e('This post is password protected. Enter the password to view any comments.', 'deciduous') ?></div>
				
					</div><!-- #comments -->
	
					<?php 
							return;
						endif; 
				
					?>
	
					<?php if ( have_comments() ) : ?>
	
						<?php
							// Collect the comments and pings
							$deciduous_comments = $wp_query->comments_by_type['comment'];
							$deciduous_pings = $wp_query->comments_by_type['pings'];
						
							// Calculate the total number of each
							$deciduous_comment_count = count( $deciduous_comments );
							$deciduous_ping_count = count( $deciduous_pings );
						
							// Get the page count for each
							$deciduous_comment_pages = get_comment_pages_count( $deciduous_comments );
							$deciduous_ping_pages = get_comment_pages_count( $deciduous_pings );
						
							// Determine which is the greater pagination number between the two (comment,ping) paginations
							$deciduous_max_response_pages = ( $deciduous_ping_pages > $deciduous_comment_pages ) ? $deciduous_ping_pages : $deciduous_comment_pages;
						
							// Reset the query var to use our calculation for the maximum page (newest/oldest)
							if ( $overridden_cpage ) {
								set_query_var( 'cpage', 'newest' == get_option('default_comments_page') ? $deciduous_comment_pages : 1 );
						}
						?>
					
						<?php if ( ! empty( $comments_by_type['comment'] ) ) : ?>
							
						<?php
							// action hook for inserting content above #comments-list
							deciduous_do_before_comments_list() ;
						?>

							<?php if ( get_query_var('cpage') <= $deciduous_comment_pages )  : ?>
					
						<div id="comments-list-wrapper" class="comments">

							<h3><?php printf( $deciduous_comment_count > 1 ? deciduous_multiple_comments_text() :  deciduous_single_comment_text(), $deciduous_comment_count ) ?></h3>
	
							<ol id="comments-list" >
								<?php wp_list_comments( deciduous_list_comments_arg() ); ?>
							</ol>
										
						</div><!-- #comments-list-wrapper .comments -->
					
							<?php endif; ?>
						
						<?php 
							// action hook for inserting content below #comments-list
							deciduous_do_after_comments_list() 
						?>
					
						<?php endif; ?>
					
						<div id="comments-nav-below" class="comment-navigation" role="navigation">
	        		
	        				<div class="paginated-comments-links"><?php paginate_comments_links( 'total=' . $deciduous_max_response_pages ); ?></div>
	                
	               		</div>	
	                	                  
						<?php if ( ! empty( $comments_by_type['pings'] ) ) : ?>
	
						<?php 
							// action hook for inserting content above #trackbacks-list-wrapper
							deciduous_do_before_trackbacks_list();
						?>
						
							<?php if ( get_query_var('cpage') <= $deciduous_ping_pages ) : ?>
						
						<div id="pings-list-wrapper" class="pings">
						
							<h3><?php printf( $deciduous_ping_count > 1 ? '<span>%d</span> ' . __( 'Trackbacks', 'deciduous' ) : sprintf( _x( '%1$sOne%2$s Trackback', '%1$ and %2$s are <span> tags', 'deciduous' ), '<span>', '</span>' ), $deciduous_ping_count ) ?></h3>
	
							<ul id="trackbacks-list">
								<?php wp_list_comments( 'type=pings&callback=deciduous_pings' ); ?>
							</ul>				
	
						</div><!-- #pings-list-wrapper .pings -->			
						
							<?php endif; ?>
						
						<?php
							// action hook for inserting content below #trackbacks-list
							deciduous_do_after_trackbacks_list();
						?>
									
						<?php endif; ?>

					<?php endif; ?>
							
				<?php
					if ( 'open' == $post->comment_status ) :

						// action hook for inserting content above #commentform
						deciduous_do_before_comments_form();
						
						comment_form( deciduous_comment_form_args() );

						// action hook for inserting content below #commentform
						deciduous_do_after_comments_form();

					endif /* if ( 'open' == $post->comment_status ) */ 
				?>

					</div><!-- #comments -->

					<?php
						// action hook for inserting content below #comments
						deciduous_do_after_comments()
					?>