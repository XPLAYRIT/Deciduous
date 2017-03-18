<?php
/**
 * Template Name: Full Width
 *
 * This Full Width template removes the primary and secondary asides so that content
 * can be displayed the entire width of the #content area.
 *
 * @package Deciduous
 * @subpackage Templates
 */
?>
<?php	
	// calling the header.php
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
						// Load the page content template part
						get_template_part( 'template-parts/content' , 'page');
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

   					// calling footer.php
    				get_footer();
    			?>