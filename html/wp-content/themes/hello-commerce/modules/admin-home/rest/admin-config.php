<?php

namespace HelloCommerce\Modules\AdminHome\Rest;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Core\DocumentTypes\Page;
use HelloCommerce\Includes\Utils;
use WP_REST_Server;

class Admin_Config extends Rest_Base {

	public function register_routes() {
		register_rest_route(
			self::ROUTE_NAMESPACE,
			'/admin-settings',
			[
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => [ $this, 'get_admin_config' ],
				'permission_callback' => [ $this, 'permission_callback' ],
			]
		);
	}

	public function get_admin_config() {
		$elementor_page_id = Utils::is_elementor_active() ? $this->ensure_elementor_page_exists() : null;

		$config = $this->get_welcome_box_config( [] );

		$config = $this->get_shop_settings( $config, $elementor_page_id );

		$config = $this->get_site_parts( $config, $elementor_page_id );

		$config = $this->get_resources( $config );

		$config = apply_filters( 'hello-plus-theme/rest/admin-config', $config );

		$config['config'] = [
			'showText'     => ! Utils::is_hello_plus_installed(),
			'nonceInstall' => wp_create_nonce( 'updates' ),
			'isWooCommerceActive' => Utils::is_woocommerce_active(),
			'isElementorActive' => Utils::is_elementor_active(),
			'isHelloPlusActive' => Utils::is_hello_plus_active(),
			'isHelloPlusSetupWizardDone' => Utils::is_hello_plus_setup_wizard_done(),
		];

		return rest_ensure_response( [ 'config' => $config ] );
	}

	private function ensure_elementor_page_exists(): int {
		$existing_page = \Elementor\Core\DocumentTypes\Page::get_elementor_page();

		if ( $existing_page ) {
			return $existing_page->ID;
		}

		$page_data = [
			'post_title'    => 'Hello Commerce page',
			'post_content'  => '',
			'post_status'   => 'draft',
			'post_type'     => 'page',
			'meta_input'    => [
				'_elementor_edit_mode' => 'builder',
				'_elementor_template_type' => 'wp-page',
			],
		];

		$page_id = wp_insert_post( $page_data );

		if ( is_wp_error( $page_id ) ) {
			throw new \RuntimeException( 'Failed to create Elementor page: ' . esc_html( $page_id->get_error_message() ) );
		}

		if ( ! $page_id ) {
			throw new \RuntimeException( 'Page creation returned invalid ID' );
		}

		wp_update_post([
			'ID' => $page_id,
			'post_title' => 'Hello Commerce #' . $page_id,
		]);
		return $page_id;
	}

	public function get_resources( array $config ) {
		$config['resourcesData'] = [
			'community' => [
				[
					'title'  => __( 'Facebook', 'hello-commerce' ),
					'link'   => 'https://www.facebook.com/groups/Elementors/',
					'icon'   => 'BrandFacebookIcon',
					'target' => '_blank',
				],
				[
					'title'  => __( 'YouTube', 'hello-commerce' ),
					'link'   => 'https://www.youtube.com/@Elementor/',
					'icon'   => 'BrandYoutubeIcon',
					'target' => '_blank',
				],
				[
					'title'  => __( 'Discord', 'hello-commerce' ),
					'link'   => 'https://discord.com/servers/elementor-official-community-1164474724626206720',
					'target' => '_blank',
				],
				[
					'title'  => __( 'Rate Us', 'hello-commerce' ),
					'link'   => 'https://wordpress.org/support/theme/hello-commerce/reviews/#new-post',
					'icon'   => 'StarIcon',
					'target' => '_blank',
				],
			],
			'resources' => [
				[
					'title'  => __( 'Help Center', 'hello-commerce' ),
					'link'   => 'https://go.elementor.com/hello-commerce-help/',
					'icon'   => 'HelpIcon',
					'target' => '_blank',
				],
				[
					'title'  => __( 'Blog', 'hello-commerce' ),
					'link'   => 'https://go.elementor.com/hello-commerce-blog/',
					'icon'   => 'SpeakerphoneIcon',
					'target' => '_blank',
				],
				[
					'title'  => __( 'Platinum Support', 'hello-commerce' ),
					'link'   => 'https://go.elementor.com/hello-commerce-care/',
					'icon'   => 'BrandElementorIcon',
					'target' => '_blank',
				],
			],
		];

		return $config;
	}

