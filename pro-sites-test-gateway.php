<?php

/**
 * Plugin Name:       Pro Sites - Test Gateway
 * Plugin URI:        http://premium.wpmudev.org/projects/pro-sites/
 * Description:       Sample custom gateway implementation for Pro Sites.
 * Version:           1.0.0
 * Author:            Joel James (WPMU DEV)
 * Author URI:        https://premium.wpmudev.org/
 * License:           GPLv2
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// Register required hooks.
add_action( 'psts_load_gateways', 'test_gateway_register' );
add_filter( 'prosites_gateways_tabs', 'test_gateway_add_tab' );
add_filter( 'prosites_settings_tabs_render_callback', 'test_gateway_callback', 99, 2 );

/**
 * Load custom gateway class file.
 *
 * This class should handle payment and renewals.
 *
 * @return void
 */
function test_gateway_register() {

	require_once 'class-pro-sites-test-gateway.php';
}

/**
 * Add custom gateway to gateways tab.
 *
 * @param array $tabs Gateway tabs.
 *
 * @return array
 */
function test_gateway_add_tab( $tabs ) {

	// Add to existing tabs.
	$tabs['test'] = array(
		'header_save_button' => true,
		'button_name'        => 'gateways',
		'title'              => __( 'Test', 'psts' ), // Title of your gateway.
		'desc'               => array(
			__( 'Test gateway', 'psts' ), // Short description of your gateway.
		),
		'url'                => add_query_arg( 'tab', 'test' ), // Gateway settings page url.
	);

	return $tabs;
}

/**
 * Register test gateway settings page callback.
 *
 * @param mixed $callback Callback function.
 * @param string $active_tab Current active tab.
 *
 * @return string
 */
function test_gateway_callback( $callback, $active_tab ) {

	// Return our callback if current page is our custom gateway.
	if ( 'test' === $active_tab ) {
		return 'test_gateway_render_settings';
	}

	return $callback;
}

/**
 * Render custom gateway tab content.
 *
 * This function contains your test gateway settings.
 * You can make use of $psts global variable to get/set
 * your settings value.
 *
 * @return void
 */
function test_gateway_render_settings() {

	global $psts;

	// Get settings page header.
	ProSites_Helper_Settings::settings_header( ProSites_Helper_Tabs_Gateways::get_active_tab() );
	// Currently enabled gateways.
	$active_gateways = (array) $psts->get_setting( 'gateways_enabled' );
	// If our gateway is enabled.
	$checked         = in_array( 'Pro_Sites_Test_Gateway', $active_gateways ) ? 'on' : 'off';

	// I have demonstrated how you can add setting fields.
	?>
	<!-- Mandotory settings -->
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e( 'Enable Gateway', 'psts' ) ?></th>
			<td>
				<input type="hidden" name="gateway" value="Pro_Sites_Test_Gateway"/>
				<input type="checkbox" name="gateway_active" value="1" <?php checked( $checked, 'on' ); ?> />
			</td>
		</tr>
	</table>
	<!-- Here you can add your custom setting fields -->
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><?php _e( 'Gateway Mode', 'psts' ) ?></th>
			<td><select name="psts[test_status]" class="chosen">
					<option value="live"<?php selected( $psts->get_setting( 'test_status' ), 'live' ); ?>><?php _e( 'Live Site', 'psts' ) ?></option>
					<option value="test"<?php selected( $psts->get_setting( 'test_status' ), 'test' ); ?>><?php _e( 'Test Mode (Sandbox)', 'psts' ) ?></option>
				</select>
			</td>
		</tr>
	</table>
	<?php
}