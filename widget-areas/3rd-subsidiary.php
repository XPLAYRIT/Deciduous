<?php
/**
 * 3rd Widget Area In The Footer
 *
 * 
 * @package Deciduous
 * @subpackage Widget-Areas
 */

    // Load action hook: deciduous_a_before_3rd_subsidiary
   deciduous_do_before_3rd_subsidiary();

	if ( is_active_sidebar( '3rd-subsidiary-aside' ) ) {
		echo deciduous_before_widget_area('3rd-subsidiary-aside' );
		dynamic_sidebar( '3rd-subsidiary-aside' );
		echo deciduous_after_widget_area( '3rd-subsidiary-aside' );
	}

    // Load action hook: deciduous_a_after_3rd_subsidiary
   deciduous_do_after_3rd_subsidiary(); 
?>