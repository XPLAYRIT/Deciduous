<?php
/**
 * Attachment Content
 *
 * @package Deciduous
 * @subpackage Template Parts
 */
 ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

			<?php
				// creating the post header
				deciduous_postheader();
			?>

				<div class="entry-content">

					<div class="entry-attachment">

						<?php
							the_content( deciduous_more_text() );

							wp_link_pages( array( 'before' => sprintf( '<nav class="page-link">%s', __( 'Pages:', 'deciduous' ) ),
														'after' => '</nav>' ) );
						?>
						
					</div><!-- entry-attachment -->
					
				</div><!-- .entry-content -->

				<?php
					// creating the post footer
					deciduous_p_postfooter();
				?>

			</article><!-- #post -->
