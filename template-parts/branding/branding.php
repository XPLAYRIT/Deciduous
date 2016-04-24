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
				
				<?php if (  $deciduous_header_image = get_header_image() ) : ?>
				<?php
					/**
					 * Filter the default twentysixteen custom header sizes attribute.
					 *
					 * @since Twenty Sixteen 1.0
					 *
					 * @param string $custom_header_sizes sizes attribute
					 * for Custom Header. Default '(max-width: 709px) 85vw,
					 * (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px'.
					 */
					$custom_header_sizes = apply_filters( 'deciduous_header_image_sizes', '(max-width: 709px) 85vw, (max-width: 909px) 81vw, (max-width: 960px) 91vw, 960px' );
				?>
				<div class="header-image">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img src="<?php echo $deciduous_header_image; ?>" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_custom_header()->attachment_id ) ); ?>" sizes="<?php echo esc_attr( $custom_header_sizes ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
					</a>
				</div><!-- .header-image -->
				<?php endif; // End header image check. ?>
			
			</div><!--  #branding -->