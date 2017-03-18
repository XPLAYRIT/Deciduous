<?php
/**
 * Template Name: Archives Page
 *
 * This is a custom Page template for displaying an index of Archives.
 * It will display the page content above an unordered list of the different
 * post-type archives nested with an unordered list of thier post-type items.
 *
 * @package Deciduous
 * @subpackage Templates
 *
 * @link http://codex.wordpress.org/Creating_an_Archive_Index Codex: Creating an Archives Index
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
						// start the loop to get the page content
						the_post();

						// Load action hook: deciduous_a_before_post
						deciduous_do_before_post();
					?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

						<?php
							/**
							 * A Plugable function for creating the post header
							 * Located in library/extensions/content-extensions.php
							 */
							deciduous_p_postheader();
						?>

						<div class="entry-content">

							<?php
								// Getting the Page content
								the_content();
								edit_post_link( __( 'Edit', 'deciduous' ),'<span class="edit-link">','</span>' );
								// Loading the archives template part
								get_template_part( 'template-parts/content/content' , 'archives' );
							?>

						</div><!-- .entry-content -->

					</article><!-- #post -->

					<?php
						// Load action hook: deciduous_a_after_post
						deciduous_do_after_post();

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template('', true);
						}
					?>
	
				</div><!-- #content -->
	
				<?php
					// Loadaction hook for placing content below #content
					deciduous_do_after_content();
				?>
	
			</div><!-- #container -->
			
			<?php
				// action hook for placing content below #container
				deciduous_do_after_container();

				// Show Main Asides sidebars only if the layout calls for them to be displayed 
				// for example: full-width layout should not have main asides 
				if ( deciduous_main_asides_switch() ) {
						deciduous_get_sidebar('primary');
    					deciduous_get_sidebar('secondary');
    			}

				// calling footer.php
				get_footer();
			?>