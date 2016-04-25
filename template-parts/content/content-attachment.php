<?php
/**
 * Attachment Content
 *
 * @package Deciduous
 * @subpackage Template Parts
 */
 ?>
 
 		<?php 
			// Load action hook for deciduous_a_before_post
			deciduous_do_before_post();
		?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

			<?php
		    	/** 
		    	 * A Plugable function that creates the post header
		    	 * Found in library/extensions/content-extensions.php
		    	 */
				deciduous_postheader();
			?>

				<div class="entry-content">

					<div class="entry-attachment">

						<?php
							the_content( deciduous_more_text() );

							wp_link_pages( array( 'before' => sprintf( '<nav class="page-link">%s', __( 'Pages:', 'deciduous' ) ),
														'after' => '</nav>' ) );
						?>
						
					</div><!-- entry-attachment -->
					
				</div><!-- .entry-content -->

				<?php
		    	/** 
		    	 * A Plugable function that creates the post footer
		    	 * Found in library/extensions/content-extensions.php
		    	 */
					deciduous_p_postfooter();
				?>

			</article><!-- #post -->

 		<?php 
			// Load action hook for deciduous_a_after_post
			deciduous_do_after_post();
		?>
