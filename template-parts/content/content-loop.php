<?php
/**
 * Index Loop
 *
 * @package Deciduous
 * @subpackage Template Parts
 */
?>
<?php
if( have_posts() ) :

	while ( have_posts() ) : the_post();
?>	
    			<?php
    				// Load action hook: deciduous_a_before_post
       				deciduous_do_before_post();
    			?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> > 

    				<?php
						if( is_search() ) {
							/** 
		    	 			 * A Plugable function that creates the page title
		    	 			 * Found in library/extensions/content-extensions.php
		    				 */
        					deciduous_p_archive_title();
        				} else {
							/** 
		    	 			 * A Plugable function that creates the post header
		    	 			 * Found in library/extensions/content-extensions.php
		    				 */
							deciduous_p_postheader();
						}
        			?>

    				<div class="entry-content">

    					<?php 
							/** 
		    	 			 * A Plugable function that creates the post content
		    	 			 * Found in library/extensions/content-extensions.php
		    				 */
		    				deciduous_p_content(); 
		    			?>

    					<?php wp_link_pages( array( 'before' => sprintf( '<nav class="page-link">%s', __( 'Pages:', 'deciduous' ) ),
    										'after' => '</nav>' ) ); ?>

    				</div><!-- .entry-content -->

    				<?php
						/** 
		    	 		 * A Plugable function that creates the post content
		    	 		 * Found in library/extensions/content-extensions.php
		    			 */
		    			deciduous_p_postfooter(); 
		    		?>

    			</article><!-- #post -->

    			<?php 
    				// Load action hook: deciduous_do_after_post
    				deciduous_do_after_post();

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template( '', true );
					}

	endwhile; 
	
else:
	
	get_template_part( 'template-parts/content/content' , 'none' );

endif; 
?>