	public function get_shop_settings( array $config, ?int $elementor_page_id = null ): array {
		$config['shopSettings'] = [
			'shopSettings' => [
				[
					'title'  => __( 'Add new product', 'hello-commerce' ),
					'link'   => self_admin_url( 'post-new.php?post_type=product' ),
					'icon'   => 'AddPageIcon',
				],
				[
					'title'  => __( 'Page setup', 'hello-commerce' ),
					'link'   => self_admin_url( 'admin.php?page=wc-settings&tab=advanced' ),
					'icon'   => 'ChecklistIcon',
				],
				[
					'title'  => __( 'WooCommerce', 'hello-commerce' ),
					'link'   => self_admin_url( 'admin.php?page=wc-admin' ),
					'icon'   => 'AdjustmentsHorizontalIcon',
				],
			],
			'shopStyle' => [
				[
					'title'  => __( 'Woo Buttons', 'hello-commerce' ),
					'link'  => $this->get_open_homepage_with_tab( $elementor_page_id, 'settings-hello-commerce' ),
					'icon'   => 'ToggleRightIcon',
				],
				[
					'title'  => __( 'Woo Prices', 'hello-commerce' ),
					'link'  => $this->get_open_homepage_with_tab( $elementor_page_id, 'settings-hello-commerce', 'section_prices_settings-hello-commerce' ),
					'icon'   => 'CoinsIcon',
				],
				[
					'title'  => __( 'Sales Flash', 'hello-commerce' ),
					'link'  => $this->get_open_homepage_with_tab( $elementor_page_id, 'settings-hello-commerce', 'section_sale_flash_settings-hello-commerce' ),
					'icon'   => 'CalendarDollarIcon',
				],
			],
			'recentProducts' => $this->get_recent_posts( 'product' ),
		];

		return $config;
	}

	private function get_elementor_editor_url( ?int $page_id, string $active_tab ): string {
		$url = add_query_arg(
			[
				'post' => $page_id,
				'action' => 'elementor',
				'active-tab' => $active_tab,
			],
			admin_url( 'post.php' )
		);

		return $url . '#e:run:panel/global/open';
	}

	public function get_recent_posts( string $post_type = 'page' ): array {
		$query = new \WP_Query(
			[
				'posts_per_page'         => 5,
				'post_type'              => $post_type,
				'post_status'            => 'publish',
				'orderby'                => 'post_date',
				'order'                  => 'DESC',
				'fields'                 => 'ids',
				'no_found_rows'          => true,
				'lazy_load_term_meta'    => true,
				'update_post_meta_cache' => false,
			]
		);

		$posts = [];

		if ( $query->have_posts() ) {
			$elementor_active = Utils::is_elementor_active();

			while ( $query->have_posts() ) {
				$query->the_post();
				$edit_with_elementor = $elementor_active && Utils::is_built_with_elementor() ? '&action=elementor' : '';
				$posts[] = [
					'title' => get_the_title(),
					'link'  => get_edit_post_link( get_the_ID(), 'admin' ) . $edit_with_elementor,
					'icon'  => 'PagesIcon',
				];
			}
		}

		return $posts;
	}

