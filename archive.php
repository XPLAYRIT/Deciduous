<?php
/**
 * Archive Template
 *
 * Displays an archive index of post-type items. Other more specific archive templates
 * may override the display of this template for example the category.php tag.php author.php
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
					// Load action hook: deciduous_a_before_content
					deciduous_do_before_content();
				?>

				<div id="content" class="site-content" role="main">

					<?php
		    			/** 
		    			 * A Plugable function that creates the post title
		    			 * Found in library/extensions/content-extensions.php
		    			 */
						deciduous_p_page_title();
						
						/**
						 * Only display vcard on author archives and on the first page 
						 * and only if the theme supports it and the user desires it.
						 */
						if ( is_author() && current_theme_supports( 'deciduous_s_author_info' ) && !is_paged() && deciduous_get_theme_opt( 'author_info' ) == 1 ) {
							// load the author vcard template
							locate_template( array( 'template-parts/content/content-author.php' ) ,true );	
						}

						if ( current_theme_supports( 'deciduous_s_nav_before_content' ) ) {
							locate_template( array( 'template-parts/navigation/nav-content-before.php' ), true );
						}

						/**
						 * Load action hook: deciduous_a_before_x_loop where x = the type of template hierarchy view
						 *
						 * The result may be: deciduous_a_before_archive_loop, deciduous_a_before_category_loop, 
						 * deciduous_a_before_tag_loop, deciduous_a_before_tax_loop, deciduous_a_before_author_loop,
						 * deciduous_a_before_date_loop, deciduous_a_before_{post-type}_loop
						 */
						deciduous_do_before_x_loop();

						locate_template( array( 'template-parts/content/loop.php' ) ,true );

						/**
						 * Load action hook: deciduous_a_after_x_loop where x = the type of template hierarchy view
						 *
						 * The result may be: deciduous_a_after_archive_loop, deciduous_a_after_category_loop,
						 * deciduous_a_after_tag_loop, deciduous_a_after_tax_loop, deciduous_a_after_author_loop,
						 * deciduous_a_after_date_loop, deciduous_a_after_{post-type}_loop
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