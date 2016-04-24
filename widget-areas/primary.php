<?php 
/**
 * Widget Area Primary
 *
 * 
 * @package Thematic
 * @subpackage Widget-Areas
 */

    // Load action hook: deciduous_a_before_primary_aside
    deciduous_do_before_primary_aside();

	if ( is_active_sidebar( 'primary-aside' ) ) { 
		echo deciduous_before_widget_area( 'primary-aside' );
		dynamic_sidebar( 'primary-aside' );
		echo deciduous_after_widget_area( 'primary-aside' );
	} 
	
    // Load action hook: deciduous_a_after_primary_aside
    deciduous_do_after_primary_aside();

?>