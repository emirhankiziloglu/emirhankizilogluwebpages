<?php
/**
 * The file that defines the core plugin class
 *
 * @link    https://posimyth.com/
 * @since   6.2.7
 *
 * @package the-plus-addons-for-elementor-page-builder
 */

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Plugin;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'WPINC' ) ) {
	exit;
}

/*
 * Column Mouse Cursor Theplus.
 */
if ( ! class_exists( 'Tpaep_Mouse_Cursor' ) ) {

	/**
	 * Define Tpaep_Mouse_Cursor class
	 */
	class Tpaep_Mouse_Cursor {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 6.2.7
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Returns a singleton instance of the class.
		 *
		 * This method ensures that only one instance of the class is created (singleton pattern).
		 * If an instance doesn't exist, it creates one using the provided shortcodes.
		 *
		 * @since 6.2.7
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
		 * Get the widget name.
		 *
		 * @since 6.2.7
		 */
		public function get_name() {
			return 'column-mouse-cursor';
		}

		/**
		 * Initalize integration hooks
		 *
		 * @since 6.2.7
		 * @return void
		 */
		public function __construct() {
            add_action( 'elementor/element/column/section_advanced/after_section_end', [ $this, 'tp_mouse_cursor_controls' ], 10, 2 );
            add_action( 'elementor/frontend/column/before_render', [ $this, 'tp_mouse_cursor_before_render'], 10, 1 );
		}

		/**
		 * Register controls for the Column Mouse Cursor feature
		 *
		 * @since 6.2.7
		 */
		public function tp_mouse_cursor_controls( $element, $section_id ) {

            $element->start_controls_section(
                'plus_mouse_cursor_section',
				[
					'label' => esc_html__( 'Mouse Cursor', 'theplus' ),
					'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
				]
			);

            $element->add_control(
                'plus_column_cursor_point',
                [
                    'label'        =>   esc_html__( 'Mouse Cursor Pointer', 'theplus' ),
                    'type'         => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'     =>  esc_html__( 'Yes', 'theplus' ),
                    'label_off'    =>  esc_html__( 'No', 'theplus' ),					
                    'default'      => 'no',
                ]
            );
            $element->add_control(
                'plus_pointer_style',
                [
                    'label' => esc_html__( 'Mouse Cursor Style', 'theplus' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'cursor-icon',
                    'options' => [
                        'cursor-icon'  => esc_html__( 'Cursor Icon', 'theplus' ),
                        'follow-image' => esc_html__( 'Follow Image', 'theplus' ),
                        'follow-text' => esc_html__( 'Follow Text', 'theplus' ),
                    ],
                    'condition' => [
                        'plus_column_cursor_point' => 'yes',
                    ],
                ]
            );
            $element->add_control(
                'plus_pointer_icon',
                [
                    'label' => esc_html__( 'Cursor Icon', 'theplus' ),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => '',
                    ],
                    'condition' => [
                        'plus_column_cursor_point' => 'yes',
                        'plus_pointer_style' => ['cursor-icon','follow-image'],
                    ],
                ]
            );
            $element->add_control(
                'plus_pointer_iconwidth',
                [
                    'label' => esc_html__( 'Icon Max Width', 'theplus' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 500,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 100,
                    ],
                    'selectors' => [
                        '{{WRAPPER}}.plus_column_{{ID}} .plus-cursor-pointer-follow' => 'max-width: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'plus_column_cursor_point' => 'yes',
                        'plus_pointer_style' => ['follow-image'],
                    ],
                ]
            );
            $element->add_control(
                'plus_pointer_text',
                [
                    'label' => esc_html__( 'Follow Text', 'theplus' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__( 'Follow Text', 'theplus' ),
                    'placeholder' => esc_html__( 'Follow Text', 'theplus' ),
                    'condition' => [
                        'plus_column_cursor_point' => 'yes',
                        'plus_pointer_style' => 'follow-text',
                    ],
                ]
            );
            $element->add_control(
                'plus_pointer_left_offset',
                [
                    'label' => esc_html__( 'Cursor Left Offset', 'theplus' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => -500,
                            'max' => 500,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 10,
                    ],						
                    'condition' => [
                        'plus_column_cursor_point' => 'yes',
                        'plus_pointer_style' => ['follow-text','follow-image'],
                    ],
                ]
            );
            $element->add_control(
                'plus_pointer_top_offset',
                [
                    'label' => esc_html__( 'Cursor Top Offset', 'theplus' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => -500,
                            'max' => 500,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 10,
                    ],
                    'condition' => [
                        'plus_column_cursor_point' => 'yes',
                        'plus_pointer_style' => ['follow-text','follow-image'],
                    ],
                ]
            );
            $element->add_control(
                'plus_column_click_cursor',
                [
                    'label'        =>  esc_html__( 'Mouse Cursor Click', 'theplus' ),
                    'type'         => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'     =>  esc_html__( 'Yes', 'theplus' ),
                    'label_off'    =>  esc_html__( 'No', 'theplus' ),					
                    'default'      => 'no',
                    'condition' => [
                        'plus_column_cursor_point' => 'yes',
                    ],
                ]
            );
            $element->add_control(
                'plus_pointer_click_icon',
                [
                    'label' => esc_html__( 'Cursor Click Icon', 'theplus' ),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => '',
                    ],
                    'condition' => [
                        'plus_column_cursor_point' => 'yes',
                        'plus_column_click_cursor' => 'yes',
                        'plus_pointer_style' => ['cursor-icon','follow-image'],
                    ],
                ]
            );
            $element->add_control(
                'plus_pointer_click_text',
                [
                    'label' => esc_html__( 'Click Follow Text', 'theplus' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__( 'See More', 'theplus' ),
                    'placeholder' => esc_html__( 'See More', 'theplus' ),
                    'condition' => [
                        'plus_column_cursor_point' => 'yes',
                        'plus_column_click_cursor' => 'yes',
                        'plus_pointer_style' => 'follow-text',
                    ],
                ]
            );
            $element->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'pointer_typography',
                    'selector' => '{{WRAPPER}}.plus_column_{{ID}} .plus-cursor-pointer-follow-text',
                    'condition' => [
                        'plus_column_cursor_point' => 'yes',
                        'plus_pointer_style' => 'follow-text',
                    ],
                    'separator' => 'before',
                ]
            );
            $element->add_control(
                'pointer_text_color',
                [
                    'label' => esc_html__( 'Text Color', 'theplus' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}}.plus_column_{{ID}} .plus-cursor-pointer-follow-text' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'plus_column_cursor_point' => 'yes',
                        'plus_pointer_style' => 'follow-text',
                    ],
                ]
            );
            $element->add_responsive_control(
                'pointer_padding',
                [
                    'label' => esc_html__( 'Text Padding', 'theplus' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'default' =>[
                        'top' => '10',
                        'right' => '15',
                        'bottom' => '10',
                        'left' => '15',
                    ],
                    'selectors' => [
                        '{{WRAPPER}}.plus_column_{{ID}} .plus-cursor-pointer-follow-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',							
                    ],
                    'condition' => [
                        'plus_column_cursor_point' => 'yes',
                        'plus_pointer_style' => 'follow-text',
                    ],
                ]
            );
            $element->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'pointer_border',
                    'label' => esc_html__( 'Border', 'theplus' ),
                    'selector' => '{{WRAPPER}}.plus_column_{{ID}} .plus-cursor-pointer-follow-text',
                    'condition' => [
                        'plus_column_cursor_point' => 'yes',
                        'plus_pointer_style' => 'follow-text',
                    ],
                ]
            );
            $element->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'pointer_background',
                    'label' => esc_html__( 'Background', 'theplus' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}}.plus_column_{{ID}} .plus-cursor-pointer-follow-text',
                    'condition' => [
                        'plus_column_cursor_point' => 'yes',
                        'plus_pointer_style' => 'follow-text',
                    ],
                ]
            );
            $element->add_control(
                'pointer_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'theplus' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}}.plus_column_{{ID}} .plus-cursor-pointer-follow-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'plus_column_cursor_point' => 'yes',
                        'plus_pointer_style' => 'follow-text',
                    ],
                ]
            );
            $element->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'pointer_box_shadow',
                    'label' => esc_html__( 'Text Box Shadow', 'theplus' ),
                    'selector' => '{{WRAPPER}}.plus_column_{{ID}} .plus-cursor-pointer-follow-text',
                    'condition' => [
                        'plus_column_cursor_point' => 'yes',
                        'plus_pointer_style' => 'follow-text',
                    ],
                ]
            );
			
            $element->end_controls_section();
		}

		/**
		 * Apply Column Mouse Cursor settings before rendering the widget.
		 *
		 * @since 6.2.7
		 */
        public function tp_mouse_cursor_before_render( $element ) {
            $settings = $element->get_settings();

            $plus_column_cursor = ! empty( $settings['plus_column_cursor_point'] ) ? $settings['plus_column_cursor_point'] : '';

            if ( 'yes' === $plus_column_cursor) {
				$cursor_pointer = array();				
				$cursor_pointer['style'] = (!empty($settings['plus_pointer_style'])) ? $settings['plus_pointer_style'] : '';

                if(!empty($settings['plus_pointer_style']) && ($settings['plus_pointer_style'] =='cursor-icon' || $settings['plus_pointer_style'] =='follow-image' ) ){				
					$cursor_pointer['cursor_icon'] = (!empty($settings['plus_pointer_icon']['url'])) ? $settings['plus_pointer_icon']['url'] : '';
					
					if( !empty($settings['plus_column_click_cursor']) && $settings['plus_column_click_cursor'] == 'yes' && !empty($settings['plus_pointer_click_icon']['url']) ){
					
						$cursor_pointer['cursor_see_more'] = 'yes';
						$cursor_pointer['cursor_see_icon'] = (!empty($settings['plus_pointer_click_icon']['url'])) ? $settings['plus_pointer_click_icon']['url'] : '';
						$cursor_pointer['cursor_adjust_left'] = (!empty($settings["plus_pointer_left_offset"]["size"])) ? $settings["plus_pointer_left_offset"]["size"] : 0;
						$cursor_pointer['cursor_adjust_top'] = (!empty($settings["plus_pointer_top_offset"]["size"])) ? $settings["plus_pointer_top_offset"]["size"] : 0;
					}
				}else if(!empty($settings['plus_pointer_style']) && $settings['plus_pointer_style'] =='follow-text'){
					$cursor_pointer['cursor_text'] = (!empty($settings['plus_pointer_text'])) ? $settings['plus_pointer_text'] : '';
					
					if( !empty($settings['plus_column_click_cursor']) && $settings['plus_column_click_cursor'] == 'yes' && !empty($settings['plus_pointer_click_text']) ){
					
						$cursor_pointer['cursor_see_more'] = 'yes';
						$cursor_pointer['cursor_see_text'] = (!empty($settings['plus_pointer_click_text'])) ? $settings['plus_pointer_click_text'] : '';
						$cursor_pointer['cursor_adjust_left'] = (!empty($settings["plus_pointer_left_offset"]["size"])) ? $settings["plus_pointer_left_offset"]["size"] : 0;
						$cursor_pointer['cursor_adjust_top'] = (!empty($settings["plus_pointer_top_offset"]["size"])) ? $settings["plus_pointer_top_offset"]["size"] : 0;
						
					}
					
				}

				if(!empty($settings['plus_pointer_style'])){
					$element->add_render_attribute( '_wrapper', [
						'class' => 'plus_cursor_pointer plus_column_'.$element->get_id().' plus-'.$settings['plus_pointer_style'],
						'data-plus-cursor-settings' => json_encode( $cursor_pointer ),
					] );
				}
			}
            
        }    
	}
}

Tpaep_Mouse_Cursor::get_instance();
