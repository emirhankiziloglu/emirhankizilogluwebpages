<?php
namespace TheplusAddons;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

final class Theplus_Element_Load {
	/**
		* Core singleton class
		* @var self - pattern realization
	*/
	private static $_instance;

	/**
	 * @var Manager
	 */
	private $_modules_manager;

	/**
	 * @deprecated
	 * @return string
	 */
	public function get_version() {
		return THEPLUS_VERSION;
	}
	
	/**
	* Cloning disabled
	*/
	public function __clone() {
	}
	
	/**
	* Serialization disabled
	*/
	public function __sleep() {
	}
	
	/**
	* De-serialization disabled
	*/
	public function __wakeup() {
	}
	
	/**
	* @return \Elementor\Theplus_Element_Loader
	*/
	public static function elementor() {
		return \Elementor\Plugin::$instance;
	}
	
	/**
	* @return Theplus_Element_Loader
	*/
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * ThePlus_Load constructor.
	 * 
	 * @since 6.1.5
	 */
	private function __construct() {
		
		$this->tpae_manage_files();

		// Register class automatically
		$this->includes();
		// Finally hooked up all things
		$this->hooks();		
		theplus_elements_integration()->init();

		if ( defined( 'L_THEPLUS_VERSION' ) && version_compare( L_THEPLUS_VERSION, '6.0.0', '<' ) ) {
			add_action( 'admin_notices', array( $this, 'theplus_elementor_cache_notice' ) );
		}

		if ( defined( 'L_THEPLUS_VERSION' ) && version_compare( L_THEPLUS_VERSION, '6.1.0', '<' ) ) {
			add_action( 'admin_notices', array( $this, 'theplus_widget_free_notice' ) );
		}

		add_action( 'wp_ajax_tp_install_elementor', array( $this, 'tp_install_elementor' ) );

		$this->include_widgets();		
		theplus_widgets_include();
	}

	/**
	 * ThePlus_Load constructor.
	 * 
	 * @since 6.1.5
	 */
	public function tpae_manage_files() {
		include THEPLUS_PATH . 'includes/notices/class-tpae-notices-main.php';
	}
	
	/**
	 * we loaded module manager + admin php from here
	 * @return [type] [description]
	 */
	private function includes() {		

		/*remove backend cache	
		$option_name='on_first_load_cache';
		$value='1';
		if ( is_admin() && get_option( $option_name ) !== false ) {
		} else if( is_admin() ){
			l_theplus_library()->remove_backend_dir_files();
			$deprecated = null;
			$autoload = 'no';			
			add_option( $option_name,$value, $deprecated, $autoload );
		}
		remove backend cache*/

		$getps = get_option( 'plusextra-v6.2.6' );
		if ( empty( $getps ) ) {
			$default_load = get_option( 'theplus_options' );

			$theplus_options = array();
			if ( ! empty( $default_load ) ) {
				$theplus_options['check_elements'] = is_array( $default_load['check_elements'] ) ? $default_load['check_elements'] : array();
				$extras_elements = is_array( $default_load['extras_elements'] ) ? $default_load['extras_elements'] : array();
				$extras_elements = array_merge( $extras_elements, array( 'plus_continuous_animation', 'plus_magic_scroll', 'plus_mouse_move_parallax', 'plus_overlay_effect', 'plus_tilt_parallax', 'plus_tooltip' ) );
				$theplus_options['extras_elements'] = array_values( array_unique( $extras_elements ) );

				update_option( 'theplus_options', $theplus_options, '', 'on' );
				update_option( 'plusextra-v6.2.6', true );
			}
		}

		/*@version 5.0.3*/
		$option_name = 'tp_key_random_generate';		
		if ( is_admin() && get_option( $option_name ) !== false ) {
		} else if( is_admin() ){
			$default_load = get_option( $option_name );

			if( empty( $default_load ) ){
				$listofcharun = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$generatedkey = substr(str_shuffle($listofcharun), 0, 12);

				add_option( $option_name, $generatedkey, '', 'no' );
			}
		}
		
		if( !class_exists( 'Theplus_SL_Plugin_Updater' ) && THEPLUS_TYPE=='store') {
			include( THEPLUS_PATH . 'includes/Theplus_SL_Plugin_Updater.php' );
		}
		
		require_once THEPLUS_INCLUDES_URL .'plus_addon.php'; 
		require_once THEPLUS_PATH . 'modules/widget-manager/class-tp-widget-manager.php'; 
		require_once THEPLUS_PATH . 'modules/widgets-features/class-tp-widgets-feature-main.php';

		require_once THEPLUS_INCLUDES_URL.'extra-option/class-tpaep-extra-option-main.php';

		require THEPLUS_PATH . 'includes/dashboard/class-tpaep-white-label.php';
		
		if( is_admin() && is_user_logged_in() && current_user_can( 'manage_options' ) ){
			require THEPLUS_PATH . 'includes/dashboard/class-tpaep-dashboard-ajax.php';
			require THEPLUS_PATH . 'includes/dashboard/class-tpaep-licence.php';
		}
		
		require THEPLUS_PATH.'modules/theplus-integration.php';
		require THEPLUS_PATH.'modules/query-control/module.php';
		
		require THEPLUS_PATH.'modules/mobile_detect.php';
		require_once THEPLUS_PATH .'modules/helper-function.php';
	}
	
