<?php

/**
 * Used to display admin notices.
 *
 * @package    caddy
 * @subpackage caddy/includes
 * @author     Tribe Interactive <hello@madebytribe.com>
 */
class Caddy_Admin_Notices {
	
	private $install_date;
	private $installed_version;
	
	public function __construct() {
		$this->setup_install_data();
	}
	
	/**
	 * Set up installation date and version data
	 */
	private function setup_install_data() {
		// Get installation date
		$this->install_date = get_option('caddy_install_date', false);
		
		// If no install date is set, set it now
		if (!$this->install_date) {
			$this->install_date = time();
			update_option('caddy_install_date', $this->install_date);
		}
		
		// Get the installed version
		$this->installed_version = get_option('caddy_version', false);
	}
	
	/**
	 * Check if the plugin was installed within a certain timeframe
	 * 
	 * @param int $days Number of days to check against
	 * @return bool True if plugin was installed within specified days
	 */
	private function is_recent_install($days = 7) {
		// If no install date, consider it a new install
		if (!$this->install_date) {
			return true;
		}
		
		$now = time();
		$diff = round(($now - $this->install_date) / DAY_IN_SECONDS);
		
		return $diff <= $days;
	}
	
	/**
	 * Check if this is an upgrade from a previous version
	 * 
	 * @return bool True if this is an upgrade
	 */
	private function is_upgrade() {
		return $this->installed_version && $this->installed_version !== CADDY_VERSION;
	}
	
	public function register_hooks() {
		
		// Display RetentionKit promo
		add_action( 'admin_notices', array( $this, 'display_rk_promo_notice' ) );
		// Display review request
		add_action( 'admin_notices', array( $this, 'display_review_notice' ) );
		// Display upgrade notice
		add_action( 'admin_notices', array( $this, 'display_upgrade_notice' ) );
		// Display opt-in notice
		add_action( 'admin_notices', array( $this, 'display_optin_notice' ) );
		
		// Update version on plugin updates
		add_action( 'upgrader_process_complete', array( $this, 'update_version_on_upgrade' ), 10, 2 );
	}
	
	/**
	 * Update version when plugin is upgraded
	 */
	public function update_version_on_upgrade($upgrader, $options) {
		if ($options['action'] == 'update' && $options['type'] == 'plugin') {
			foreach($options['plugins'] as $plugin) {
				if ($plugin == plugin_basename(CADDY_PLUGIN_FILE)) {
					update_option('caddy_version', CADDY_VERSION);
				}
			}
		}
	}
	
