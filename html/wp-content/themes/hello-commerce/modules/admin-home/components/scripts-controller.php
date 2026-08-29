<?php

namespace HelloCommerce\Modules\AdminHome\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use HelloCommerce\Modules\AdminHome\Module;

class Scripts_Controller {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_hello_commerce_admin_scripts' ] );
	}

	public function enqueue_hello_commerce_admin_scripts() {
		$screen = get_current_screen();

		if ( 'toplevel_page_' . Module::MENU_PAGE_SLUG !== $screen->id ) {
			return;
		}

		$handle     = 'hello-commerce-admin';
		$asset_path = HELLO_COMMERCE_SCRIPTS_PATH . 'hello-commerce-admin.asset.php';
		$asset_url  = HELLO_COMMERCE_SCRIPTS_URL;

		if ( ! file_exists( $asset_path ) ) {
			throw new \Exception( 'You need to run `npm run build` for the "hello-commerce" first.' );
		}

		$script_asset = require $asset_path;

		wp_enqueue_script(
			$handle,
			HELLO_COMMERCE_SCRIPTS_URL . "$handle.js",
			array_merge( $script_asset['dependencies'], [ 'wp-util' ] ),
			$script_asset['version'],
			true
		);

		wp_set_script_translations( $handle, 'hello-commerce' );
	}
}
