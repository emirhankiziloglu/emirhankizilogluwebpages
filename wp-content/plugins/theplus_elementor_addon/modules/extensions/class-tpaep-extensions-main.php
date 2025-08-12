<?php
/**
 * The file that defines the widget plugin for the free version.
 *
 * @link       https://posimyth.com/
 * @since      6.5.6
 *
 * @package    the-plus-addons-for-elementor-page-builder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define Tpaep_Extensions_Main class for the free version.
 * 
 * @since 6.5.6
 */
if ( ! class_exists( 'Tpaep_Extensions_Main' ) ) {

    /**
     * Define L_Tpaef_Extensions_Main class for the free version
     * 
     * @since 6.5.6
     */
    class Tpaep_Extensions_Main {

        /**
         * Call __construct.
         */
        public function __construct() {

            $theplus_options = get_option( 'theplus_options' );

            $extras_elements = ! empty( $theplus_options['extras_elements'] ) ? $theplus_options['extras_elements'] : [];
            $get_widget = ! empty( $theplus_options['check_elements'] ) ? $theplus_options['check_elements'] : [];

            if (  in_array( 'plus_adv_shadow', $extras_elements ) ) {
                require L_THEPLUS_PATH . 'modules/extensions/class-tpae-advanced-shadow.php';
            }

            if( in_array( 'plus_custom_css', $extras_elements ) ){
                include THEPLUS_PATH . 'modules/extensions/custom-css/class-tpaep-custom-css.php';
            }

            if ( in_array( 'plus_display_rules', $extras_elements ) ) {
                include THEPLUS_PATH . 'modules/extensions/display-condition/class-tpaep-display-condition.php';
            }
            
            if ( in_array( 'plus_event_tracker', $extras_elements ) ) {
                include THEPLUS_PATH . 'modules/extensions/event-tracker/class-tpaep-event-tracker.php';
            }

            if (  in_array( 'plus_equal_height', $extras_elements ) ) {
                require L_THEPLUS_PATH . 'modules/extensions/class-tpae-equal-height.php';
            }

            if (  in_array( 'plus_glass_morphism', $extras_elements ) ) {
                require L_THEPLUS_PATH . 'modules/extensions/class-tpae-glass-morphism.php';
            }

            if ( in_array( 'order_sort_column', $extras_elements ) || in_array( 'custom_width_column', $extras_elements ) ) {
                require THEPLUS_PATH . 'modules/extensions/column-width/class-tpaep-column-width.php';
            }

            if ( in_array( 'column_mouse_cursor', $extras_elements ) ) {
                require THEPLUS_PATH . 'modules/extensions/class-tpaep-mouse-cursor.php';
            }

            if ( in_array( 'section_scroll_animation', $extras_elements ) ) {
                require THEPLUS_PATH . 'modules/extensions/class-tpaep-scroll-animation.php';
            }

            if (  in_array( 'column_sticky', $extras_elements ) ) {
                include THEPLUS_PATH . 'modules/extensions/class-tpaep-sticky-container.php';
            }

            if (  in_array( 'plus_section_column_link', $extras_elements ) ) {
                require L_THEPLUS_PATH . 'modules/extensions/wrapper-link/class-tpae-wrapper-link.php';
            }
        }
    }
}

new Tpaep_Extensions_Main();
