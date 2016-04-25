<?php
/**
 * 1st Widget Area In The Footer
 *
 * 
 * @package Deciduous
 * @subpackage Widget-Areas
 */

    // Load action hook: deciduous_a_before_1st_subsidiary
    deciduous_do_before_1st_subsidiary();

	if ( is_active_sidebar( '1st-subsidiary-aside' ) ) {
		echo deciduous_before_widget_area( '1st-subsidiary-aside' );
		dynamic_sidebar( '1st-subsidiary-aside' );
		echo deciduous_after_widget_area( '1st-subsidiary-aside' );
	}

    // Load action hook: deciduous_a_after_1st_subsidiary
    deciduous_do_after_1st_subsidiary(); 
?>