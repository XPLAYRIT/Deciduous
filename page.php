<?php
/**
 * Page Template
 *
 * …
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
					/**
					 * Load the content-page template which will load 
					 * actions: deciduous_a_before_post deciduous_a_after_post
					 * as well as the comments template
					 */
					get_template_part( 'template-parts/content/content' , 'page' );
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