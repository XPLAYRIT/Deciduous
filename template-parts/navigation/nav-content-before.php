<?php
/**
 * Navigation #navigation before
 *
 * Creates the older posts/newer posts links before the content
 *
 * @package Deciduous
 * @subpackage Template Parts
 */
 ?>
 <?php	
		if ( is_single() ) { 
		?>
				<nav id="navigation-before" class="navigation nav-content nav-single" role="navigation">
					
               		<h2 class="screen-reader-text">
               			<?php esc_html_e( 'Post navigation', 'deciduous' ) ?>
               		</h2>
					
					<div class="nav-previous">
						<?php 
							// deciduous_previous_post_link() is found in library/extensions/content-extensions
							deciduous_previous_post_link() 
						?>
					</div>
					
					<div class="nav-next">
						<?php 
							// deciduous_next_post_link() is found in library/extensions/content-extensions
							deciduous_next_post_link() 
						?>
					</div>

				</nav>

		<?php } else { ?>
				<nav id="navigation-before" class="navigation nav-content nav-plural" role="navigation">
               		
               		<h2 class="screen-reader-text">
               			<?php esc_html_e( 'Post navigation', 'deciduous' ) ?>
               		</h2>
               		
               		<?php 
               			// Check for pluggable function to include an alternate navigation
               			if ( function_exists( 'deciduous_p_alt_nav' ) ) : 
                			deciduous_p_alt_nav();
						else: 
					?>

					<div class="nav-previous">
						<?php 
							next_posts_link( 
								sprintf( '<span class="meta-nav">&laquo;</span> %s', 
									esc_html__( 'Older posts', 'deciduous' )
								)
							)
						?>
					</div>
					
					<div class="nav-next">
						<?php 
							previous_posts_link(
								sprintf( '%s <span class="meta-nav">&raquo;</span>',
									esc_html__( 'Newer posts', 'deciduous')
								)
							)
						?>
					</div>
					
					<?php endif ?>
					
				</nav>
		<?php }
