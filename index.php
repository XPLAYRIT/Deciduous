<?php
/**
 * Index Template
 *
 * This file is required by WordPress to recoginze deciduous as a valid theme.
 * It is also the default template WordPress will use to display your web site,
 * when no other applicable templates are present in this theme's root directory
 * that apply to the query made to the site.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy Codex: Template Hierarchy
 *
 * @package Deciduous
 * @subpackage Templates
 */


	get_header();
?>

			<?php
				// Load action hook: deciduous_a_before_container
				deciduous_do_before_container();
			?>

			<div id="container" class="content-wrapper">
	
				<?php
					// Load action: deciduous_a_before_content
					deciduous_do_before_content();
				?>

				<div id="content" class="site-content" role="main">
			
					<?php
						if ( current_theme_supports( 'deciduous_s_nav_before_content' ) ) {
							locate_template( array( 'template-parts/navigation/nav-content-before.php' ), true );
						}
	
						/**
						 * Load action hook: deciduous_a_before_x_loop where x = the type of template hierarchy view
						 *
						 * The result may be: deciduous_a_before_blog_loop, deciduous_a_before_search_loop, 
						 * deciduous_a_before_404_loop
						 */
						deciduous_do_before_x_loop();

						locate_template( array( 'template-parts/content/loop.php' ) ,true );

						/**
						 * Load action hook: deciduous_a_after_x_loop where x = the type of template hierarchy view
						 *
						 * The result may be: deciduous_a_after_blog_loop, deciduous_a_after_search_loop, 
						 * deciduous_a_after_404_loop
						 */
						deciduous_do_after_x_loop();

						if ( current_theme_supports( 'deciduous_s_nav_after_content' ) ) {
							locate_template( array( 'template-parts/navigation/nav-content-after.php' ), true );
						}
					?>
	
				</div><!-- #content -->
	
				<?php
					// Load action hook: deciduous_a_after_content
					deciduous_do_after_content();
				?>

			</div><!-- #container -->

			<?php
				// Load action hook: deciduous_a_after_container
				deciduous_do_after_container();

				/**
				 * Show Main Asides sidebars only if the layout calls for them to be displayed 
				 * for example: full-width layout should not have main asides
				 */
				if ( deciduous_main_asides_switch() ) {
						deciduous_get_sidebar('primary');
    					deciduous_get_sidebar('secondary');
    			}

				get_footer();
			?>