<?php
/**
 * Single Post
 *
 * @package Deciduous
 * @subpackage Template Parts
 */
 ?>
 
		<?php 
			// action hook for insterting content before #post
			deciduous_do_before_post();
		?>
		
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> > 
		
		<?php
		
		    // creating the post header
		    deciduous_p_postheader();
		?>
		    
		    <div class="entry-content">
		    
		    	<?php deciduous_p_content(); ?>
		
		    	<?php wp_link_pages( array( 'before' => sprintf( '<nav class="page-link">%s', __( 'Pages:', 'deciduous' ) ),
		    								'after' => '</nav>' ) ); ?>
		    	
		    </div><!-- .entry-content -->
		    
		    <?php deciduous_p_postfooter(); ?>
		    
		</article><!-- #post -->
		
		<?php
			// action hook for insterting content after #post
			deciduous_do_after_post();
		?>