	public function get_site_parts( array $config, ?int $elementor_page_id = null ): array {
		$site_pages = $this->get_recent_posts();

		$general = [
			[
				'title' => __( 'Add New Page', 'hello-commerce' ),
				'link'  => self_admin_url( 'post-new.php?post_type=page' ),
				'icon'  => 'PageTypeIcon',
			],
			[
				'title' => __( 'Settings', 'hello-commerce' ),
				'link'  => self_admin_url( 'admin.php?page=hello-plus-settings' ),
			],
		];

		$common_parts = [];

		$customizer_header_footer_url = self_admin_url( 'customize.php?autofocus[section]=hello-commerce-options' );

		$header_part = [
			'id'           => 'header',
			'title'        => __( 'Header', 'hello-commerce' ),
			'link'         => $customizer_header_footer_url,
			'icon'         => 'HeaderTemplateIcon',
			'showSublinks' => true,
			'sublinks'     => [],
		];
		$footer_part = [
			'id'           => 'footer',
			'title'        => __( 'Footer', 'hello-commerce' ),
			'link'         => $customizer_header_footer_url,
			'icon'         => 'FooterTemplateIcon',
			'showSublinks' => true,
			'sublinks'     => [],
		];

		if ( Utils::is_elementor_active() ) {
			if ( Utils::has_pro() ) {
				$header_part = $this->update_pro_part( $header_part, 'header' );
				$footer_part = $this->update_pro_part( $footer_part, 'footer' );
			}

			$common_parts = [
				array_merge(
					[
						'id'    => 'theme-builder',
						'title' => __( 'Theme Builder', 'hello-commerce' ),
						'icon'  => 'ThemeBuilderIcon',
					],
					Utils::get_theme_builder_options()
				),
			];
		}

		$site_parts = [
			'siteParts' => array_merge(
				[
					$header_part,
					$footer_part,
				],
				$common_parts
			),
			'sitePages' => $site_pages,
			'general'   => $general,
		];

		$config['siteParts'] = apply_filters( 'hello-plus-theme/template-parts', $site_parts );

		return $this->get_quicklinks( $config, $elementor_page_id );
	}

	private function update_pro_part( array $part, string $location ): array {
		$theme_builder_module = \ElementorPro\Modules\ThemeBuilder\Module::instance();
		$conditions_manager   = $theme_builder_module->get_conditions_manager();

		$documents    = $conditions_manager->get_documents_for_location( $location );
		$add_new_link = \Elementor\Plugin::instance()->app->get_base_url() . '#/site-editor/templates/' . $location;
		if ( ! empty( $documents ) ) {
			$first_document_id    = array_key_first( $documents );
			$part['showSublinks'] = true;
			$part['sublinks']     = [
				[
					'title' => __( 'Edit', 'hello-commerce' ),
					'link'  => get_edit_post_link( $first_document_id, 'admin' ) . '&action=elementor',
				],
				[
					'title' => __( 'Add New', 'hello-commerce' ),
					'link'  => $add_new_link,
				],
			];
		} else {
			$part['link']         = $add_new_link;
			$part['showSublinks'] = false;
		}

		return $part;
	}

	public function get_open_homepage_with_tab( ?int $page_id, $action, $section = null, $customizer_fallback_args = [] ): string {
		if ( Utils::is_elementor_active() ) {
			$url = $page_id ? $this->get_elementor_editor_url( $page_id, $action ) : Page::get_site_settings_url_config( $action )['url'];

			if ( $section ) {
				$url = add_query_arg( 'active-section', $section, $url );
			}

			return $url;
		}

		return add_query_arg( $customizer_fallback_args, self_admin_url( 'customize.php' ) );
	}

	public function get_quicklinks( $config, ?int $elementor_page_id = null ): array {
		$config['quickLinks'] = [
			'site_name' => [
				'title' => __( 'Site Name', 'hello-commerce' ),
				'link'  => $this->get_open_homepage_with_tab( $elementor_page_id, 'settings-site-identity', null, [ 'autofocus[section]' => 'title_tagline' ] ),
				'icon'  => 'TextIcon',
			],
			'site_logo' => [
				'title' => __( 'Site Logo', 'hello-commerce' ),
				'link'  => $this->get_open_homepage_with_tab( $elementor_page_id, 'settings-site-identity', null, [ 'autofocus[section]' => 'title_tagline' ] ),
				'icon'  => 'PhotoIcon',
			],
			'site_favicon' => [
				'title' => __( 'Site Favicon', 'hello-commerce' ),
				'link'  => $this->get_open_homepage_with_tab( $elementor_page_id, 'settings-site-identity', null, [ 'autofocus[section]' => 'title_tagline' ] ),
				'icon'  => 'AppsIcon',
			],
		];

		if ( Utils::is_elementor_active() ) {
			$config['quickLinks']['site_colors'] = [
				'title' => __( 'Site Colors', 'hello-commerce' ),
				'link'  => $this->get_open_homepage_with_tab( $elementor_page_id, 'global-colors' ),
				'icon'  => 'BrushIcon',
			];

			$config['quickLinks']['site_fonts'] = [
				'title' => __( 'Site Fonts', 'hello-commerce' ),
				'link'  => $this->get_open_homepage_with_tab( $elementor_page_id, 'global-typography' ),
				'icon'  => 'UnderlineIcon',
			];
		}

		return $config;
	}

