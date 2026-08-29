<?php
/**
 * Theme functions and definitions
 *
 * @package HelloCommerce
 */

use HelloCommerce\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_COMMERCE_ELEMENTOR_VERSION', '1.0.1' );
define( 'EHP_THEME_SLUG', 'hello-commerce' );

define( 'HELLO_COMMERCE_PATH', get_template_directory() );
define( 'HELLO_COMMERCE_URL', get_template_directory_uri() );
define( 'HELLO_COMMERCE_ASSETS_PATH', HELLO_COMMERCE_PATH . '/assets/' );
define( 'HELLO_COMMERCE_ASSETS_URL', HELLO_COMMERCE_URL . '/assets/' );
define( 'HELLO_COMMERCE_SCRIPTS_PATH', HELLO_COMMERCE_ASSETS_PATH . 'js/' );
define( 'HELLO_COMMERCE_SCRIPTS_URL', HELLO_COMMERCE_ASSETS_URL . 'js/' );
define( 'HELLO_COMMERCE_STYLE_PATH', HELLO_COMMERCE_ASSETS_PATH . 'css/' );
define( 'HELLO_COMMERCE_STYLE_URL', HELLO_COMMERCE_ASSETS_URL . 'css/' );
define( 'HELLO_COMMERCE_IMAGES_PATH', HELLO_COMMERCE_ASSETS_PATH . 'images/' );
define( 'HELLO_COMMERCE_IMAGES_URL', HELLO_COMMERCE_ASSETS_URL . 'images/' );
define( 'HELLO_COMMERCE_STARTER_IMAGES_PATH', HELLO_COMMERCE_IMAGES_PATH . 'starter-content/' );
define( 'HELLO_COMMERCE_STARTER_IMAGES_URL', HELLO_COMMERCE_IMAGES_URL . 'starter-content/' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

// Init the Theme class
require HELLO_COMMERCE_PATH . '/theme.php';

Theme::instance();
