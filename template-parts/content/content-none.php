<?php
/**
 * 404 Error Page and Search (no results) Content
 *
 * @package Deciduous
 * @subpackage Template Parts
 */
 ?>

 		<?php 
			// Load action hook for deciduous_a_before_post
			deciduous_do_before_post();

			if( is_404() ) {
				deciduous_p_postheader();
			} elseif  (is_search() ) {
				deciduous_p_page_title();
			}
		?>
		
		<div id="post-0" class="post not-found">
  			
			<div class="entry-content">
			
				<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

				<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'deciduous' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
				
			</div><!-- .entry-content -->
			 
				<?php else: ?>
				
				<p><?php _e( 'Apologies, but we were unable to find what you were looking for. Perhaps searching will help.', 'deciduous' ) ?></p>
			
			</div><!-- .entry-content -->
			
			<?php get_search_form() ?>
			
			<?php endif; ?>
			
		</div><!-- .post -->
		
		<?php
			// Load action hook for deciduous_a_after_post
			deciduous_do_after_post();
		?>
