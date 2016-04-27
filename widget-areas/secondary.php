<?php 
/**
 * Widget Area Secondary
 *
 * …
 * 
 * @package Deciduous
 * @subpackage Widget-Areas
 */

    // Load action hook: deciduous_a_before_secondary_aside
    deciduous_do_before_secondary_aside();
    
	if ( is_active_sidebar( 'secondary-aside' ) ) {
		echo deciduous_before_widget_area( 'secondary-aside' );
		dynamic_sidebar( 'secondary-aside' );
		echo deciduous_after_widget_area( 'secondary-aside' );

	}
	
    // Load action hook: deciduous_a_after_secondary_aside
    deciduous_do_after_secondary_aside(); 
?>