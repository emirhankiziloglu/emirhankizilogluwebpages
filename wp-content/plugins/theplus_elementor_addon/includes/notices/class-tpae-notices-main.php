<?php
/**
 * It is Main File to load all Notice, Upgrade Menu and all
 *
 * @link       https://posimyth.com/
 * @since      6.1.6
 *
 * @package    Theplus
 * @subpackage ThePlus/Notices
 * */

/**
 * Exit if accessed directly.
 * */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Tpae_Notices_Main' ) ) {

	/**
	 * This class used for only load All Notice Files
	 *
	 * @since 6.1.6
	 */
	class Tpae_Notices_Main {

		/**
		 * Instance
		 *
		 * @since 6.1.6
		 * 
		 * @var instance of the class.
		 */
		private static $instance = null;

		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 *
		 * @since  6.1.6
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * Perform some compatibility checks to make sure basic requirements are meet.
		 *
		 * @since 6.1.6
		 */
		public function __construct() {
			$this->tpae_notices_manage();
		}

		/**
		 * Initiate our hooks
		 *
		 * @since 6.1.6
		 */
		public function tpae_notices_manage() {

			if ( is_admin() && current_user_can( 'manage_options' ) ) {
				include THEPLUS_PATH . 'includes/notices/class-tpae-plugin-page.php';
			}
		}
	}

	Tpae_Notices_Main::instance();
}
