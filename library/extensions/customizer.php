<?php
/**
 * deciduous support for Theme Customizer
 *
 * @package DeciduousLibrary
 * @subpackage Customizer
 */


/**
 * Implement Theme Customizer additions and adjustments.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function deciduous_customize_register( $wp_customize ) {
	
	/**
	 * Create a custom control to use a textarea for the footer text
	 * 
	 * @link http://ottopress.com/2012/making-a-custom-control-for-the-theme-customizer/
	 */
	class Deciduous_Customize_Textarea_Control extends WP_Customize_Control {
	    public $type = 'textarea';

	    public function render_content() {
	        ?>
	        <label>
	        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	        <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
	        </label>
	        <?php
	    }
	}
	
	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Get the defaults 
	$deciduous_defaults = deciduous_default_opt();

	/**
	 * Layout
	 */
	 	
	// Only show the layout section if the theme supports it
	if( current_theme_supports('deciduous_s_customizer_layout') ) {
	
		$deciduous_default_layout = $deciduous_defaults['layout'];

		$wp_customize->add_section( 'deciduous_layout', array(
			'title'       => __( 'Layout', 'deciduous' ),
			'description' => __( 'Choose the main layout of your theme', 'deciduous' ),
			'capability'  => 'edit_theme_options',
			'priority'    => '90'
		) );

		$wp_customize->add_setting( 'deciduous_theme_opt[layout]', array(
			'default'  => $deciduous_default_layout,
			'type'   => 'theme_mod',
			'sanitize_callback'	=> 'sanitize_html_class'
		) );

		$possible_layouts = deciduous_available_theme_layouts();
		$available_layouts = array();
		foreach( $possible_layouts as $layout) {
			$available_layouts[ $layout['slug'] ] = $layout['title'];
		}

		$wp_customize->add_control( 'deciduous_layout_control', array(
			'type'  => 'radio',
			'label'  => __( 'Theme layout', 'deciduous' ),
			'section' => 'deciduous_layout',
			'choices' => $available_layouts,
			'settings' => 'deciduous_theme_opt[layout]'
		) );
	}


	/**
	 * Author Info vCard
	 */
	 
	if ( current_theme_supports( 'deciduous_s_author_info' ) ) {
	
		// Get the default author info value
		$deciduous_default_author_info = $deciduous_defaults['author_info'];

		$wp_customize->add_section( 'deciduous_author_info', array(
			'title'			=> __( 'Info on Author Page', 'deciduous'),
			'description'	=> sprintf( _x('Display a %1$smicroformatted vCard%2$s with the author\'s avatar, bio and email on the author page.', '%1$s and %2$s are <a> tags', 'deciduous' ) , '<a target="_blank" href="http://microformats.org/wiki/hcard">', '</a>' ), 
			'priority'		=> 130,
		) );
		
		
		// Add setting for author info  
    	$wp_customize->add_setting( 'deciduous_theme_opt[author_info]', array(
			'default'			=> $deciduous_default_author_info,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'absint'
		) );
 
		// Add control for author info
		$wp_customize->add_control( 'deciduous_theme_opt[author_info]', array(
			'label'			=> __('Display Author Info on Author Page', 'deciduous'),
			'section'		=> 'deciduous_author_info',
			'type'			=> 'checkbox',
			'settings'		=> 'deciduous_theme_opt[author_info]'
		) );

}

	/**
	 * Footer Text
	 */
	
	$deciduous_default_footertext = $deciduous_defaults['footer_txt'];
	
	// Add section for deciduous footer options 
    $wp_customize->add_section( 'deciduous_footer_text', array(
		'title'			=> __( 'Footer', 'deciduous'),
		'description'	=> __('You can use HTML and shortcodes in your footer text.', 'deciduous'),
		'priority'		=> 135,
	) );
	
	// Add setting for footer text 
    $wp_customize->add_setting( 'deciduous_theme_opt[footer_txt]', array(
		'default'		=> $deciduous_default_footertext,
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback'	=> 'wp_kses_post'
	) );

	// Add control for footer text 
	$wp_customize->add_control( new Deciduous_Customize_Textarea_Control( $wp_customize, 'deciduous_theme_opt[footer_txt]', array(
		'label'			=> __('Footer text', 'deciduous'),
		'section'		=> 'deciduous_footer_text',
		'type'			=> 'textarea',
		'settings'		=> 'deciduous_theme_opt[footer_txt]'
	) ) );

}



add_action( 'customize_register', 'deciduous_customize_register' );





/**
 * Bind JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 */
function deciduous_customize_preview_js() {
	wp_enqueue_script( 'deciduous_customizer', get_template_directory_uri() . '/library/js/customizer.js', array( 'customize-preview' ), '20160205', true );
}
add_action( 'customize_preview_init', 'deciduous_customize_preview_js' );
