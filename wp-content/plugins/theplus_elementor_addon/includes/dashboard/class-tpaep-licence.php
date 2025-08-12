<?php
/**
 * The file store Database Default Entry
 *
 * @link       https://posimyth.com/
 * @since      5.6.7
 *
 * @package    the-plus-addons-for-elementor-page-builder
 */

/**Exit if accessed directly.*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Tpaep_Licence' ) ) {

	/**
	 * Tpaep_Licence
	 *
	 * @since 6.0.0
	 */
	class Tpaep_Licence {

		/**
		 * Licence Name
		 *
		 * @var licence_name
		 */
		private static $licence_name = 'tpaep_licence_data';

		/**
		 * Transient Name
		 *
		 * @var transient_licence_name
		 */
		private static $transient_licence_name = 'tpaep_licence_time_data';

		/**
		 * Store url
		 *
		 * @var store_url
		 */
		private static $store_url = 'https://store.posimyth.com';

		/**
		 * Transient Name
		 *
		 * @var license_key
		 */
		private $license_key = '';

		/**
		 * Product Name
		 *
		 * @var product_name
		 */
		private static $product_name = 'The Plus Addons for Elementor';

		/**
		 * Auto check expires licence add automatic
		 *
		 * @var expires_add
		 */
		private $expires_add = '';

		/**
		 * Member Variable
		 *
		 * @var instance
		 */
		private static $instance;

		/**
		 *  Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Define the core functionality of the plugin.
		 *
		 * @since 6.0.0
		 */
		public function __construct() {
			add_action( 'admin_init', array( $this, 'tpaep_old_license_check' ), 1 );
			// add_action( 'admin_init', array( $this, 'tpaep_check_expired_date_key' ), 1 );
			add_filter( 'tpaep_licence_ajax_call', array( $this, 'tpaep_licence_ajax_call' ), 10, 1 );
		}

		/**
		 * Old License Remove and Set New dataabash Entry.
		 *
		 * @since 6.0.0
		 */
		public function tpaep_old_license_check() {

			if( isset( $_GET['page'] ) && ! empty( $_GET['page'] ) && 'theplus_welcome_page' == $_GET['page'] ){
				$get_verified = get_option( 'theplus_verified' );
				$get_key      = get_option( 'theplus_purchase_code' );

				if ( ! empty( $get_key['tp_api_key'] ) ) {
					$this->license_key = $get_key['tp_api_key'];

					$this->tpaep_add_license();

					delete_option( 'theplus_verified' );
					delete_option( 'theplus_purchase_code' );
					delete_transient( 'theplus_verify_trans_api_store' );
				} 
			}
		}

		/**
		 * Admin Dashbord check Every reload licence
		 *
		 * @since 6.0.0
		 */
		public function tpaep_check_expired_date_key() {
			$today_date = strtotime( 'today midnight' );

			$get_licence = get_option( self::$licence_name );
			$expired     = ! empty( $get_licence['expires'] ) ? $get_licence['expires'] : '';
			$license_key = ! empty( $get_licence['license_key'] ) ? $get_licence['license_key'] : '';

			if ( 'lifetime' !== $expired && $today_date >= strtotime( $expired ) ) {
				$this->license_key = $license_key;
				
				if ( ! empty( $this->license_key ) ) {
					$transient_licence_name = get_transient( self::$transient_licence_name );
					if ( false === $transient_licence_name ) {
						$this->expires_add = 'check_license';
						$this->tpaep_add_license();
					}
				} else {
					self::tpaep_license_reset();
				}
			}
		}

		/**
		 * Check License Status.
		 *
		 * @since 6.0.0
		 */
		public function tpaep_get_license_status() {
			// if( 'lifetime' != $expired && $today_date >= $expired ){
			$get_data = get_option( self::$licence_name );

			$license_key = ! empty( $get_data['license_key'] ) ? $get_data['license_key'] : '';
			$checksum    = ! empty( $get_data['checksum'] ) ? $get_data['checksum'] : '';
			if ( ! empty( $license_key ) ) {
				$last_four = substr( $license_key, -4 );
				$final_key = str_repeat( '*', strlen( $license_key ) - 4 ) . $last_four;

				$get_data['license_key'] = $final_key;
			}

			return $get_data;
		}

		/**
		 * Add license In Databash
		 *
		 * @since 6.0.0
		 */
		public function tpaep_add_license() {
			$r_response = array();
			$tpaep_success = false;
			$tpaep_message = 'Error';
			$tpaep_description = 'Error';

			$home_url  = get_home_url();
			$item_name = urlencode( 'The Plus Addons for Elementor' );

			if ( empty( $this->license_key ) ) {
				return $this->tpaep_set_response( false, 'license key.', 'license key Not Found.', array() );
			}

			$api_params = array(
				'edd_action' => 'activate_license',
				'item_name' => self::$product_name,
				'url' => $home_url,
				'license' => $this->license_key,
			);

			$u_r_l = wp_remote_get( self::$store_url, array(
				'timeout'   => 30,
				'sslverify' => false,
				'body'	  	=> $api_params
			) );

			// $a_p_i = self::$store_url . '/?edd_action=activate_license&url=' . $home_url . '&item_name=' . self::$product_name . '&license=' . $this->license_key;
			// $u_r_l = wp_remote_get( $a_p_i );

			$get_status        = wp_remote_retrieve_response_code( $u_r_l );
			$get_retrieve_body = wp_remote_retrieve_body( $u_r_l );

			if ( 200 == $get_status ) {

				$r_response = json_decode( $get_retrieve_body, true );

				$success          = ! empty( $r_response['success'] ) ? $r_response['success'] : 0;
				$license          = ! empty( $r_response['license'] ) ? $r_response['license'] : 'invalid';
				$item_i_d         = ! empty( $r_response['item_id'] ) ? $r_response['item_id'] : '';
				$item_name        = ! empty( $r_response['item_name'] ) ? $r_response['item_name'] : '';
				$is_local         = ! empty( $r_response['is_local'] ) ? $r_response['is_local'] : '';
				$license_limit    = ! empty( $r_response['license_limit'] ) ? $r_response['license_limit'] : 0;
				$site_count       = ! empty( $r_response['site_count'] ) ? $r_response['site_count'] : 0;
				$expires          = ! empty( $r_response['expires'] ) ? $r_response['expires'] : '';
				$activations_left = ! empty( $r_response['activations_left'] ) ? $r_response['activations_left'] : '';
				$customer_name    = ! empty( $r_response['customer_name'] ) ? $r_response['customer_name'] : '';
				$customer_email   = ! empty( $r_response['customer_email'] ) ? $r_response['customer_email'] : '';
				$error   		  = ! empty( $r_response['error'] ) ? $r_response['error'] : '';

				if ( ! empty( $r_response ) ) {
					unset( $r_response['price_id'] );
					unset( $r_response['payment_id'] );
					unset( $r_response['checksum'] );
				}
				
				$get_messages = $this->tpaep_get_message( $license, $error );

				$tpaep_success = !empty( $get_messages['success'] ) ? $get_messages['success'] : false;
				$tpaep_message = !empty( $get_messages['message'] ) ? $get_messages['message'] : 'Error';
				$tpaep_description = !empty( $get_messages['description'] ) ? $get_messages['description'] : 'Error';

				if ( is_array( $r_response ) ) {
					$set_license_key = array( 'license_key' => $this->license_key );

					$set_tpaep_success = array( 'tpae_success' => $tpaep_success );
					$set_tpaep_message = array( 'tpae_message' => $tpaep_message );
					$set_description = array( 'tpae_description' => $tpaep_description );

					$r_response = array_merge( $r_response, $set_license_key, $set_tpaep_success, $set_tpaep_message, $set_description );
				}

				if( ( 'valid' === $license ) || ( 'invalid' === $license && ! empty( $this->expires_add ) && 'check_license' === $this->expires_add ) ){

					if ( get_option( self::$licence_name ) ) {
						update_option( self::$licence_name, $r_response );
					} else {
						add_option( self::$licence_name, $r_response, '', 'yes' );
					}

					$transient_licence_name = get_transient( self::$transient_licence_name );
					if ( false === $transient_licence_name ) {
						set_transient( self::$transient_licence_name, '1', 1296000 );
					}
				}

				return $this->tpaep_set_response( $tpaep_success, $tpaep_message, $tpaep_description, $r_response );
			}else{
				return $this->tpaep_set_response( $tpaep_success, $tpaep_message, "Status Code $get_status", [] );
			}

			return $this->tpaep_set_response( $tpaep_success, $tpaep_message, $tpaep_description, [] );
		}

		/**
		 * Licence Message Display.
		 *
		 * @since 6.0.0
		 */
		public function tpaep_get_message( $license = '', $error = '' ) {
			$status = false;
			$message = "Message Empty";
			$description = "Description Empty";

			if ( 'valid' === $license ) {
				$status = true;
				$message = "Successfully.";
				$description = "Successfully.";
			}else if( 'invalid' === $license ){
				
				$status = false;
				if( 'expired' === $error ){
					$message = "Expired.";
					$description = "Your license key expired.";
				}else if( 'missing' === $error ){
					$message = "Missing.";
					$description = "Invalid license.";
				}else if( 'no_activations_left' === $error ){
					$message = "No Activations Left.";
					$description = "Your license key has reached its activation limit.";
				}else if( 'site_inactive' === $error ){
					$message = "Site Inactive.";
					$description = "Your license is not active for this URL.";
				}else if( 'revoked' === $error ){
					$message = "Revoked.";
					$description = "Your license key has been disabled.";
				}else if( 'item_name_mismatch' === $error ){
					$message = "Item Name Mismatch.";
					$description = "This appears to be an invalid license key for {$item_name}.";
				}else if( 'invalid' === $error ){
					$message = "Invalid.";
					$description = "Your license is not active for this URL.";
				}else{
					$message = "Going to else.";
					$description = "Error message Not Found.";
				}
			}

			return $this->tpaep_set_response( $status, $message, $description, [] );
		}

		/**
		 * Set white label Logo for WordPress Menu
		 *
		 * @since 6.0.0
		 */
		public function tpaep_licence_ajax_call( $p_type ) {

			if ( ! check_ajax_referer( 'tpae-db-nonce', 'nonce', false ) ) {

				$response = $this->tpaep_set_response( false, 'Invalid nonce.', 'The security check failed. Please refresh the page and try again.' );

				wp_send_json( $response );
				wp_die();
			}

			if ( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) ) {
				$response = $this->tpaep_set_response( false, 'Invalid Permission.', 'Something went wrong.' );

				wp_send_json( $response );
				wp_die();
			}

			$type = isset( $_POST['type'] ) ? strtolower( sanitize_text_field( wp_unslash( $_POST['type'] ) ) ) : false;
			if ( ! $type ) {
				$response = $this->tpaep_set_response( false, 'Invalid type.', 'Something went wrong.' );

				wp_send_json( $response );
				wp_die();
			}

			switch ( $p_type ) {
				case 'tpaep_license_status':
					$response = $this->tpaep_get_license_status();
					break;
				case 'tpaep_license_manage':
					$response = $this->tpaep_license_manage();
					break;
			}

			return $response;
		}

		/**
		 * License active code.
		 *
		 * @since 6.0.0
		 */
		public function tpaep_license_manage() {

			$license_type = isset( $_POST['license_type'] ) ? sanitize_text_field( wp_unslash( $_POST['license_type'] ) ) : '';
			$license_key  = isset( $_POST['license_key'] ) ? sanitize_text_field( wp_unslash( $_POST['license_key'] ) ) : '';

			if ( empty( $license_type ) ) {
				return $this->tpaep_set_response( false, 'license_type issue.', 'license_type not found.', array() );
			}

			// if ( empty( $license_key ) ) {
			// 	return $this->tpaep_set_response( false, 'license key.', 'license key not found.', array() );
			// }

			if ( 'active' === $license_type ) {

				$this->license_key = $license_key;

				return $this->tpaep_add_license();

			} elseif ( 'deactive' === $license_type ) {

				$this->tpaep_remove_site();
				self::tpaep_license_reset();

				return $this->tpaep_set_response( true, 'license deactived.', 'license deactived Successfully.', array() );
			}
		}

		/**
		 * Revome site from the store when License deactive.
		 *
		 * @since 6.1.3
		 */
		public function tpaep_remove_site() {
			$licence_data =  get_option( self::$licence_name );
			$license_key = !empty( $licence_data['license_key'] ) ? $licence_data['license_key'] : '';

			if ( !empty( $licence_data ) && !empty( $license_key ) ) {

				$home_url  = get_home_url();

				$api_params = array(
					'edd_action' => 'deactivate_license',
					'item_name'  => self::$product_name,
					'url'        => $home_url,
					'license'    => $license_key,
				);
				
				$response = wp_remote_post( self::$store_url, array(
					'timeout'   => 30,
					'sslverify' => false,
					'body'      => $api_params
				) );
			}
		}

		/**
		 * Set white label Logo for WordPress Menu
		 *
		 * @since 6.0.0
		 */
		public static function tpaep_license_reset() {
			delete_option( self::$licence_name );
			delete_transient( self::$transient_licence_name );

			delete_option( 'theplus_verified' );
			delete_option( 'theplus_purchase_code' );
			delete_transient( 'theplus_verify_trans_api_store' );
		}

		/**
		 * Set the response data.
		 *
		 * @since 6.0.0
		 *
		 * @param bool   $success     Indicates whether the operation was successful. Default is false.
		 * @param string $message     The main message to include in the response. Default is an empty string.
		 * @param string $description A more detailed description of the message or error. Default is an empty string.
		 * @param mixed  $data        Optional additional data to include in the response. Default is an empty string.
		 */
		public function tpaep_set_response( $success = false, $message = '', $description = '', $data = array() ) {

			$response = array(
				'success'     => $success,
				'message'     => esc_html( $message ),
				'description' => esc_html( $description ),
				'data'        => $data,
			);

			return $response;
		}
	}

	Tpaep_Licence::get_instance();
}
