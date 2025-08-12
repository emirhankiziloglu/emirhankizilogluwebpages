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

if ( ! class_exists( 'Tpaep_White_Label' ) ) {

	/**
	 * Tpaep_White_Label
	 *
	 * @since 1.0.0
	 */
	class Tpaep_White_Label {

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
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_media_uploader' ) );
			add_action( 'admin_head', array( $this, 'tpaep_plus_icon_logo' ) );
			add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'tpaep_help_links' ) );
		}

		/**
		 * Enqueue WordPress media library scripts
		 *
		 * @since 6.0.0
		 */
		public function enqueue_media_uploader() {
			wp_enqueue_media();
		}

		/**
		 * Set white label Logo for WordPress Menu
		 *
		 * @since 6.0.0
		 */
		public function tpaep_plus_icon_logo() {
			$get_whitelabel = get_option( 'theplus_white_label' );
			$logo_url       = isset( $get_whitelabel['tp_plus_logo'] ) && ! empty( $get_whitelabel['tp_plus_logo'] ) ? $get_whitelabel['tp_plus_logo'] : '';

			if ( ! empty( $logo_url ) ) { ?>
				<style>.wp-menu-image.dashicons-before.dashicons-plus-settings{background: url(<?php echo esc_url( $logo_url ); ?>);background-size: 22px;background-repeat: no-repeat;background-position: center;}.theplus-current-version.wp-badge{background: url(<?php echo esc_url( $logo_url ); ?>) center 25px no-repeat;background-size: 35px;background-position: center 30px;}</style>
				<?php
			}
		}

		/**
		 * Set Elementor Panal Need Help button and section Hide
		 *
		 * @since 6.0.0
		 */
		public function tpaep_help_links() {
			$get_whitelabel = get_option( 'theplus_white_label' );
			$help_link      = isset( $get_whitelabel ) && ! empty( $get_whitelabel['help_link'] ) ? $get_whitelabel['help_link'] : '';

			if ( 'on' === $help_link ) {
				?>
				<style>
					#elementor-controls .elementor-control-theplus_section_needhelp,#elementor-panel__editor__help__link[href^="https://store.posimyth.com/helpdesk"]{
						display: none !important;
					}
				</style>
				<?php
			}
		}
	}

	Tpaep_White_Label::get_instance();
}
