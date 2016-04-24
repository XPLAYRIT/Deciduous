<?php
/**
 * Author Vcard Content
 *
 * @package Deciduous
 * @subpackage Template Parts
 */
 ?>
 
	<?php
		// setup the first post to acess the Author's metadata
		the_post();

	?>

			<div id="author-info" class="vcard">

				<h2 class="entry-title"><?php the_author_meta( 'first_name' ); ?> <?php the_author_meta( 'last_name' ); ?></h2>

				<?php
					// display the author's avatar
					echo( str_replace( "class='avatar", "class='photo avatar", get_avatar( get_the_author_meta('email') ) ) );
				?>

				<div class="author-bio note">

					<?php
						// Display Author's discription if it exists
						if ( get_the_author_meta( 'user_description' ) )
							// Filterable use the_author_user_description *or* get_the_author_user_description
							the_author_meta( 'user_description' );
					?>

				</div>

			<div id="author-email">

				<a class="email" title="<?php echo antispambot( get_the_author_meta( 'user_email' ) ); ?>" href="mailto:<?php echo antispambot( get_the_author_meta( 'user_email' ) ); ?>">
					<?php esc_html_e( 'Email ', 'deciduous' ) ?>
					<span class="fn n">
						<span class="given-name"><?php the_author_meta( 'first_name' ); ?></span>
						<span class="family-name"><?php the_author_meta( 'last_name' ); ?></span>
					</span>
				</a>

				<a class="url"  style="display:none;" href="<?php echo home_url() ?>/"><?php bloginfo('name') ?></a>

			</div>

		</div><!-- #author-info -->

<?php
	// Return to the beginning of the loop
	rewind_posts();
?>