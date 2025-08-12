<?php
/**
 * Widget Name: Custom Field Repeater
 * Description: Custom Field Repeater.
 * Author: Theplus
 * Author URI: https://posimyth.com
 *
 * @package ThePlus
 */

/**Exit if accessed directly.*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Tpaep_ACFRepeater_Field' ) ) {

	/**
	 * Tpaep_ACFRepeater_Field
	 *
	 * @since 5.7.0
	 */
	class Tpaep_ACFRepeater_Field {

		/**
		 * Member Variable
		 *
		 * @var instance
		 */
		private static $instance;

		/**
		 * Member Variable
		 *
		 * @var prefix
		 */
		public $prefix = 'tp_';

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Define the core functionality of the plugin.
		 *
		 * @since 5.7.0
		 */
		public function __construct() {
			add_action( 'add_meta_boxes', array( $this, 'add_acf_repeater_meta_box' ) );
			add_action( 'save_post', array( $this, 'save_acf_repeater_meta_box' ) );

			add_action( 'wp_ajax_plus_acf_repeater_field', array( $this, 'plus_acf_repeater_field_ajax' ) );
		}

		/**
		 * Set ACF Repeater meta box
		 *
		 * @since 5.7.0
		 */
		public function add_acf_repeater_meta_box() {
			add_meta_box(
				'tp_acf_repeater_metabox',
				esc_html__( 'ThePlus Elementor Options', 'theplus' ),
				array( $this, 'render_acf_repeater_meta_box' ),
				'elementor_library',
				'normal',
				'high'
			);
		}

		/**
		 * Render ACF Repeater meta box.
		 *
		 * @since 5.7.0
		 */
		public function render_acf_repeater_meta_box( $post ) {

			wp_nonce_field( 'tp_save_acf_repeater_metabox', 'tp_acf_repeater_nonce' );

			$render_mode    = get_post_meta( $post->ID, $this->prefix . 'render_mode_type', true );
			$preview_post   = get_post_meta( $post->ID, $this->prefix . 'preview_post', true );
			$acf_field_name = get_post_meta( $post->ID, $this->prefix . 'acf_field_name', true );

			?>

			<style>
				#tp_acf_repeater_metabox .tpaep_acf_repeater_field_main{display:flex;padding:10px}.tpaep_acf_repeater_field_main .tpaep_acf_repeater_field_wrap{width:100%;display:flex;padding:15px 7px;border-bottom:1px solid #e9e9e9}.tpaep_acf_repeater_field_wrap>label{width:20%;display:flex;align-items:center;font-size:14px;font-weight:500}.tpaep_acf_repeater_field_wrap>select{width:40%}
			</style>

			<div class="tpaep_acf_repeater_field_main">
				<div class="tpaep_acf_repeater_field_wrap">
					<label for="render_mode_type"><?php echo esc_html__( 'Render Mode:', 'theplus' ); ?></label>
					<select id="render_mode_type" name="<?php echo esc_attr( $this->prefix ); ?>render_mode_type">
						<option value="default" <?php selected( $render_mode, 'default' ); ?>><?php echo esc_html__( 'Default', 'theplus' ); ?></option>
						<option value="acf_repeater" <?php selected( $render_mode, 'acf_repeater' ); ?>><?php echo esc_html__( 'ACF Repeater Content', 'theplus' ); ?></option>
					</select>
				</div>
			</div>

			<div class="tpaep_acf_repeater_field_main">
				<div class="tpaep_acf_repeater_field_wrap">
					<label for="preview_post"><?php echo esc_html__( 'Select Preview Post:', 'theplus' ); ?></label>
					<input type="hidden" name="tp_preview_post" id="tp_preview_post" val="<?php echo esc_attr( $preview_post ); ?>">
					<select id="tp_preview_post_input" name="<?php echo esc_attr( $this->prefix ); ?>preview_post" val="<?php echo esc_attr( $preview_post ); ?>">
						<option value=""><?php echo esc_html__( 'Select a Post', 'theplus' ); ?></option>
						<?php
						$args = array(
							'post_type'      => 'any',
							'posts_per_page' => -1,
							'post_status'    => 'publish',
							'orderby'        => 'title',
							'order'          => 'ASC',
						);

						$posts = get_posts( $args );

						foreach ( $posts as $post ) {
							echo '<option value="' . esc_attr( $post->ID ) . '" ' . selected( $preview_post, $post->ID, false ) . '>' . esc_html( $post->post_title ) . '</option>';
						}
						?>
					</select>
				</div>
			</div>

			<script>
				document.getElementById('tp_preview_post_input').addEventListener('change', function() {
					var selectedPostId = this.value; 
					document.getElementById('tp_preview_post').value = selectedPostId; 
					document.getElementById('tp_preview_post_input').value = selectedPostId; 
				});
			</script>

			<div class="tpaep_acf_repeater_field_main">
				<div class="tpaep_acf_repeater_field_wrap">
					<label for="acf_field_name"><?php echo esc_html__( 'Select ACF Field:', 'theplus' ); ?></label>
					<select id="<?php echo esc_attr( $this->prefix ); ?>acf_field_name" name="<?php echo esc_attr( $this->prefix ); ?>acf_field_name">
						<?php
						$acf_fields = $this->get_acf_repeater_field();
						foreach ( $acf_fields as $field_key => $field_label ) {
							echo '<option value="' . esc_attr( $field_key ) . '" ' . selected( $acf_field_name, $field_key, false ) . '>' . esc_html( $field_label ) . '</option>';
						}
						?>
					</select>
				</div>
			</div>

			<?php
		}

		/**
		 * Submit ACF Repeater form data
		 *
		 * @since 5.7.0
		 */
		public function save_acf_repeater_meta_box( $post_id ) {
			if ( ! isset( $_POST['tp_acf_repeater_nonce'] ) || ! wp_verify_nonce( $_POST['tp_acf_repeater_nonce'], 'tp_save_acf_repeater_metabox' ) ) {
				return;
			}

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			if ( isset( $_POST[ $this->prefix . 'render_mode_type' ] ) ) {
				update_post_meta( $post_id, $this->prefix . 'render_mode_type', sanitize_text_field( $_POST[ $this->prefix . 'render_mode_type' ] ) );
			}

			if ( isset( $_POST[ $this->prefix . 'preview_post' ] ) ) {
				update_post_meta( $post_id, $this->prefix . 'preview_post', absint( $_POST[ $this->prefix . 'preview_post' ] ) );
			}

			if ( isset( $_POST[ $this->prefix . 'acf_field_name' ] ) ) {
				update_post_meta( $post_id, $this->prefix . 'acf_field_name', sanitize_text_field( $_POST[ $this->prefix . 'acf_field_name' ] ) );
			}
		}

		/**
		 * Get ACF Repeater Field.
		 *
		 * @since 5.7.0
		 */
		public function get_acf_repeater_field() {
			$data = array();

			if ( class_exists( 'acf' ) && isset( $_GET['post'] ) && absint( $_GET['post'] ) ) {
				$post_id    = get_field( 'tp_preview_post', $_GET['post'] );
				$acf_fields = get_field_objects( $post_id );

				if ( $acf_fields ) {
					foreach ( $acf_fields as $field_name => $field ) {
						if ( $field['type'] == 'repeater' ) {
							$data[ $field['name'] ] = $field['label'];
						}
					}
				}
			}

			return $data;
		}

		/**
		 * ACF Repeater Field AJAX.
		 *
		 * @since 5.7.0
		 */
		public function plus_acf_repeater_field_ajax() {
			
			if ( ! isset( $_POST['security'] ) || empty( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'theplus-addons' ) ) {
				die( 'Invalid Nonce Security checked!' );
			}

			$data = array();
			if ( ! empty( $_POST['post_id'] ) && isset( $_POST['post_id'] ) && absint( $_POST['post_id'] ) ) {
				$acf_fields = get_field_objects( $_POST['post_id'] );

				if ( $acf_fields ) {
					foreach ( $acf_fields as $field_name => $field ) {
						if ( $field['type'] == 'repeater' ) {
							$data[] = array(
								'meta_id' => $field['name'],
								'text'    => $field['label'],
							);
						}
					}
				}
			}

			wp_send_json_success( $data );
		}
	}

	Tpaep_ACFRepeater_Field::get_instance();
}