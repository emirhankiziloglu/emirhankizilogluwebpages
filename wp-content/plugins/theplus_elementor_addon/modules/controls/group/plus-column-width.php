<?php	
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Theplus_Column_Responsive extends Elementor\Widget_Base {

	public function __construct() {
		parent::__construct();
		$this->init();
	}

	public function get_name() {
		return 'plus-column-responsive';
	}

	public function section_register_controls( $element, $section_id ) {
		$plus_extras=theplus_get_option('general','extras_elements');
		
		if($element->get_name() == 'section' || $element->get_name() == 'container') {
		
			$element->start_controls_section(
				'plus_section_responsive_section',
				[
					'label' => esc_html__( 'Plus Extras', 'theplus' ),
					'tab' => Controls_Manager::TAB_ADVANCED,
				]
			);
			if(isset($plus_extras) && (empty($plus_extras) || (!empty($plus_extras) && in_array('section_custom_css',$plus_extras)))){
				$element->add_control(
					'plus_section_overflow_hidden',
					[
						'label' => esc_html__( 'Section Overflow Hidden', 'theplus' ),
						'type' => Controls_Manager::SWITCHER,
						'label_on' => esc_html__( 'Yes', 'theplus' ),
						'label_off' => esc_html__( 'No', 'theplus' ),
						'return_value' => 'yes',
						'default' => 'no',
						'description' => esc_html__('If, Check Yes section scrollbar Overflow Hidden.', 'theplus' ),
						'separator' => 'before',
					]
				);
			}
			$element->end_controls_section();
		}
	}
	
	/**
	 * Before Section Render
	 *
	 */
	public function plus_before_render_section($element) {
		$settings = $element->get_settings();
		//$settings = $element->get_settings_for_display();
		
		$plus_extras=theplus_get_option('general','extras_elements');
		
		if(isset($plus_extras) && (empty($plus_extras) || (!empty($plus_extras) && in_array('section_custom_css',$plus_extras)))){
			
			$section_overflow_hidden= ($settings['plus_section_overflow_hidden']=='yes') ? 'yes' : 'no';			
			if($section_overflow_hidden=='yes'){
				$element->add_render_attribute( '_wrapper', [
					'class' => 'plus_row_scroll_overflow',
				] );
			}
		}
	}
	
	protected function init($data='') {
		$theplus_options=get_option('theplus_options');
		$plus_extras=theplus_get_option('general','extras_elements');
		
		if((isset($plus_extras) && empty($plus_extras) && empty($theplus_options)) || (!empty($plus_extras) && in_array('section_custom_css',$plus_extras))){
			add_action( 'elementor/frontend/section/before_render', [ $this, 'plus_before_render_section'], 10, 1 );

			$experiments_manager = Plugin::$instance->experiments;		
			if($experiments_manager->is_feature_active( 'container' )){
				add_action( 'elementor/frontend/container/before_render', [ $this, 'plus_before_render_section'], 10, 1 );
			}
		}
		
		if((isset($plus_extras) && empty($plus_extras) && empty($theplus_options)) || (!empty($plus_extras) && (in_array('section_custom_css',$plus_extras)))){			
			add_action( 'elementor/element/section/section_advanced/after_section_end', [ $this, 'section_register_controls' ], 10, 2 );

			$experiments_manager = Plugin::$instance->experiments;		
			if($experiments_manager->is_feature_active( 'container' )){
				add_action( 'elementor/element/container/section_layout/after_section_end', [ $this, 'section_register_controls' ], 10, 2  );
			}			
		}
	}

}