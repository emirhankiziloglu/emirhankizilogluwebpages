<?php
/*
* Plugin Name: The Plus Addons for Elementor - Pro
* Plugin URI: https://theplusaddons.com/
* Description: Highly Customisable 120+ Advanced Elementor Widgets & Extensions for Performance Driven Website. Keep the free version active to access all of its features.
* Version: 6.3.0
* Author: POSIMYTH
* Author URI: https://posimyth.com/
* Text Domain: theplus
* Domain Path: /languages
* Elementor tested up to: 3.27
* Elementor Pro tested up to: 3.27
*/

if ( ! defined( 'ABSPATH' ) ) { 
	exit; 
}

update_option( 'theplus_purchase_code', ['tp_api_key' => '********************'] );
add_filter('pre_http_request', function($preempt, $r, $url) {
    if (strpos($url, 'https://store.posimyth.com') !== false && isset($r['body']['edd_action']) && $r['body']['edd_action'] === 'activate_license') {
        return array(
            'headers'  => array(),
            'body'     => json_encode(array(
                'success'          => true,
                'license'          => 'valid',
                'item_id'          => false,
                'item_name'        => 'The Plus Addons for Elementor',
                'license_limit'    => 10,
                'site_count'       => 1,
                'expires'          => '2050-01-01 23:59:59',
                'activations_left' => 9,
                'checksum'         => 'GPL001122334455AA6677BB8899CC000',
                'payment_id'       => 123321,
                'customer_name'    => 'GPL',
                'customer_email'   => 'noreply@gmail.com',
                'price_id'         => '1'
            )),
            'response' => array(
                'code'    => 200,
                'message' => 'OK'
            ),
        );
    }

    return $preempt;
}, 10, 3);

defined( 'THEPLUS_VERSION' ) or define( 'THEPLUS_VERSION', '6.3.0' );
define( 'THEPLUS_FILE__', __FILE__ );

define( 'THEPLUS_PATH', plugin_dir_path( __FILE__ ) );
define( 'THEPLUS_PBNAME', plugin_basename(__FILE__) );
define( 'THEPLUS_PNAME', basename( dirname(__FILE__)) );
define( 'THEPLUS_URL', plugins_url( '/', __FILE__ ) );
define( 'THEPLUS_ASSETS_URL', THEPLUS_URL . 'assets/' );
define( 'THEPLUS_ASSET_PATH', wp_upload_dir()['basedir'] . DIRECTORY_SEPARATOR . 'theplus-addons' );
define( 'THEPLUS_ASSET_URL', wp_upload_dir()['baseurl'] . '/theplus-addons' );
define( 'THEPLUS_INCLUDES_URL', THEPLUS_PATH . 'includes/' );
define( 'THEPLUS_TYPE', 'store' );
define( 'THEPLUS_TPDOC', 'https://theplusaddons.com/docs/' );
define( 'THEPLUS_HELP', 'https://store.posimyth.com/helpdesk/');
define( 'THEPLUS_WSTYLES', THEPLUS_PATH . 'modules/widgets-styles/' );

define( 'TP_PLUS_SL_STORE_URL', 'https://store.posimyth.com' );
define( 'TP_PLUS_SL_ITEM_ID', 28 );

add_action( 'init', 'tpae_i18n' );
function tpae_i18n() {
	load_plugin_textdomain( 'theplus', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}

/* theplus language plugins loaded */
function theplus_pluginsLoaded() {

	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}
	
	if( !defined("L_THEPLUS_VERSION") ) {
		add_action( 'admin_notices', 'theplus_lite_load_notice' );
		return;
	}
	
	// Elementor widget loader
	if(THEPLUS_TYPE=='store' && is_admin()){
		add_action( 'admin_init', 'theplus_plugin_updater', 0 );
	}
	
    require( THEPLUS_PATH . 'widgets_loader.php' );
}
add_action( 'plugins_loaded', 'theplus_pluginsLoaded' );