	/**
	* Widget Include required files
	*
	*/
	public function include_widgets() {			

		add_action( 'elementor/init', function() {
			include THEPLUS_PATH . 'modules/extensions/class-tpaep-extensions-main.php';
		});

		require_once THEPLUS_PATH.'modules/theplus-include-widgets.php';
	}
	
	public function theplus_editor_styles() {
		wp_enqueue_style( 'theplus-ele-admin-pro', THEPLUS_ASSETS_URL .'css/admin/theplus-ele-admin.css', array(),THEPLUS_VERSION,false );
	}

	public function theplus_elementor_admin_css() {
		wp_enqueue_style( 'theplus-ele-admin-pro', THEPLUS_ASSETS_URL .'css/admin/theplus-ele-admin.css', array('wp-color-picker'),THEPLUS_VERSION,false );
		wp_enqueue_script( 'wp-color-picker', THEPLUS_ASSETS_URL . 'js/extra/wp-color-picker-alpha.min.js',array() , THEPLUS_VERSION, true );
		wp_enqueue_script( 'theplus-admin-js-pro', THEPLUS_ASSETS_URL .'js/admin/theplus-admin.js', array( 'wp-color-picker'),THEPLUS_VERSION,false );
	}
	
	public function theplus_load_template( $single_template ) {
		
		global $post;

		if ( 'plus-mega-menu' == $post->post_type) {

			$elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

			if ( file_exists( $elementor_2_0_canvas ) ) {
				return $elementor_2_0_canvas;
			} else {
				return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
			}
		}

		return $single_template;
	}

	private function hooks() {
		$theplus_options = get_option('theplus_options');
		$plus_extras = theplus_get_option('general','extras_elements');
		
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'theplus_editor_styles' ] );
		
		// Include some backend files
		add_action( 'admin_enqueue_scripts', [ $this,'theplus_elementor_admin_css'] );
		add_filter( 'single_template', [ $this, 'theplus_load_template' ] );
	}

	public static function nav_item_load() {
		add_filter( 'wp_edit_nav_menu_walker', array( __CLASS__, 'plus_filter_walker' ), 99 );
	}

	/**
	 * TPAE free Dashboard version update notice
	 * 
	 * @since 6.0.0
	 */
	public function theplus_elementor_cache_notice() {
		echo '<div class="notice notice-error tp-update-notice is-dismissible"><p>' . esc_html__( 'Update required: Free version of The Plus Addons for Elementor (v6.0) needed for full compatibility.', 'theplus' ) . '</p><button class="tp-freeupdate-btn button button-primary">' . esc_html__('Update Now','theplus') .'</button></div>';
	}

	/**
	 * TPAE free Dashboard version update notice
	 * 
	 * @since 6.1.0
	 */
	public function theplus_widget_free_notice() {
		echo '<div class="notice notice-error tp-update-notice is-dismissible"><p>' . esc_html__( 'Update required: Free version of The Plus Addons for Elementor (v6.1.0) needed for full compatibility.', 'theplus' ) . '</p><button class="tp-freeupdate-btn button button-primary">' . esc_html__('Update Now','theplus') .'</button></div>';
	}

	/**
	 * TPAE free Dashboard version update notice
	 * 
	 * @since 6.0.0
	 */
	public function tp_install_elementor() {

		check_ajax_referer( 'theplus-addons', 'security' );

		if ( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'content' => __( 'Insufficient permissions.', 'uichemy' ) ) );
		}

		include_once ABSPATH . 'wp-admin/includes/file.php';
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		include_once ABSPATH . 'wp-admin/includes/class-automatic-upgrader-skin.php';

		$result = [];
		$response = wp_remote_post('http://api.wordpress.org/plugins/info/1.0/',
			[
				'body' => [
					'action' => 'plugin_information',
					'request' => serialize((object) [
						'slug' => 'the-plus-addons-for-elementor-page-builder',
						'fields' => [
							'version' => false,
						],
					]),
				],
			]
		);

		$elementor_plugin = unserialize(wp_remote_retrieve_body($response));
		if ( is_wp_error($elementor_plugin) ) {
			$result = $this->tp_response( 'Something Went Wrong', 'get body', false, $elementor_plugin );
		}

		$upgrader = new \Plugin_Upgrader(new \Automatic_Upgrader_Skin());

		$installed_plugins = get_plugins();
        $plugin_basename = 'the-plus-addons-for-elementor-page-builder/theplus_elementor_addon.php';

		if (isset($installed_plugins[$plugin_basename])) {

			$update_result = $upgrader->upgrade($plugin_basename);

            if (is_wp_error($update_result)) {
                $result = $this->tp_response('Something Went Wrong', 'Update Plugin', false, $update_result);
            }

			/**Activate Plugin*/
			if ( true === $update_result ) {
				$elementor_active = activate_plugin( $upgrader->plugin_info(), '', false, true );

				if ( is_wp_error($elementor_active) ) {
					$result = $this->tp_response( 'Something Went Wrong', 'Activate Plugin', false, $elementor_active );
				}

				$success = null === $elementor_active;
				$result = $this->tp_response( 'Success Install The Plus addons for elementor', 'Success Install The Plus addons for elementor', $success, '' );
			}else{
                $result = $this->tp_response( 'Something Went Wrong', 'Update Plugin', false, $update_result );
			}
			
		}else{
			$result = $this->tp_response( 'Something Went Wrong', 'Update Plugin', false, $update_result );
		}

		wp_send_json( $result );
	}

}

/**Get theplus_addon_load Running*/
function theplus_addon_load(){
	return Theplus_Element_Load::instance();
}
theplus_addon_load();