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
 * Scroll Animation Theplus.
 */
if ( ! class_exists( 'Tpaep_Scroll_Animation' ) ) {

	/**
	 * Define Tpaep_Scroll_Animation class
	 */
	class Tpaep_Scroll_Animation {

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
			return 'section-scroll-animation';
		}

		/**
		 * Initalize integration hooks
		 *
		 * @since 6.2.7
		 * @return void
		 */
		public function __construct() {

            add_action( 'elementor/element/section/section_advanced/after_section_end', [ $this, 'tp_scroll_animation_controls'], 10, 2 );
			add_action( 'elementor/frontend/section/before_render', [ $this, 'tp_scroll_animation_before_render'], 10, 1 );
			
            if ( \Elementor\Plugin::$instance->experiments->is_feature_active( 'container' ) ) {
				add_action( 'elementor/element/container/section_layout/after_section_end', [ $this, 'tp_scroll_animation_controls'], 10, 2 );
				add_action( 'elementor/frontend/container/before_render', [ $this, 'tp_scroll_animation_before_render'], 10, 1 );
			}
		}

		/**
		 * Register controls for the Scroll Animation feature
		 *
		 * @since 6.2.7
		 */
		public function tp_scroll_animation_controls( $element, $section_id ) {

            $element->start_controls_section(
                'plus_scroll_animation_section',
				[
					'label' => esc_html__( 'Scroll Animation', 'theplus' ),
					'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
				]
			);
			$element->add_control(
				'plus_section_scroll_animation_in',
				[
					'label' => esc_html__( 'In/Entrance Animation', 'theplus' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none'  => esc_html__( 'None', 'theplus' ),						
						'scale-smaller' => esc_html__( 'Scale smaller', 'theplus' ),
						'fade' => esc_html__( 'Fade in', 'theplus' ),
						'rotate-back' => esc_html__( '3D Rotate backward', 'theplus' ),
						'rotate-forward' => esc_html__( '3D Rotate forward', 'theplus' ),
						'carousel' => esc_html__( 'Carousel forward', 'theplus' ),
						'fly-up' => esc_html__( 'Fly up', 'theplus' ),
						'fly-left' => esc_html__( 'Fly left', 'theplus' ),
						'fly-right' => esc_html__( 'Fly right', 'theplus' ),
						'cube' => esc_html__( '3D cube (use 3D cube entrance animation on the next row to make this look good)', 'theplus' ),
					],
				]
			);
			$element->add_control(
				'plus_section_scroll_animation_out',
				[
					'label' => esc_html__( 'Exit Animation', 'theplus' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [						
						'none' => esc_html__( 'None', 'theplus' ),						
						'scale-smaller' => esc_html__( 'Scale smaller', 'theplus' ),
						'fade' => esc_html__( 'Fade out', 'theplus' ),
						'rotate-back' => esc_html__( '3D Rotate backward', 'theplus' ),
						'rotate-forward' => esc_html__( '3D Rotate forward', 'theplus' ),
						'carousel' => esc_html__( 'Carousel forward', 'theplus' ),
						'fly-up' => esc_html__( 'Fly up', 'theplus' ),
						'fly-left' => esc_html__( 'Fly left', 'theplus' ),
						'fly-right' => esc_html__( 'Fly right', 'theplus' ),
						'cube' => esc_html__( '3D cube (use 3D cube entrance animation on the next row to make this look good)', 'theplus' ),
					],
				]
			);
			$element->add_control(
				'plus_section_scroll_in_delay',
				[
					'label' => esc_html__( 'Entrance Delay', 'theplus' ),
					'type' => Controls_Manager::NUMBER,
					'min' => -20,
					'max' => 20,
					'step' => 1,
					'default' => '',
					'description' => esc_html__( 'Add any value from -20 to 20. Tip: Positive numbers lengthen the entrance animation duration, and negative numbers shorten it.','theplus' ),
					'condition' => [
						'plus_section_scroll_animation_in' => ['fly-up','fly-left','fly-right','scale-smaller','fade','rotate-forward','rotate-back'],
					],
				]
			);
			$element->add_control(
				'plus_section_scroll_out_delay',
				[
					'label' => esc_html__( 'Exit Delay', 'theplus' ),
					'type' => Controls_Manager::NUMBER,
					'min' => -20,
					'max' => 20,
					'step' => 1,
					'default' => '',
					'description' => esc_html__( 'The exit animation triggers when your container reaches more than 1/3th of the screen from the top (some effects are different, some are unchangeable). Add any value from -20 to 20.(Tip: Positive numbers lengthen the entrance animation duration, and negative numbers shorten it.)','theplus' ),
					'condition' => [
						'plus_section_scroll_animation_out' => ['fly-up','fly-left','fly-right','scale-smaller','fade','rotate-forward','rotate-back'],
					],
				]
			);
			$element->add_control(
				'plus_section_scroll_overflow',
				[
					'label' => esc_html__( 'Fix Body Overflow', 'theplus' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'theplus' ),
					'label_off' => esc_html__( 'No', 'theplus' ),
					'return_value' => 'yes',
					'default' => 'no',
					'description' => esc_html__('Check this if you see an unwanted scrollbar that shows up for a very short time while scrolling with some effects & some themes.', 'theplus' ),
				]
			);
			$element->add_control(
				'plus_section_scroll_mobile_disable',
				[
					'label' => esc_html__( 'Mobile Disable/Off', 'theplus' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'theplus' ),
					'label_off' => esc_html__( 'No', 'theplus' ),
					'return_value' => 'yes',
					'default' => 'no',
					'description' => esc_html__('Note : If you disable this option, It will be disabled for all sections of page.', 'theplus' ),
				]
			);
            $element->end_controls_section();
		}

		/**
		 * Apply Scroll Animation settings before rendering the widget.
		 *
		 * @since 6.2.7
		 */
        public function tp_scroll_animation_before_render( $element ) {
            $settings = $element->get_settings();

            $scroll_animation_in = ! empty( $settings['plus_section_scroll_animation_in'] ) ? $settings['plus_section_scroll_animation_in'] : '';
			$scroll_animation_out = ! empty( $settings['plus_section_scroll_animation_out'] ) ? $settings['plus_section_scroll_animation_out'] : '';

			$in_delay  = ( $settings['plus_section_scroll_in_delay'] != '' ) ? $settings['plus_section_scroll_in_delay'] : '-5';
			$out_delay = ( $settings['plus_section_scroll_out_delay'] != '' ) ? $settings['plus_section_scroll_out_delay'] : '-5';

			$overflow_section = ( $settings['plus_section_scroll_overflow'] == 'yes' ) ? 'true' : 'false';
			$mobile_disable   = ( $settings['plus_section_scroll_mobile_disable'] == 'yes' ) ? 'true' : 'false';

			if( 'none' !== $scroll_animation_in || 'none' !== $scroll_animation_out ) {

				$element->add_render_attribute( '_wrapper', [
					'class' => 'plus_row_scroll',
					'data-row-exit' => $scroll_animation_out,
					'data-row-entrance' => $scroll_animation_in,
					'data-body-overflow' => $overflow_section,
					'data-row-mobile-off' => $mobile_disable,
				] );

				//cube out
				if($scroll_animation_out=='cube'){
					$element->add_render_attribute( '_wrapper', [
					'data-5p-top-bottom' => 'transform: perspective(1000px) scale(1) rotateX(91deg) translateX(0vw) translateY(0vh);transform-origin: !50% 100%;',
					'data-20p-center-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);transform-origin: !50% 100%;',
					] );
				}

				//fly-up out
				if($scroll_animation_out=='fly-up'){
					$element->add_render_attribute( '_wrapper', [
					'data-top-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(-30vh);',
					'data-'.$out_delay.'p-center-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);',
					] );
				}

				//fly-left out
				if($scroll_animation_out=='fly-left'){
					$element->add_render_attribute( '_wrapper', [
					'data-top-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(-100vw) translateY(0vh);',
					'data-'.$out_delay.'p-center-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);',
					] );
				}

				//fly-right out
				if($scroll_animation_out=='fly-right'){
					$element->add_render_attribute( '_wrapper', [
					'data-top-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(100vw) translateY(0vh);opacity: 0;',
					'data-'.$out_delay.'p-center-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);opacity: 1;',
					] );
				}

				//scale-smaller out
				if($scroll_animation_out=='scale-smaller'){
					$element->add_render_attribute( '_wrapper', [
					'data-top-bottom' => 'transform: perspective(1000px) scale(0.7) rotateX(0deg) translateX(0vw)  translateY(0vh);transform-origin: !50% 100%;opacity: 0.4;',
					'data-'.$out_delay.'p-center-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw)  translateY(0vh);transform-origin: !50% 100%;opacity: 1;',
					] );
				}

				//fade out
				if($scroll_animation_out=='fade'){
					$element->add_render_attribute( '_wrapper', [
					'data-top-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);opacity: 0.0;',
					'data-'.$out_delay.'p-center-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);opacity: 1;',
					] );
				}

				//carousel out
				if($scroll_animation_out=='carousel'){
					$element->add_render_attribute( '_wrapper', [
					'data-top-bottom' => 'transform: perspective(1000px) scale(0.4) rotateX(0deg) translateX(0vw) translateY(50vh);opacity: 1;z-index: 0;',
					'data--1-top-bottom' => 'transform: perspective(1000px) scale(0.4) rotateX(0deg) translateX(0vw) translateY(50vh);opacity: 0;z-index: 0;',
					'data--20p-center-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);opacity: 1;z-index: 0;',
					'data--19.999p-center-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);opacity: 1;z-index: 1;',
					] );
				}

				//stick out
				if($scroll_animation_out=='stick'){
					$element->add_render_attribute( '_wrapper', [
					'data--1-top-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(50vh);transform-origin: !50% 0%;opacity: 0;z-index: 1;',
					'data-top-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(50vh);transform-origin: !50% 0%;opacity: 1;z-index: 1;',
					'data-center-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);transform-origin: !50% 0%;opacity: 1;z-index: 1;',
					'data-smooth-scrolling' => 'off',
					] );
				}

				//stick-fly-left out
				if($scroll_animation_out=='stick-fly-left'){
					$element->add_render_attribute( '_wrapper', [
					'data-top-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(-100vw) translateY(100vh);z-index: 2;opacity: 1;',
					'data-bottom-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);z-index: 2;opacity: 1;',
					'data-1-bottom-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);z-index: 1;opacity: 1;',
					] );
				}

				//stick-fly-right out
				if($scroll_animation_out=='stick-fly-right'){
					$element->add_render_attribute( '_wrapper', [
					'data-top-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(100vw) translateY(100vh);z-index: 2;transform-origin: !50% 50%;opacity: 1;',
					'data-bottom-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);z-index: 2;transform-origin: !50% 50%;opacity: 1;',
					'data-1-bottom-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);z-index: 1;transform-origin: !50% 50%;opacity: 1;',				
					'data-smooth-scrolling-exit' => "off",
					] );
				}

				//stick-fly-down out
				if($scroll_animation_out=='stick-fly-down'){
					$element->add_render_attribute( '_wrapper', [
					'data-top-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(200%);z-index: 2;opacity: 1;transform-origin: !50% 50%;',
					'data-bottom-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);z-index: 2;opacity: 1;transform-origin: !50% 50%;',
					'data-1-bottom-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);z-index: 1;opacity: 1;transform-origin: !50% 50%;',				
					'data--1-top-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);z-index: 1;opacity: 0;transform-origin: !50% 50%;',				
					] );
				}

				//rotate-forward out
				if($scroll_animation_out=='rotate-forward'){
					$element->add_render_attribute( '_wrapper', [
					'data-top-bottom' => 'transform: perspective(1000px) scale(1) rotateX(-70deg) translateX(0vw) translateY(0vh);transform-origin: !50% 100%;opacity: 1;',
					'data-'.$out_delay.'p-center-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);transform-origin: !50% 100%;opacity: 1;',
					] );
				}

				//rotate-back out
				if($scroll_animation_out=='rotate-back'){
					$element->add_render_attribute( '_wrapper', [
					'data-top-bottom' => 'transform: perspective(1000px) scale(1) rotateX(70deg) translateX(0vw) translateY(0vh);transform-origin: !50% 100%;',
					'data-'.$out_delay.'p-center-bottom' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);transform-origin: !50% 100%;',			
					] );
				}

				//cube in
				if($scroll_animation_in=='cube'){
					$element->add_render_attribute( '_wrapper', [
					'data--20p-center-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);transform-origin: !50% 0%;',
					'data--5p-bottom-top' => 'transform: perspective(1000px) scale(1) rotateX(-91deg) translateX(0vw) translateY(0vh);transform-origin: !50% 0%;',
					] );
				}
		
				//fly-up in
				if($scroll_animation_in=='fly-up'){
					$element->add_render_attribute( '_wrapper', [
					'data-'.$in_delay.'p-center-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);transform-origin: !50% 100%;',
					'data-bottom-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(30vh);transform-origin: !50% 100%;',
					] );
				}

				//fly-left in
				if($scroll_animation_in=='fly-left'){
					$element->add_render_attribute( '_wrapper', [
					'data-'.$in_delay.'p-center-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw)  translateY(0vh);',
					'data-bottom-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(100vw)  translateY(0vh);',
					] );
				}

				//fly-right in
				if($scroll_animation_in=='fly-right'){
					$element->add_render_attribute( '_wrapper', [
					'data-'.$in_delay.'p-center-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw)  translateY(0vh);opacity: 1;',
					'data-bottom-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(-100vw)  translateY(0vh);opacity: 1;',
					] );
				}

				//scale-smaller in
				if($scroll_animation_in=='scale-smaller'){
					$element->add_render_attribute( '_wrapper', [
					'data-'.$in_delay.'p-center-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);transform-origin: !50% 0%;opacity: 1;',
					'data-bottom-top' => 'transform: perspective(1000px) scale(1.2) rotateX(0deg) translateX(0vw) translateY(0vh);transform-origin: !50% 0%;opacity: 0.4;',
					] );
				}

				//fade in
				if($scroll_animation_in=='fade'){
					$element->add_render_attribute( '_wrapper', [
					'data-'.$in_delay.'p-center-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);transform-origin: !50% 50%;opacity: 1;',
					'data-bottom-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);transform-origin: !50% 100%;transform-origin: !50% 50%;opacity: 0.0;',
					] );
				}

				//carousel in
				if($scroll_animation_in=='carousel'){
					$element->add_render_attribute( '_wrapper', [
					'data-20p-center-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);opacity: 1;z-index: 0;',
					'data-19.9999p-center-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);opacity: 1;z-index: 1;',
					'data-bottom-top' => 'transform: perspective(1000px) scale(0.4) rotateX(0deg) translateX(0vw) translateY(-50vh);opacity: 1;z-index: 1;',
					'data-1-bottom-top' => 'transform: perspective(1000px) scale(0.4) rotateX(0deg) translateX(0vw) translateY(-50vh);opacity: 0;z-index: 0;',
					] );
				}

				//stick in
				if($scroll_animation_in=='stick'){
					$element->add_render_attribute( '_wrapper', [
					'data-1-top-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);transform-origin: !50% 0%;opacity: 1;z-index: 1;',
					'data-2-top-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);transform-origin: !50% 0%;opacity: 1;z-index: 0;',
					'data-bottom-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(-100vh);transform-origin: !50% 0%;opacity: 1;z-index: 0;',
					'data-1-bottom-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);transform-origin: !50% 0%;opacity: 0;z-index: 0;',
					'data-smooth-scrolling' => 'off',
					] );
				}

				//rotate-forward in
				if($scroll_animation_in=='rotate-forward'){
					$element->add_render_attribute( '_wrapper', [
					'data-'.$in_delay.'p-center-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);transform-origin: !50% 0%;',
					'data-bottom-top' => 'transform: perspective(1000px) scale(1) rotateX(-70deg) translateX(0vw) translateY(0vh);transform-origin: !50% 0%;',			
					] );
				}

				//rotate-back in
				if($scroll_animation_in=='rotate-back'){
					$element->add_render_attribute( '_wrapper', [
					'data-'.$in_delay.'p-center-top' => 'transform: perspective(1000px) scale(1) rotateX(0deg) translateX(0vw) translateY(0vh);transform-origin: !50% 0%;',
					'data-bottom-top' => 'transform: perspective(1000px) scale(1) rotateX(70deg) translateX(0vw) translateY(0vh);transform-origin: !50% 0%;',			
					] );
				}
			}
            
        }    
	}
}

Tpaep_Scroll_Animation::get_instance();
