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

if ( ! class_exists( 'Tpaep_Dashboard_Ajax' ) ) {

	/**
	 * Tpaep_Dashboard_Ajax
	 *
	 * @since 1.0.0
	 */
	class Tpaep_Dashboard_Ajax {

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
		 * @since    1.0.0
		 */
		public function __construct() {
			add_filter( 'tpaep_dashboard_ajax_call', array( $this, 'tpaep_dashboard_ajax_call' ), 10 );
		}

		/**
		 * Load the required dependencies for this plugin.
		 *
		 * @since    1.0.0
		 */
		public function tpaep_dashboard_ajax_call( $p_type ) {

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
				case 'tpaep_set_whitelabel':
					$response = $this->tpaep_set_whitelabel();
					break;
				case 'tpaep_woo_thankyou_options':
					$response = $this->tpaep_woo_thankyou_options();
					break;
			}

			return $response;
		}

		/**
		 * White label active code
		 *
		 * @since 1.0.0
		 */
		public function tpaep_set_whitelabel() {
			$option_name = 'theplus_white_label';

			$whitelable_data = json_decode( stripslashes( sanitize_text_field( wp_unslash( $_POST['whitelable_data'] ) ) ), true );

			if ( false == $whitelable_data ) {
				add_option( $option_name, $whitelable_data, '', 'on' );
			} else {
				update_option( $option_name, $whitelable_data );
			}

			return $this->tpaep_set_response( true, 'White Label.', 'White Label Set Successfully.' );
		}

		/**
		 * Thank You page list
		 *
		 * @since 1.0.0
		 */
		public function tpaep_woo_thankyou_options() {
            $output                 = array();
            $args                   = array();
            $args['post_type']      = array( 'page' );
            $args['posts_per_page'] = -1;
            $output[''] = 'Select Template';

            $query = get_posts( $args );

            if ( $query ) {
                foreach ( $query as $post ) {
                    if ( $post->ID ){
                        $output[ $post->ID ] = !empty($post->post_title) ? $post->post_title : '';
                    }
                }
            }

            return $output;
        }

		/**
		 * Set Response
		 *
		 * @since 1.0.0
		 */
		public function tpaep_set_response( $success = false, $message = '', $description = '', $data = array() ) {

			$response = array(
				'success'     => $success,
				'message'     => esc_html( $message, 'theplus' ),
				'description' => esc_html( $description, 'theplus' ),
				'data'        => $data,
			);

			return $response;
		}
	}

	Tpaep_Dashboard_Ajax::get_instance();
}
