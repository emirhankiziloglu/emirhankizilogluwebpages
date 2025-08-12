<?php
/**
 * The file that defines the core plugin class
 *
 * @link       https://posimyth.com/
 * @since      5.6.7
 *
 * @package    ThePlus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Tpaep_Create_Template' ) ) {

	/**
	 * Tpaep_Create_Template
	 *
	 * @since 5.6.7
	 */
	class Tpaep_Create_Template {

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
		 * @since 5.6.7
		 */
		public function __construct() {
			$this->tp_check_elements();
		}

		/**
		 * Check elements
		 *
		 * @since 5.6.7
		 */
		public function tp_check_elements() {
			add_action( 'wp_ajax_theplus_template_create', array( $this, 'theplus_template_create' ) );
			add_action( 'wp_ajax_nopriv_theplus_template_create', array( $this, 'theplus_template_create' ) );

			add_action( 'wp_ajax_change_current_template_title', array( $this, 'change_current_template_title' ) );
			add_action( 'wp_ajax_nopriv_change_current_template_title', array( $this, 'change_current_template_title' ) );
		}

		/**
		 * Template Create
		 *
		 * @since 5.6.7
		 */
		public function theplus_template_create() {

			/** Security checked wp nonce*/
			$nonce = ! empty( $_POST['security'] ) ? sanitize_text_field( wp_unslash( $_POST['security'] ) ) : '';
			if ( ! isset( $nonce ) || empty( $nonce ) || ! wp_verify_nonce( $nonce, 'live_editor' ) ) {
				die( 'Security checked!' );
			}

			/** Security checked user login*/
			if ( ! is_user_logged_in() ) {
				wp_send_json_error( array( 'content' => __( 'Insufficient permissions.', 'theplus' ) ) );
			}

			$uniq       = uniqid();
			$rand_num   = wp_rand( 1, 1000 );
			$post_name  = 'tp-create-template-' . sanitize_text_field( wp_unslash( $uniq ) );
			$post_title = '';

			$args = array(
				'post_type'              => 'elementor_library',
				'post_status'            => 'publish',
				'name'                   => $post_name,
				'posts_per_page'         => 1,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
			);
			$post = get_posts( $args );

			if ( empty( $post ) ) {
				$post_title = 'TP Template ' . $rand_num;

				$params = array(
					'post_content' => '',
					'post_type'    => 'elementor_library',
					'post_title'   => $post_title,
					'post_name'    => $post_name,
					'post_status'  => 'publish',
					'meta_input'   => array(
						'_elementor_edit_mode'     => 'builder',
						'_elementor_template_type' => 'page',
						'_wp_page_template'        => 'elementor_canvas',
					),
				);

				$post_id = wp_insert_post( $params );

			}

			$temp_url = get_admin_url() . '/post.php?post=' . $post_id . '&action=elementor';

			$result = array(
				'url'   => $temp_url,
				'id'    => $post_id,
				'title' => $post_title,
			);

			wp_send_json_success( $result );
		}

		/**
		 * Change Template name
		 *
		 * @since 5.6.7
		 */
		public function change_current_template_title() {

			/** Security checked wp nonce*/
			$nonce = ! empty( $_POST['security'] ) ? sanitize_text_field( wp_unslash( $_POST['security'] ) ) : '';
			if ( ! isset( $nonce ) || empty( $nonce ) || ! wp_verify_nonce( $nonce, 'live_editor' ) ) {
				die( 'Security checked!' );
			}

			/** Security checked user login*/
			if ( ! is_user_logged_in() ) {
				wp_send_json_error( array( 'content' => __( 'Insufficient permissions.', 'theplus' ) ) );
			}

			$id = ! empty( $_POST['id'] ) ? sanitize_text_field( wp_unslash( $_POST['id'] ) ) : '';

			$updated_title = ! empty( $_POST['updated_title'] ) ? sanitize_text_field( wp_unslash( $_POST['updated_title'] ) ) : '';

			$res = wp_update_post(
				array(
					'ID'         => $id,
					'post_title' => $updated_title,
				)
			);

			$dev = array(
				'ID'         => $id,
				'post_title' => $updated_title,
			);

			wp_send_json_success( $dev );
		}
	}

	return Tpaep_Create_Template::get_instance();
}