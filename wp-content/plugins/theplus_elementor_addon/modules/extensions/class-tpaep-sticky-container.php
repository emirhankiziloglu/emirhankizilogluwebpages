<?php
/**
 * The file that defines the core plugin class
 *
 * @link    https://posimyth.com/
 * @since   6.5.6
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
if ( ! class_exists( 'Tpaep_Sticky_Con' ) ) {

	/**
	 * Define Tpaep_Sticky_Con class
	 */
	class Tpaep_Sticky_Con {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 6.5.6
		 * @var   object
		 */
		private static $instance = null;
		/**
		 * Returns a singleton instance of the class.
		 *
		 * This method ensures that only one instance of the class is created (singleton pattern).
		 * If an instance doesn't exist, it creates one using the provided shortcodes.
		 *
		 * @since 6.5.6
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

        private array $containers_data = [];

		/**
		 * Initalize integration hooks
		 *
		 * @return void
		 */
		public function __construct() {

            if ( \Elementor\Plugin::$instance->experiments->is_feature_active( 'container' ) ) {
                add_action( 'elementor/element/container/section_layout/after_section_end', [ $this, 'tpaep_register_controls' ], 10, 2 );
                add_action( 'elementor/frontend/container/before_render', [ $this, 'tpaep_render_element' ], 10, 1 );
            } 
            add_action( 'elementor/element/column/section_advanced/after_section_end', [ $this, 'tpaep_register_controls' ], 10, 2 );
            add_action( 'elementor/frontend/column/before_render', [ $this, 'tpaep_render_element'], 10, 1 );	
		}

        public function tpaep_register_controls( $element, $section_id ) {

            if ( ! $element || ! is_object( $element ) ) {
                return; 
            }
    
            // if( 'container' === $element->get_name() ) {
    
                $element->start_controls_section(
                    'plus_section_stickycon_section',
                    array(
                        'label' => esc_html__( 'Sticky Column', 'theplus' ),
                        'tab'   => Controls_Manager::TAB_ADVANCED,
                    )
                );
    
                $element->add_control(
                    'plus_column_sticky',
                    [
                        'label'        =>  esc_html__( 'Sticky Column', 'theplus' ),
                        'type'         => \Elementor\Controls_Manager::SWITCHER,
                        'label_on'     =>  esc_html__( 'Enable', 'theplus' ),
                        'label_off'    =>  esc_html__( 'Disable', 'theplus' ),
                        'return_value' => 'true',
                        'default'      => 'false',
                    ]
                );
                $element->add_control(
                    'plus_sticky_top_spacing',
                    [
                        'label'   =>  esc_html__( 'Top Spacing', 'theplus' ),
                        'type'    => \Elementor\Controls_Manager::NUMBER,
                        'default' => 40,
                        'min'     => 0,
                        'max'     => 500,
                        'step'    => 1,
                        'condition' => [
                            'plus_column_sticky' => 'true',
                        ],
                    ]
                );
    
                $element->add_control(
                    'plus_sticky_bottom_spacing',
                    [
                        'label'   =>  esc_html__( 'Bottom Spacing', 'theplus' ),
                        'type'    => \Elementor\Controls_Manager::NUMBER,
                        'default' => 40,
                        'min'     => 0,
                        'max'     => 500,
                        'step'    => 1,
                        'condition' => [
                            'plus_column_sticky' => 'true',
                        ],
                    ]
                );
                $element->add_responsive_control(
                    'plus_sticky_padding',
                    [
                        'label' => esc_html__( 'Padding', 'theplus' ),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => [ 'px', 'em' ],
                        'selectors' => [
                            '{{WRAPPER}} .inner-wrapper-sticky' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                        'condition' => [
                            'plus_column_sticky' => 'true',
                        ],
                    ]
                );
                $element->add_control(
                    'plus_sticky_enable_desktop',
                    [
                        'label' => esc_html__( 'Sticky Desktop', 'theplus' ),
                        'type' => \Elementor\Controls_Manager::SWITCHER,
                        'label_on' => esc_html__( 'Enable', 'theplus' ),
                        'label_off' => esc_html__( 'Disable', 'theplus' ),					
                        'default' => 'yes',
                        'condition' => [
                            'plus_column_sticky' => 'true',
                        ],
                    ]
                );
                $element->add_control(
                    'plus_sticky_enable_tablet',
                    [
                        'label' => esc_html__( 'Sticky Tablet', 'theplus' ),
                        'type' => \Elementor\Controls_Manager::SWITCHER,
                        'label_on' => esc_html__( 'Enable', 'theplus' ),
                        'label_off' => esc_html__( 'Disable', 'theplus' ),					
                        'default' => 'no',
                        'condition' => [
                            'plus_column_sticky' => 'true',
                        ],
                    ]
                );
                $element->add_control(
                    'plus_sticky_enable_mobile',
                    [
                        'label' => esc_html__( 'Sticky Mobile', 'theplus' ),
                        'type' => \Elementor\Controls_Manager::SWITCHER,
                        'label_on' => esc_html__( 'Enable', 'theplus' ),
                        'label_off' => esc_html__( 'Disable', 'theplus' ),					
                        'default' => 'no',
                        'condition' => [
                            'plus_column_sticky' => 'true',
                        ],
                    ]
                );
    
                $element->end_controls_section();
            // }
        }
    
        public function tpaep_render_element( $element ) {
            
            $settings = $element->get_settings();
    
            $con_id  = $element->get_id();
            $post_id = get_the_ID();
    
            $data = $element->get_data();
            $type = isset( $data['elType'] ) ? $data['elType'] : '';

            if ( 'container' !== $type && 'column' !== $type ) {
                return;
            }
    
            $plus_column_sticky = ! empty( $settings['plus_column_sticky'] ) ? $settings['plus_column_sticky'] : '';

            if ( 'true' === $plus_column_sticky ) {

                $sc_array = array();

                $sc_desktop = ! empty( $settings['plus_sticky_enable_desktop'] ) ? $settings['plus_sticky_enable_desktop'] : '';
                $sc_tablet  = ! empty( $settings['plus_sticky_enable_tablet'] ) ? $settings['plus_sticky_enable_tablet'] : '';
                $sc_mobile  = ! empty( $settings['plus_sticky_enable_mobile'] ) ? $settings['plus_sticky_enable_mobile'] : '';

                $sc_top_spacing    = ! empty( $settings['plus_sticky_top_spacing'] ) ? $settings['plus_sticky_top_spacing'] : 40;
                $sc_bottom_spacing = ! empty( $settings['plus_sticky_bottom_spacing'] ) ? $settings['plus_sticky_bottom_spacing'] : 40;

                if ( 'yes' === $sc_desktop ) {
                    $sc_array[]= 'desktop';
                }
                if ( 'yes' === $sc_tablet ) {
                    $sc_array[]= 'tablet';
                }
                if ( 'yes' === $sc_mobile ) {
                    $sc_array[]= 'mobile';
                }

                $sc_settings = array(
                    'id'            => $data['id'],
                    'sticky'        => filter_var( $plus_column_sticky, FILTER_VALIDATE_BOOLEAN ),
                    'topSpacing'    => $sc_top_spacing,
                    'bottomSpacing' => $sc_bottom_spacing,
                    'stickyOn'      => isset( $sc_array ) ? $sc_array : array( 'desktop' ),
                );

                if ( filter_var( $plus_column_sticky, FILTER_VALIDATE_BOOLEAN ) ) {
                    $element->add_render_attribute( '_wrapper', array(
                        'class' => 'plus-sticky-column-sticky',
                        'data-plus-sticky-column-settings' => json_encode( $sc_settings ),
                    ) );
                }

                $this->containers_data[ $element->get_id() ] = $sc_settings;
            }
        }
		
	}
}

Tpaep_Sticky_Con::get_instance();