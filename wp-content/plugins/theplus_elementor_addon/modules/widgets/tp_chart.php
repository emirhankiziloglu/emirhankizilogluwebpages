<?php
/**
 * Widget Name: Chart
 * Description: Chart
 * Author: Theplus
 * Author URI: https://posimyth.com
 *
 *  @package ThePlus
 */

namespace TheplusAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

use TheplusAddons\Theplus_Element_Load;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class ThePlus_Chart.
 */
class ThePlus_Chart extends Widget_Base {

	public $tp_doc = THEPLUS_TPDOC;

	/**
	 * Helpdesk Link For Need help.
	 *
	 * @var tp_help of the class.
	 */
	public $tp_help = THEPLUS_HELP;

	/**
	 * Get Widget Name.
	 *
	 * @since 1.0.0
	 * @version 5.4.2
	 */
	public function get_name() {
		return 'tp-chart';
	}

	/**
	 * Get Widget Title.
	 *
	 * @since 1.0.0
	 * @version 5.4.2
	 */
	public function get_title() {
		return esc_html__( 'Chart', 'theplus' );
	}

	/**
	 * Get Widget Icon.
	 *
	 * @since 1.0.0
	 * @version 5.4.2
	 */
	public function get_icon() {
		return 'fa fa-area-chart theplus_backend_icon';
	}

	/**
	 * Get Widget Category.
	 *
	 * @since 1.0.0
	 * @version 5.4.2
	 */
	public function get_categories() {
		return array( 'plus-essential' );
	}

	/**
	 * Get Widget Keyword.
	 *
	 * @since 1.0.0
	 * @version 5.4.2
	 */
	public function get_keywords() {
		return array( 'Advanced Chart', 'Chart Widget', 'Elementor Chart', 'Graph Widget', 'Elementor Graph', 'Data Visualization Widget', 'Elementor Data Visualization', 'Advanced Data Visualization', 'Interactive Chart', 'Interactive Graph', 'Elementor Addon Chart', 'Elementor Addon Graph' );
	}

	/**
	 * Get Custom URL.
	 *
	 * @since 1.0.0
	 * @version 5.6.5
	 */
	public function get_custom_help_url() {
		$help_url = $this->tp_help;

		return esc_url( $help_url );
	}

