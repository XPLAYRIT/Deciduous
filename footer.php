<?php
/**
 * Footer Template
 *
 * This template closes #main div and displays the #footer div.
 *
 * @package Deciduous
 * @subpackage Templates
 */
?>
  		<?php
  			// action hook for placing content above the closing of the #main div
			deciduous_do_before_main_close();
		?>
		</div><!-- #main -->
		
		<?php
			// action hook for placing content above the footer
			deciduous_do_before_footer(); 
		?>
		
		<footer id="footer" class="site-footer">
			
			<?php    
				// action hook for placing content before the subsidiary widget areas
    			deciduous_do_before_sub_asides();
    
     			// Only output Subsidiary markup if one of the asides has a widget in it
    			if ( is_active_sidebar( '1st-subsidiary-aside' ) || is_active_sidebar( '2nd-subsidiary-aside' ) || is_active_sidebar( '3rd-subsidiary-aside' ) ) : 
    		?>
        	
        	<div id="subsidiary">
    			<?php
					deciduous_get_sidebar( '1st-subsidiary' );
					deciduous_get_sidebar( '2nd-subsidiary' );
					deciduous_get_sidebar( '3rd-subsidiary' );
   	 			?>	        
        	</div><!-- #subsidiary -->
			
			<?php 
				endif;
				
				// action hook for placing content after subsidiary widget areas
				deciduous_do_after_sub_asides();
			?>
			<div id="colophon" role="contentinfo"> 
    			
    			<?php 
    				deciduous_do_before_siteinfo();
    				if ( $deciduous_footer_txt = deciduous_get_theme_opt( 'footer_txt' ) ) : 
    			?>
    			
    			<div id="siteinfo">
					<p><?php echo( do_shortcode( $deciduous_footer_txt ) )?></p>
				</div><!-- #siteinfo -->
    			
    			<?php  
    				endif;
    				deciduous_do_after_siteinfo();
    			?>
    			
			</div><!-- #colophon -->

		</footer><!-- .site-footer -->
		
		<?php
			// action hook for placing content below the footer
			deciduous_do_after_footer();
		?>
		
	</div><!-- #wrapper .hfeed -->
	
	<?php 
		// action hook for placing content before closing the BODY tag
		deciduous_do_after_wrapper();

		// calling WordPress' footer action hook
		wp_footer();
	?>
	
</body>
</html>