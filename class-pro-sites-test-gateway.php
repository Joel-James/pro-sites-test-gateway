<?php

/**
 * Class Pro_Sites_Test_Gateway
 *
 * A class definition that handles everything related to your custom gateway.
 *
 * @author     Joel James (WPMU DEV)
 * @license    http://www.gnu.org/licenses/ GNU General Public License
 */
class Pro_Sites_Test_Gateway {

	/**
	 * Pro_Sites_Test_Gateway constructor.
	 */
	public function __construct() {

		// Cancel site subscription in gateway when a site is deleted.
		add_action( 'delete_blog', array( 'Pro_Sites_Test_Gateway', 'cancel_subscription' ) );

		// Handle renewal notifications from your gateway webhook.
		add_action( 'wp_ajax_nopriv_psts_test_webhook', array( 'Pro_Sites_Test_Gateway', 'webhook_handler' ) );
		add_action( 'wp_ajax_psts_test_webhook', array( 'Pro_Sites_Test_Gateway', 'webhook_handler' ) );
	}

	/**
	 * Display the our test gateway payment form.
	 *
	 * This function should handle the front end payment
	 * form.
	 * This method is required and should be static.
	 *
	 * @param array  $render_data Render data.
	 * @param array  $args Form agruments.
	 * @param int    $blog_id Site ID.
	 * @param string $domain Site domain.
	 *
	 * @return string|void
	 */
	public static function render_gateway( $render_data = array(), $args, $blog_id, $domain ) {

		return 'Your gateway payment form here. Refer other gateways for example.';
	}

	/**
	 * Process the checkout form submit.
	 *
	 * When a payment form is submitted handle that here.
	 * You should do all your gateway process here.
	 * Refer Stripe or PayPal gateways for example.
	 * This method is required and should be static.
	 *
	 * @param array  $process_data Processed data.
	 * @param int    $blog_id Site ID.
	 * @param string $domain Site domain.
	 *
	 * @return void
	 */
	public static function process_checkout_form( $process_data = array(), $blog_id, $domain ) {

		// Handle your gateway payement here.
	}

	/**
	 * Return gateway unique name.
	 *
	 * This method is required and should be static.
	 *
	 * @return array
	 */
	public static function get_name() {

		return array(
			'test' => __( 'Test', 'psts' ),
		);
	}

	/**
	 * Handle renewals of subscriptions.
	 *
	 * Your gaeway should be able to handle renewals.
	 * If so, get the webhook notifications like PayPal or
	 * Stripe and extend the blog expiry dates.
	 *
	 * @return void
	 */
	public static function webhook_handler() {

		// Handle payment notifications from gateway.
	}

	/**
	 * Cancel site subscription in gateway when a site is deleted.
	 *
	 * @param int    $blog_id Deleted site id.
	 * @param string $display_message Message.
	 *
	 * @return void
	 */
	public static function cancel_subscription( $blog_id, $display_message = false ) {

		// Cancel subscription in gateway.
	}
}

psts_register_gateway( 'Pro_Sites_Test_Gateway', __( 'Test Gateway', 'psts' ), __( 'Sample implementation for a custom gateway.', 'psts' ) );