	/**
	 * Register controls.
	 *
	 * @since 1.0.0
	 * @version 5.4.2
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'chart_tab_content',
			array(
				'label' => esc_html__( 'Chart', 'theplus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'smart-preset-button',
			array(
                'type'=> Controls_Manager::RAW_HTML,
                'raw' => sprintf(
					'<div class="tpae-preset-main-raw-main">
						<a href="%s" class="tp-preset-live-demo" id="tp-preset-live-demo" data-temp_id="12558" target="_blank" rel="noopener noreferrer">%s</a>
						<a class="tp-preset-editor-raw" id="tp-preset-editor-raw" data-temp_id="12558">%s</a>
					</div>',
					esc_url('https://theplusaddons.com/widgets/elementor-advanced-charts/'),
					esc_html__('Live Demo', 'theplus'),
					esc_html__('Import Presets', 'theplus')
				),
                'label_block'     => true,
            )
		);
		$this->add_control(
			'select_chart_type',
			array(
				'label'              => esc_html__( 'Chart Type', 'theplus' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'custom',
				'options'            => array(
					'custom'   => esc_html__( 'Custom', 'theplus' ),
					'csv_file' => esc_html__( 'CSV File', 'theplus' ),
					'g_sheet'  => esc_html__( 'Google Sheet', 'theplus' ),
				),
				'frontend_available' => true,
			)
		);
		$this->add_control(
			'csv_url',
			array(
				'label'         => wp_kses_post( 'Enter a CSV File URL', 'theplus' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'Add URL', 'theplus' ),
				'show_external' => false,
				'label_block'   => true,
				'default'       => array(
					'url' => '',
				),
				'options'       => false,
				'condition'     => array(
					'select_chart_type' => 'csv_file',
				),
			)
		);
		$this->add_control(
			'gs_apikey',
			array(
				'label'       => esc_html__( 'API Key', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter API Key', 'theplus' ),
				'ai'          => false,
				'condition'   => array(
					'select_chart_type' => 'g_sheet',
				),
			)
		);
		$this->add_control(
			'gs_sheetid',
			array(
				'label'       => esc_html__( 'Sheet ID', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Sheet ID', 'theplus' ),
				'ai'          => false,
				'condition'   => array(
					'select_chart_type' => 'g_sheet',
				),
			)
		);
		$this->add_control(
			'gs_tablerange',
			array(
				'label'       => esc_html__( 'Table Range', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Table Range', 'theplus' ),
				'ai'          => false,
				'condition'   => array(
					'select_chart_type' => 'g_sheet',
				),
			)
		);
		$this->add_control(
			'select_chart',
			array(
				'label'   => esc_html__( 'Select Chart', 'theplus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'line',
				'options' => array(
					'line'      => esc_html__( 'Line', 'theplus' ),
					'bar'       => esc_html__( 'Bar', 'theplus' ),
					'radar'     => esc_html__( 'Radar', 'theplus' ),
					'pie'       => esc_html__( 'Doughnut & Pie', 'theplus' ),
					'polarArea' => esc_html__( 'Polar Area', 'theplus' ),
					'bubble'    => esc_html__( 'Bubble', 'theplus' ),
				),
				'frontend_available' => true,
			)
		);
		$this->add_control(
			'how_it_works_bubble',
			array(
				'label'     => wp_kses_post( "<a class='tp-docs-link' href='" . esc_url( $this->tp_doc ) . "bubble-chart-in-elementor/?utm_source=wpbackend&utm_medium=elementoreditor&utm_campaign=widget' target='_blank' rel='noopener noreferrer'> How it works <i class='eicon-help-o'></i> </a>" ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'select_chart' => array( 'bubble' ),
				),
			)
		);
		$this->add_control(
			'how_it_works_polarArea',
			array(
				'label'     => wp_kses_post( "<a class='tp-docs-link' href='" . esc_url( $this->tp_doc ) . "polar-area-graph-in-elementor/?utm_source=wpbackend&utm_medium=elementoreditor&utm_campaign=widget' target='_blank' rel='noopener noreferrer'> How it works <i class='eicon-help-o'></i> </a>" ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'select_chart' => array( 'polarArea' ),
				),
			)
		);
		$this->add_control(
			'how_it_works_pie',
			array(
				'label'     => wp_kses_post( "<a class='tp-docs-link' href='" . esc_url( $this->tp_doc ) . "pie-chart-in-elementor/?utm_source=wpbackend&utm_medium=elementoreditor&utm_campaign=widget' target='_blank' rel='noopener noreferrer'> How it works <i class='eicon-help-o'></i> </a>" ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'select_chart' => array( 'pie' ),
				),
			)
		);
		$this->add_control(
			'how_it_works_radar',
			array(
				'label'     => wp_kses_post( "<a class='tp-docs-link' href='" . esc_url( $this->tp_doc ) . "radar-chart-in-elementor/?utm_source=wpbackend&utm_medium=elementoreditor&utm_campaign=widget' target='_blank' rel='noopener noreferrer'> How it works <i class='eicon-help-o'></i> </a>" ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'select_chart' => array( 'radar' ),
				),
			)
		);
		$this->add_control(
			'how_it_works_bar',
			array(
				'label'     => wp_kses_post( "<a class='tp-docs-link' href='" . esc_url( $this->tp_doc ) . "bar-graph-in-elementor/?utm_source=wpbackend&utm_medium=elementoreditor&utm_campaign=widget' target='_blank' rel='noopener noreferrer'> How it works <i class='eicon-help-o'></i> </a>" ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'select_chart' => array( 'bar' ),
				),
			)
		);
		$this->add_control(
			'bar_chart_type',
			array(
				'label'     => esc_html__( 'Orientation', 'theplus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'vertical_bar',
				'options'   => array(
					'vertical_bar'   => esc_html__( 'Vertical Bar', 'theplus' ),
					'horizontal_bar' => esc_html__( 'Horizontal Bar', 'theplus' ),
				),
				'condition' => array(
					'select_chart' => 'bar',
				),
			)
		);
		$this->add_control(
			'doughnut_pie_chart_type',
			array(
				'label'     => esc_html__( 'Orientation', 'theplus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'pie',
				'options'   => array(
					'pie'      => esc_html__( 'Pie', 'theplus' ),
					'doughnut' => esc_html__( 'Doughnut', 'theplus' ),
				),
				'condition' => array(
					'select_chart' => 'pie',
				),
			)
		);
		$this->add_control(
			'main_label',
			array(
				'label'       => esc_html__( 'Label Values', 'theplus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Jan | Feb | Mar', 'theplus' ),
				'placeholder' => esc_html__( 'Seprate by | ', 'theplus' ),
				'dynamic'     => array( 'active' => true ),
				'condition'   => array(
					'select_chart_type' => 'custom',
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'chart_dataset',
			array(
				'label'     => esc_html__( 'Dataset', 'theplus' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'select_chart'      => array( 'line', 'bar', 'radar' ),
					'select_chart_type' => 'custom',
				),
			)
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'loop_label',
			array(
				'label'       => esc_html__( 'Label', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Label', 'theplus' ),
				'placeholder' => esc_html__( 'Enter label', 'theplus' ),
				'dynamic'     => array( 'active' => true ),

			)
		);
		$repeater->add_control(
			'loop_data',
			array(
				'label'       => esc_html__( 'Data', 'theplus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '0 | 25 | 42', 'theplus' ),
				'placeholder' => esc_html__( 'Seprate by | ', 'theplus' ),
				'dynamic'     => array( 'active' => true ),
				'separator'   => 'before',
			)
		);
		$repeater->add_control(
			'multi_dot_bg',
			array(
				'label'        => esc_html__( 'Multiple Dot Background', 'theplus' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'theplus' ),
				'label_off'    => esc_html__( 'Off', 'theplus' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before',
			)
		);
		$repeater->add_control(
			'dot_bg',
			array(
				'label'     => esc_html__( 'Dot Background', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgb(0 0 0 / 50%)',
				'condition' => array(
					'multi_dot_bg!' => 'yes',
				),
			)
		);
		$repeater->add_control(
			'multi_dot_bg_multiple',
			array(
				'label'       => esc_html__( 'Dot Background', 'theplus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '#f7d78299|#6fc78499|#8072fc99', 'theplus' ),
				'placeholder' => esc_html__( 'Seprate by | ', 'theplus' ),
				'dynamic'     => array( 'active' => true ),
				'condition'   => array(
					'multi_dot_bg' => 'yes',
				),
			)
		);
		$repeater->add_control(
			'multi_dot_border',
			array(
				'label'        => esc_html__( 'Multiple Border', 'theplus' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'theplus' ),
				'label_off'    => esc_html__( 'Off', 'theplus' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before',
			)
		);
		$repeater->add_control(
			'dot_border',
			array(
				'label'     => esc_html__( 'Dot Border', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgb(0 0 0 / 50%)',
				'condition' => array(
					'multi_dot_border!' => 'yes',
				),
			)
		);
		$repeater->add_control(
			'multi_dot_border_multiple',
			array(
				'label'       => esc_html__( 'Dot Border', 'theplus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '#f7d78299|#6fc78499|#8072fc99', 'theplus' ),
				'placeholder' => esc_html__( 'Seprate by | ', 'theplus' ),
				'dynamic'     => array( 'active' => true ),
				'condition'   => array(
					'multi_dot_border' => 'yes',
				),
			)
		);
		$repeater->add_control(
			'fill_opt',
			array(
				'label'       => esc_html__( 'Fill', 'theplus' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Enable', 'theplus' ),
				'label_off'   => esc_html__( 'Disable', 'theplus' ),
				'default'     => 'yes',
				'description' => esc_html__( 'Note : Fill works in Line and Radar chart', 'theplus' ),
				'separator'   => 'before',
			)
		);
		$repeater->add_control(
			'line_styling_opt',
			array(
				'label'       => esc_html__( 'Border Dash', 'theplus' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Enable', 'theplus' ),
				'label_off'   => esc_html__( 'Disable', 'theplus' ),
				'default'     => 'no',
				'description' => esc_html__( 'Note : Border Dash works in Line and Radar chart', 'theplus' ),
				'separator'   => 'before',
			)
		);
		$this->add_control(
			'chart_content',
			array(
				'label'       => esc_html__( 'Chart Data Boxes', 'theplus' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'loop_label' => esc_html__( 'Jan', 'theplus' ),
						'loop_data'  => esc_html__( '25 | 15 | 30 ', 'theplus' ),
						'dot_bg'     => '#f7d78299',
						'dot_border' => '#f7d78299',
					),
					array(
						'loop_label' => esc_html__( 'Feb', 'theplus' ),
						'loop_data'  => esc_html__( '12 | 18 | 28', 'theplus' ),
						'dot_bg'     => '#6fc78499',
						'dot_border' => '#6fc78499',
					),
					array(
						'loop_label' => esc_html__( 'Mar', 'theplus' ),
						'loop_data'  => esc_html__( '11 | 20 | 40', 'theplus' ),
						'dot_bg'     => '#8072fc99',
						'dot_border' => '#8072fc99',
					),
				),
				'title_field' => '{{{ loop_label }}}',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'chart_dataset_alone',
			array(
				'label'      => esc_html__( 'Dataset', 'theplus' ),
				'tab'        => Controls_Manager::TAB_CONTENT,
				'condition'  => array(
					'select_chart_type' => 'custom',
				),
				'conditions' => array(
					'terms' => array(
						array(
							'relation' => 'or',
							'terms'    => array(
								array(
									'name'     => 'select_chart',
									'operator' => '==',
									'value'    => 'polarArea',
								),
								array(
									'terms' => array(
										array(
											'name'  => 'select_chart',
											'value' => 'pie',
										),
										array(
											'name'  => 'doughnut_pie_chart_type',
											'value' => 'pie',
										),
									),
								),
							),
						),
					),
				),
			)
		);
		$this->add_control(
			'alone_data',
			array(
				'label'       => esc_html__( 'Data', 'theplus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '10 | 15 | 20', 'theplus' ),
				'placeholder' => esc_html__( 'Seprate by | ', 'theplus' ),
				'dynamic'     => array( 'active' => true ),
				'separator'   => 'before',
			)
		);
		$this->add_control(
			'alone_bg_colors',
			array(
				'label'       => esc_html__( 'Background Colors', 'theplus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '#f7d78299|#6fc78499|#8072fc99', 'theplus' ),
				'placeholder' => esc_html__( 'Seprate by | ', 'theplus' ),
				'dynamic'     => array( 'active' => true ),
				'separator'   => 'before',
			)
		);
		$this->add_control(
			'alone_border_colors',
			array(
				'label'       => esc_html__( 'Border Colors', 'theplus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '#f7d78299|#6fc78499|#8072fc99', 'theplus' ),
				'placeholder' => esc_html__( 'Seprate by | ', 'theplus' ),
				'dynamic'     => array( 'active' => true ),
				'separator'   => 'before',
				'conditions'  => array(
					'terms' => array(
						array(
							'relation' => 'or',
							'terms'    => array(
								array(
									'terms' => array(
										array(
											'name'  => 'select_chart',
											'value' => 'pie',
										),
										array(
											'name'  => 'doughnut_pie_chart_type',
											'value' => 'pie',
										),
									),
								),
							),
						),
					),
				),
			)
		);
		$this->add_control(
			'alone_border_colors_polar',
			array(
				'label'       => esc_html__( 'Border Colors', 'theplus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '#f7d78299|#6fc78499|#8072fc99', 'theplus' ),
				'placeholder' => esc_html__( 'Seprate by | ', 'theplus' ),
				'dynamic'     => array( 'active' => true ),
				'separator'   => 'before',
				'conditions'  => array(
					'terms' => array(
						array(
							'relation' => 'or',
							'terms'    => array(
								array(
									'terms' => array(
										array(
											'name'  => 'select_chart',
											'value' => 'polarArea',
										),
									),
								),
							),
						),
					),
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'doughnut_chart_dataset',
			array(
				'label'     => esc_html__( 'Dataset', 'theplus' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'select_chart_type'       => 'custom',
					'select_chart'            => 'pie',
					'doughnut_pie_chart_type' => 'doughnut',
				),
			)
		);
		$repeater2 = new \Elementor\Repeater();
		$repeater2->add_control(
			'doughnut_loop_label',
			array(
				'label'       => esc_html__( 'Label', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Label', 'theplus' ),
				'placeholder' => esc_html__( 'Enter label', 'theplus' ),
				'dynamic'     => array( 'active' => true ),

			)
		);
		$repeater2->add_control(
			'doughnut_loop_data',
			array(
				'label'       => esc_html__( 'Data', 'theplus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '10 | 15 | 20', 'theplus' ),
				'placeholder' => esc_html__( 'Seprate by | ', 'theplus' ),
				'dynamic'     => array( 'active' => true ),
				'separator'   => 'before',
			)
		);
		$repeater2->add_control(
			'doughnut_loop_background',
			array(
				'label'       => esc_html__( 'Background Colors', 'theplus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '#ff5a6e99|#8072fc99|#6fc78499', 'theplus' ),
				'placeholder' => esc_html__( 'Seprate by | ', 'theplus' ),
				'dynamic'     => array( 'active' => true ),
				'separator'   => 'before',
			)
		);
		$repeater2->add_control(
			'doughnut_loop_border',
			array(
				'label'       => esc_html__( 'Border Colors', 'theplus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '#00000099|#00000099|#00000099', 'theplus' ),
				'placeholder' => esc_html__( 'Seprate by | ', 'theplus' ),
				'dynamic'     => array( 'active' => true ),
				'separator'   => 'before',
			)
		);
		$this->add_control(
			'doughnut_chart_datasets',
			array(
				'label'       => esc_html__( 'Chart Data Boxes', 'theplus' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater2->get_controls(),
				'default'     => array(
					array(
						'doughnut_loop_label'      => esc_html__( 'Jan', 'theplus' ),
						'doughnut_loop_data'       => esc_html__( '25 | 15 | 30 ', 'theplus' ),
						'doughnut_loop_background' => '#ff5a6e99|#8072fc99|#6fc78499',
						'doughnut_loop_border'     => '#00000099|#00000099|#00000099',
					),
					array(
						'doughnut_loop_label'      => esc_html__( 'Feb', 'theplus' ),
						'doughnut_loop_data'       => esc_html__( '12 | 18 | 28', 'theplus' ),
						'doughnut_loop_background' => '#f7d78299|#6fc78499|#8072fc99',
						'doughnut_loop_border'     => '#40e0d0|#40e0d0|#40e0d0',
					),
					array(
						'doughnut_loop_label'      => esc_html__( 'Mar', 'theplus' ),
						'doughnut_loop_data'       => esc_html__( '11 | 20 | 40', 'theplus' ),
						'doughnut_loop_background' => '#71d1dc99|#8072fc99|#ff5a6e99',
						'doughnut_loop_border'     => '#00000099|#00000099|#00000099',
					),
				),
				'title_field' => '{{{ doughnut_loop_label }}}',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'chart_dataset_bubble',
			array(
				'label'     => esc_html__( 'Datasets', 'theplus' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'select_chart_type' => 'custom',
					'select_chart'      => 'bubble',
				),
			)
		);
		$repeater1 = new \Elementor\Repeater();
		$repeater1->add_control(
			'loop_label',
			array(
				'label'       => esc_html__( 'Label', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Label', 'theplus' ),
				'placeholder' => esc_html__( 'Enter label', 'theplus' ),
				'dynamic'     => array( 'active' => true ),

			)
		);
		$repeater1->add_control(
			'bubble_data',
			array(
				'label'       => esc_html__( 'Data', 'theplus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '[5|15|15][10|18|12][7|14|14]', 'theplus' ),
				'placeholder' => esc_html__( 'Seprate by | ', 'theplus' ),
				'dynamic'     => array( 'active' => true ),
				'separator'   => 'before',
			)
		);
		$repeater1->add_control(
			'multi_dot_bg',
			array(
				'label'        => esc_html__( 'Multiple Background Colors', 'theplus' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'theplus' ),
				'label_off'    => esc_html__( 'Off', 'theplus' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before',
			)
		);
		$repeater1->add_control(
			'dot_bg',
			array(
				'label'     => esc_html__( 'Background', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgb(0 0 0 / 50%)',
				'condition' => array(
					'multi_dot_bg!' => 'yes',
				),
			)
		);
		$repeater1->add_control(
			'multi_dot_bg_multiple',
			array(
				'label'       => esc_html__( 'Background', 'theplus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '#f7d78299|#6fc78499|#8072fc99', 'theplus' ),
				'placeholder' => esc_html__( 'Seprate by | ', 'theplus' ),
				'dynamic'     => array( 'active' => true ),
				'condition'   => array(
					'multi_dot_bg' => 'yes',
				),
			)
		);
		$repeater1->add_control(
			'multi_dot_border',
			array(
				'label'        => esc_html__( 'Multiple Border Colors', 'theplus' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'theplus' ),
				'label_off'    => esc_html__( 'Off', 'theplus' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before',
			)
		);
		$repeater1->add_control(
			'dot_border',
			array(
				'label'     => esc_html__( 'Dot Border', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgb(0 0 0 / 50%)',
				'condition' => array(
					'multi_dot_border!' => 'yes',
				),
			)
		);
		$repeater1->add_control(
			'multi_dot_border_multiple',
			array(
				'label'       => esc_html__( 'Dot Background Colors', 'theplus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '#f7d78299|#6fc78499|#8072fc99', 'theplus' ),
				'placeholder' => esc_html__( 'Seprate by | ', 'theplus' ),
				'dynamic'     => array( 'active' => true ),
				'condition'   => array(
					'multi_dot_border' => 'yes',
				),
			)
		);
		$this->add_control(
			'bubble_content',
			array(
				'label'       => esc_html__( 'Chart Data Boxes', 'theplus' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater1->get_controls(),
				'default'     => array(
					array(
						'loop_label'  => esc_html__( 'Jan', 'theplus' ),
						'bubble_data' => esc_html__( '[5|15|15][10|18|12][7|14|14]', 'theplus' ),
						'dot_bg'      => '#f7d78299',
						'dot_border'  => '#f7d78299',
					),
					array(
						'loop_label'  => esc_html__( 'Feb', 'theplus' ),
						'bubble_data' => esc_html__( '[7|10|16][15|14|18][15|17|12]', 'theplus' ),
						'dot_bg'      => '#6fc78499',
						'dot_border'  => '#6fc78499',
					),
					array(
						'loop_label'  => esc_html__( 'Mar', 'theplus' ),
						'bubble_data' => esc_html__( '[9|20|12][8|16|16][14|24|20]', 'theplus' ),
						'dot_bg'      => '#8072fc99',
						'dot_border'  => '#8072fc99',
					),
				),
				'title_field' => '{{{ loop_label }}}',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'chart_extra_options',
			array(
				'label' => esc_html__( 'Extra Options', 'theplus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_responsive_control(
			'maxbarthickness',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Bar Size', 'theplus' ),
				'range'     => array(
					'px' => array(
						'min'  => 1,
						'max'  => 50,
						'step' => 1,
					),
				),
				'condition' => array(
					'select_chart' => 'bar',
				),
			)
		);
		$this->add_responsive_control(
			'barthickness',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Bar Space', 'theplus' ),
				'range'     => array(
					'px' => array(
						'min'  => 1,
						'max'  => 50,
						'step' => 1,
					),
				),
				'separator' => 'after',
				'condition' => array(
					'select_chart' => 'bar',
				),
			)
		);
		$this->add_control(
			'show_grid_lines',
			array(
				'label'     => esc_html__( 'Grid Lines', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default'   => 'yes',
				'condition' => array(
					'select_chart!' => 'pie',
				),
			)
		);
		$this->start_controls_tabs(
			'tabs_axes_style',
			array(
				'condition' => array(
					'select_chart!'   => 'pie',
					'show_grid_lines' => 'yes',
				),
			)
		);
		$this->start_controls_tab(
			'tab_axes_x',
			array(
				'label'     => esc_html__( 'X-Axis', 'theplus' ),
				'condition' => array(
					'select_chart!'   => 'pie',
					'show_grid_lines' => 'yes',
				),
			)
		);
		$this->add_control(
			'grid_color',
			array(
				'label'     => esc_html__( 'Grid Color X-Axis', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgb(0 0 0 / 50%)',
				'condition' => array(
					'select_chart!'   => 'pie',
					'show_grid_lines' => 'yes',
				),
			)
		);
		$this->add_control(
			'zero_linecolor_x',
			array(
				'label'     => esc_html__( 'Zero Line Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0.25)',
				'condition' => array(
					'select_chart!'   => 'pie',
					'show_grid_lines' => 'yes',
				),
			)
		);
		$this->add_control(
			'draw_border_x',
			array(
				'label'     => esc_html__( 'Draw Border', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default'   => 'no',
				'condition' => array(
					'select_chart!'   => 'pie',
					'show_grid_lines' => 'yes',
				),
			)
		);
		$this->add_control(
			'draw_on_chart_area_x',
			array(
				'label'     => esc_html__( 'Draw Border on Chart Area', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default'   => 'yes',
				'condition' => array(
					'select_chart!'   => 'pie',
					'show_grid_lines' => 'yes',
				),
			)
		);
		$this->add_control(
			'begin_atzero_x',
			array(
				'label'     => esc_html__( 'Begin At Zero', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default'   => 'no',
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_axes_y',
			array(
				'label'     => esc_html__( 'Y-Axis', 'theplus' ),
				'condition' => array(
					'select_chart!'   => 'pie',
					'show_grid_lines' => 'yes',
				),
			)
		);
		$this->add_control(
			'grid_color_xAxes',
			array(
				'label'     => esc_html__( 'Grid Color Y-Axis', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgb(0 0 0 / 50%)',
				'condition' => array(
					'select_chart!'   => 'pie',
					'show_grid_lines' => 'yes',
				),
			)
		);
		$this->add_control(
			'zero_linecolor_y',
			array(
				'label'     => esc_html__( 'Zero Line Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0.25)',
				'condition' => array(
					'select_chart!'   => 'pie',
					'show_grid_lines' => 'yes',
				),
			)
		);
		$this->add_control(
			'draw_border_y',
			array(
				'label'     => esc_html__( 'Draw Border', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default'   => 'no',
				'condition' => array(
					'select_chart!'   => 'pie',
					'show_grid_lines' => 'yes',
				),
			)
		);
		$this->add_control(
			'draw_on_chart_area_y',
			array(
				'label'     => esc_html__( 'Draw Border on Chart Area', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default'   => 'yes',
				'condition' => array(
					'select_chart!'   => 'pie',
					'show_grid_lines' => 'yes',
				),
			)
		);
		$this->add_control(
			'begin_atzero_y',
			array(
				'label'     => esc_html__( 'Begin At Zero', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default'   => 'no',
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'show_labels',
			array(
				'label'     => esc_html__( 'Labels', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default'   => 'yes',
				'separator' => 'before',
				'condition' => array(
					'select_chart!' => 'pie',
				),
			)
		);
		$this->add_control(
			'show_labels_color',
			array(
				'label'     => esc_html__( 'Label Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666',
				'condition' => array(
					'select_chart!' => 'pie',
					'show_labels'   => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'show_labels_size',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Label Size', 'theplus' ),
				'range'     => array(
					'px' => array(
						'min'  => 1,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'   => array(
					'size' => 12,
				),
				'separator' => 'after',
				'condition' => array(
					'select_chart!' => 'pie',
					'show_labels'   => 'yes',
				),
			)
		);
		$this->add_control(
			'show_legend',
			array(
				'label'     => esc_html__( 'Legend', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default'   => 'yes',
			)
		);
		$this->add_responsive_control(
			'show_legend_size',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Size', 'theplus' ),
				'range'     => array(
					'px' => array(
						'min'  => 1,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'   => array(
					'size' => 12,
				),
				'condition' => array(
					'show_legend' => 'yes',
				),
			)
		);
		$this->add_control(
			'show_legend_color',
			array(
				'label'     => esc_html__( 'Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666',
				'condition' => array(
					'show_legend' => 'yes',
				),
			)
		);
		$this->add_control(
			'show_legend_position',
			array(
				'label'     => esc_html__( 'Position', 'theplus' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'theplus' ),
						'icon'  => 'eicon-text-align-left',
					),
					'top'    => array(
						'title' => esc_html__( 'Top', 'theplus' ),
						'icon'  => 'eicon-v-align-top',
					),
					'bottom' => array(
						'title' => esc_html__( 'Bottom', 'theplus' ),
						'icon'  => 'eicon-v-align-bottom',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'theplus' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'top',
				'condition' => array(
					'show_legend' => 'yes',
				),
			)
		);
		$this->add_control(
			'show_legend_align',
			array(
				'label'     => esc_html__( 'Alignment', 'theplus' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'start'  => array(
						'title' => esc_html__( 'Start', 'theplus' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'theplus' ),
						'icon'  => 'eicon-text-align-center',
					),
					'end'    => array(
						'title' => esc_html__( 'End', 'theplus' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'condition' => array(
					'show_legend' => 'yes',
				),
			)
		);
		$this->add_control(
			'tension',
			array(
				'label'     => esc_html__( 'Smooth', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default'   => 'yes',
				'separator' => 'before',
				'condition' => array(
					'select_chart' => 'line',
				),
			)
		);
		$this->add_control(
			'custom_point_styles',
			array(
				'label'     => esc_html__( 'Custom Point Styles', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default'   => 'no',
				'separator' => 'before',
				'condition' => array(
					'select_chart' => array( 'line', 'radar', 'bubble' ),
				),
			)
		);
		$this->add_control(
			'point_styles',
			array(
				'label'     => esc_html__( 'Point Styles', 'theplus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'circle',
				'options'   => array(
					'circle'      => esc_html__( 'Circle', 'theplus' ),
					'cross'       => esc_html__( 'Cross', 'theplus' ),
					'crossRot'    => esc_html__( 'CrossRot', 'theplus' ),
					'dash'        => esc_html__( 'Dash', 'theplus' ),
					'line'        => esc_html__( 'Line', 'theplus' ),
					'rect'        => esc_html__( 'Rect', 'theplus' ),
					'rectRounded' => esc_html__( 'RectRounded', 'theplus' ),
					'rectRot'     => esc_html__( 'RectRot', 'theplus' ),
					'star'        => esc_html__( 'Star', 'theplus' ),
					'triangle'    => esc_html__( 'Triangle', 'theplus' ),
				),
				'condition' => array(
					'select_chart'        => array( 'line', 'radar', 'bubble' ),
					'custom_point_styles' => 'yes',
				),
			)
		);
		$this->add_control(
			'point_bg',
			array(
				'label'     => esc_html__( 'Point Background', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff5a6e99',
				'condition' => array(
					'select_chart'        => array( 'line', 'radar' ),
					'custom_point_styles' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'point_n_size',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Point Normal Size', 'theplus' ),
				'range'     => array(
					'px' => array(
						'min'  => 1,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'   => array(
					'size' => 5,
				),
				'condition' => array(
					'select_chart'        => array( 'line', 'radar' ),
					'custom_point_styles' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'point_h_size',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Point Hover Size', 'theplus' ),
				'range'     => array(
					'px' => array(
						'min'  => 1,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'   => array(
					'size' => 10,
				),
				'condition' => array(
					'select_chart'        => array( 'line', 'radar' ),
					'custom_point_styles' => 'yes',
				),
			)
		);
		$this->add_control(
			'point_border_color',
			array(
				'label'     => esc_html__( 'Point Border', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#00000099',
				'condition' => array(
					'select_chart'        => array( 'line', 'radar' ),
					'custom_point_styles' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'point_border_width',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Point Border Width', 'theplus' ),
				'range'     => array(
					'px' => array(
						'min'  => 1,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'   => array(
					'size' => 1,
				),
				'condition' => array(
					'select_chart'        => array( 'line', 'radar' ),
					'custom_point_styles' => 'yes',
				),
			)
		);
		$this->add_control(
			'show_tooltip',
			array(
				'label'     => esc_html__( 'Tooltip', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default'   => 'yes',
				'separator' => 'before',
			)
		);
		$this->add_control(
			'tooltip_event',
			array(
				'label'     => esc_html__( 'Event', 'theplus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'mousemove',
				'options'   => array(
					'mousemove' => esc_html__( 'Hover', 'theplus' ),
					'click'     => esc_html__( 'Click', 'theplus' ),
				),
				'condition' => array(
					'show_tooltip' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'tooltip_font_size',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Font Size', 'theplus' ),
				'range'     => array(
					'px' => array(
						'min'  => 1,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'   => array(
					'size' => 12,
				),
				'condition' => array(
					'show_tooltip' => 'yes',
				),
			)
		);
		$this->add_control(
			'tooltip_color',
			array(
				'label'     => esc_html__( 'Title Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'condition' => array(
					'show_tooltip' => 'yes',
				),
			)
		);
		$this->add_control(
			'tooltip_body_color',
			array(
				'label'     => esc_html__( 'Body Font Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'condition' => array(
					'show_tooltip' => 'yes',
				),
			)
		);
		$this->add_control(
			'tooltip_bg',
			array(
				'label'     => esc_html__( 'Tooltip Background', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'show_tooltip' => 'yes',
				),
			)
		);
		$this->add_control(
			'aspect_ratio',
			array(
				'label'     => esc_html__( 'Aspect Ratio', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default'   => 'no',
				'separator' => 'before',
			)
		);
		$this->add_control(
			'maintain_aspect_ratio',
			array(
				'label'     => esc_html__( 'Maintain Aspect Ratio', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default'   => 'yes',
			)
		);
		$this->add_control(
			'c_animation',
			array(
				'label'     => esc_html__( 'Animation', 'theplus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'easeOutQuart',
				'options'   => array(
					'linear'           => esc_html__( 'linear', 'theplus' ),
					'easeInQuad'       => esc_html__( 'easeInQuad', 'theplus' ),
					'easeOutQuad'      => esc_html__( 'easeOutQuad', 'theplus' ),
					'easeInOutQuad'    => esc_html__( 'easeInOutQuad', 'theplus' ),
					'easeInCubic'      => esc_html__( 'easeInCubic', 'theplus' ),
					'easeOutCubic'     => esc_html__( 'easeOutCubic', 'theplus' ),
					'easeInOutCubic'   => esc_html__( 'easeInOutCubic', 'theplus' ),
					'easeInQuart'      => esc_html__( 'easeInQuart', 'theplus' ),
					'easeOutQuart'     => esc_html__( 'easeOutQuart', 'theplus' ),
					'easeInOutQuart'   => esc_html__( 'easeInOutQuart', 'theplus' ),
					'easeInQuint'      => esc_html__( 'easeInQuint', 'theplus' ),
					'easeOutQuint'     => esc_html__( 'easeOutQuint', 'theplus' ),
					'easeInOutQuint'   => esc_html__( 'easeInOutQuint', 'theplus' ),
					'easeInSine'       => esc_html__( 'easeInSine', 'theplus' ),
					'easeOutSine'      => esc_html__( 'easeOutSine', 'theplus' ),
					'easeInOutSine'    => esc_html__( 'easeInOutSine', 'theplus' ),
					'easeInExpo'       => esc_html__( 'easeInExpo', 'theplus' ),
					'easeOutExpo'      => esc_html__( 'easeOutExpo', 'theplus' ),
					'easeInOutExpo'    => esc_html__( 'easeInOutExpo', 'theplus' ),
					'easeInCirc'       => esc_html__( 'easeInCirc', 'theplus' ),
					'easeOutCirc'      => esc_html__( 'easeOutCirc', 'theplus' ),
					'easeInOutCirc'    => esc_html__( 'easeInOutCirc', 'theplus' ),
					'easeInElastic'    => esc_html__( 'easeInElastic', 'theplus' ),
					'easeOutElastic'   => esc_html__( 'easeOutElastic', 'theplus' ),
					'easeInOutElastic' => esc_html__( 'easeInOutElastic', 'theplus' ),
					'easeInBack'       => esc_html__( 'easeInBack', 'theplus' ),
					'easeOutBack'      => esc_html__( 'easeOutBack', 'theplus' ),
					'easeInOutBack'    => esc_html__( 'easeInOutBack', 'theplus' ),
					'easeInBounce'     => esc_html__( 'easeInBounce', 'theplus' ),
					'easeOutBounce'    => esc_html__( 'easeOutBounce', 'theplus' ),
					'easeInOutBounce'  => esc_html__( 'easeInOutBounce', 'theplus' ),
				),
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'c_animation_duration',
			array(
				'type'    => Controls_Manager::SLIDER,
				'label'   => esc_html__( 'Duration', 'theplus' ),
				'range'   => array(
					'px' => array(
						'min'  => 1,
						'max'  => 10000,
						'step' => 100,
					),
				),
				'default' => array(
					'size' => 1000,
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_styling',
			array(
				'label' => esc_html__( 'Chart Style', 'theplus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'chartwidth',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Chart Width', 'theplus' ),
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .tp-chart-wrapper > canvas' => 'max-width: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}} !important;',
				],
			)
		);
		$this->add_responsive_control(
			'chartheight',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Chart Height', 'theplus' ),
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .tp-chart-wrapper > canvas' => 'max-height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}} !important;',
				],
			)
		);
		$this->add_responsive_control(
			'chart_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'theplus' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'theplus' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'theplus' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'theplus' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'devices'   => array( 'desktop', 'tablet', 'mobile' ),
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .tp-chart-wrapper' => 'justify-content: {{VALUE}} !important;',
				),
			)
		);
		
		$this->end_controls_section();

		include THEPLUS_PATH . 'modules/widgets/theplus-needhelp.php';
	}

	/**
	 * Bubble Array.
	 *
	 * @param string $bubble_data The data representing bubble coordinates and radii in a string format.
	 *
	 * @since 1.0.0
	 * @version 5.4.2
	 */
	public function bubble_array( $bubble_data ) {
		$bubble_data = trim( $bubble_data );
		$split_value = preg_match_all( '#\[([^\]]+)\]#U', $bubble_data, $fetch_and_match );
		if ( ! $split_value ) {
			return array();
		} else {
			$data_value = $fetch_and_match[1];
			$bubble     = array();
			foreach ( $data_value as $item_value ) {
				$item_value = trim( $item_value, '][ ' );
				$item_value = explode( '|', $item_value );

				if ( 3 != count( $item_value ) ) {
					continue;
				}

				$x_y_r    = new \stdClass();
				$x_y_r->x = floatval( trim( $item_value[0] ) );
				$x_y_r->y = floatval( trim( $item_value[1] ) );
				$x_y_r->r = floatval( trim( $item_value[2] ) );
				$bubble[] = $x_y_r;
			}
			return $bubble;
		}
	}

