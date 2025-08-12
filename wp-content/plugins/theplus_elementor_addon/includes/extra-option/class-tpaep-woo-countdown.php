<?php
/**
 * Widget Name: Countdown
 * Description: Display countdown.
 * Author: Theplus
 * Author URI: https://posimyth.com
 *
 * @package ThePlus
 */

/**Exit if accessed directly.*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Tpaep_Woo_Countdown' ) ) {

	/**
	 * Tpaep_Woo_Countdown
	 *
	 * @since 6.0.0
	 */
	class Tpaep_Woo_Countdown {

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
			add_action( 'add_meta_boxes', array( $this, 'tpaep_woo_countdown_meta_box' ) );
			add_action( 'save_post', array( $this, 'tpaep_woo_countdown_meta_data' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_woo_countdown_styles' ) );
		}

		/**
		 * Load CSS file.
		 *
		 * @since 6.1.0
		 */
		public function enqueue_woo_countdown_styles( $slug ) {
			if( 'post.php' === $slug ){
				wp_enqueue_style( 'tpaep-woo-countdown-admin', THEPLUS_URL . 'includes/extra-option/css/tpaep-woo-countdown.css', array(), THEPLUS_VERSION, false );
			}
		}

		/**
		 * Function call for the countdown field.
		 *
		 * @since 6.0.0
		 */
		public function tpaep_woo_countdown_meta_box() {
			add_meta_box(
				'woocommerce_countdown',
				esc_html__( 'WooCommerce Countdown', 'theplus' ),
				array( $this, 'woocommerce_countdown_callback' ),
				'product',
				'normal',
				'high'
			);
		}

		/**
		 * Form for the Countdown field.
		 *
		 * @since 6.0.0
		 */
		public function woocommerce_countdown_callback( $post ) {
			wp_nonce_field( 'save_woocommerce_countdown_data', 'woocommerce_countdown_meta_box_nonce' );

			$normal_countdown_date      = get_post_meta( $post->ID, 'tpc_proc_ndate', true );
			$scarcity_countdown_minutes = get_post_meta( $post->ID, 'tpc_proc_ns_days', true );

			$initial_fake_number = get_post_meta( $post->ID, 'tpc_proc_fn_ini_num', true );
			$final_fake_number   = get_post_meta( $post->ID, 'tpc_proc_fn_final_num', true );

			$number_range    = get_post_meta( $post->ID, 'tpc_proc_fn_num_range', true );
			$change_interval = get_post_meta( $post->ID, 'tpc_proc_ci_in_sec', true );

			?>
			<div class="tpaep_woo_countdown_main">
				<div class="tpaep_countdown_type tpaep_normal_countdown_wrap">
					<div for="tpc_pro_countdown_normal_countdown" class="title"> <?php echo esc_html__( 'Normal Countdown :', 'theplus' ); ?> </div>
					<div class="tpaep_countdown_right">
						<label for="tpc_proc_ndate_title"> <?php echo esc_html__( 'Date ', 'theplus' ); ?> </label>
						<input type="date" id="tpc_proc_ndate" name="tpc_proc_ndate" value="<?php echo esc_attr( $normal_countdown_date ); ?>">
					</div>
				</div>

				<div class="tpaep_countdown_type tpaep_scarcity_countdown_wrap">
					<div for="tpc_pro_countdown_normal_scarcity" class="title"> <?php echo esc_html__( 'Scarcity Countdown (Evergreen) :', 'theplus' ); ?> </div>
					<div class="tpaep_countdown_right">						
						<label for="tpc_proc_ns_days_title"> <?php echo esc_html__( 'Minutes ', 'theplus' ); ?> </label>
						<input type="number" id="tpc_proc_ns_days" name="tpc_proc_ns_days" value="<?php echo esc_attr( $scarcity_countdown_minutes ); ?>">
					</div>
				</div>

				<div class="tpaep_countdown_type tpaep_fakenumbers_countdown_wrap">
					<div for="tpc_pro_countdown_fake_numbers_counter" class="title"> <?php echo esc_html__( 'Fake Numbers Counter : ', 'theplus' ); ?> </div>
					<div class="tpaep_countdown_content">	
						<div class="tpaep_fakenumbers_content">
							<label for="tpc_proc_fn_ini_num_title"> <?php echo esc_html__( 'Initial Number ', 'theplus' ); ?> </label>
							<input type="number" id="tpc_proc_fn_ini_num" name="tpc_proc_fn_ini_num" value="<?php echo esc_attr( $initial_fake_number ); ?>">
						</div>

						<div class="tpaep_fakenumbers_content">
							<label for="tpc_proc_fn_final_num_title"> <?php echo esc_html__( 'Final Number ', 'theplus' ); ?> </label>
							<input type="number" id="tpc_proc_fn_final_num" name="tpc_proc_fn_final_num" value="<?php echo esc_attr( $final_fake_number ); ?>">
						</div>

						<div class="tpaep_fakenumbers_content">
							<label for="tpc_proc_fn_num_range_title"> <?php echo esc_html__( 'Number Range ', 'theplus' ); ?> </label>
							<input type="number" id="tpc_proc_fn_num_range" name="tpc_proc_fn_num_range" value="<?php echo esc_attr( $number_range ); ?>">
						</div>
						
						<div class="tpaep_fakenumbers_content">
							<label for="tpc_proc_ci_in_sec_title"> <?php echo esc_html__( 'Change Interval (In Seconds) ', 'theplus' ); ?> </label>
							<input type="number" id="tpc_proc_ci_in_sec" name="tpc_proc_ci_in_sec" value="<?php echo esc_attr( $change_interval ); ?>">
						</div>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Submit form data
		 *
		 * @since 6.0.0
		 */
		public function tpaep_woo_countdown_meta_data( $post_id ) {

			if ( ! isset( $_POST['woocommerce_countdown_meta_box_nonce'] ) ) {
				return;
			}

			if ( ! wp_verify_nonce( $_POST['woocommerce_countdown_meta_box_nonce'], 'save_woocommerce_countdown_data' ) ) {
				return;
			}

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			if ( isset( $_POST['tpc_proc_ndate'] ) ) {
				update_post_meta( $post_id, 'tpc_proc_ndate', sanitize_text_field( $_POST['tpc_proc_ndate'] ) );
			}

			if ( isset( $_POST['tpc_proc_ns_days'] ) ) {
				update_post_meta( $post_id, 'tpc_proc_ns_days', sanitize_text_field( $_POST['tpc_proc_ns_days'] ) );
			}

			if ( isset( $_POST['tpc_proc_fn_ini_num'] ) ) {
				update_post_meta( $post_id, 'tpc_proc_fn_ini_num', sanitize_text_field( $_POST['tpc_proc_fn_ini_num'] ) );
			}

			if ( isset( $_POST['tpc_proc_fn_final_num'] ) ) {
				update_post_meta( $post_id, 'tpc_proc_fn_final_num', sanitize_text_field( $_POST['tpc_proc_fn_final_num'] ) );
			}

			if ( isset( $_POST['tpc_proc_fn_num_range'] ) ) {
				update_post_meta( $post_id, 'tpc_proc_fn_num_range', sanitize_text_field( $_POST['tpc_proc_fn_num_range'] ) );
			}

			if ( isset( $_POST['tpc_proc_ci_in_sec'] ) ) {
				update_post_meta( $post_id, 'tpc_proc_ci_in_sec', sanitize_text_field( $_POST['tpc_proc_ci_in_sec'] ) );
			}
		}
	}

	Tpaep_Woo_Countdown::get_instance();
}