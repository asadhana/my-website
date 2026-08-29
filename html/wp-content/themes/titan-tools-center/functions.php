<?php
/**
 * Titan Tools center functions
 */

if ( ! function_exists( 'titan_tools_center_setup' ) ) :
function titan_tools_center_setup() {
    load_theme_textdomain( 'titan-tools-center', get_template_directory() . '/languages' );
}
endif; 
add_action( 'after_setup_theme', 'titan_tools_center_setup' );

if ( ! function_exists( 'titan_tools_center_styles' ) ) :
	function titan_tools_center_styles() {
		// Register theme stylesheet.
		wp_register_style('titan-tools-center-style',
			get_template_directory_uri() . '/style.css',array(),
			wp_get_theme()->get( 'Version' )
		);

		wp_enqueue_style(
			'owl.carousel-css',
			get_template_directory_uri() . '/assets/css/owl.carousel.css',
			array(),
			'2.3.4'
		);

		wp_enqueue_script(
			'owl-carousel-js',
			get_template_directory_uri() . '/assets/js/owl.carousel.js',
			array('jquery'),
			'2.3.4',
			true
		);

		wp_enqueue_script('titan-tools-center-js',
        	get_template_directory_uri() . '/assets/js/effects.js',array(),
        	wp_get_theme()->get('Version'),true 
   		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'titan-tools-center-style' );

		wp_style_add_data( 'titan-tools-center-style', 'rtl', 'replace' );

	}
endif;
add_action( 'wp_enqueue_scripts', 'titan_tools_center_styles' );

/**
 * TGM FILE
 */
require get_theme_file_path( '/tgm.php' );