	/**
	 * Chart Render.
	 *
	 * @since 1.0.0
	 * @version 5.4.2
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$output     = '';
		$label_data = '';
		$get_data   = '';
		$charttype  = '';

		$select_chart   = ! empty( $settings['select_chart'] ) ? $settings['select_chart'] : 'line';
		$bar_chart_type = ! empty( $settings['bar_chart_type'] ) ? $settings['bar_chart_type'] : 'vertical_bar';

		$doughnut_pie_chart_type = ! empty( $settings['doughnut_pie_chart_type'] ) ? $settings['doughnut_pie_chart_type'] : 'pie';

		$chart_type = ! empty( $settings['select_chart_type'] ) ? $settings['select_chart_type'] : 'custom';

		if ( 'bar' === $select_chart && 'horizontal_bar' === $bar_chart_type ) {
			$charttype = 'horizontalBar';
		} elseif ( 'pie' === $select_chart && 'doughnut' === $doughnut_pie_chart_type ) {
			$charttype = 'doughnut';
		} else {
			$charttype = $select_chart;
		}

		$options   = array();
		$datasets  = array();
		$datasets1 = array();

		$chart_datasets = array();

		if ( 'custom' === $chart_type ) {
			if ( 'pie' === $select_chart || 'polarArea' === $select_chart ) {
				if ( 'doughnut' !== $doughnut_pie_chart_type ) {

					$alone_data = array_map( 'floatval', explode( '|', $settings['alone_data'] ) );
					if ( ! empty( $alone_data ) ) {
						$datasets[] = array(
							'data'            => $alone_data,
							'backgroundColor' => explode( '|', $settings['alone_bg_colors'] ),
						);
					}

					if ( 'doughnut' === $doughnut_pie_chart_type && ! empty( $settings['alone_border_colors'] ) ) {
						$datasets[] = array(
							'borderColor' => explode( '|', $settings['alone_border_colors'] ),
						);
					}

					if ( 'polarArea' === $select_chart && ! empty( $settings['alone_border_colors_polar'] ) ) {
						$datasets[] = array(
							'borderColor' => explode( '|', $settings['alone_border_colors_polar'] ),
						);
					}
				} else {
					foreach ( $settings['doughnut_chart_datasets'] as $item1 ) {

						$datasets2['data'] = array_map( 'floatval', explode( '|', $item1['doughnut_loop_data'] ) );

						$datasets2['backgroundColor'] = $item1['doughnut_loop_background'] ? explode( '|', $item1['doughnut_loop_background'] ) : array();

						$datasets2['borderColor'] = $item1['doughnut_loop_border'] ? explode( '|', $item1['doughnut_loop_border'] ) : array();

						$datasets[] = $datasets2;
					}
				}
			} else {
				$chart_datasets = 'bubble' === $select_chart ? $settings['bubble_content'] : $settings['chart_content'];

				foreach ( $chart_datasets as $item ) {
					$datasets1['label'] = $item['loop_label'];

					if ( 'bubble' === $select_chart ) {
						$datasets1['data'] = $this->bubble_array( $item['bubble_data'] );
					} else {
						$datasets1['data'] = array_map( 'floatval', explode( '|', $item['loop_data'] ) );
					}

					if ( ( ! empty( $item['multi_dot_bg'] ) && 'yes' === $item['multi_dot_bg'] ) && ! empty( $item['multi_dot_bg_multiple'] ) ) {
						$datasets1['backgroundColor'] = explode( '|', $item['multi_dot_bg_multiple'] );
					} else {
						$datasets1['backgroundColor'] = $item['dot_bg'];
					}

					if ( ( ! empty( $item['multi_dot_border'] ) && 'yes' === $item['multi_dot_border'] ) && ! empty( $item['multi_dot_border_multiple'] ) ) {
						$datasets1['borderColor'] = explode( '|', $item['multi_dot_border_multiple'] );
					} else {
						$datasets1['borderColor'] = $item['dot_border'];
					}

					$datasets1['borderDash'] = array();
					if ( ( 'line' === $select_chart || 'radar' === $select_chart ) && ( ! empty( $item['line_styling_opt'] ) && 'yes' === $item['line_styling_opt'] ) ) {
						$datasets1['borderDash'] = array( 5, 5 );
					}

					if ( ! empty( $item['fill_opt'] ) && 'yes' === $item['fill_opt'] ) {
						$datasets1['fill'] = true;
					} else {
						$datasets1['fill'] = false;
					}

					if ( ( 'line' === $select_chart || 'radar' === $select_chart || 'bubble' === $select_chart ) ) {
						if ( ! empty( $settings['custom_point_styles'] ) && 'yes' === $settings['custom_point_styles'] ) {
							if ( ! empty( $settings['point_styles'] ) ) {
								$datasets1['pointStyle'] = $settings['point_styles'];
							}

							if ( ! empty( $settings['point_bg'] ) && 'bubble' !== $select_chart ) {
								$datasets1['pointBackgroundColor'] = $settings['point_bg'];
							}

							if ( ! empty( $settings['point_n_size']['size'] ) && 'bubble' !== $select_chart ) {
								$datasets1['pointRadius'] = $settings['point_n_size']['size'];
							}

							if ( ! empty( $settings['point_h_size']['size'] ) && 'bubble' !== $select_chart ) {
								$datasets1['pointHoverRadius'] = $settings['point_h_size']['size'];
							}

							if ( ! empty( $settings['point_border_width']['size'] ) && 'bubble' !== $select_chart ) {
								$datasets1['borderWidth'] = $settings['point_border_width']['size'];
							}

							if ( ! empty( $settings['point_border_color'] ) && 'bubble' !== $select_chart ) {
								$datasets1['pointBorderColor'] = $settings['point_border_color'];
							}
						}

						if ( 'line' === $select_chart && ( ! empty( $settings['tension'] ) && 'yes' === $settings['tension'] ) ) {
							$datasets1['tension'] = 0.4;
						} else {
							$datasets1['tension'] = 0;
						}
					}

					if ( 'bar' === $select_chart ) {
						if ( ! empty( $settings['barthickness']['size'] ) ) {
							$datasets1['barThickness'] = $settings['barthickness']['size'];  /*space*/
						}
						if ( ! empty( $settings['maxbarthickness']['size'] ) ) {
							$datasets1['maxBarThickness'] = $settings['maxbarthickness']['size'];  /*size*/
						}
					}

					$datasets[] = $datasets1;
				}
			}
		} 


		if ( 'pie' === $select_chart && ( ! empty( $doughnut_pie_chart_type ) && 'pie' === $doughnut_pie_chart_type ) ) {
			$options['cutoutPercentage'] = 0;
		} elseif ( 'pie' === $select_chart && ( ! empty( $doughnut_pie_chart_type ) && 'doughnut' === $doughnut_pie_chart_type ) ) {
			$options['cutoutPercentage'] = 50;
		} elseif ( ! empty( $settings['show_grid_lines'] ) && 'yes' === $settings['show_grid_lines'] ) {

			$beginAtZeroX = ! empty( $settings['begin_atzero_x'] ) && $settings['begin_atzero_x'] === 'yes' ? true : false;
			$beginAtZeroY = ! empty( $settings['begin_atzero_y'] ) && $settings['begin_atzero_y'] === 'yes' ? true : false;

			$options['scales'] = array(
				'x' => array(
					'axis'        => 'x',
					'beginAtZero' => $beginAtZeroX,
					'grid'        => array(
						'display'         => true,
						'color'           => $settings['grid_color_xAxes'],
						'zeroLineColor'   => $settings['zero_linecolor_x'],
						'drawBorder'      => ! empty( $settings['draw_border_x'] ) ? true : false,
						'drawOnChartArea' => ! empty( $settings['draw_on_chart_area_x'] ) ? true : false,
						/**
						 * 'borderColor'   => 'rgba(0,0,0,0.1)',
						 * 'display'   => true,
						 * 'lineWidth' => '1',
						 */
					),
					'id'          => 'x',
					'ticks'       => array(
						'display' => ! empty( $settings['show_labels'] ) ? true : false,
						'align' => 'center',
						'color' => $settings['show_labels_color'],
						'font'  => array(
							'size' => ! empty( $settings['show_labels_size']['size'] ) ? $settings['show_labels_size']['size'] : 0,
						),
					),
				),
				'y' => array(
					'axis'        => 'y',
					'beginAtZero' => $beginAtZeroY,
					'grid'        => array(
						'display'         => true,
						'color'           => $settings['grid_color'],
						'zeroLineColor'   => $settings['zero_linecolor_y'],
						'drawBorder'      => ! empty( $settings['draw_border_y'] ) ? true : false,
						'drawOnChartArea' => ! empty( $settings['draw_on_chart_area_y'] ) ? true : false,
						/**
						 * 'borderColor'   => 'rgba(0,0,0,0.1)',
						 * 'display'   => true,
						 * 'lineWidth' => '1',
						 */
					),
					'id'          => 'y',
					'ticks'       => array(
						'display' => ! empty( $settings['show_labels'] ) ? true : false,
						'align' => 'center',
						'color' => $settings['show_labels_color'],
						'font'  => array(
							'size' => ! empty( $settings['show_labels_size']['size'] ) ? $settings['show_labels_size']['size'] : 0,
						),
					),
				),
			);
		} else {
			$options['scales'] = array(
				'x' => array(
					'ticks' => array(
						'display' => $settings['show_labels'] ? true : false,
						'color'   => $settings['show_labels_color'],
						'font'    => array(
							'size' => isset( $settings['show_labels_size']['size'] ) ? $settings['show_labels_size']['size'] : '',
						),
					),
					'grid' => array(
						'display' => false,
					),
				),
				'y' => array(
					'ticks' => array(
						'display'=> $settings['show_labels'] ? true : false,
						'color'  => $settings['show_labels_color'],
						'font'   => array(
							'size' => isset( $settings['show_labels_size']['size'] ) ? $settings['show_labels_size']['size'] : '',
						),
					),
					'grid'  => array(
						'display' => false,
					),
				),
			);
		}

		if ( ! empty( $settings['show_legend'] ) && 'yes' === $settings['show_legend'] ) {
			if ( ! empty( $settings['show_legend_position'] ) ) {
				$options['plugins']['legend'] = array(
					'display'  => true,
					'labels'   => array(
						'color' => $settings['show_legend_color'],
						'font'  => array(
							'size'   => $settings['show_legend_size']['size'],
							// 'style'  => 'italic',
							// 'weight' => 'bold',
						),
					),
					'position' => $settings['show_legend_position'],
					'align'    => $settings['show_legend_align'],
				);
			}
		} else {
			$options['plugins']['legend'] = array( 'display' => false );
		}

		if ( ! empty( $settings['c_animation'] ) && ! empty( $settings['c_animation_duration']['size'] ) ) {
			$options['animation'] = array(
				'duration' => $settings['c_animation_duration']['size'],
				'easing'   => $settings['c_animation'],
			);
		}

		if ( ! empty( $settings['show_tooltip'] ) && 'yes' === $settings['show_tooltip'] ) {
			if ( ! empty( $settings['tooltip_bg'] ) || ! empty( $settings['tooltip_color'] ) || ! empty( $settings['tooltip_body_color'] ) ) {
				$options['plugins']['tooltip'] = array(
					'enabled'         => true,
					'events'          => $settings['tooltip_event'],
					'backgroundColor' => $settings['tooltip_bg'],
					'titleColor'      => $settings['tooltip_color'],
					'bodyColor'       => $settings['tooltip_body_color'],
					'footerColor'     => 'lightgray',
					'titleFont'       => array(
						'size' => $settings['tooltip_font_size']['size'],
					),
					'bodyFont'        => array(
						'size' => $settings['tooltip_font_size']['size'],
					),
					'footerFont'      => array(
						'size' => $settings['tooltip_font_size']['size'],
					),
				);
			}
		} else {
			$options['plugins']['tooltip'] = array( 'enabled' => false );
		}

		if ( ! empty( $settings['aspect_ratio'] ) && 'yes' === $settings['aspect_ratio'] ) {
			$options['aspectRatio'] = 1;
		}

		if ( ! empty( $settings['maintain_aspect_ratio'] ) && 'yes' !== $settings['maintain_aspect_ratio'] ) {
			$options['maintainAspectRatio'] = false;
		}

		if ( ( 'line' === $charttype || 'radar' === $charttype || 'bubble' === $charttype ) ) {
			if ( ! empty( $settings['custom_point_styles'] ) && 'yes' === $settings['custom_point_styles'] ) {
				if ( ! empty( $settings['point_styles'] ) ) {
					$options['pointStyle'] = $settings['point_styles'];
				}

				if ( ! empty( $settings['point_bg'] ) && 'bubble' !== $charttype ) {
					$options['pointBackgroundColor'] = $settings['point_bg'];
				}

				if ( ! empty( $settings['point_n_size']['size'] ) && 'bubble' !== $charttype ) {
					$options['pointRadius'] = $settings['point_n_size']['size'];
				}

				if ( ! empty( $settings['point_h_size']['size'] ) && 'bubble' !== $charttype ) {
					$options['pointHoverRadius'] = $settings['point_h_size']['size'];
				}

				if ( ! empty( $settings['point_border_width']['size'] ) && 'bubble' !== $charttype ) {
					$options['borderWidth'] = $settings['point_border_width']['size'];
				}

				if ( ! empty( $settings['point_border_color'] ) && 'bubble' !== $charttype ) {
					$options['pointBorderColor'] = $settings['point_border_color'];
				}
			}

			if ( 'line' === $charttype && ( ! empty( $settings['tension'] ) && 'yes' === $settings['tension'] ) ) {
				$options['tension'] = 0.4;
			} else {
				$options['tension'] = 0;
			}
		}

		if( 'bar' === $charttype ) {
			if ( ! empty( $settings['barthickness']['size'] ) ) {
				$options['barThickness'] = $settings['barthickness']['size'];  /**space*/
			}
			if ( ! empty( $settings['maxbarthickness']['size'] ) ) {
				$options['maxBarThickness'] = $settings['maxbarthickness']['size'];  /**size*/
			}
		}

		if ( 'horizontalBar' === $charttype ) {
			$charttype = 'bar';

			$options['indexAxis'] = 'y';
		}

		$unique     = uniqid( 'chart' );
		$chartparam = '';

		if ( 'custom' === $chart_type ) {
			$this->add_render_attribute(
				array(
					'get_all_chart_values' => array(
						'data-settings' => array(
							wp_json_encode(
								array_filter(
									array(
										'type'    => $charttype,
										'data'    => array(
											'labels'   => explode( '|', $settings['main_label'] ),
											'datasets' => $datasets,
										),
										'options' => $options,
									)
								)
							),
						),
					),
				)
			);
		}

		if ( 'csv_file' === $chart_type ) {
			$csv_url = ! empty( $settings['csv_url']['url'] ) ? esc_url( $settings['csv_url']['url'] ) : '';
			$ext     = pathinfo( $csv_url, PATHINFO_EXTENSION );

			if ( 'csv' !== $ext ) {
				echo '<h3 class="theplus-posts-not-found">' . esc_html__( 'Opps!! Please Enter Only CSV File Extension.', 'theplus' ) . '</h3>';

				return false;
			}

			$csv_data   = $this->theplus_fetch_csv( $csv_url );
			$csv_output = array();
			$data_setts = '';

			if ( ! empty( $csv_data ) ) {
				foreach ( $csv_data as $item ) {
					$csv_output[] = explode( ',', $item );
				}

				if ( 'line' === $charttype || 'bar' === $charttype || 'radar' === $charttype ) {
					$data_setts = $this->tp_blr_charts( $chart_type, $charttype, $csv_output, $options );
				} elseif ( 'pie' === $charttype || 'polarArea' === $charttype ) {
					$data_setts = $this->tp_piepolar_charts( $chart_type, $charttype, $csv_output, $options );
				} elseif ( 'doughnut' === $charttype ) {
					$data_setts = $this->tp_doughnut_charts( $chart_type, $charttype, $csv_output, $options );
				} elseif ( 'bubble' === $charttype ) {
					$data_setts = $this->tp_bubble_charts( $chart_type, $charttype, $csv_output, $options );
				}
			}

			$chartparam = 'data-chartparam= \'' . wp_json_encode( $data_setts ) . '\' ';
		}

		if ( 'g_sheet' === $chart_type ) {
			$data_setts    = '';
			$gsheet_output = $this->tp_google_sheet_data();

			if ( ! empty( $gsheet_output['values'] ) ) {
				if ( 'bar' === $charttype || 'horizontalBar' === $charttype || 'line' === $charttype || 'radar' === $charttype ) {
					$data_setts = $this->tp_blr_charts( $chart_type, $charttype, $gsheet_output, $options );
				} elseif ( 'pie' === $charttype || 'polarArea' === $charttype ) {
					$data_setts = $this->tp_piepolar_charts( $chart_type, $charttype, $gsheet_output, $options );
				} elseif ( 'doughnut' === $charttype ) {
					$data_setts = $this->tp_doughnut_charts( $chart_type, $charttype, $gsheet_output, $options );
				} elseif ( 'bubble' === $charttype ) {
					$data_setts = $this->tp_bubble_charts( $chart_type, $charttype, $gsheet_output, $options );
				}
			}

			$chartparam = 'data-chartparam= \'' . wp_json_encode( $data_setts ) . '\' ';
		}

		$css = '<style>.tp-chart-wrapper{display:flex;justify-content:center;align-items:center;}</style>';

		$output .= '<div class="tp-chart-wrapper" data-source="' . esc_attr( $chart_type ) . '" data-id="' . esc_attr( $unique ) . '" ' . $chartparam . ' ' . $this->get_render_attribute_string( 'get_all_chart_values' ) . '>';

			$output .= $css;
			$output .= '<canvas id="' . esc_attr( $unique ) . '"></canvas>';

		$output .= '</div>';

		echo $output;
	}

	/**
	 * Function to It is use for call api
	 *
	 * @since 5.6.3
	 *
	 * @param string $file The path to the CSV file.
	 */
	protected function theplus_fetch_csv( $file ) {
		$column    = '';
		$char_skip = '';
		$csv_rows  = file( $file );

		return $csv_rows;
	}

	/**
	 * Function to It is used for Retrieve data for google sheet
	 *
	 * @since 5.6.3
	 */
	protected function tp_google_sheet_data() {
		$widget_id = $this->get_id();
		$settings  = $this->get_settings();

		$gs_apikey  = ! empty( $settings['gs_apikey'] ) ? $settings['gs_apikey'] : '';
		$gs_sheetid = ! empty( $settings['gs_sheetid'] ) ? $settings['gs_sheetid'] : '';

		$gs_tablerange = ! empty( $settings['gs_tablerange'] ) ? $settings['gs_tablerange'] : '';

		$a_p_i = "https://sheets.googleapis.com/v4/spreadsheets/{$gs_sheetid}/values/{$gs_tablerange}?key={$gs_apikey}";

		$data = $this->tp_chart_api( $a_p_i );

		return $data;
	}

	/**
	 * Function to It is use for call api
	 *
	 * If yes returns Array Data
	 *
	 * @since 5.6.3
	 *
	 * @param string $a_p_i   The API for the get data.
	 */
	protected function tp_chart_api( $a_p_i ) {
		$settings = $this->get_settings_for_display();

		$final = array();
		$u_r_l = wp_remote_get( $a_p_i );

		$statuscode = wp_remote_retrieve_response_code( $u_r_l );
		$getdataone = wp_remote_retrieve_body( $u_r_l );
		$statuscode = array( 'HTTP_CODE' => $statuscode );

		$response = json_decode( $getdataone, true );
		if ( is_array( $statuscode ) && is_array( $response ) ) {
			$final = array_merge( $statuscode, $response );
		}

		return $final;
	}

	/**
	 * Get data for the Bar, Line & Radar chart in GoogleSheet & CSV options.
	 *
	 * @since 5.6.3
	 *
	 * @param string $chart_type   The chart type.
	 * @param string $charttype    The chart style.
	 * @param string $output_data  The output data get from googlesheet or csv.
	 * @param string $options      The options of the chart.
	 *
	 * @return mixed The result of generating the array for data.
	 */
	protected function tp_blr_charts( $chart_type, $charttype, $output_data, $options ) {
		$gsheet_label   = array();
		$gsheet_dataval = array();

		$gsheet_datalable = array();

		if ( 'csv_file' === $chart_type ) {
			$gsheet_label   = ! empty( $output_data['0'] ) ? $output_data['0'] : array();
			$gsheet_dataval = ! empty( $output_data ) ? $output_data : array();
		} elseif ( 'g_sheet' === $chart_type ) {
			$gsheet_label   = ! empty( $output_data['values']['0'] ) ? $output_data['values']['0'] : array();
			$gsheet_dataval = ! empty( $output_data['values'] ) ? $output_data['values'] : array();
		}

		unset( $gsheet_label[0] );
		$gsheet_label = array_values( $gsheet_label );

		unset( $gsheet_dataval[0] );
		$gsheet_dataval = array_values( $gsheet_dataval );

		foreach ( $gsheet_dataval as &$sub_array ) {
			$gsheet_datalable[] = array_shift( $sub_array );
		}

		$datalables_colors = $this->tp_set_chartscolor( $gsheet_datalable );

		$gsheet_datalable = ! empty( $datalables_colors['lables'] ) ? $datalables_colors['lables'] : array();
		$lable_colors     = ! empty( $datalables_colors['colors'] ) ? $datalables_colors['colors'] : array();

		$label_array = array_map(
			function ( $element ) {
				return array( 'label' => $element );
			},
			$gsheet_datalable
		);

		foreach ( $label_array as $index => $label ) {
			$gsheet_datasets[] = array(
				'label'           => $label['label'],
				'data'            => $gsheet_dataval[ $index ],
				'backgroundColor' => $lable_colors[ $index ],
				'borderColor'     => $lable_colors[ $index ],
				'borderDash'      => array(),
				'fill'            => true,
			);
		}

		if ( 'horizontalBar' === $charttype ) {
			$charttype            = 'bar';
			$options['indexAxis'] = 'y';
		}

		$datasets = $this->tp_get_datasets( $charttype, $gsheet_label, $gsheet_datasets, $options );

		return $datasets;
	}

	/**
	 * Get data for the Pie & Polar chart in GoogleSheet & CSV options.
	 *
	 * @since 5.6.3
	 *
	 * @param string $chart_type   The chart type.
	 * @param string $charttype    The chart style.
	 * @param string $output_data  The output data get from googlesheet or csv.
	 * @param string $options      The options of the chart.
	 *
	 * @return mixed The result of generating the array for data.
	 */
	protected function tp_piepolar_charts( $chart_type, $charttype, $output_data, $options ) {
		$gsheet_label   = array();
		$gsheet_dataval = array();

		if ( 'csv_file' === $chart_type ) {
			$output_data = ! empty( $output_data ) ? $output_data : array();
		} elseif ( 'g_sheet' === $chart_type ) {
			$output_data = ! empty( $output_data['values'] ) ? $output_data['values'] : array();
		}

		foreach ( $output_data as $data ) {
			$gsheet_label[]   = $data[0]; 
			$gsheet_dataval[] = $data[1]; 
		}

		$datalables_colors = $this->tp_set_chartscolor( $gsheet_label );

		$gsheet_label = ! empty( $datalables_colors['lables'] ) ? $datalables_colors['lables'] : array();
		$lable_colors = ! empty( $datalables_colors['colors'] ) ? $datalables_colors['colors'] : array();

		$gsheet_datasets[] = array(
			'data'            => $gsheet_dataval,
			'backgroundColor' => $lable_colors,
		);

		$datasets = $this->tp_get_datasets( $charttype, $gsheet_label, $gsheet_datasets, $options );

		return $datasets;
	}

	/**
	 * Get data for the Doughnut chart in GoogleSheet & CSV options.
	 *
	 * @since 5.6.3
	 *
	 * @param string $chart_type   The chart type.
	 * @param string $charttype    The chart style.
	 * @param string $output_data  The output data get from googlesheet or csv.
	 * @param string $options      The options of the chart.
	 *
	 * @return mixed The result of generating the array for data.
	 */
	protected function tp_doughnut_charts( $chart_type, $charttype, $output_data, $options ) {
		$gsheet_dataval = array();

		$gsheet_datalable   = array();
		$gsheet_dataval_set = array();

		if ( 'csv_file' === $chart_type ) {
			$gsheet_datalable = ! empty( $output_data['0'] ) ? $output_data['0'] : array();
			$gsheet_dataval   = ! empty( $output_data ) ? $output_data : array();
		} elseif ( 'g_sheet' === $chart_type ) {
			$gsheet_datalable = ! empty( $output_data['values']['0'] ) ? $output_data['values']['0'] : array();
			$gsheet_dataval   = ! empty( $output_data['values'] ) ? $output_data['values'] : array();
		}

		unset( $gsheet_datalable[0] );
		$gsheet_datalable = array_values( $gsheet_datalable );

		unset( $gsheet_dataval[0] );
		foreach ( $gsheet_dataval as $datasub_array ) {
			foreach ( $datasub_array as $index => $value ) {
				$gsheet_dataval_set[ $index ][] = $value;
			}
		}
		$gsheet_label = $gsheet_dataval_set[0];
		unset( $gsheet_dataval_set[0] );
		$gsheet_dataval_set = array_values( $gsheet_dataval_set );

		$gsheetlabel_colors = $this->tp_set_chartscolor( $gsheet_label );

		$gsheet_label = ! empty( $gsheetlabel_colors['lables'] ) ? $gsheetlabel_colors['lables'] : array();
		$lable_colors = ! empty( $gsheetlabel_colors['colors'] ) ? $gsheetlabel_colors['colors'] : array();

		foreach ( $gsheet_dataval_set as $index => $label ) {
			$gsheet_datasets[] = array(
				'label'           => $gsheet_datalable[ $index ],
				'data'            => $gsheet_dataval_set[ $index ],
				'backgroundColor' => $lable_colors,
				// 'borderColor'     => '#fff'.
				// 'hoverOffset'     => 4.
			);
		}

		$datasets = $this->tp_get_datasets( $charttype, $gsheet_label, $gsheet_datasets, $options );

		return $datasets;
	}

	/**
	 * Get data for the Bubble chart in GoogleSheet & CSV options.
	 *
	 * @since 5.6.3
	 *
	 * @param string $chart_type   The chart type.
	 * @param string $charttype    The chart style.
	 * @param string $output_data  The output data get from googlesheet or csv.
	 * @param string $options      The options of the chart.
	 *
	 * @return mixed The result of generating the array for data.
	 */
	protected function tp_bubble_charts( $chart_type, $charttype, $output_data, $options ) {
		$gsheet_label = array();

		$gsheet_dataval   = array();
		$gsheet_datalable = array();

		if ( 'csv_file' === $chart_type ) {
			$gsheet_label   = ! empty( $output_data['0'] ) ? $output_data['0'] : array();
			$gsheet_dataval = ! empty( $output_data ) ? $output_data : array();
		} elseif ( 'g_sheet' === $chart_type ) {
			$gsheet_label   = ! empty( $output_data['values']['0'] ) ? $output_data['values']['0'] : array();
			$gsheet_dataval = ! empty( $output_data['values'] ) ? $output_data['values'] : array();
		}

		unset( $gsheet_label[0] );
		$gsheet_label = array_values( $gsheet_label );

		unset( $gsheet_dataval[0] );
		$gsheet_dataval = array_values( $gsheet_dataval );

		foreach ( $gsheet_dataval as &$sub_array ) {
			$gsheet_datalable[] = array_shift( $sub_array );
		}

		$datalables_colors = $this->tp_set_chartscolor( $gsheet_datalable );

		$gsheet_datalable = ! empty( $datalables_colors['lables'] ) ? $datalables_colors['lables'] : array();
		$lable_colors     = ! empty( $datalables_colors['colors'] ) ? $datalables_colors['colors'] : array();

		foreach ( $gsheet_dataval as $setsub_array ) {
			$transformed_sub_array = array();
			foreach ( $setsub_array as $values ) {
				$value_parts = explode( '|', $values );

				$transformed_sub_array[] = array(
					'x' => $value_parts[0],
					'y' => $value_parts[1],
					'r' => $value_parts[2],
				);
			}
			$transformed_data[] = $transformed_sub_array;
		}

		foreach ( $gsheet_dataval as $index => $label ) {
			$gsheet_datasets[] = array(
				'label'           => $gsheet_datalable[ $index ],
				'data'            => $transformed_data[ $index ],
				'backgroundColor' => $lable_colors[ $index ],
				'borderColor'     => $lable_colors[ $index ],
				// 'hoverOffset'     => 4.
			);
		}

		$datasets = $this->tp_get_datasets( $charttype, $gsheet_label, $gsheet_datasets, $options );

		return $datasets;
	}

	/**
	 * Separate label name & label color from the name which get from the output data.
	 *
	 * @since 5.6.3
	 *
	 * @param string $gsheet_datalable   The array of the chart label & colors.
	 *
	 * @return mixed The result of dividing the lables & colors in array.
	 */
	protected function tp_set_chartscolor( $gsheet_datalable ) {
		$default_colors = array( '#FF5733', '#33FF57', '#3357FF', '#FF33A6', '#33FFF5', '#FF9633', '#9633FF', '#FFFF33', '#FF3333', '#33FFB5', '#33B5FF', '#8D33FF' );
		$lable_colors   = array();

		foreach ( $gsheet_datalable as $index => $item ) {
			// if ( is_string( $item ) && strpos( $item, ' ' ) !== false ) {
			if ( strpos( $item, ' ' ) !== false ) {
				list( $label, $color ) = explode( ' ', $item, 2 );

				if ( strpos( $color, '#' ) === 0 ) {
					$lable_colors[] = $color;

					$gsheet_datalable[ $index ] = $label;
				}
			} else {
				$random_color   = $default_colors[ array_rand( $default_colors ) ];
				$lable_colors[] = $random_color;

				$gsheet_datalable[ $index ] = $item;
			}
		}

		$datalables_colors = array(
			'lables' => $gsheet_datalable,
			'colors' => $lable_colors,
		);

		return $datalables_colors;
	}

	/**
	 * Set datasets output for the pass in attributes to design charts.
	 *
	 * @since 5.6.3
	 *
	 * @param string $charttype        The chart type.
	 * @param string $gsheet_label     The label name of the chart.
	 * @param string $gsheet_datasets  The data of the chart.
	 * @param string $options          The options of the chart.
	 *
	 * @return mixed The result of gererating dataset array for the design charts.
	 */
	protected function tp_get_datasets( $charttype, $gsheet_label, $gsheet_datasets, $options ) {
		$data_setts = array(
			'type'    => $charttype,
			'data'    => array(
				'labels'   => $gsheet_label,
				'datasets' => $gsheet_datasets,
			),
			'options' => $options,
		);

		return $data_setts;
	}
}