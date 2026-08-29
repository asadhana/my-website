<?php

namespace HelloCommerce\Modules\AdminHome\Rest;

use HelloCommerce\Includes\Utils;
use WP_REST_Server;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Promotions extends Rest_Base {

	public function get_promotions() {
		$action_links_data = [];

		if ( ! Utils::has_pro() && Utils::is_elementor_installed() ) {
			$action_links_data[] = [
				'type' => 'go-pro',
				'image' => HELLO_COMMERCE_IMAGES_URL . 'go-pro.svg',
				'url' => 'https://go.elementor.com/hello-commerce-pro/',
				'alt' => __( 'Elementor Pro', 'hello-commerce' ),
				'title' => __( 'Ready to sell more?', 'hello-commerce' ),
				'messages' => [
					__( 'Enhance your sales with Elementor Pro’s advanced customization and conversion boosting features. ', 'hello-commerce' ),
				],
				'button' => __( 'Upgrade Now', 'hello-commerce' ),
				'upgrade' => true,
				'features' => [
					__( 'Popup Builder', 'hello-commerce' ),
					__( 'Product Page', 'hello-commerce' ),
					__( 'Product Listings', 'hello-commerce' ),
					__( 'Coupon Bar', 'hello-commerce' ),
					__( 'Chat Button', 'hello-commerce' ),
					__( 'Form Integrations', 'hello-commerce' ),
					__( 'Display Conditions', 'hello-commerce' ),
					__( 'Custom Code & CSS', 'hello-commerce' ),
					__( 'Role Manager', 'hello-commerce' ),
				],
			];
		}

		if (
			! defined( 'ELEMENTOR_IMAGE_OPTIMIZER_VERSION' ) &&
			! defined( 'IMAGE_OPTIMIZATION_VERSION' )
		) {
			$action_links_data[] = [
				'type' => 'go-image-optimizer',
				'image' => HELLO_COMMERCE_IMAGES_URL . 'image-optimizer.svg',
				'url' => Utils::get_plugin_install_url( 'image-optimization' ),
				'alt' => __( 'Elementor Image Optimizer', 'hello-commerce' ),
				'title' => '',
				'messages' => [
					__( 'Optimize Images.', 'hello-commerce' ),
					__( 'Reduce Size.', 'hello-commerce' ),
					__( 'Improve Speed.', 'hello-commerce' ),
					__( 'Try Image Optimizer for free', 'hello-commerce' ),
				],
				'button' => __( 'Install', 'hello-commerce' ),
				'width' => 72,
				'height' => 'auto',
				'target' => '_self',
				'backgroundImage' => HELLO_COMMERCE_IMAGES_URL . 'image-optimization-bg.svg',
			];
		}

		if ( ! defined( 'SEND_VERSION' ) ) {
			$action_links_data[] = [
				'type' => 'go-send',
				'image' => HELLO_COMMERCE_IMAGES_URL . 'send-logo.gif',
				'backgroundColor' => '#EFEFFF',
				'url' => Utils::get_plugin_install_url( 'send-app' ),
				'alt' => __( 'Send', 'hello-commerce' ),
				'title' => '',
				'messages' => [
					__( 'Connect any website to automated Email & SMS workflows in a click with Send.', 'hello-commerce' ),
				],
				'button' => __( 'Install', 'hello-commerce' ),
				'buttonBgColor' => '#524CFF',
				'width' => 72,
				'height' => 'auto',
				'target' => '_self',
			];
		} elseif (
			! defined( 'ELEMENTOR_AI_VERSION' ) &&
			Utils::is_elementor_installed()
		) {
			$action_links_data[] = [
				'type' => 'go-ai',
				'image' => HELLO_COMMERCE_IMAGES_URL . 'ai.png',
				'url' => 'https://go.elementor.com/hello-commerce-ai/',
				'alt' => __( 'Elementor AI', 'hello-commerce' ),
				'title' => __( 'Elementor AI', 'hello-commerce' ),
				'messages' => [
					__( 'Boost creativity with Elementor AI. Craft & enhance copy, create custom CSS & Code, and generate images to elevate your website.', 'hello-commerce' ),
				],
				'button' => __( 'Let\'s Go', 'hello-commerce' ),
			];
		}

		return rest_ensure_response( [ 'links' => $action_links_data ] );
	}

	public function register_routes() {
		register_rest_route(
			self::ROUTE_NAMESPACE,
			'/promotions',
			[
				'methods' => WP_REST_Server::READABLE,
				'callback' => [ $this, 'get_promotions' ],
				'permission_callback' => [ $this, 'permission_callback' ],
			]
		);
	}
}