	public function get_welcome_box_config( array $config ): array {
		$is_hello_plus_active = Utils::is_hello_plus_active();
		$title = __( 'Welcome to Hello Commerce', 'hello-commerce' );
		$description = __( 'Access the full suite of features, including shop website kits, header and footer templates, and extra widgets.', 'hello-commerce' );
		$button_text = __( 'Begin setup', 'hello-commerce' );

		if ( ! $is_hello_plus_active ) {
			$link = Utils::is_hello_plus_installed() ? Utils::get_hello_plus_activation_link() : 'install';

			$config['welcome'] = [
				'title'   => $title,
				'text'    => $description,
				'image'   => [
					'src' => HELLO_COMMERCE_IMAGES_URL . 'banner-image.png',
					'alt' => __( 'Hello Commerce banner illustration', 'hello-commerce' ),
				],
				'buttons' => [
					[
						'title'   => $button_text,
						'variant' => 'contained',
						'link'    => $link,
						'color'   => 'primary',
					],
				],
				'showText' => true,
			];

			return $config;
		}

		$button_link = Utils::get_hello_plus_activation_link();
		$show_text = true;
		$front_page_id = get_option( 'page_on_front' );

		if ( $is_hello_plus_active ) {
			$show_text = false;

			if ( Utils::is_hello_plus_setup_wizard_done() ) {
				$title = __( 'Hello Commerce Home', 'hello-commerce' );
				$description = __( 'Access everything you need to set up and manage your online shop.', 'hello-commerce' );
				$button_text = __( 'Edit home page', 'hello-commerce' );
				$button_link = $front_page_id ? get_edit_post_link( $front_page_id, 'admin' ) . '&action=elementor' : '';
			} else {
				$button_link = self_admin_url( 'admin.php?page=hello-plus-setup-wizard' );
				$title = __( 'Almost there', 'hello-commerce' );
				$description = __( 'Choose a template kit and start customizing your online shop.', 'hello-commerce' );
				$button_text = __( 'Finish setup', 'hello-commerce' );
			}
		}

		if ( $is_hello_plus_active && ! Utils::is_hello_plus_setup_wizard_done() ) {
			$config['welcome'] = [
				'title'   => $title,
				'text'    => $description,
				'image'   => [
					'src' => HELLO_COMMERCE_IMAGES_URL . 'banner-image.png',
					'alt' => $button_text,
				],
				'buttons' => [
					[
						'title'   => $button_text,
						'variant' => 'contained',
						'link'    => $button_link,
						'color'   => 'primary',
					],
				],
				'showText' => $show_text,
			];

			return $config;
		}

		$buttons = [];

		if ( $front_page_id ) {
			$buttons[] = [
				'title'   => $button_text,
				'variant' => 'contained',
				'link'    => $button_link,
				'color'   => 'primary',
			];
		}

		$buttons[] = [
			'title'   => __( 'View shop', 'hello-commerce' ),
			'variant' => 'outlined',
			'link'    => home_url(),
			'color'   => 'secondary',
		];

		$config['welcome'] = [
			'title'   => $title,
			'text'    => $description,
			'image'   => [
				'src' => HELLO_COMMERCE_IMAGES_URL . 'banner-image.png',
				'alt' => $button_text,
			],
			'buttons' => $buttons,
			'showText' => $show_text,
		];

		return $config;
	}
}