	/**
	 * Display RK promo notice
	 */
	public function display_rk_promo_notice() {
		
		// Ensure WooCommerce is active
		if (!function_exists('WC')) return;
		
		global $rk_promo_notice_called;
		if (isset($rk_promo_notice_called) && $rk_promo_notice_called) {
			return; // Don't execute if the notice has already been called
		}
		$rk_promo_notice_called = true;
		
		// Get the current URL
		$http_host = isset($_SERVER['HTTP_HOST']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_HOST'])) : '';
		$request_uri = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : '';
		$current_url = (is_ssl() ? 'https://' : 'http://') . $http_host . $request_uri;
		
		// Check if RK is not active and if we're on the target WooCommerce Subscriptions pages
		if (!class_exists('rk') && (
			$this->is_subscriptions_listing_page($current_url) ||
			$this->is_edit_subscription_page($current_url)
		)) {
			wp_enqueue_style('kt-admin-notice', plugin_dir_url(__DIR__) . 'admin/css/caddy-admin-notices.css', array(), CADDY_VERSION);
		
			if (!PAnD::is_admin_notice_active('notice-rk-promo-forever')) {
				return;
			}
		?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					// Parse numbers without commas
					var cancelledCount = parseInt($('.wc-cancelled span.count').text().replace(/\(|\)|,/g, "") || 0);
					var pendingCancelCount = parseInt($('.wc-pending-cancel span.count').text().replace(/\(|\)|,/g, "") || 0);
			
					// Function to add commas to numbers for display
					function numberWithCommas(x) {
						return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
					}
				
					// Update the message first
					if (cancelledCount === 0 && pendingCancelCount === 0) {
						$('.dynamic-message').html("put a stop subscription cancellations!");
					} else if (cancelledCount === 0) {
						$('.dynamic-message').html("You have <span class='pending-cancel-count'></span> pending-cancels!");
					} else if (pendingCancelCount === 0) {
						$('.dynamic-message').html("You have <span class='cancel-count'></span> cancellations!");
					}
				
					// Then update the counts using formatted numbers with commas
					$('.cancel-count').html(numberWithCommas(cancelledCount));
					$('.pending-cancel-count').html(numberWithCommas(pendingCancelCount));
				});
			</script>
	
			<div data-dismissible="notice-rk-promo-forever" class="notice is-dismissible caddy-notice rk-promo">
				<div class="kt-left"><img src="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'admin/img/rk-cancel-promo.svg' ); ?>" width="145" height="145" alt="kt Promo"></div>
				<div class="kt-right">
					<div class="welcome-heading">
						<span class="dynamic-message"><?php echo esc_html( __( 'You have ', 'caddy' ) ); ?> <span class="cancel-count"></span> <?php echo esc_html( __( 'cancellations and ', 'caddy' ) ); ?> <span class="pending-cancel-count"></span> <?php echo esc_html( __( 'pending-cancels!', 'caddy' ) ); ?></span>
					</div>
	
					<p class="rk-message">
						<?php echo esc_html( __( 'That\'s potential revenue slipping away. Let ', 'caddy' ) ); ?>
						<a href="<?php echo esc_url( 'https://www.getretentionkit.com/?utm_source=caddy-plugin&amp;utm_medium=plugin&amp;utm_campaign=sub-promo-15' ); ?>"><?php echo esc_html( __( 'RetentionKit', 'caddy' ) ); ?></a>
						<?php echo esc_html( __( ' step in! We\'ll not only reveal why they\'re stepping back but also weave in offers that can transform those exits into profit boosts. In the subscription game, every comeback is a win for your bottom line. 💰', 'caddy' ) ); ?>
					</p>
					<p>
						<?php 
						echo wp_kses(
							__( 'Use code <strong>RKSAVE15</strong> to take <strong>15% off</strong> RetentionKit today and start saving your subscription revenue.', 'caddy' ),
							array(
								'strong' => array()
							)
						); 
						?>
					</p>
					<p class="caddy-notice-ctas">
						<a class="button" href="<?php echo esc_url( 'https://www.getretentionkit.com/?utm_source=caddy-plugin&amp;utm_medium=plugin&amp;utm_campaign=sub-promo-15' ); ?>"><?php echo esc_html( __( 'Enable Cancellation Protection', 'caddy' ) ); ?><img src="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'admin/img/rk-arrow-right.svg' ); ?>" width="20" height="20"></a>
					</p>
				</div>
			</div>
		<?php
		}
	}

	private function is_subscriptions_listing_page($url) {
		// Check if the URL is for the subscriptions listing page
		return strpos($url, 'page=wc-orders--shop_subscription') !== false && strpos($url, 'action=edit') === false;
	}
	
	private function is_edit_subscription_page($url) {
		// Check if the URL is for the edit subscription page
		return strpos($url, 'page=wc-orders--shop_subscription') !== false && strpos($url, 'action=edit') !== false && $this->is_subscription_cancel_or_pending_cancel();
	}
	
	private function is_subscription_cancel_or_pending_cancel() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Reading URL parameter for display logic, not processing form data
		if (!isset($_GET['id'])) return false;
	
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Reading URL parameter for display logic, not processing form data
		$post_id = intval(sanitize_text_field(wp_unslash($_GET['id'])));
		$subscription = wcs_get_subscription($post_id);
	
		if (!$subscription) return false;
	
		$status = $subscription->get_status();
	
		return in_array($status, ['cancelled', 'pending-cancel']);
	}

	/**
	 * Display review request notice
	 */
	public function display_review_notice() {
		// Don't show if the notice has been dismissed permanently or temporarily
		if (!PAnD::is_admin_notice_active('notice-caddy-review-forever') || !PAnD::is_admin_notice_active('notice-caddy-review-30')) {
			return;
		}
		
		// Don't show for recent installs (less than 14 days old)
		if ($this->is_recent_install(14)) {
			return;
		}

		// Don't show if upgrade notice is still active (prioritize upgrade first)
		if (!class_exists('Caddy_Premium') && PAnD::is_admin_notice_active('notice-caddy-upgrade-forever') && PAnD::is_admin_notice_active('notice-caddy-upgrade-30')) {
			return;
		}

		// Skip on specific admin pages
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Reading URL parameter to determine page context for display logic
		$page_name = isset($_GET['page']) ? sanitize_text_field(wp_unslash($_GET['page'])) : '';
		if ('caddy' == $page_name || 'caddy-addons' === $page_name) {
			return;
		}

		wp_enqueue_style('kt-admin-notice', plugin_dir_url(__DIR__) . 'admin/css/caddy-admin-notices.css', array(), CADDY_VERSION);

		// Get user info
		$current_user = wp_get_current_user();
		$first_name = $current_user->first_name;
		$username = $current_user->user_login;

		?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('.caddy-review-later').click(function(e) {
					e.preventDefault();
					$(this).closest('.notice').attr('data-dismissible', 'notice-caddy-review-30');
					$(this).closest('.notice').find('.notice-dismiss').trigger('click');
				});
				
				$('.caddy-review-button').click(function(e) {
					$(this).closest('.notice').attr('data-dismissible', 'notice-caddy-review-forever');
					$(this).closest('.notice').find('.notice-dismiss').trigger('click');
				});
			});
		</script>

		<div data-dismissible="notice-caddy-review-forever" class="notice is-dismissible caddy-notice review-notice">
			<div class="kt-right" style="padding:0;">
				<div class="welcome-heading">
					<?php 
					$display_name = !empty($first_name) ? $first_name : $username;
					printf(
						/* translators: %s: User's first name or username */
						esc_html__('A quick favor, %s?', 'caddy'),
						esc_html($display_name)
					);
					?>
				</div>
				<p class="review-message">
					<?php echo esc_html__('Hope Caddy\'s been helping you boost conversions and create a better cart experience! Quick favor — if it\'s been useful, would you mind leaving a short review on WordPress.org? Your feedback helps others discover Caddy and gives us fuel to keep improving it. Thanks so much for your support!', 'caddy'); ?>
				</p>
				<p class="caddy-notice-ctas">
					<a class="button caddy-review-button" href="<?php echo esc_url('https://wordpress.org/support/plugin/caddy/reviews/?filter=5#new-post'); ?>" target="_blank">
						<?php echo esc_html__('OK, you deserve it', 'caddy'); ?>
					</a>
					<a href="#" class="caddy-review-later">
						<?php echo esc_html__('Maybe later', 'caddy'); ?>
					</a>
					<a href="#" class="dismiss-this">
						<?php echo esc_html__('I already rated it', 'caddy'); ?>
					</a>
				</p>
			</div>
		</div>
		<?php
	}

	/**
	 * Get the limited-time offer content with countdown timer
	 * 
	 * @param string $coupon_code The coupon code to display
	 * @param string $discount_text The discount text to display
	 * @param string $container_class Additional class for the container (optional)
	 * @param string $unique_id Unique identifier for this countdown instance (optional)
	 * @return string HTML content for the limited-time offer
	 */
	public function get_limited_time_offer($coupon_code = '1E479230A6', $discount_text = '25% off Caddy Pro', $container_class = '', $unique_id = '') {
		// Don't show countdown offers for recent installs (less than 14 days old)
		if ($this->is_recent_install(14)) {
			return '';
		}

		// Generate a unique ID if not provided
		if (empty($unique_id)) {
			$unique_id = 'caddy-' . wp_rand(1000, 9999);
		} else {
			// Ensure unique_id is safe for use in HTML and JS
			$unique_id = preg_replace('/[^a-z0-9-_]/i', '', $unique_id);
		}
		
		// Create unique element IDs
		$countdown_id = 'caddy-countdown-' . $unique_id;
		$timer_id = 'caddy-countdown-time-' . $unique_id;
		
		// Use a SHARED storage key for ALL countdown timers
		$storage_key = 'caddy_global_promo_end_time';
		
		// Ensure the CSS is loaded
		wp_enqueue_style('kt-admin-notice', plugin_dir_url(__DIR__) . 'admin/css/caddy-admin-notices.css', array(), CADDY_VERSION);
		
		ob_start();
		?>
		<div class="caddy-limited-offer <?php echo esc_attr($container_class); ?>" id="<?php echo esc_attr($countdown_id); ?>-container">
			<div class="caddy-offer-content">
				<div class="caddy-offer-text">
					<?php echo esc_html__('Use code', 'caddy'); ?> <code><?php echo esc_html($coupon_code); ?></code> 
					<?php echo esc_html__( 'within the next', 'caddy' ); ?>
					<div class="caddy-countdown" id="<?php echo esc_attr($countdown_id); ?>">
						<div class="caddy-countdown-timer">
							<div class="caddy-countdown-item">
								<span class="caddy-countdown-number" id="<?php echo esc_attr($timer_id); ?>">48:00:00</span>
								<span class="caddy-countdown-label"><?php echo esc_html__('hours', 'caddy'); ?></span>
							</div>
						</div>
					</div>
					<?php echo esc_html__( 'to take ', 'caddy' ); ?>
					<strong><?php echo esc_html( $discount_text ); ?></strong>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				(function() {
					// Elements
					var timerElement = document.getElementById("<?php echo esc_js($timer_id); ?>");
					var containerElement = document.getElementById("<?php echo esc_js($countdown_id); ?>-container");
					
					if (!timerElement || !containerElement) return;
					
					// Shared storage key for ALL countdown timers
					var storageKey = "<?php echo esc_js($storage_key); ?>";
					
					// Set default end time (48 hours from now)
					var defaultEndTime = new Date().getTime() + (48 * 60 * 60 * 1000);
					var endTime;
					
					// Try to get stored end time
					try {
						var storedEndTime = localStorage.getItem(storageKey);
						
						if (storedEndTime) {
							// Check if the stored end time is valid
							endTime = parseInt(storedEndTime);
							
							// If the end time is in the past, reset it
							if (endTime < new Date().getTime()) {
								endTime = defaultEndTime;
								localStorage.setItem(storageKey, endTime);
							}
						} else {
							// No stored end time, set default
							endTime = defaultEndTime;
							localStorage.setItem(storageKey, endTime);
						}
					} catch (e) {
						// If localStorage fails, use default
						endTime = defaultEndTime;
					}
					
					// Function to update the display
					function updateCountdown() {
						var now = new Date().getTime();
						var distance = endTime - now;
						
						// If countdown expired
						if (distance < 0) {
							clearInterval(countdownInterval);
							containerElement.style.display = 'none';
							return;
						}
						
						// Calculate hours, minutes, seconds
						var totalSeconds = Math.floor(distance / 1000);
						var hours = Math.floor(totalSeconds / 3600);
						var minutes = Math.floor((totalSeconds % 3600) / 60);
						var seconds = totalSeconds % 60;
						
						// Format with leading zeros
						var formattedHours = (hours < 10 ? "0" : "") + hours;
						var formattedMinutes = (minutes < 10 ? "0" : "") + minutes;
						var formattedSeconds = (seconds < 10 ? "0" : "") + seconds;
						
						// Update display
						timerElement.innerHTML = formattedHours + ":" + formattedMinutes + ":" + formattedSeconds;
					}
					
					// Initial update
					updateCountdown();
					
					// Update the countdown every second
					var countdownInterval = setInterval(updateCountdown, 1000);
				})();
			});
		</script>
		<?php
		return ob_get_clean();
	}

	/**
	 * Display upgrade notice
	 */
	public function display_upgrade_notice() {
		// Don't show if the notice has been dismissed permanently or temporarily
		if (!PAnD::is_admin_notice_active('notice-caddy-upgrade-forever') || !PAnD::is_admin_notice_active('notice-caddy-upgrade-30')) {
			return;
		}

		// Don't show for recent installs (less than 14 days old)
		if ($this->is_recent_install(14)) {
			return;
		}

		// Check if Caddy Premium is not active
		if (class_exists('Caddy_Premium')) {
			return;
		}

		// Only show after newsletter opt-in is dismissed (newsletter has priority)
		if (PAnD::is_admin_notice_active('notice-caddy-optin-forever') && PAnD::is_admin_notice_active('notice-caddy-optin-30')) {
			return;
		}

		// Only show on Caddy settings and add-ons pages
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Reading URL parameter to determine page context for display logic
		$page_name = isset($_GET['page']) ? sanitize_text_field(wp_unslash($_GET['page'])) : '';
		if ('caddy' !== $page_name && 'caddy-addons' !== $page_name) {
			return;
		}

		wp_enqueue_style('kt-admin-notice', plugin_dir_url(__DIR__) . 'admin/css/caddy-admin-notices.css', array(), CADDY_VERSION);

		// Get user info
		$current_user = wp_get_current_user();
		$first_name = $current_user->first_name;
		$username = $current_user->user_login;

		?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('.caddy-upgrade-later').click(function(e) {
					e.preventDefault();
					$(this).closest('.notice').attr('data-dismissible', 'notice-caddy-upgrade-30');
					$(this).closest('.notice').find('.notice-dismiss').trigger('click');
				});
				
				$('.caddy-upgrade-button').click(function(e) {
					$(this).closest('.notice').attr('data-dismissible', 'notice-caddy-upgrade-forever');
					$(this).closest('.notice').find('.notice-dismiss').trigger('click');
				});
			});
		</script>
		
		<div data-dismissible="notice-caddy-upgrade-forever" class="notice is-dismissible caddy-notice upgrade-notice">
			<div class="kt-left">
				<img src="<?php echo esc_url( plugin_dir_url(__DIR__) . 'admin/img/caddy-mascot.svg' ); ?>" width="145" height="145" alt="Caddy Mascot">
			</div>
			<div class="kt-right">
				<div class="welcome-heading">
					<?php 
					$display_name = !empty($first_name) ? $first_name : $username;
					printf(
						/* translators: %s: User's first name or username */
						esc_html__('You\'re one step away from unlocking higher cart conversions, %s!', 'caddy'),
						esc_html($display_name)
					);
					?>
				</div>
				<p class="upgrade-message">
					<?php echo esc_html__('Take your cart experience and your revenue to the next level with Caddy Pro. Upgrade to access:', 'caddy'); ?>
				</p>
				<ul class="upgrade-features">
					<li>⚡️ <?php echo esc_html__('Advanced Cart Upsell Workflows', 'caddy'); ?></li>
					<li>📊 <?php echo esc_html__('Conversion & Cart Analytics', 'caddy'); ?></li>
					<li>🎁 <?php echo esc_html__('Mult-tier Cart Rewards', 'caddy'); ?></li>
					<li>💎 <?php echo esc_html__('Full design control & much more', 'caddy'); ?></li>
				</ul>
				
				<?php 
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Method returns already escaped HTML
			echo $this->get_limited_time_offer(); 
			?>

				<p class="caddy-notice-ctas">
					<a class="button caddy-upgrade-button" href="<?php echo esc_url('https://usecaddy.com/pricing/?utm_source=caddy-plugin&utm_medium=plugin&utm_campaign=upgrade-notice'); ?>" target="_blank">
						<?php echo esc_html__('Upgrade Now', 'caddy'); ?>
					</a>
					<a href="#" class="caddy-upgrade-later">
						<?php echo esc_html__('Maybe later', 'caddy'); ?>
					</a>
					<a href="#" class="dismiss-this">
						<?php echo esc_html__('I\'ve already upgraded', 'caddy'); ?>
					</a>
				</p>
			</div>
		</div>
		<?php
	}

	/**
	 * Display opt-in notice
	 */
	public function display_optin_notice() {
		// Don't show if the notice has been dismissed permanently or temporarily
		if (!PAnD::is_admin_notice_active('notice-caddy-optin-forever') || !PAnD::is_admin_notice_active('notice-caddy-optin-30')) {
			return;
		}

		// Show immediately for all installs (no delay)

		// Check if Caddy Premium is not active
		if (class_exists('Caddy_Premium')) {
			return;
		}

		
		// Only show on specific admin pages
		$screen = get_current_screen();
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Reading URL parameter to determine page context for display logic
		$page_name = isset($_GET['page']) ? sanitize_text_field(wp_unslash($_GET['page'])) : '';
		if ( 'caddy' != $page_name && 'caddy-addons' !== $page_name ) {
			return;
		}

		wp_enqueue_style('kt-admin-notice', plugin_dir_url(__DIR__) . 'admin/css/caddy-admin-notices.css', array(), CADDY_VERSION);

		// Get user info
		$current_user = wp_get_current_user();
		$first_name = $current_user->first_name;
		$username = $current_user->user_login;

		?>
		<div data-dismissible="notice-caddy-optin-forever" class="notice is-dismissible caddy-notice caddy-optin-notice">
			<div class="kt-left">
				<img src="<?php echo esc_url( plugin_dir_url(__DIR__) . 'admin/img/airplane.svg' ); ?>" width="145" height="145" alt="Join our VIP email list">
			</div>
			<div class="kt-right">
				<div class="welcome-heading">
					<?php echo esc_html( __( 'Join the Caddy VIP list and get a special offer', 'caddy' ) ); ?>
				</div>
				<p>
					<?php echo esc_html( __( 'Join our list for exclusive offers, proven ways to increase cart conversions, and practical tactics to grow your store\'s sales. No fluff. Just actionable insights — and you can unsubscribe anytime.', 'caddy' ) ); ?>
				</p>
				<form id="caddy-email-signup" class="cc-klaviyo-default-styling" action="//manage.kmail-lists.com/subscriptions/subscribe"
				      data-ajax-submit="//manage.kmail-lists.com/ajax/subscriptions/subscribe" method="GET" target="_blank" validate="validate">
					<input type="hidden" name="g" value="YctmsM">
					<input type="hidden" name="$fields" value="$consent">
					<input type="hidden" name="$list_fields" value="$consent">
					<div class="cc-klaviyo-field-group">
						<input class="" type="text" value="" name="first_name" id="k_id_first_name" placeholder="Your First Name">
						<input class="" type="email" value="" name="email" id="k_id_email" placeholder="Your email" required>
						<div class="cc-klaviyo-field-group cc-klaviyo-form-actions cc-klaviyo-opt-in">
							<input type="checkbox" name="$consent" id="cc-consent-email" value="email" required>
							<label for="cc-consent-email">
								<?php
								echo sprintf(
									'%1$s <a href="%2$s" target="_blank">%3$s</a> %4$s <a href="%5$s" target="_blank">%6$s</a>.',
									esc_html__( 'By joining our VIP email list, you agree to receive marketing communications from us and agree to our ', 'caddy' ),
									esc_url( 'https://www.usecaddy.com/terms-and-conditions/' ),
									esc_html__( 'Terms', 'caddy' ),
									esc_html__( ' &amp; ', 'caddy' ),
									esc_url( 'https://www.usecaddy.com/privacy-policy/' ),
									esc_html__( 'Privacy Policy', 'caddy' )
								);
								?>
							</label>
						</div>
					</div>
					<div class="cc-klaviyo-messages">
						<div class="success_message" style="display:none;"></div>
						<div class="error_message" style="display:none;"></div>
					</div>
					<div class="cc-klaviyo-form-actions">
						<button type="submit" class="cc-klaviyo-submit-button button button-primary"><?php echo esc_html( __( 'Claim my special offer', 'caddy' ) ); ?></button>
					</div>
				</form>
				<?php
				// Enqueue Klaviyo script properly
				wp_enqueue_script('klaviyo-subscribe', '//www.klaviyo.com/media/js/public/klaviyo_subscribe.js', array(), CADDY_VERSION, true);
				
				// Add inline script for Klaviyo initialization
				$klaviyo_init_script = "
					KlaviyoSubscribe.attachToForms( '#caddy-email-signup', {
						hide_form_on_success: true,
						success_message: 'Thank you for signing up! Your special offer is on its way!',
						extra_properties: {
							\$source: 'CaddyPluginSignup',
							Website: '" . esc_url( get_site_url() ) . "',
						}
					} );
				";
				wp_add_inline_script('klaviyo-subscribe', $klaviyo_init_script);
				?>
			</div>
		</div>
		<?php
	}

}

/**
 * Global helper function to display the limited time offer
 *
 * @param string $coupon_code The coupon code to display
 * @param string $discount_text The discount text to display
 * @param string $container_class Additional class for the container (optional)
 * @param string $unique_id Unique identifier for this countdown instance (optional)
 * @return string HTML content for the limited-time offer
 */
function caddy_get_limited_time_offer($coupon_code = '1E479230A6', $discount_text = '25% off Caddy Pro', $container_class = '', $unique_id = '') {
	static $notices_instance = null;
	
	if ($notices_instance === null) {
		$notices_instance = new Caddy_Admin_Notices();
	}
	
	return $notices_instance->get_limited_time_offer($coupon_code, $discount_text, $container_class, $unique_id);
}