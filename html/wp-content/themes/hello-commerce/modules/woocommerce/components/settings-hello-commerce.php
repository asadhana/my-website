<?php
namespace HelloCommerce\Modules\Woocommerce\Components;

use Elementor\{
	Controls_Manager,
	Group_Control_Typography,
	Group_Control_Box_Shadow,
	Group_Control_Background,
};

use Elementor\Core\Kits\Documents\Tabs\Tab_Base;
use HelloCommerce\Includes\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Settings_Hello_Commerce extends Tab_Base {
	public function get_id() {
		return 'settings-hello-commerce';
	}

	public function get_title() {
		return esc_html__( 'Hello Commerce', 'hello-commerce' );
	}

	public function get_icon() {
		return 'eicon-cart-light';
	}

	public function get_group() {
		return 'settings';
	}

	public function get_help_url() {
		return 'https://go.elementor.com/global-woocommerce';
	}

	protected function register_tab_controls() {
		$this->add_woo_button_controls();
		$this->add_woo_prices_controls();
		$this->add_woo_sale_flash_controls();
	}

	protected function add_woo_button_controls() {
		$this->start_controls_section(
			'section_buttons_' . $this->get_id(),
			[
				'label' => esc_html__( 'Woo Buttons', 'hello-commerce' ),
				'tab' => $this->get_id(),
			]
		);

		$button_selectors = $this->get_button_selectors();
		$button_selector = implode( ',', $button_selectors );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'woo_buttons_typography',
				'label' => esc_html__( 'Typography', 'hello-commerce' ),
				'selector' => $button_selector,
			]
		);

		$this->start_controls_tabs( 'woo_buttons_tabs' );

		$this->start_controls_tab(
			'woo_buttons_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'hello-commerce' ),
			]
		);

		$this->add_control(
			'woo_buttons_normal_text_color',
			[
				'label' => esc_html__( 'Text Color', 'hello-commerce' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					$button_selector => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'woo_buttons_normal_background_color',
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => $button_selector,
				'fields_options' => [
					'color' => [
						'selectors' => [
							'{{SELECTOR}}' => 'background: {{VALUE}}',
						],
					],
					'gradient_angle' => [
						'selectors' => [
							'{{SELECTOR}}' => 'background: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
						],
					],
					'gradient_position' => [
						'selectors' => [
							'{{SELECTOR}}' => 'background: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
						],
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'woo_buttons_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'hello-commerce' ),
			]
		);

		$this->add_control(
			'woo_buttons_hover_text_color',
			[
				'label' => esc_html__( 'Text Color', 'hello-commerce' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					$this->add_hover_focus_to_selectors( $button_selector ) => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'woo_buttons_background_hover',
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => $this->add_hover_focus_to_selectors( $button_selector ),
				'fields_options' => [
					'color' => [
						'selectors' => [
							'{{SELECTOR}}' => 'background: {{VALUE}}',
						],
					],
					'gradient_angle' => [
						'selectors' => [
							'{{SELECTOR}}' => 'background: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
						],
					],
					'gradient_position' => [
						'selectors' => [
							'{{SELECTOR}}' => 'background: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
						],
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'show_button_border',
			[
				'label' => esc_html__( 'Border', 'hello-commerce' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'hello-commerce' ),
				'label_off' => esc_html__( 'No', 'hello-commerce' ),
				'return_value' => 'yes',
				'default' => 'no',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'woo_button_border_width',
			[
				'label' => __( 'Border Width', 'hello-commerce' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 1,
					'unit' => 'px',
				],
				'selectors' => [
					$button_selector => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;',
				],
				'condition' => [
					'show_button_border' => 'yes',
				],
			]
		);

		$this->add_control(
			'woo_buttons_border_color',
			[
				'label' => esc_html__( 'Color', 'hello-commerce' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					$button_selector => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'show_button_border' => 'yes',
				],
			]
		);

		$shape_options = [
			'default' => '8px',
			'sharp' => '0',
			'rounded' => '12px',
			'round' => '32px',
			'oval' => '50%',
		];

		$shape_attributes = '--ehc-button-border-top-left-radius: var(--ehc-button-border-radius-{{VALUE}}); --ehc-button-border-top-right-radius: var(--ehc-button-border-radius-{{VALUE}}); --ehc-button-border-bottom-left-radius: var(--ehc-button-border-radius-{{VALUE}}); --ehc-button-border-bottom-right-radius: var(--ehc-button-border-radius-{{VALUE}});';

		$this->add_responsive_control(
			'woo_button_border_radius_type',
			[
				'label' => esc_html__( 'Shape', 'hello-commerce' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'sharp',
				'options' => [
					'default' => esc_html__( 'Default', 'hello-commerce' ),
					'sharp' => esc_html__( 'Sharp', 'hello-commerce' ),
					'rounded' => esc_html__( 'Rounded', 'hello-commerce' ),
					'round' => esc_html__( 'Round', 'hello-commerce' ),
					'oval' => esc_html__( 'Oval', 'hello-commerce' ),
					'custom' => esc_html__( 'Custom', 'hello-commerce' ),
				],
				'selectors' => [
					'{{WRAPPER}}.woocommerce' => $shape_attributes,
					'{{WRAPPER}}.woocommerce-cart' => $shape_attributes,
					'{{WRAPPER}}.woocommerce-checkout' => $shape_attributes,
					'{{WRAPPER}}.woocommerce-account' => $shape_attributes,
					'{{WRAPPER}} .woocommerce ul.products li.product .button' => $shape_attributes,
				],
			]
		);

		$custom_shape_attributes = '--ehc-button-border-top-left-radius: {{BOTTOM}}{{UNIT}}; --ehc-button-border-top-right-radius: {{TOP}}{{UNIT}}; --ehc-button-border-bottom-right-radius: {{RIGHT}}{{UNIT}}; --ehc-button-border-bottom-left-radius: {{LEFT}}{{UNIT}};';

		$this->add_responsive_control(
			'woo_button_border_radius_shape_custom',
			[
				'label' => esc_html__( 'Border Radius', 'hello-commerce' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'selectors' => [
					'{{WRAPPER}}.woocommerce' => $custom_shape_attributes,
					'{{WRAPPER}}.woocommerce-cart' => $custom_shape_attributes,
					'{{WRAPPER}}.woocommerce-checkout' => $custom_shape_attributes,
					'{{WRAPPER}}.woocommerce-account' => $custom_shape_attributes,
					'{{WRAPPER}} .woocommerce ul.products li.product .button' => $custom_shape_attributes,
				],
				'condition' => [
					'woo_button_border_radius_type' => 'custom',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'woo_button_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'hello-commerce' ),
				'selector' => $button_selector,
			]
		);

		$padding_attributes = '--ehc-padding-block-start: {{TOP}}{{UNIT}}; --ehc-padding-block-end: {{BOTTOM}}{{UNIT}}; --ehc-padding-inline-start: {{LEFT}}{{UNIT}}; --ehc-padding-inline-end: {{RIGHT}}{{UNIT}};';

		$this->add_responsive_control(
			'woo_button_padding',
			[
				'label' => esc_html__( 'Padding', 'hello-commerce' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}}.woocommerce' => $padding_attributes,
					'{{WRAPPER}}.woocommerce-cart' => $padding_attributes,
					'{{WRAPPER}}.woocommerce-checkout' => $padding_attributes,
					'{{WRAPPER}}.woocommerce-account' => $padding_attributes,
					'{{WRAPPER}} .woocommerce ul.products li.product .button' => $padding_attributes,
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function add_woo_prices_controls() {
		$this->start_controls_section(
			'section_prices_' . $this->get_id(),
			[
				'label' => esc_html__( 'Woo Prices', 'hello-commerce' ),
				'tab' => $this->get_id(),
			]
		);

		$typography_selectors = $this->get_typography_selectors();
		$typography_selector = implode( ',', $typography_selectors );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'woo_prices_typography',
				'label' => esc_html__( 'Typography', 'hello-commerce' ),
				'selector' => $typography_selector,
			]
		);

		$this->add_control(
			'woo_prices_color',
			[
				'label' => esc_html__( 'Text Color', 'hello-commerce' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.woocommerce' => '--ehc-price-color: {{VALUE}}',
					'{{WRAPPER}}.woocommerce-cart' => '--ehc-price-color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce ul.products li.product .price' => '--ehc-price-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function add_woo_sale_flash_controls() {
		$this->start_controls_section(
			'section_sale_flash_' . $this->get_id(),
			[
				'label' => esc_html__( 'Sale Flash', 'hello-commerce' ),
				'tab' => $this->get_id(),
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'woo_sale_flash_typography',
				'label' => esc_html__( 'Typography', 'hello-commerce' ),
				'selector' => '{{WRAPPER}}.woocommerce span.onsale, {{WRAPPER}} .elementor-products-grid ul.products.elementor-grid li.product span.onsale, {{WRAPPER}}.woocommerce-cart span.onsale, {{WRAPPER}} .woocommerce ul.products li.product span.onsale',
			]
		);

		$this->add_control(
			'woo_sale_flash_color',
			[
				'label' => esc_html__( 'Text Color', 'hello-commerce' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.woocommerce' => '--ehc-sale-color: {{VALUE}}',
					'{{WRAPPER}}.woocommerce-cart' => '--ehc-sale-color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce ul.products li.product' => '--ehc-sale-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'woo_sale_flash_background_color',
			[
				'label' => esc_html__( 'Background Color', 'hello-commerce' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.woocommerce' => '--ehc-sale-background-color: {{VALUE}}',
					'{{WRAPPER}}.woocommerce-cart' => '--ehc-sale-background-color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce ul.products li.product' => '--ehc-sale-background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	public function get_additional_tab_content(): string {
		if ( Utils::has_pro() ) {
			return '';
		}

		$html = Utils::elementor()->controls_manager->get_teaser_template( [
			'title' => esc_html__( 'Fully customize your shop', 'hello-commerce' ),
			'messages' => [
				esc_html__( 'Create custom product grids, and personalized shopping experiences and more with Elementor Pro', 'hello-commerce' ),
			],
			'link' => 'https://go.elementor.com/hello-commerce-settings-pro',
			'button' => esc_html__( 'Upgrade Now', 'hello-commerce' ),
		] );
		return $html;
	}

	/**
	 * Generate a selector string with :hover and :focus for each selector.
	 *
	 * @param string $selector_list Comma-separated selectors.
	 * @return string
	 */
	protected function add_hover_focus_to_selectors( $selector_list ): string {
		$selectors = array_map( 'trim', explode( ',', $selector_list ) );
		$result = [];

		foreach ( $selectors as $selector ) {
			$result[] = $selector . ':hover';
			$result[] = $selector . ':focus';
		}

		return implode( ', ', $result );
	}

	/**
	 * Get all WooCommerce button selectors for controls.
	 *
	 * @return array
	 */
	protected function get_button_selectors(): array {
		return [
			'{{WRAPPER}}.woocommerce button.button.alt',
			'{{WRAPPER}}.woocommerce button.button.alt.disabled',
			'{{WRAPPER}}.woocommerce ul.products li.product .button',
			'{{WRAPPER}} .woocommerce ul.products li.product .button',
			'{{WRAPPER}}.woocommerce #respond input#submit',
			'{{WRAPPER}}.woocommerce .woocommerce-message .button',
			'{{WRAPPER}}.woocommerce div.product .woocommerce-tabs.wc-tabs-wrapper ul.tabs li.active',
			'{{WRAPPER}}.woocommerce-cart .wc-proceed-to-checkout a.checkout-button',
			'{{WRAPPER}}.woocommerce-cart .cart .button',
			'{{WRAPPER}}.woocommerce-cart button.button',
			'{{WRAPPER}}.woocommerce-cart .cart .button',
			'{{WRAPPER}}.woocommerce-cart .wc-proceed-to-checkout a.checkout-button',
			'{{WRAPPER}}.woocommerce-cart ul.products li.product .button',
			'{{WRAPPER}}.woocommerce-checkout button.button',
			'{{WRAPPER}}.woocommerce-checkout button.button.alt',
			'{{WRAPPER}}.woocommerce-cart a.button',
			'{{WRAPPER}}.woocommerce-account a.button',
			'{{WRAPPER}}.woocommerce-account a.button.alt',
			'{{WRAPPER}}.woocommerce-account button.button',
			'{{WRAPPER}}.woocommerce-account .woocommerce-MyAccount-navigation-link.is-active',
		];
	}

	/**
	 * Get all WooCommerce typography selectors for controls.
	 *
	 * @return array
	 */
	protected function get_typography_selectors(): array {
		return [
			'{{WRAPPER}}.woocommerce div.product span.price',
			'{{WRAPPER}}.woocommerce div.product div.summary p.price',
			'{{WRAPPER}}.woocommerce ul.products li.product .price',
			'{{WRAPPER}} .woocommerce ul.products li.product .price',
			'{{WRAPPER}}.woocommerce div.product .stock',
		];
	}
}
