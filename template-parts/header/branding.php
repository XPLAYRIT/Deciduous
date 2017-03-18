<?php
/**
 * Branding
 *
 * @package Deciduous
 * @subpackage Template Parts
 */
 ?>
 
			<div id="branding" class="branding">
			
				<div id="blog-title" class="site-title">
					<span><a href="<?php echo home_url() ?>/" rel="home"><?php bloginfo('name') ?></a></span>
				</div>
	    	
	    		<?php ( is_home() || is_front_page() ) ? $tag = 'h1': $tag = 'div' ?>

				<<?php echo( $tag ) ?> id="blog-description" class="tagline"><?php bloginfo( 'description', 'display' ) ?></<?php echo( $tag ) ?>>
				
				<?php 
				    /**
				     * We are storing the header image tag in a variable
				     * if it is empty continue on without a header image div 
				     * 
				     * Filter: deciduous_f_header_image_attributes
				     * For setting custom attributes for the img tag
				     *
				     * I am passing a blank space as the srcset value in customizer previews
				     * because Safari blows chunks with srcset in the customizer preview iframe
				     * and it disappears the header image upon update.
				     * 
				     * @link https://developer.wordpress.org/reference/functions/get_header_image_tag/
				     */
				    if( is_customize_preview() ) {
						$deciduous_header_image_attributes =	array( 'srcset' => ' ' );
					} else {
						$deciduous_header_image_attributes =	array();
					}
					
					// Begin header image check
					$deciduous_header_image = get_header_image_tag( apply_filters( 'deciduous_f_header_image_attributes' , $deciduous_header_image_attributes ) );

					if ( !empty( $deciduous_header_image ) ) : 
				?>
				
				<div class="header-image">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php echo $deciduous_header_image; ?>
					</a>
				</div><!-- .header-image -->
				<?php endif; // End header image check. ?>
			
			</div><!--  #branding -->