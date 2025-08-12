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

if ( ! class_exists( 'Tpaep_Woo_Videourl' ) ) {

	/**
	 * Tpaep_Woo_Videourl
	 *
	 * @since 6.0.0
	 */
	class Tpaep_Woo_Videourl {

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
			add_action('add_meta_boxes', array( $this, 'tpaep_woo_videourl_meta_box') );
			add_action('save_post', array( $this, 'tpaep_woo_videourl_meta_data') );

			add_action('admin_enqueue_scripts', array( $this, 'enqueue_woo_videourl_styles'));
		}

		/**
		 * Load CSS file.
		 *
		 * @since 6.1.0
		 */
		public function enqueue_woo_videourl_styles( $slug ) {
			if( 'post.php' === $slug ){
            	wp_enqueue_style( 'tpaep-woo-videourl-admin', THEPLUS_URL . 'includes/extra-option/css/tpaep-woo-videourl.css', array(), THEPLUS_VERSION, false );
			}
		}

		/**
		 * function call for the video-url field
		 *
		 * @since 6.0.0
		 */
		public function tpaep_woo_videourl_meta_box() {
			add_meta_box(
				'woocommerce_videourl',
				esc_html__( 'Video', 'theplus' ),
				array( $this, 'woocommerce_videourl_callback' ),
				'product',
				'normal',
				'default'
			);
		}

		/**
		 * Form for the video url field
		 *
		 * @since 6.0.0
		 */
		public function woocommerce_videourl_callback( $post ) {
			$video_url = get_post_meta( $post->ID, '_woocommerce_video_url', true );

            wp_nonce_field( 'save_woocommerce_videourl_data', 'woocommerce_videourl_meta_box_nonce' );
			?>

            <div class="tpaep_woo_videourl_main">
                <div class="tpaep_videourl_wrap">
                    <label for="woocommerce_video_url"> <?php echo esc_html__( 'Video Upload ', 'theplus' ) ?> </label>
                    <input type="text" id="woocommerce_video_url" name="woocommerce_video_url" value="<?php echo esc_attr( $video_url ); ?>" placeholder="https://">
                    <div class="tpaep_videourl_btn">
                        <button type="button" class="button" id="tpaep_upload_video_button"><?php _e( 'Add or Upload File', 'theplus' ); ?></button>
                    </div>
                    <div class="extra"> </div>
                    <div class="tpaep_note"><?php _e( 'You can use Self Hosted Video URL here.', 'theplus' ); ?></div>
                </div>
            </div>
			<p>
			</p>
			<script>
				jQuery(document).ready(function($) {
					$('#tpaep_upload_video_button').click(function(e) {
						e.preventDefault();
						var videoInput = $('#woocommerce_video_url');
						var custom_uploader = wp.media({
							title: '<?php esc_html__( 'Upload Video', 'theplus' ); ?>',
							button: {
								text: '<?php esc_html__( 'Use this video', 'theplus' ); ?>'
							},
							multiple: false
						}).on('select', function() {
							var attachment = custom_uploader.state().get('selection').first().toJSON();
							videoInput.val(attachment.url);
						}).open();
					});
				});
			</script>
			<?php
		}

		/**
		 * Submit form data
		 *
		* @since 6.0.0
		 */
        public function tpaep_woo_videourl_meta_data( $post_id ) {
			
			if ( ! isset( $_POST['woocommerce_videourl_meta_box_nonce'] ) ) {
				return;
			}
			
			if ( ! wp_verify_nonce( $_POST['woocommerce_videourl_meta_box_nonce'], 'save_woocommerce_videourl_data' ) ) {
				return;
			}
			
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			if ( isset( $_POST['woocommerce_video_url'] ) ) {
				update_post_meta( $post_id, '_woocommerce_video_url', sanitize_text_field( $_POST['woocommerce_video_url'] ) );
			}
		}
	}

	Tpaep_Woo_Videourl::get_instance();
}