<?php
/**
 * The file that defines the core plugin class
 *
 * @link    https://posimyth.com/
 * @since   6.2.5
 *
 * @package the-plus-addons-for-elementor-page-builder
 */

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Plugin;

if ( ! defined( 'WPINC' ) ) {
	exit;
}

/*
 * Cross Domain Copy Paste Theplus.
 */
if ( ! class_exists( 'Tpaep_Custom_Css' ) ) {

	/**
	 * Define Tpaep_Custom_Css class
	 */
	class Tpaep_Custom_Css {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 6.2.5
		 * @var   object
		 */
		private static $instance = null;
		/**
		 * Returns a singleton instance of the class.
		 *
		 * This method ensures that only one instance of the class is created (singleton pattern).
		 * If an instance doesn't exist, it creates one using the provided shortcodes.
		 *
		 * @since 6.2.5
		 *
		 * @param array $shortcodes Optional. An array of shortcodes to initialize the instance with.
		 * @return self The single instance of the class.
		 */
		public static function get_instance( $shortcodes = array() ) {

			if ( null === self::$instance ) {
				self::$instance = new self( $shortcodes );
			}

			return self::$instance;
		}

		/**
		 * Initalize integration hooks
		 *
		 * @since 6.2.5
		 * @return void
		 */
		public function __construct() {

			add_action( 'elementor/element/parse_css', array( $this, 'tpaep_add_post_css' ), 10, 2 );

			add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'tpaep_custom_css_scrpt' ) );

			/** For the Add in Section & Columns*/
			add_action( 'elementor/element/section/section_advanced/after_section_end', array( $this, 'tpaep_register_controls' ), 10, 2 );
			add_action( 'elementor/element/column/section_advanced/after_section_end', array( $this, 'tpaep_register_controls' ), 10, 2 );

			/** For the Add in Widgets*/
			add_action( 'elementor/element/common/_section_style/after_section_end', array( $this, 'tpaep_register_controls' ), 10, 2 );

			/** For the Add in Container*/
			if ( \Elementor\Plugin::$instance->experiments->is_feature_active( 'container' ) ) {
				add_action( 'elementor/element/container/section_layout/after_section_end', [ $this, 'tpaep_register_controls' ], 10, 2  );
			}

			/** For the all Elementor elements*/
			// add_action('elementor/element/after_section_end', [$this, 'tpaep_register_controls'], 10, 2);
		}

		/**
		 * Enqueues the custom CSS editor JavaScript for The Plus Addons.
		 *
		 * This function loads the `tp-custom-css-editor.min.js` script, which is used
		 * to apply custom CSS in the Elementor editor. The script depends on jQuery
		 * and WordPress i18n (internationalization) libraries.
		 *
		 * @since 6.2.5
		 */
		public function tpaep_custom_css_scrpt() {
			wp_enqueue_script( 'tp-custom-css-editor-js', THEPLUS_URL . 'modules/extensions/custom_css/tp-custom-css-editor.min.js', array( 'jquery', 'wp-i18n' ), THEPLUS_VERSION, true );
		}

		/**
		 * Adds custom CSS to the Elementor post stylesheet.
		 *
		 * This function applies user-defined custom CSS from the Elementor editor
		 * to the current post's stylesheet. It replaces the 'selector' placeholder
		 * with the element's unique CSS selector to ensure correct scoping.
		 *
		 * @param object $post_css Instance of the Elementor Post_CSS or similar class.
		 * @param object $element  The Elementor element instance (Element_Base).
		 *
		 * @since 6.2.5
		 */
		public function tpaep_add_post_css( $post_css, $element ) {

			if ( $post_css instanceof Dynamic_CSS ) {
				return;
			}

			$element_settings = $element->get_settings();

			if ( empty( $element_settings['plus_custom_css'] ) ) {
				return;
			}

			$css = trim( $element_settings['plus_custom_css'] );

			if ( empty( $css ) ) {
				return;
			}

			$css = str_replace( 'selector', $post_css->get_element_unique_selector( $element ), $css );

			$post_css->get_stylesheet()->add_raw_css( $css );
		}

		/**
		 * Registers custom controls for adding custom CSS in Elementor.
		 *
		 * This function adds a 'Plus Extras: Custom CSS' section under the
		 * Advanced tab in the Elementor editor. It provides a code editor
		 * for users to add custom CSS styles.
		 *
		 * @param object $element    The Elementor element instance.
		 * @param string $section_id The ID of the current section.
		 *
		 * @since 6.2.5
		 */
		public function tpaep_register_controls( $element, $section_id ) {

			$element->start_controls_section(
				'plus_section_customcss_section',
				array(
					'label' => esc_html__( 'Custom CSS', 'theplus' ),
					'tab'   => Controls_Manager::TAB_ADVANCED,
				)
			);

			$element->add_control(
				'plus_custom_css',
				array(
					'label'       => esc_html__( 'Custom CSS', 'theplus' ),
					'type'        => \Elementor\Controls_Manager::CODE,
					'language'    => 'css',
					'render_type' => 'ui',
					'separator'   => 'none',
					'rows'        => 20,
				)
			);

			$element->end_controls_section();
		}
	}
}

Tpaep_Custom_Css::get_instance();
