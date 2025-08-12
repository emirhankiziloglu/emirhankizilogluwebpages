<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://posimyth.com/
 * @since      6.1.6
 *
 * @package    ThePlus
 * @subpackage ThePlus/Notices
 */

/**Exit if accessed directly.*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Tpae_Plugin_Page' ) ) {

	/**
	 * Tpae_Plugin_Page
	 *
	 * @since 6.1.6
	 */
	class Tpae_Plugin_Page {

		/**
		 * Member Variable
		 *
		 * @var instance
		 */
		private static $instance;

		/**
		 * Initiator
		 *
		 * @since 6.1.6
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * White label Option
		 *
		 * @var string
		 */
		public $whitelabel = '';

		/**
		 * White label Option
		 *
		 * @var string
		 */
		public $hidden_label = '';

		/**
		 * Define the core functionality of the plugin.
		 *
		 * @since 6.1.5
		 */
		public function __construct() {
			$this->whitelabel   = get_option( 'theplus_white_label' );
			$this->hidden_label = ! empty( $this->whitelabel['help_link'] ) ? $this->whitelabel['help_link'] : '';

			add_filter( 'plugin_action_links_' . THEPLUS_PBNAME, array( $this, 'tpae_add_settings_link' ) );
			add_filter( 'plugin_row_meta', array( $this, 'tpae_extra_links_plugin_row_meta' ), 10, 2 );
		}

		/**
		 * Adds custom links to the plugin actions on the plugins page.
		 *
		 * This function appends additional links (e.g., Settings, Need Help, License)
		 * to the default action links displayed for the plugin on the WordPress plugins page.
		 *
		 * @param array $links Default action links provided by WordPress for the plugin.
		 * @return array Modified array of action links with custom links appended.
		 */
		public function tpae_add_settings_link( $links ) {

			// Need Help link.
			$links = (array) $links;

			$settings = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=theplus_welcome_page#/' ), __( 'Settings', 'theplus' ) );
			$links[]  = $settings;

			if ( empty( $this->whitelabel ) || 'on' !== $this->hidden_label ) {
				$need_help = sprintf( '<a href="%s" target="_blank" rel="noopener noreferrer">%s</a>', esc_url( 'https://store.posimyth.com/get-support-addons/?utm_source=wpbackend&utm_medium=pluginpage&utm_campaign=links' ), __( 'Need Help?', 'theplus' ) );
				$license   = sprintf( '<a href="%s" style="color:green;font-weight:600;">%s</a>', admin_url( 'admin.php?page=theplus_welcome_page#/activate_pro' ), __( 'License', 'theplus' ) );
				$links[]   = $need_help;
				$links[]   = $license;
			}

			return $links;
		}

		/**
		 * Adds extra links to the plugin row meta on the Plugins page.
		 *
		 * This function appends additional meta links (e.g., Docs, Video Tutorials, Join Community, etc.)
		 * to the plugin's row on the WordPress Plugins page.
		 *
		 * @since 6.1.5
		 *
		 * @param array  $plugin_meta Default array of meta links for the plugin.
		 * @param string $plugin_file The current plugin file being iterated over.
		 * @return array Modified array of plugin meta links with additional custom links.
		 */
		public function tpae_extra_links_plugin_row_meta( $plugin_meta, $plugin_file ) {

			if ( strpos( $plugin_file, THEPLUS_PBNAME ) !== false && ( empty( $this->whitelabel ) || 'on' !== $this->hidden_label ) ) {
				$new_links = array(
					'docs'            => '<a href="' . esc_url( 'https://theplusaddons.com/docs?utm_source=wpbackend&utm_medium=pluginpage&utm_campaign=links' ) . '" target="_blank" rel="noopener noreferrer" style="color:green;">' . esc_html__( 'Docs', 'theplus' ) . '</a>',
					'video-tutorials' => '<a href="' . esc_url( 'https://www.youtube.com/c/POSIMYTHInnovations/?sub_confirmation=1' ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Video Tutorials', 'theplus' ) . '</a>',
					'join-community'  => '<a href="' . esc_url( 'https://www.facebook.com/groups/1331664136965680' ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Join Community', 'theplus' ) . '</a>',
					'whats-new'       => '<a href="' . esc_url( 'https://roadmap.theplusaddons.com/updates?filter=Pro' ) . '" target="_blank" rel="noopener noreferrer" style="color: orange;">' . esc_html__( 'What\'s New?', 'theplus' ) . '</a>',
					'req-feature'     => '<a href="' . esc_url( 'https://roadmap.theplusaddons.com/boards/feature-request' ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Request Feature', 'theplus' ) . '</a>',
					'rate-theme'      => '<a href="' . esc_url( 'https://wordpress.org/support/plugin/the-plus-addons-for-elementor-page-builder/reviews/?filter=5' ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Share Review', 'theplus' ) . '</a>',
				);

				$plugin_meta = array_merge( $plugin_meta, $new_links );
			}

            if ( ! empty( $this->whitelabel['help_link'] ) ) {
				foreach ( $plugin_meta as $key => $meta ) {
					if ( stripos( $meta, 'Visit plugin site' ) !== false ) {
						unset( $plugin_meta[ $key ] );
					}
				}
			}

			return $plugin_meta;
		}
	}

	Tpae_Plugin_Page::get_instance();
}
