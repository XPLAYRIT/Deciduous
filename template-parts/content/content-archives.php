<?php
/**
 * Archives Page Template Content
 *
 * @package Deciduous
 * @subpackage Template Parts
 */
 ?>
 
			<ul id="archives-page" class="xoxo">

				<li id="category-archives" class="content-column">
					<h2><?php esc_html_e( 'Archives by Category', 'deciduous' ) ?></h2>
					<ul>
						<?php wp_list_categories( array ( 
													'feed' => 'RSS',
													'title_li' => '',
													'show_count' => true
												) );
						?> 
					</ul>
				</li>

				<li id="monthly-archives" class="content-column">
					<h2><?php esc_html_e('Archives by Month', 'deciduous') ?></h2>
					<ul>
						<?php wp_get_archives( array(
												'type' => 'monthly',
												'show_post_count' => true
											 )	); 
						?>
					</ul>
				</li>
				
			</ul><!-- #archives-page -->



