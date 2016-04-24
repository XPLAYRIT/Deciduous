<?php
/**
 * Page Content
 *
 * @package Deciduous
 * @subpackage Template Parts
 */
 

	while ( have_posts() ) : the_post();

		// Load action hook: deciduous_a_before_post
		deciduous_do_before_post();

?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

			<?php
				// creating the post header
				deciduous_p_postheader();
			?>

				<div class="entry-content">

				<?php
					the_content();

					wp_link_pages( "\t\t\t\t\t<nav class='page-link'>" . __( 'Pages: ', 'deciduous' ), "</nav>\n", 'number' );

					edit_post_link( __( 'Edit', 'deciduous' ), "\n\t\t\t\t\t\t" . '<div class="edit-link">' , '</div>' . "\n" );
				?>

				</div><!-- .entry-content -->

			</article><!-- #post -->

		<?php

			// Load action hook: deciduous_a_after_post
			deciduous_do_after_post();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template( '', true );
			}
		?>
<?php 
	endwhile;
?>