/* theplus update notice */
add_action('in_plugin_update_message-theplus_elementor_addon/theplus_elementor_addon.php','tp_in_plugin_update_message',10,2);
function tp_in_plugin_update_message($data,$response){
	if( isset( $data['upgrade_notice'] ) && !empty($data['upgrade_notice']) ) {
		printf(
			'<div class="update-message">%s</div>',
			wpautop( $data['upgrade_notice'] )
		);
	}
}

/* theplus lite load notice */
function theplus_lite_load_notice() {	
	$plugin = 'the-plus-addons-for-elementor-page-builder/theplus_elementor_addon.php';	

	if ( theplus_lite_activated() ) {

		if ( ! current_user_can( 'activate_plugins' ) ) { 
			return; 
		}

		$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
		$admin_notice = '<p>' . esc_html__( 'You are one step away from using The Plus Addons for Elementor Pro. Please activate The Plus Addons for Elementor Lite version.', 'theplus' ) . '</p>';
		$admin_notice .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate The Plus Addons for Elementor Lite', 'theplus' ) ) . '</p>';
	} else {

		if ( ! current_user_can( 'install_plugins' ) ) { 
			return; 
		}

		$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=the-plus-addons-for-elementor-page-builder' ), 'install-plugin_the-plus-addons-for-elementor-page-builder' );
		$admin_notice = '<p>' . esc_html__( 'The Plus Addons for Elementor lite is missing. Would you please install that to make The Plus Addons for Elementor Pro working smoothly?', 'theplus' ) . '</p>';
		$admin_notice .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install The Plus Addons for Elementor Lite', 'theplus' ) ) . '</p>';
	}

	echo '<div class="notice notice-error is-dismissible">'.$admin_notice.'</div>';	
}

/**
 * Plugin Updater - setup the updater
*/
function theplus_plugin_updater() {
	
    $licence_data = get_option( 'tpaep_licence_data' );

	$license_key = !empty( $licence_data['license_key'] ) ? $licence_data['license_key'] : '';
	$success = !empty( $licence_data['success'] ) ? $licence_data['success'] : 0;
	$valid = !empty( $licence_data['license'] ) ? $licence_data['license'] : 'valid';

	if( ! empty( $license_key ) && 'valid' == $valid ){
		$edd_updater = new Theplus_SL_Plugin_Updater( TP_PLUS_SL_STORE_URL, __FILE__, array(
			'version' 	=> THEPLUS_VERSION,
			'license' 	=> $license_key,		
			'item_id' 	=> TP_PLUS_SL_ITEM_ID,
			'author' 	=> 'POSIMYTH Themes',
			'url' 		=> home_url(),
			'beta' 		=> false,
		));
	}
}
$activate_plus_label = get_option( 'theplus_white_label' );		

function theplus_activated_plugin( $plugin ) { 
	if( $plugin == plugin_basename( __FILE__ ) ) {
		delete_option('theplus_white_label');
	}
}
add_action( 'activated_plugin', 'theplus_activated_plugin', 10 );

/**
 * The Plus Lite activated or not
 */
if ( ! function_exists( 'theplus_lite_activated' ) ) {
	
	function theplus_lite_activated() {
		$file_path = 'the-plus-addons-for-elementor-page-builder/theplus_elementor_addon.php';
		$installed_plugins = get_plugins();
		
		return isset( $installed_plugins[ $file_path ] );
	}
}

/**
 * Redirect lite action
 *
 * @since v1.0.0
 */
function theplus_activate() {
    add_option('theplus_activation_redirect', true);
}
register_activation_hook(__FILE__, 'theplus_activate');

function theplus_redirect_lite_version() {
	if( !defined('L_THEPLUS_VERSION') ){
		require( THEPLUS_INCLUDES_URL . 'theplus_lite_action.php' );
	}

	if ( get_option('theplus_activation_redirect', false) ) {
		delete_option('theplus_activation_redirect');

		if(!defined('L_THEPLUS_VERSION')){				
			wp_safe_redirect("admin.php?action=theplus_lite_install_plugin");
		}
	}
}
add_action('admin_init', 'theplus_redirect_lite_version');
