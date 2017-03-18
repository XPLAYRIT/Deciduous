<?php
/**
 * Single Post Template
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
					// Load action hook: deciduous_a_before_content
					deciduous_do_before_content();
				?>

				<div id="content" class="site-content" role="main">

					<?php 
						while ( have_posts() ) : the_post();
							if ( current_theme_supports( 'deciduous_s_nav_before_content' ) ) {
								get_template_part( 'template-parts/navigation/nav-content' , 'before' );
							}
		
							if ( is_attachment() ) {
								get_template_part( 'template-parts/content/content' , 'attachment' );
							} else {
								get_template_part( 'template-parts/content/content' , 'single'  );
							}
		
							if ( current_theme_supports( 'deciduous_s_nav_after_content' ) ) {
								get_template_part( 'template-parts/navigation/nav-content' , 'after' );
							}

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) {
								comments_template( '', true );
							}
							
						// end the loop
						endwhile;
					?>
					
					<?php
						// calling the widget area 'single-bottom'
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

				// Show Main Asides sidebars only if the layout calls for them to be displayed 
				// for example: full-width layout should not have main asides 
				if ( deciduous_main_asides_switch() ) {
						deciduous_get_sidebar('primary');
    					deciduous_get_sidebar('secondary');
    			}

    			get_footer();
    		?>