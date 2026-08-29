=== Caddy - Smart Side Cart for WooCommerce ===
Author: Tribe Interactive
Author URI: https://www.usecaddy.com
Contributors: tribeinteractive, kakshak, mvalera
Tags: caddy, side cart, cart, woocommerce, sticky cart
Requires at least: 5.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 2.1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A high performance, conversion-boosting side cart for your WooCommerce store that improves your store's shopping experience & helps grow your sales.

== Description ==

**[Caddy](https://www.usecaddy.com/?utm_source=wp-org&amp;utm_medium=plugin-lp&amp;utm_campaign=plugin-desc-links)** is a **high performance, conversion-boosting side cart for your WooCommerce store** that improves your store's shopping experience & helps grow your sales. 

**Increase average order sizes** with Caddy's built-in product recommendations, **reduce cart abandonment** with a free shipping meter, and **encourage repeat shoppers** with a saved product list.

⚡️ **Optimized for performance**
📱 **Mobile friendly responsive design**
🔄 **Real-time (ajax) cart updates**
🌏 **Translation ready**
⚔️ **Cross-browser and cross-OS battle tested**
🔒 **Secure and reliable**
💡 **Lightweight and easy to use**
💰 **Boosts sales and average order value**
🔄 **Works with most themes and plugins**
🎁 **Apply cart discounts and promo codes**

**[Try the Demo](https://demo.usecaddy.com/)** | **[Visit usecaddy.com](https://www.usecaddy.com/?utm_source=wp-org&amp;utm_medium=plugin-lp&amp;utm_campaign=plugin-desc-links)**

= Caddy Lite features: =

* Add an (ajax powered) sticky side cart across your whole site
* Show a free shipping meter in the side cart that lets customers know when they qualify for free shipping
* Show product recommendations when customers add products to their cart
* Let customers save products for later
* Add cart and saved list links to your navigation menu (short codes + widgets)
* Let customers add products & manage their cart items without reloading the page
* Let customers manage cart quantities in the side cart
* Let customers remove items from the side cart
* Show a sticky floating cart button with a cart quantity indicator
* Let customers add coupons in the side cart
* Add custom CSS to set your own styles and match your brand
* WooCommerce HPOS support

= Compatibility =

Caddy is compatible with most themes and plugins. The following themes and plugins have been tested and confirmed working:

* Plugins: WooCommerce Subscriptions, WooCommerce Product Bundles, All Products For WooCommerceSubscriptions, Elementor, Divi
* Themes: GeneratePress, Flatsome, Astra, Hello Elementor, Kadence, OceanWP, Storefront

== Upgrade to Pro ==

Upgrade to Pro and unlock powerful customization features, analytics, recommendations, and more.

= Caddy Pro features: =

* 7 different cart icon styles & 30+ custom color options
* Cart tracking & analytics dashboard
* Multi-tier reward levels with free shipping, free gifts, and discounts
* Workflow automation engine
* In-cart annoucenment bar
* In-cart product subscription upsells using with the All Products for WooCommerce Subscriptions extension
* Change the cart bubble position on the screen
* Display notices when adding to cart or adding/removing saved products
* Promote custom coupon offers in the cart
* Set free shipping meter exclusions
* Set product recommendation exclusions
* Set product recommendation fall-back rules
* Show save for later buttons on product pages and shop archives
* Manage placement of save for later buttons on shop archives
* Customize a welcome message to new users
* Hide Caddy on specific pages
* Hide out of stock products from product recommendations
* Get priority email support
* Get early access to new features

**Upgrade to Pro Now:** [https://www.usecaddy.com/](https://www.usecaddy.com/?utm_source=wp-org&amp;utm_medium=plugin-lp&amp;utm_campaign=plugin-desc-links)

== Installation ==

Important: You must download and activate the WooCommerce plugin, before using Caddy.

= Install Caddy from within WordPress =
1. Visit the plugins page within your dashboard and click the 'Add New' button.
2. Search for 'Caddy'.
3. Click the install button.
4. Click the activate button.
5. Find the 'Caddy' menu within your dashboard and change your plugin settings.

== Frequently Asked Questions ==

= How do I add the Caddy cart icon & link to my menu or header? =

Caddy has an option in it's settings to insert the cart icon into your menu. If you want to add the cart icon somewhere else in your header you can use our widget or shortcode:

Widget:
Search for the "Caddy Cart" widget and add it to your header. 

Shortcodes:
Or, you can use our included shortcodes using the "Shortcodes in Menus" plugin and then adding the following Caddy shortcodes:
\[cc_saved_items text='Saves' icon='yes'\]
\[cc_cart_items text='Cart' icon='yes'\]

The "text" value is the text that you want to appear in your menu.
The "icon" value (yes or no) will display a heart icon for the "Saves" link and a cart icon for the "Cart" link

= Does Caddy work with multisite? =

Yes.

= How do I translate Caddy? =

1. Install and activate the free Loco Translate plugin.
2. Once installed, navigate to the Loco Translate menu option and select "plugins" from the sub menu.
3. Select the "Caddy" plugin
4. Click the "New language" link
5. Select the "WordPress language" option and select a language.
6. Choose a location for your language file (Custom is recommended), then click the "Start translating" button.
7. Select each of the source text lines (1), enter the translations (2) and finally save your changes (3).
8. Now make sure your default WordPress settings are set for the language you've configured and you're done.

You can find full instructions [here](https://usecaddy.com/docs/developers/how-to-translate-caddy-into-different-languages).

= Will Caddy slow down my site? =

No. We've built Caddy with performance in mind and have fine tuned it for speed.

== Screenshots ==

1. The Caddy side cart opened.
2. The up-sell recommendations screen after a product has been added to the side cart.
3. The settings screen.
4. The custom CSS styling screen.

== Changelog ==

= 2.1.2 =
* Improvement: Add cache-friendly cart fragments handler
* Improvement: Enhance get_refreshed_fragments method for better session handling
* Fix: Missing custom styles output on front-end
* Fix: Remove nonce verification for read-only cart data
* Feature: Added the option to disable 'save for later'

= 2.1.1 =
* Fix: missing menu cart icon

= 2.1.0 =
* Improvement: Enhanced error handling and user feedback for cart operations with proper notice display
* Improvement: Added validation for cart items and products with graceful degradation
* Improvement: Optimized cart update process to prevent duplicate function execution
* Improvement: Product removal notifications now display properly in the dedicated notice area with proper timing
* Improvement: Security improvements
* Fix: Updated deprecated WooCommerce function wc_add_to_cart_message to wc_add_to_cart_message_html for better compatibility with newer WooCommerce versions
* Fix: Added comprehensive validation to prevent errors when updating cart quantities for invalid or deleted products
* Fix: Implemented proper handling of trashed/unavailable products with automatic removal and user notification
* Fix: Resolved "Cart item not found" error when using minus button to remove items from cart
* Fix: Product recommendation image dimensions

= 2.0.9 =
* Fix: Refactor cart item savings display to prevent coupon modification
* Improvement: Enhance coupon discount calculation by respecting WooCommerce tax display settings. 
* Improvement: Update cart total display logic
* Improvement: Remove shipping option override when free shipping calculation met

= 2.0.8 =
* Improvement: Added minimum and maximum quantity validation for add to cart functionality.
* Improvement: AJAX error handling to provide fallback messages for cart loading issues.
* Improvement: Misc cleanup and better code organization

= 2.0.7 = 
* Fix: Nonce issue with recommendations
* Improvement: Improved refresh of cart contents on drawer open
* Improvement: Added skeleton loading for cart drawer
* Improvement: Admin settings pages refactored and redesigned
* Improvement: Improved coupon savings calculation
* Improvement: Performance improvements
* Compatibility: Support for Pro free gifting

= 2.0.6 = 
* Fix: Mobile styling issues
* Fix: Coupon calculations

= 2.0.5 = 
* Improvement: Improved mobile styling for recommendations
* Fix: Added dependency on WooCommerce add-to-cart script
* Fix: Added version numbers to scripts to prevent caching issues
* Fix: Minor styling fixes
* Fix: Removed obsolete files
* Fix: Android Chrome styling issues

= 2.0.4 = 
* Fix: Release fix

= 2.0.3 = 
* Feature: Added "Recommendations" field option in product settings
* Feature: Added "Recommendation Type" field option in Caddy settings
* Improvement: Improved coupon form experience
* Improvement: Improved performance
* Improvement: Cart processing improvements
* Improvement: Setting core styles as variables
* Fix: Various bug fixes and improvements

= 2.0.2 = 
* Fix: Composer dependency include
* Fix: Ensuring strings are wrapped with the appropriate translation functions
* Improvement: Ensuring all HTML attributes are properly escaped

= 2.0.1 = 
* Fix: PHP Warning - Attempt to read property "slug" on string
* Fix: Scroll overflow issue and body bottom padding
* Compatibility: Tested up to the latest WooCommerce 9.0.2 and WordPress 6.5.5 versions

= 2.0 =
* Compatibility: Remove Caddy from loading on DIVI editor screen
* Improvement: Major front-end cart UI design update
* Improvement: Re-arranged cart item contents
* Improvement: Replaced emojis in favor of simpler SVGs
* Improvement: Increased Caddy window width on desktop
* Improvement: Moved item count in bubble to the left
* Improvement: Added animation to FSM bar
* Improvement: FSM bar now fixed at the top of the cart screen
* Improvement: Cart recommendations moved below cart items
* Improvement: Cart item window now shows scrollbars when scrolling
* Improvement: Support for bundled products
* Feature: Set minus button on single qty item to remove item from the cart
* Feature: Add option to include tax with the free shipping meter calculation
* Feature: Add cart & save menu widget options
* Fix: Depreciated PHP < 8.0 code

= 1.9.8 =
* Compatibility: Tested up to latest WooCommerce 8.4.0 and WordPress 6.4.2 versions
* Compatibility: Added WooCommerce HPOS support
* Improvement: Removed IBM webfont
* Security: Added nonce to admin settings form

= 1.9.7 =
* Fix: Add-to-cart JS event not working for some products

= 1.9.6 =
* Fix: Address the same reference to the shipping meter text
* Improvement: Add-to-cart JS event changes
* Improvement: AJAX object handle name changes for caddy-public JS file
* Improvement: Cart subtotal calculation changes

= 1.9.5 =
* Fix: trash button is not working for some customers
* Improvement: Tested upto latest WooCommerce 6.9.4 and WordPress 6.0.2 versions

= 1.9.4 =
* Improvement: window.load event changes
* Improvement: Tested upto latest WooCommerce 6.8.2 and WordPress 6.0.2 versions
* Improvement: Updating the sidebar boxes and links in admin-area

= 1.9.3 =
* Fix: Call to a member function is_empty() on null
* Fix: Cart object condition check on the cart screen
* Improvement: Free shipping total calculation is round-up
* Improvement: Convert all the integer value to float for better calculations

= 1.9.2 =
* Fix: Call to a member function get_cart_contents_count() on null
* Fix: Minor fix for undefined variable that may have impacted subscription products
* Improvement: Replace cc_update_window_data AJAX action with get_refreshed_fragments
* Improvement: Tag added for free shipping country

= 1.9.1 =
* Fix: Added dynamic version number to public JS
* Improvement: WC 6.5.1 and WP 6.0 compatibility added

= 1.9 =
* Fix: Removed "Save for later" tab when "save for later" options (in premium version) is disabled
* Fix: Removed unused cc-fontawesome CSS
* Fix: Removed premium plugin save for later ajax action
* Improvement: Optimized add-to-cart process using WC Rest API
* Improvement: Performance improvement by minifying JS and CSS
* Improvement: Get refreshed fragments on-page load using JS
* Improvement: Using get_option instead of get_transient to check if premium license is active or not
* Improvement: Temporarily disable cart contents for any action within Caddy cart to show its loading
* Feature: Added affiliate ID field & affiliate link to Caddy branding
* Feature: Add affiliate ID field & affiliate link to Caddy branding

= 1.8.2 =
* Improvement: Performance improvement for all the major actions within plugin

= 1.8.1 =
* Improvement: Update save for later product listing code

= 1.8 =
* Improvement: caddy-public-fonts.css added as a separate file
* Fix: Redirect external product to the URL
* Improvement: Update Caddy cart screen qty field based on the product "Sold individually" settings
* Fix: cc_cart_icon & cart_text undefined error for the widgets
* Improvement: Premium version license activation check function added
* Improvement: Add support for "Display on the Checkout page" premium version option
* Fix: Excluding draft products to appear on the product recommendation
* Improvement: UK country code added in the free shipping meter
* Improvement: Hooks added before and after caddy cart items

= 1.7.9 =
* Improvement: Cart sub-total calculations (support decimal value)
* Improvement: Caddy global admin and public object created to override hooks
* Fix: Wrapper css changes for some themes

= 1.7.8 =
* Fix: Mobile cart open issue (sometime) when product added

= 1.7.7 =
* Fix: DIVI theme builder compatibility issue
* Improvement: Display Caddy cart item meta info below product name
* Improvement: Free shipping meter price changes
* Improvement: Translation file updated

= 1.7.6 =
* Fix: WP Rocket caching issue
* Improvement: Hide catalog visibility hidden products from recommendations
* Improvement: Adding transition to compass count
* Improvement: Remove subtotal section
* Improvement: Change "Estimated total" to "Subtotal" and calculations (exclude shipping and taxes)

= 1.7.5 =
* Fix: YITH gift card plugin compatibility
* Improvement: Remove added class after deleting item from the cart
* Improvement: Free shipping meter calculations updated
* Improvement: Subtotal and estimated total changes
* Fix: WordPress jQuery (default) load issue
* Improvement: Changing Caddy logo
* Improvement: Fixing colors to match new Caddy brand
* Improvement: Caddy widget condition changes
* Improvement: Display subtotal under the coupon code box

= 1.7.4 =
* Improvement: New hook added for Caddy nav menu
* Improvement: POT file updated

= 1.7.3 =
* Improvement: Product price in cart screen updated
* Improvement: Caddy premium license condition updated

= 1.7.2 =
* Fix: Save for later button condition changes

= 1.7.1 =
* Fix: Fixing bubble close button
* POT file updated for translation
* Fix: Free shipping meter bug

= 1.7 =
* Improvement: General performance optimizations
* Improvement: Shipping meter CSS animation added
* Improvement: Caddy admin settings layout changes
* Improvement: Display product recommendations directly inside the cart screen
* Improvement: Front-end UI improvements
* Fix: Display an error message while trying to add an out-of-stock product
* Fix: product links
* Fix: CSS changes to support larger screens
* Fix: Product recommendations layout when adding product to saved list
* Fix: Mobile styles
* Fix: Free shipping meter condition updated
* Compatibility: Caddy support added for Elementor editor
* Compatibility: Twenty Twenty-One theme compatibility added
* Compatibility: Premium latest version support added with different notices
* Compatibility: Flatsome theme support added
* Compatibility: Multi-site support updated

= 1.6 =
* General bug fixes
* Add-on page changes
* Before and after cart screen hooks added
* Caddy Announcement add-on section added to the add-ons page
* Prevent out of stock products from being added to cart
* Free shipping meter condition updated when a coupon code is removed
* Added support for the "WooCommerce Blocks" plugin

= 1.5 =
* Bug fixes
* Crate cart and saved items widgets
* Updated add-on page layout
* Cart confirmation screen refresh rate updated

= 1.4 =
* Bug fixes
* Updated plugin using hooks

= 1.3 =
* Calculations were fixed for the discount amount

= 1.2 =
* Bug fixes
* Code clean-up and optimization
* Adding support for the latest versions of WordPress and WooCommerce

= 1.1 =
* Fixed issue with pot language file
* Added missing language strings
* Code cleanup

= 1.0 =
* Initial release

== Upgrade Notice ==

= 2.0 =
This version introduces major design changes. Please be sure to back up any changes before updating.