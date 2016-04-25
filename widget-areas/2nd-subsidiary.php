<?php
/**
 * 2nd Widget Area In The Footer
 *
 * 
 * @package Deciduous
 * @subpackage Widget-Areas
 */

    // Load action hook: deciduous_a_before_2nd_subsidiary
    deciduous_do_before_2nd_subsidiary();

	if ( is_active_sidebar( '2nd-subsidiary-aside' ) ) {
		echo deciduous_before_widget_area('2nd-subsidiary-aside' );
		dynamic_sidebar( '2nd-subsidiary-aside' );
		echo deciduous_after_widget_area( '2nd-subsidiary-aside' );
	}

    // Load action hook: deciduous_a_after_2nd_subsidiary
    deciduous_do_after_2nd_subsidiary(); 
?>