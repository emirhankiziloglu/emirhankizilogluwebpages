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

if ( ! defined( 'WPINC' ) ) {
	exit;
}

/*
 * Colum Width Theplus.
 */
if ( ! class_exists( 'Tpaep_Column_Width' ) ) {

	/**
	 * Define Tpaep_Column_Width class
	 */
	class Tpaep_Column_Width {

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
			return 'custom-width-column';
		}

		/**
		 * Initalize integration hooks
		 *
		 * @since 6.2.7
		 * @return void
		 */
		public function __construct() {

            add_action( 'elementor/element/column/section_advanced/after_section_end', [ $this, 'tp_column_width_controls' ], 10, 2 );

            add_action( 'elementor/frontend/column/before_render', [ $this, 'tp_column_width_before_render'], 10, 1 );
		}

		/**
		 * Register controls for the Column Width feature
		 *
		 * @since 6.2.7
		 */
		public function tp_column_width_controls( $element, $section_id ) {

            $theplus_options = get_option( 'theplus_options' );
            $extras_elements = ! empty( $theplus_options['extras_elements'] ) ? $theplus_options['extras_elements'] : [];

            $element->start_controls_section(
                'plus_column_width_section',
				[
					'label' => esc_html__( 'Column Width', 'theplus' ),
					'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
				]
			);
            if ( in_array( 'order_sort_column', $extras_elements ) ) {
                $element->add_responsive_control(
                    'plus_column_width',
                    [
                        'label' => esc_html__( 'Column Width', 'theplus' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'label_block' => true,
                        'description' => 'E.g. 300px, 40%, calc(100%-400px)',		
                        'separator' => 'before',			
                        'selectors' => [
                            '{{WRAPPER}}' => 'width: {{VALUE}} !important;',
                        ],
                    ]
                );
                $element->add_responsive_control(
                    'plus_column_order',
                    [
                        'label' => esc_html__( 'Column Order', 'theplus' ),
                        'type' => \Elementor\Controls_Manager::NUMBER,
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                        'default' => '',
                        'separator' => 'before',
                        'description' => 'E.g. 0,1,2,3,etc.',
                        'selectors' => [
                            '{{WRAPPER}}' => 'order: {{VALUE}}',
                        ],
                    ]
                );
            }

            if ( in_array( 'custom_width_column', $extras_elements ) ) {
                $element->add_control(
                    'plus_responsive_column_heading',
                    [
                        'label' => esc_html__( 'Responsive Options for Breakpoints', 'theplus' ),
                        'type' => \Elementor\Controls_Manager::HEADING,
                        'separator' => 'before',
                    ]
                );
                $repeater = new \Elementor\Repeater();
                $repeater->add_control(
                    'plus_media_max_width',
                    [
                        'label' => esc_html__( '@Media Max-Width Value', 'theplus' ),
                        'type' => \Elementor\Controls_Manager::SWITCHER,
                        'default' => 'no',
                        'label_on' => 'Yes',
                        'label_off' => 'No',
                        'return_value' => 'yes',
                    ]
                );
                $repeater->add_control(
                    'media_max_width',
                    [
                        'label' => esc_html__( 'Select Max-Width Value(px)', 'theplus' ),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => [ 'px' ],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 3000,
                                'step' => 1,
                            ],
                        ],
                        'default' => [
                            'unit' => 'px',
                            'size' => 0,
                        ],
                        'condition' => [
                            'plus_media_max_width' => 'yes',
                        ],
                    ]
                );
                $repeater->add_control(
                    'plus_media_min_width',
                    [
                        'label' => esc_html__( '@Media Min-Width Value', 'theplus' ),
                        'type' => \Elementor\Controls_Manager::SWITCHER,
                        'default' => 'no',
                        'label_on' => 'Yes',
                        'label_off' => 'No',
                        'return_value' => 'yes',
                    ]
                );
                $repeater->add_control(
                    'media_min_width',
                    [
                        'label' => esc_html__( 'Select Min-Width Value(px)', 'theplus' ),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => [ 'px' ],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 3000,
                                'step' => 1,
                            ],
                        ],
                        'default' => [
                            'unit' => 'px',
                            'size' => 0,
                        ],
                        'condition' => [
                            'plus_media_min_width' => 'yes',
                        ],
                    ]
                );
                $repeater->add_control(
                    'plus_column_width',
                    [
                        'label' => esc_html__( 'Column Width', 'theplus' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'label_block' => true,
                        'description' => 'E.g. 300px, 40%, calc(100%-400px)',
                        'separator' => 'before',
                    ]
                );
                $repeater->add_responsive_control(
                    'plus_column_margin',
                    [
                        'label' => esc_html__( 'Margin', 'theplus' ),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => [ 'px', 'em' ],
                        'selectors' => [
                            '{{WRAPPER}} .your-class' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ]
                );
                $repeater->add_responsive_control(
                    'plus_column_padding',
                    [
                        'label' => esc_html__( 'Padding', 'theplus' ),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => [ 'px', 'em' ],
                        'selectors' => [
                            '{{WRAPPER}} .your-class' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ]
                );
                $repeater->add_control(
                    'plus_column_hide',
                    [
                        'label' => esc_html__( 'Column Visibility', 'theplus' ),
                        'type' => \Elementor\Controls_Manager::SWITCHER,
                        'default' => '',
                        'label_on' => 'Hide',
                        'label_off' => 'Show',
                        'return_value' => 'yes',
                        'separator' => 'before',
                    ]
                );
                $repeater->add_control(
                    'plus_column_order',
                    [
                        'label' => esc_html__( 'Column Order', 'theplus' ),
                        'type' => \Elementor\Controls_Manager::NUMBER,
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                        'default' => '',
                        'separator' => 'before',
                        'description' => 'E.g. 0,1,2,3,etc.',
                    ]
                );
                $element->add_control(
                    'plus_column_responsive_list',
                    [
                        'type'    => \Elementor\Controls_Manager::REPEATER,
                        'fields'  => $repeater->get_controls(),
                        'title_field' => 'Min: {{{plus_media_min_width}}} - Max: {{{plus_media_min_width}}}',
                    ]
                );
            }

            $element->end_controls_section();
		}

        /**
		 * Apply Column Width settings before rendering the widget.
		 *
		 * @since 6.2.7
		 */
        public function tp_column_width_before_render( $element ) {
            $settings = $element->get_settings();

            $theplus_options = get_option( 'theplus_options' );
            $extras_elements = ! empty( $theplus_options['extras_elements'] ) ? $theplus_options['extras_elements'] : [];

            if( in_array( 'custom_width_column', $extras_elements ) ) {
                $column_wrapper_id = $element->get_id();
    
                if ( array_key_exists( 'plus_column_responsive_list', $settings ) ) {
    
                    $list = ! empty( $settings['plus_column_responsive_list'] ) ? $settings['plus_column_responsive_list'] : '';
    
                    if( ! empty( $list[0]['media_max_width']['size'] ) || ! empty( $list[0]['media_min_width']['size'] ) ) {
    
                        $media_query = '@media ';
                        
                        $index = 0;
                        $style = '';
    
                        $max_width = '';
                        $min_width = '';
                        $betwn_and = '';
    
                        foreach ( $list as $item ) {
    
                            $index++;
    
                            $max_width = '';
                            $min_width = '';
                            $betwn_and = '';
    
                            if(!empty($item['media_max_width']['size']) && !empty($item["plus_media_max_width"]) && $item["plus_media_max_width"]=='yes') {
                                $max_width = '(max-width: '.$item['media_max_width']['size'].$item['media_max_width']['unit'].') ';
                            }
                            if(!empty($item['media_min_width']['size']) && !empty($item["plus_media_min_width"]) && $item["plus_media_min_width"]=='yes') {
                                $min_width = ' (min-width: '.$item['media_min_width']['size'].$item['media_min_width']['unit'].') ';
                            }
                            if(!empty($item['media_max_width']['size']) && !empty($item['media_min_width']['size']) && $item["plus_media_max_width"]=='yes' && $item["plus_media_min_width"]=='yes'){
                                $betwn_and =' and ';
                            }
                            $style .= $media_query . $max_width . $betwn_and . $min_width .'{';
                                $style .= '.elementor-element.elementor-column.elementor-element-'.$column_wrapper_id.'{';
                                if(!empty($item['plus_column_width'])){
                                    $style .= 'width : '. $item['plus_column_width'].' !important;';
                                }
                                if(!empty($item['plus_column_hide'])){
                                    $style .= 'display : none;';
                                }
                                if(!empty($item['plus_column_order'])){
                                    $style .= 'order : '.$item['plus_column_order'].';';
                                }
                                
                                $style .= '}';
                                $style .= '.elementor-element.elementor-column.elementor-element-'.$column_wrapper_id.' > .elementor-column{';
                                if(!empty($item['plus_column_margin']["top"]) || !empty($item['plus_column_margin']["right"]) || !empty($item['plus_column_margin']["bottom"]) || !empty($item['plus_column_margin']["left"])){
                                    $top_margin = ($item['plus_column_margin']["top"]) ? $item['plus_column_margin']["top"].$item['plus_column_margin']["unit"] : 0;
                                    $right_margin = ($item['plus_column_margin']["right"]) ? $item['plus_column_margin']["right"].$item['plus_column_margin']["unit"] : 0;
                                    $bottom_margin = ($item['plus_column_margin']["bottom"]) ? $item['plus_column_margin']["bottom"].$item['plus_column_margin']["unit"] : 0;
                                    $left_margin = ($item['plus_column_margin']["left"]) ? $item['plus_column_margin']["left"].$item['plus_column_margin']["unit"] : 0;
                                    
                                    $style .= 'margin : '.$top_margin.' '.$right_margin.' '.$bottom_margin.' '.$left_margin.' !important;';
                                }
                                if(!empty($item['plus_column_padding']["top"]) || !empty($item['plus_column_padding']["right"]) || !empty($item['plus_column_padding']["bottom"]) || !empty($item['plus_column_padding']["left"])){
                                    $top_padding = ($item['plus_column_padding']["top"]) ? $item['plus_column_padding']["top"].$item['plus_column_padding']["unit"] : 0;
                                    $right_padding = ($item['plus_column_padding']["right"]) ? $item['plus_column_padding']["right"].$item['plus_column_padding']["unit"] : 0;
                                    $bottom_padding = ($item['plus_column_padding']["bottom"]) ? $item['plus_column_padding']["bottom"].$item['plus_column_padding']["unit"] : 0;
                                    $left_padding = ($item['plus_column_padding']["left"]) ? $item['plus_column_padding']["left"].$item['plus_column_padding']["unit"] : 0;
                                    
                                    $style .= 'padding : '.$top_padding.' '.$right_padding.' '.$bottom_padding.' '.$left_padding.' !important;';
                                }
                                $style .= '}';
                            
                            $style .= '}';
                            
                        }
                        if( ! empty( $style ) ) {
                            echo '<style>' . $style . '</style>';
                        }
                    }
                }
            }
        }    
	}
}

Tpaep_Column_Width::get_instance();
