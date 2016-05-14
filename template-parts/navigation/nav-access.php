<?php
/**
 * Navigation #access
 *
 * Creates the Main Navigation: nav#access
 *
 * The filter: deciduous_f_menu_toggle_text can be used for changing the mobile menu toggle text.
 * The filter: deciduous_f_nav_menu_args can be used for altering the arguments passed to wp_nav_menu
 * The filter: deciduous_f_primary_menu_id can be used to change the theme location used for the main menu
 *
 * @package Deciduous
 * @subpackage Template Parts
 */
 ?>

    		<nav id="access" role="navigation">
    		
    			<div class="menu-toggle"><?php echo apply_filters( 'deciduous_f_menu_toggle_text', esc_html_x( 'Menu', 'Mobile navigation button', 'deciduous' ) ); ?></div>
    		    		
    			<?php 
    			$deciduous_nav_access = wp_nav_menu( apply_filters( 'deciduous_f_nav_menu_args', 
    				array(
						'theme_location'	=> apply_filters( 'deciduous_f_access_location', 'primary' ),
						'container'			=> 'div',
						'container_class'	=> 'menu',
						'menu_class'		=> 'sf-menu',
						'fallback_cb'		=> 'wp_page_menu',
						'depth'				=> 0,
						'echo'				=> false
				) ) );
				/**
				 * Here we check for the existance of a menu
				 * and if the menu does not exist it will use wp_page_menu()
				 * as a fallback function.
				 *
				 * Unfortunately wp_page_menu() applies the sf-menu class to
				 * the outer div instead of the inner ul.
				 * So we will search and replace the set the proper class attributes.
				 */
				if ( has_nav_menu( apply_filters( 'deciduous_f_primary_menu_id', 'primary' ) ) ) {
					echo $deciduous_nav_access;
				} else {
					echo preg_replace( array( '/sf-menu/','/ul/' ), array( 'menu', 'ul class="sf-menu"' ), $deciduous_nav_access, 1 );
				}
				?>
    		
    		</nav><!-- nav#access -->

