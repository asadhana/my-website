<?php

namespace HelloCommerce\Includes;

use Elementor\App\App;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * class Utils
 **/
class Utils {

	const BUILT_WITH_ELEMENTOR_META_KEY = '_elementor_edit_mode';

	public static function elementor(): \Elementor\Plugin {
		return \Elementor\Plugin::instance();
	}

	public static function has_pro(): bool {
		return defined( 'ELEMENTOR_PRO_VERSION' );
	}

	public static function is_elementor_active(): bool {
		static $elementor_active = null;

		if ( null === $elementor_active ) {
			$elementor_active = defined( 'ELEMENTOR_VERSION' );
		}

		return $elementor_active;
	}

	public static function is_elementor_installed(): bool {
		static $elementor_installed = null;

		if ( null === $elementor_installed ) {
			$elementor_installed = file_exists( WP_PLUGIN_DIR . '/elementor/elementor.php' );
		}

		return $elementor_installed;
	}

	public static function is_hello_plus_active(): bool {
		return defined( 'HELLO_PLUS_VERSION' );
	}

	public static function is_hello_plus_installed(): bool {
		static $hello_plus_installed = null;

		if ( null === $hello_plus_installed ) {
			$hello_plus_installed = file_exists( WP_PLUGIN_DIR . '/hello-plus/hello-plus.php' );
		}

		return $hello_plus_installed;
	}

	public static function is_hello_plus_setup_wizard_done(): bool {
		if ( ! class_exists( 'HelloPlus\Modules\Admin\Classes\Menu\Pages\Setup_Wizard' ) ) {
			return false;
		}

		return \HelloPlus\Modules\Admin\Classes\Menu\Pages\Setup_Wizard::has_site_wizard_been_completed();
	}

	public static function get_hello_plus_activation_link(): string {
		$plugin = 'hello-plus/hello-plus.php';

		$url = 'plugins.php?action=activate&plugin=' . $plugin . '&plugin_status=all';

		return add_query_arg( '_wpnonce', wp_create_nonce( 'activate-plugin_' . $plugin ), $url );
	}

	public static function get_plugin_install_url( $plugin_slug ): string {
		$action = 'install-plugin';

		$url = add_query_arg(
			[
				'action' => $action,
				'plugin' => $plugin_slug,
				'referrer' => 'hello-commerce',
			],
			admin_url( 'update.php' )
		);

		return add_query_arg( '_wpnonce', wp_create_nonce( $action . '_' . $plugin_slug ), $url );
	}

	public static function get_theme_builder_options(): array {
		$url = 'https://go.elementor.com/hello-commerce-theme-builder/';
		$target = '_blank';

		if ( ! class_exists( 'Elementor\App\App' ) ) {
			return [
				'link' => $url,
				'target' => $target,
			];
		}

		if ( self::is_elementor_active() ) {
			$url = admin_url( 'admin.php?page=' . App::PAGE_ID . '&ver=' . ELEMENTOR_VERSION ) . '#site-editor/promotion';
			$target = '_self';
		}

		if ( self::has_pro() ) {
			$url = admin_url( 'admin.php?page=' . App::PAGE_ID . '&ver=' . ELEMENTOR_VERSION ) . '#site-editor';
			$target = '_self';
		}

		return [
			'link' => $url,
			'target' => $target,
		];
	}

	public static function is_woocommerce_active(): bool {
		static $woocommerce_active = null;

		if ( null === $woocommerce_active ) {
			$woocommerce_active = defined( 'WC_VERSION' );
		}

		return $woocommerce_active;
	}

	public static function is_built_with_elementor( $post_id = null ): bool {
		$post_id ??= get_the_ID();

		return get_post_meta( $post_id, self::BUILT_WITH_ELEMENTOR_META_KEY, true );
	}
}
