<?php
/**
 * Widget Name: Taxonomy Option
 * Description: Taxonomy Option.
 * Author: Theplus
 * Author URI: https://posimyth.com
 *
 * @package ThePlus
 */

/**Exit if accessed directly.*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Tpaep_Taxonomy_Options' ) ) {

	/**
	 * Get all taxonomies.
	 *
	 * @since 5.7.0
	 */
	function theplus_get_list_taxonomies() {

		$args = array(
			'public'  => true,
			'show_ui' => true,
		);

		$output   = 'names';
		$operator = 'and';

		$taxonomies = get_taxonomies( $args, $output, $operator );

		$options = array();

		if ( $taxonomies ) {
			foreach ( $taxonomies as $taxonomy ) {
				$options[ $taxonomy ] = $taxonomy;
			}

			if ( in_array( 'product_cat', $options ) ) {
				unset( $options['product_cat'] );
			}
		}

		return $options;
	}

	/**
	 * Tpaep_Taxonomy_Options
	 *
	 * @since 5.7.0
	 */
	class Tpaep_Taxonomy_Options {

		/**
		 * Member Variable
		 *
		 * @var instance
		 */
		private static $instance;

		/**
		 *  Initiator
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

			add_action( 'init', array( $this, 'tpaep_taxonomy_opt' ), 10, 2 );
			
			add_filter( 'manage_edit-category_columns', array( $this, 'add_taxonomy_image_column' ) );
			add_filter( 'manage_category_custom_column', array( $this, 'display_taxonomy_image_column' ), 10, 3 );
		}

		/**
		 * Load function taxonomy option
		 *
		 * @since 5.7.0
		 */
		public function tpaep_taxonomy_opt() {

			$taxonomies = theplus_get_list_taxonomies();

			foreach ( $taxonomies as $taxonomy_name ) {

				add_action(
					"{$taxonomy_name}_edit_form_fields",
					function ( $term, $taxonomy_name ) {
						$this->add_dynamic_taxonomy_fields( $term, $taxonomy_name );
					},
					10,
					2
				);

				add_action(
					"{$taxonomy_name}_add_form_fields",
					function ( $taxonomy_name ) {
						$this->add_dynamic_taxonomy_fields_on_create( $taxonomy_name );
					},
					10,
					2
				);

				add_action( "edited_{$taxonomy_name}", array( $this, 'save_dynamic_taxonomy_fields' ), 10, 2 );
				add_action( "created_{$taxonomy_name}", array( $this, 'save_dynamic_taxonomy_fields' ), 10, 2 );
			}
		}

		/**
		 * Add custom image field to edit product category.
		 *
		 * @since 5.7.0
		 */
		public function add_dynamic_taxonomy_fields( $term, $taxonomy_name ) {

			$value = get_term_meta( $term->term_id, 'tp_taxonomy_' . $taxonomy_name, true );

			$image_id  = get_term_meta( $term->term_id, 'tp_taxonomy_image_id', true );
			$image_url = $image_id ? wp_get_attachment_url( $image_id ) : '';
			?>

			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="tp_taxonomy_<?php echo esc_attr( $taxonomy_name ); ?>">
						<?php echo esc_html( ucwords( str_replace( '_', ' ', $taxonomy_name ) ) ); ?> <?php echo esc_html__( ' Thumbnail ', 'theplus' ); ?>
					</label>
				</th>
				<td>
					<input type="hidden" id="tp_taxonomy_<?php echo esc_attr( $taxonomy_name ); ?>" name="tp_taxonomy_<?php echo esc_attr( $taxonomy_name ); ?>" value="<?php echo esc_attr( $image_id  ); ?>" />
					<input type="button" class="button upload_image_button" value="<?php echo esc_html__( 'Upload/Add image', 'theplus' ); ?>" />
					<div class="taxonomy-image-preview">
						<?php if ( $image_url  ) : ?>
							<img src="<?php echo esc_url( $image_url ); ?>" style="max-width:150px;" />
						<?php endif; ?>
					</div>
				</td>
			</tr>
			<script>
				jQuery(document).ready(function($) {
					var mediaUploader;
					$('.upload_image_button').on('click', function(e) {
						e.preventDefault();
						if (mediaUploader) {
							mediaUploader.open();
							return;
						}
						mediaUploader = wp.media.frames.file_frame = wp.media({
							title: 'Choose Image',
							button: {
								text: 'Choose Image'
							},
							multiple: false
						});
						mediaUploader.on('select', function() {
							var attachment = mediaUploader.state().get('selection').first().toJSON();
							$('#tp_taxonomy_<?php echo esc_attr( $taxonomy_name ); ?>').val(attachment.id);
							$('.taxonomy-image-preview').html('<img src="' + attachment.url + '" style="max-width:150px;" />');
						});
						mediaUploader.open();
					});
				});
			</script>
			<?php
		}

		/**
		 * Add custom image field to add product category (on create page).
		 *
		 * @since 5.7.0
		 */
		public function add_dynamic_taxonomy_fields_on_create( $taxonomy_name ) {
			?>

			<div class="form-field term-thumbnail-wrap">
				<label for="tp_taxonomy_<?php echo esc_attr( $taxonomy_name ); ?>"> Thumbnail </label>
				<input type="hidden" id="tp_taxonomy_<?php echo esc_attr( $taxonomy_name ); ?>" name="tp_taxonomy_<?php echo esc_attr( $taxonomy_name ); ?>" value="" />
				<input type="button" class="button upload_image_button" value="<?php echo esc_html__( 'Upload/Add image', 'theplus' ); ?>" />
				<div class="taxonomy-image-preview"></div>
			</div>

			<script>
				jQuery(document).ready(function($) {
					var mediaUploader;
					$('.upload_image_button').on('click', function(e) {
						e.preventDefault();
						if (mediaUploader) {
							mediaUploader.open();
							return;
						}

						mediaUploader = wp.media.frames.file_frame = wp.media({
							title: 'Choose Image',
							button: {
								text: 'Choose Image'
							},
							multiple: false
						});

						mediaUploader.on('select', function() {
							var selection = mediaUploader.state().get('selection');
							var attachment = mediaUploader.state().get('selection').first().toJSON();
							$('#tp_taxonomy_<?php echo esc_attr( $taxonomy_name ); ?>').val(attachment.id);
							$('.taxonomy-image-preview').html('<img src="' + attachment.url + '" style="max-width:150px;" />');
						});

						jQuery(document).ready(function($) {
							$('#submit').on('click', function(e) {
								setTimeout(function() {
									if ($('#tag-name').val() === '') {
										$('#tp_taxonomy_<?php echo esc_attr( $taxonomy_name ); ?>').val('');
										$('.taxonomy-image-preview').html('');
									}
								}, 1000);
							});
						});

						mediaUploader.open();
					});
				});
			</script>
			<?php
		}

		/**
		 * Save taxonomy field.
		 *
		 * @since 5.7.0
		 */
		public function save_dynamic_taxonomy_fields( $term_id ) {
			$taxonomies = theplus_get_list_taxonomies();

			foreach ( $taxonomies as $taxonomy_name => $taxonomy_label ) {
				if ( isset( $_POST[ 'tp_taxonomy_' . $taxonomy_name ] ) ) {
					$thumbnail_id = intval( $_POST[ 'tp_taxonomy_' . $taxonomy_name ] );

					$thumbnail_url = wp_get_attachment_url( $thumbnail_id );
					update_term_meta( $term_id, 'tp_taxonomy_image_id', $thumbnail_id );
					update_term_meta( $term_id, 'tp_taxonomy_image', esc_url( $thumbnail_url ) );
				}
			}
		}

		/**
		 * Add taxonomy image column.
		 *
		 * @since 5.7.0
		 */
		public function add_taxonomy_image_column( $columns ) {
			$checkbox = array( 'cb' => $columns['cb'] );
			unset( $columns['cb'] );
		
			$image_column = array( 'tp_taxonomy_image' => __( 'Image', 'theplus' ) );

			$columns = array_merge( $checkbox, $image_column, $columns );
		
			return $columns;
		}
		
		/**
		 * Display taxonomy image in the column.
		 *
		 * @since 5.7.0
		 */
		public function display_taxonomy_image_column( $content, $column_name, $term_id ) {
			if ( 'tp_taxonomy_image' === $column_name ) {
				$image_id = get_term_meta( $term_id, 'tp_taxonomy_image_id', true );
				$image_url = $image_id ? wp_get_attachment_url( $image_id ) : '';
		
				if ( $image_url ) {
					$content = '<img src="' . esc_url( $image_url ) . '" style="max-width:40px;" />';
				}
			}
			return $content;
		}
	}

	Tpaep_Taxonomy_Options::get_instance();
}