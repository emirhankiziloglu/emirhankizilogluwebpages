<?php
/**
 * @package ThePlus
 */

/**Exit if accessed directly.*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Tpaep_Extra_Option_Main' ) ) {

	/**
	 * Tpaep_Extra_Option_Main
	 *
	 * @since 1.0.0
	 */
	class Tpaep_Extra_Option_Main {

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
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->tpaep_extra_option_files();
		}

		/**
		 * Add Taxonomy Options
		 *
		 * @since 1.0.0
		 */
		public function tpaep_extra_option_files() {
			$megamenu       = theplus_get_option( 'general', 'check_elements' );
			$check_category = get_option( 'theplus_api_connection_data' );

			require_once THEPLUS_INCLUDES_URL . 'extra-option/class-tpaep-custom-field-repeater.php';

			if ( isset( $megamenu ) && ! empty( $megamenu ) ) {

				if( in_array( 'tp_navigation_menu', $megamenu ) ){
					require_once THEPLUS_INCLUDES_URL . 'extra-option/class-tpaep-mega-menu.php';
					require_once THEPLUS_INCLUDES_URL . 'extra-option/custom-nav-item/menu-item-custom-fields.php';
					require_once THEPLUS_INCLUDES_URL . 'extra-option/custom-nav-item/plus-navigation-fields.php';
				}

				if ( ! empty( $check_category['dynamic_category_thumb_check'] ) ) {
					require_once THEPLUS_INCLUDES_URL . 'extra-option/class-tpaep-taxonomy-option.php';
				}

				if ( ! empty( $check_category['theplus_custom_field_video_switch'] ) ) {
					require_once THEPLUS_INCLUDES_URL . 'extra-option/class-tpaep-woo-videourl.php';
				}

				if ( ! empty( $check_category['theplus_woo_countdown_switch'] ) ) {
					require_once THEPLUS_INCLUDES_URL . 'extra-option/class-tpaep-woo-countdown.php';
				}

				if ( ! empty( $check_category['theplus_woo_swatches_switch'] ) ) {
					require_once THEPLUS_INCLUDES_URL . 'extra-option/tp_custom_product_swatches.php';
					require_once THEPLUS_INCLUDES_URL . 'extra-option/tp_custom_product_swatches_meta.php';
					require_once THEPLUS_INCLUDES_URL . 'extra-option/tp_custom_product_swatches_front.php';
	
					if ( ! is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
						add_action( 'init', array( 'TP_Woo_Variation_Swatches_Front', 'instance' ) );
					}
				}
			}

		}
	}

	Tpaep_Extra_Option_Main::get_instance();

}
