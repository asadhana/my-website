<?php

require get_template_directory() . '/class-tgm-plugin-activation.php';
/**
 * Recommended plugins.
 */
function titan_tools_center_register_recommended_plugins() {
	$plugins = array(
		array(
			'name'      => esc_html__( 'GTranslate', 'titan-tools-center' ),
			'slug'      => 'gtranslate',
			'source'           => '',
			'required'  => false,
			'force_activation' => false,
		),
		array(
			'name'      => esc_html__( 'WooCommerce', 'titan-tools-center' ),
			'slug'      => 'woocommerce',
			'source'           => '',
			'required'  => false,
			'force_activation' => false,
		)
	);
	$config = array();
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'titan_tools_center_register_recommended_plugins' );