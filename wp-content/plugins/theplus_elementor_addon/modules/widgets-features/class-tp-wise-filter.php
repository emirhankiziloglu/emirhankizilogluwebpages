<?php
/**
 * The file that defines the core plugin class
 *
 * @link       https://posimyth.com/
 * @since      6.1.4
 *
 * @package    ThePlus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Tp_Wise_Filter' ) ) {

	/**
	 * Tp_Wise_Filter
	 *
	 * @since 6.1.4
	 */
	class Tp_Wise_Filter {

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
		 * @since 6.1.4
		 */
		public function __construct() {
			add_action( 'wp_ajax_tp_wise_filter', array( $this, 'tp_wise_filter' ) );
			add_action( 'wp_ajax_nopriv_tp_wise_filter', array( $this, 'tp_wise_filter' ) );
		}

		/**
		 * Ajax filter for wise filter
		 *
		 * @version 6.1.4
		 * @since 6.1.4
		 */
		public function tp_wise_filter() {

			check_ajax_referer( 'theplus-addons', 'security' );

			$optiondata = isset( $_POST['option'] ) ? wp_unslash( $_POST['option'] ) : array();
			$filter_id  = isset( $_POST['filter_id'] ) ? sanitize_text_field( wp_unslash( $_POST['filter_id'] ) ) : '';

			$filter_ids = isset( $_POST['filter_ids'] ) ? wp_unslash( $_POST['filter_ids'] ) : array();
			$load_type  = isset( $_POST['load_type'] ) ? sanitize_text_field( wp_unslash( $_POST['load_type'] ) ) : '';

			$postdata = tp_check_decrypt_key( $optiondata );
			$postdata = json_decode( $postdata, true );

			$widgetname = isset( $postdata['load'] ) ? sanitize_text_field( wp_unslash( $postdata['load'] ) ) : '';
			$post_load  = $widgetname;

			$ajax_filter_type = ! empty( $postdata['cat_filter_type'] ) ? $postdata['cat_filter_type'] : 'normal';

			$desktop_class = '';
			$tablet_class  = '';
			$mobile_class  = '';

			if ( 'blogs' === $widgetname ) {
				$content_html = ! empty( $postdata['content_html'] ) ? $postdata['content_html'] : '';
			}

			if ( 'clients' === $widgetname ) {
				$clientContentFrom = ! empty( $_POST['SourceType'] ) ? sanitize_text_field( wp_unslash( $_POST['SourceType'] ) ) : '';
			}

			if ( 'dynamic_smart' === $widgetname ) {
				$post_title_count = ! empty( $postdata['post_title_count'] ) ? ! empty( $postdata['post_title_count'] ) : 10;
			}

			if ( 'products' !== $widgetname ) {
				$title_desc_word_break = isset( $postdata['title_desc_word_break'] ) ? wp_unslash( $postdata['title_desc_word_break'] ) : '';

				$style_layout = isset( $postdata['style_layout'] ) ? sanitize_text_field( wp_unslash( $postdata['style_layout'] ) ) : '';
				$post_tags    = isset( $postdata['post_tags'] ) ? wp_unslash( $postdata['post_tags'] ) : '';
				$post_authors = isset( $postdata['post_authors'] ) ? wp_unslash( $postdata['post_authors'] ) : '';

				$display_post_meta        = isset( $postdata['display_post_meta'] ) ? sanitize_text_field( wp_unslash( $postdata['display_post_meta'] ) ) : '';
				$post_meta_tag_style      = isset( $postdata['post_meta_tag_style'] ) ? wp_unslash( $postdata['post_meta_tag_style'] ) : '';
				$display_post_meta_date   = isset( $postdata['display_post_meta_date'] ) ? wp_unslash( $postdata['display_post_meta_date'] ) : '';
				$display_post_meta_author = isset( $postdata['display_post_meta_author'] ) ? wp_unslash( $postdata['display_post_meta_author'] ) : '';

				$display_post_meta_author_pic = isset( $postdata['display_post_meta_author_pic'] ) ? wp_unslash( $postdata['display_post_meta_author_pic'] ) : '';

				$button_style = isset( $postdata['button_style'] ) ? sanitize_text_field( wp_unslash( $postdata['button_style'] ) ) : '';
				$before_after = isset( $postdata['before_after'] ) ? sanitize_text_field( wp_unslash( $postdata['before_after'] ) ) : '';
				$button_text  = isset( $postdata['button_text'] ) ? sanitize_text_field( wp_unslash( $postdata['button_text'] ) ) : '';
				$button_icon  = isset( $postdata['button_icon'] ) ? $postdata['button_icon'] : '';

				$display_excerpt       = isset( $postdata['display_excerpt'] ) ? sanitize_text_field( wp_unslash( $postdata['display_excerpt'] ) ) : '';
				$post_excerpt_count    = isset( $postdata['post_excerpt_count'] ) ? wp_unslash( $postdata['post_excerpt_count'] ) : '';
				$display_post_category = isset( $postdata['display_post_category'] ) ? wp_unslash( $postdata['display_post_category'] ) : '';

				$dpc_all = isset( $postdata['dpc_all'] ) ? wp_unslash( $postdata['dpc_all'] ) : '';

				$post_category_style  = isset( $postdata['post_category_style'] ) ? sanitize_text_field( wp_unslash( $postdata['post_category_style'] ) ) : '';
				$display_title_limit  = isset( $postdata['display_title_limit'] ) ? wp_unslash( $postdata['display_title_limit'] ) : '';
				$display_title_by     = isset( $postdata['display_title_by'] ) ? wp_unslash( $postdata['display_title_by'] ) : '';
				$display_title_input  = isset( $postdata['display_title_input'] ) ? wp_unslash( $postdata['display_title_input'] ) : '';
				$display_title_3_dots = isset( $postdata['display_title_3_dots'] ) ? wp_unslash( $postdata['display_title_3_dots'] ) : '';

				$feature_image   = isset( $postdata['feature_image'] ) ? wp_unslash( $postdata['feature_image'] ) : '';
				$full_image_size = ! empty( $postdata['full_image_size'] ) ? $postdata['full_image_size'] : 'yes';
				$author_prefix   = isset( $postdata['author_prefix'] ) ? wp_unslash( $postdata['author_prefix'] ) : 'By';

				$news_style           = ! empty( $postdata['news_style'] ) ? $postdata['news_style'] : 'news_style_1';
				$news_highlight_style = ! empty( $postdata['news_highlight_style'] ) ? $postdata['news_highlight_style'] : 'hl_left';
				$news_loop_page       = ! empty( $postdata['news_loop_page'] ) ? $postdata['news_loop_page'] : '6';
				$display_post_title   = ! empty( $postdata['display_post_title'] ) ? $postdata['display_post_title'] : 'yes';

			}

			if ( 'products' === $widgetname ) {
				$b_dis_badge_switch = isset( $postdata['badge'] ) ? sanitize_text_field( wp_unslash( $postdata['badge'] ) ) : '';
				$out_of_stock       = isset( $postdata['out_of_stock'] ) ? sanitize_text_field( wp_unslash( $postdata['out_of_stock'] ) ) : '';

				$variation_price_on = isset( $postdata['variationprice'] ) ? sanitize_text_field( wp_unslash( $postdata['variationprice'] ) ) : '';
				$hover_image_on_off = isset( $postdata['hoverimagepro'] ) ? sanitize_text_field( wp_unslash( $postdata['hoverimagepro'] ) ) : '';

				$display_product   = isset( $postdata['display_product'] ) ? wp_unslash( $postdata['display_product'] ) : '';
				$display_rating    = isset( $postdata['display_rating'] ) ? wp_unslash( $postdata['display_rating'] ) : '';
				$display_catagory  = isset( $postdata['display_catagory'] ) ? wp_unslash( $postdata['display_catagory'] ) : '';
				$display_yith_list = isset( $postdata['display_yith_list'] ) ? wp_unslash( $postdata['display_yith_list'] ) : '';

				$display_yith_compare   = isset( $postdata['display_yith_compare'] ) ? wp_unslash( $postdata['display_yith_compare'] ) : '';
				$display_yith_wishlist  = isset( $postdata['display_yith_wishlist'] ) ? wp_unslash( $postdata['display_yith_wishlist'] ) : '';
				$display_yith_quickview = isset( $postdata['display_yith_quickview'] ) ? wp_unslash( $postdata['display_yith_quickview'] ) : '';
				$display_cart_button    = isset( $postdata['cart_button'] ) ? wp_unslash( $postdata['cart_button'] ) : '';
				$dcb_single_product     = isset( $postdata['dcb_single_product'] ) ? wp_unslash( $postdata['dcb_single_product'] ) : '';
				$dcb_variation_product  = isset( $postdata['dcb_variation_product'] ) ? wp_unslash( $postdata['dcb_variation_product'] ) : '';
			}

			if ( 'team_member' === $widgetname ) {
				$selctSource  = isset( $load_attr['SourceType'] ) ? $load_attr['SourceType'] : '';
				$disable_link = isset( $load_attr['disable_link'] ) ? $load_attr['disable_link'] : '';
				$member_url   = ! empty( $postdata['member_url'] ) ? $postdata['member_url'] : '';

				$member_urlBlank    = ! empty( $postdata['member_urlBlank'] ) ? $postdata['member_urlBlank'] : '';
				$member_urlNofollow = ! empty( $postdata['member_urlNofollow'] ) ? $postdata['member_urlNofollow'] : '';
			}

				$post_type = isset( $postdata['post_type'] ) ? sanitize_text_field( wp_unslash( $postdata['post_type'] ) ) : '';
				$layout    = isset( $postdata['layout'] ) ? sanitize_text_field( wp_unslash( $postdata['layout'] ) ) : '';

				$texonomy_category = isset( $postdata['texonomy_category'] ) ? sanitize_text_field( wp_unslash( $postdata['texonomy_category'] ) ) : '';
				$offset            = ! empty( $postdata['offset-posts'] ) ? $postdata['offset-posts'] : '';

				$more_post_optn = ! empty( $postdata['more_post_option'] ) ? $postdata['more_post_option'] : 'skeleton';
				$loading_optn   = ! empty( $postdata['loading_optn'] ) ? $postdata['loading_optn'] : '';
				$loading_class  = ! empty( $postdata['loading_optn'] ) ? 'style="visibility: visible; opacity: 1; "' : '';

				$display_btn    = ! empty( $postdata['display_btn'] ) ? $postdata['display_btn'] : '';
				$post_load_more = ( isset( $postdata['post_load_more'] ) && intval( $postdata['post_load_more'] ) ) ? wp_unslash( $postdata['post_load_more'] ) : 1;
				$post_title_tag = isset( $postdata['post_title_tag'] ) ? wp_unslash( $postdata['post_title_tag'] ) : '';

				$style = isset( $postdata['style'] ) ? sanitize_text_field( wp_unslash( $postdata['style'] ) ) : 'style-1';

				$desktop_column = ( isset( $postdata['desktop-column'] ) && intval( $postdata['desktop-column'] ) ) ? wp_unslash( $postdata['desktop-column'] ) : 3;
				$tablet_column  = ( isset( $postdata['tablet-column'] ) && intval( $postdata['tablet-column'] ) ) ? wp_unslash( $postdata['tablet-column'] ) : 4;
				$mobile_column  = ( isset( $postdata['mobile-column'] ) && intval( $postdata['mobile-column'] ) ) ? wp_unslash( $postdata['mobile-column'] ) : 6;
				$metro_column   = isset( $postdata['metro_column'] ) ? wp_unslash( $postdata['metro_column'] ) : '';
				$metro_style    = isset( $postdata['metro_style'] ) ? wp_unslash( $postdata['metro_style'] ) : '';

				$responsive_tablet_metro = isset( $postdata['responsive_tablet_metro'] ) ? wp_unslash( $postdata['responsive_tablet_metro'] ) : '';

				$tablet_metro_column = isset( $postdata['tablet_metro_column'] ) ? wp_unslash( $postdata['tablet_metro_column'] ) : '';
				$tablet_metro_style  = isset( $postdata['tablet_metro_style'] ) ? wp_unslash( $postdata['tablet_metro_style'] ) : '';

				$category_type = isset( $postdata['category_type'] ) ? $postdata['category_type'] : 'false';

				$category   = isset( $postdata['category'] ) ? wp_unslash( $postdata['category'] ) : '';
				$order_by   = isset( $postdata['order_by'] ) ? sanitize_text_field( wp_unslash( $postdata['order_by'] ) ) : '';
				$post_order = isset( $postdata['post_order'] ) ? sanitize_text_field( wp_unslash( $postdata['post_order'] ) ) : '';

				$filter_category     = isset( $postdata['filter_category'] ) ? sanitize_text_field( wp_unslash( $postdata['filter_category'] ) ) : '';
				$animated_columns    = isset( $postdata['animated_columns'] ) ? sanitize_text_field( wp_unslash( $postdata['animated_columns'] ) ) : '';
				$featured_image_type = isset( $postdata['featured_image_type'] ) ? wp_unslash( $postdata['featured_image_type'] ) : '';
				$display_thumbnail   = isset( $postdata['display_thumbnail'] ) ? wp_unslash( $postdata['display_thumbnail'] ) : '';

				$thumbnail     = isset( $postdata['thumbnail'] ) ? wp_unslash( $postdata['thumbnail'] ) : '';
				$thumbnail_car = isset( $postdata['thumbnail_car'] ) ? wp_unslash( $postdata['thumbnail_car'] ) : '';

				$display_theplus_quickview = isset( $postdata['display_theplus_quickview'] ) ? wp_unslash( $postdata['display_theplus_quickview'] ) : '';

				$include_posts = isset( $postdata['include_posts'] ) && intval( $postdata['include_posts'] ) ? wp_unslash( $postdata['include_posts'] ) : '';
				$exclude_posts = isset( $postdata['exclude_posts'] ) && intval( $postdata['exclude_posts'] ) ? wp_unslash( $postdata['exclude_posts'] ) : '';

				// $dynamic_template = isset( $postdata['skin_template'] ) ? $postdata['skin_template'] : '';
				$skin_template    = isset( $postdata['skin_template'] ) ? $postdata['skin_template'] : '';
				$dynamic_template = $skin_template;

				$paged = isset( $postdata['page'] ) && intval( $postdata['page'] ) ? wp_unslash( $postdata['page'] ) : '';

				$filter_search_type = ! empty( $postdata['filter_search_type'] ) ? $postdata['filter_search_type'] : '';

				$widget_id  = ! empty( $postdata['widget_id'] ) ? $postdata['widget_id'] : '';
				$filter_url = ! empty( $postdata['filter_url'] ) ? $postdata['filter_url'] : '';

				$enable_archive_search = ( ! empty( $postdata['enablearchive'] ) && 'true' === $postdata['enablearchive'] ) ? 'true' : 'false';

				$display_button = isset( $postdata['display_button'] ) ? wp_unslash( $postdata['display_button'] ) : '';

				$display_post = ( isset( $postdata['display_post'] ) && intval( $postdata['display_post'] ) ) ? sanitize_text_field( $postdata['display_post'] ) : 4;


			// $texonomy_cat = $texonomy_category;
			// if( 'cat' == $texonomy_category ){
			// 	$texonomy_cat = 'category';
			// }

			if ( 'carousel' !== $layout && 'metro' !== $layout ) {
				$desktop_class = 'tp-col-lg-' . esc_attr( $desktop_column );
				$tablet_class  = 'tp-col-md-' . esc_attr( $tablet_column );
				$mobile_class  = 'tp-col-sm-' . esc_attr( $mobile_column );
				$mobile_class .= ' tp-col-' . esc_attr( $mobile_column );
			}

			if ( 'onload' === $load_type ) {
				if ( is_array( $filter_ids ) && array_key_exists( "wish_filter_$widget_id", $filter_ids ) ) {
					$filter_id = $filter_ids[ "wish_filter_$widget_id" ];
				}

				$loadmoreParams = array();

				$referrer  = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : 'No referrer';
				$parsedUrl = wp_parse_url( $referrer );

				if ( isset( $parsedUrl['query'] ) ) {
					$queryParams = array();
					parse_str( $parsedUrl['query'], $queryParams );

					$keyToFind = "loadmore_$widget_id";
					if ( isset( $queryParams[ $keyToFind ] ) ) {
						$loadmore_value = $queryParams[ $keyToFind ];

						$display_post = ( $loadmore_value * $post_load_more ) + $display_post;
					}
				}
			}

			$args = array(
				'post_type'      => $post_type,
				'post_status'    => 'publish',
				'posts_per_page' => $display_post,
				'offset'         => $offset,
				'orderby'        => $order_by,
				'order'          => $post_order,
			);

			if ( ! empty( $exclude_posts ) ) {
				$args['post__not_in'] = explode( ',', $exclude_posts );
			}

			if ( ! empty( $include_posts ) ) {
				$args['post__in'] = explode( ',', $include_posts );
			}

			if ( ! empty( $post_authors ) && ( ( 'post' === $post_type && 'dynamiclisting' === $widgetname ) || 'blogs' === $widgetname ) ) {
				$args['author'] = $post_authors;
			}

			if ( ! empty( $filter_id ) && '*' !== $filter_id ) {
				$attr_tax[] = array(
					'taxonomy' => $texonomy_category,
					'field'    => $filter_search_type,
					'terms'    => explode( ',', $filter_id ),
				);
			}

			if ( ! empty( $attr_tax ) ) {
				$args['tax_query'] = array(
					'relation' => 'AND',
					$attr_tax,
				);
			}

			$ji = 1;
			$ij = '';

			$tablet_ij = '';
			$content   = '';

			$tablet_metro_class = '';

			ob_start();
				$loop       = new WP_Query( $args );
				$totalcount = $loop->found_posts;

			if ( $loop->have_posts() ) {
				while ( $loop->have_posts() ) {
					$loop->the_post();

					// Read more button.
					$the_button = '';
					if ( 'yes' === $display_button ) {

						$btn_uid = uniqid( 'btn' );

						$data_class  = $btn_uid;
						$data_class .= ' button-' . $button_style . ' ';

						$the_button = '<div class="pt-plus-button-wrapper">';

							$the_button .= '<div class="button_parallax">';

								$the_button .= '<div class="ts-button">';

									$the_button .= '<div class="pt_plus_button ' . $data_class . '">';

										$the_button .= '<div class="animted-content-inner">';

											$the_button .= '<a href="' . esc_url( get_the_permalink() ) . '" class="button-link-wrap" role="button" rel="nofollow">';
											$the_button .= include THEPLUS_WSTYLES . 'blog/post-button.php';
											$the_button .= '</a>';

										$the_button .= '</div>';

									$the_button .= '</div>';

								$the_button .= '</div>';

							$the_button .= '</div>';

						$the_button .= '</div>';
					}

					if ( 'products' === $widgetname && 'product' === $post_type ) {
						$template_id = '';
						if ( ! empty( $dynamic_template ) ) {
							$count = count( $dynamic_template );
							$value = (int) $offset % (int) $count;

							$template_id = $dynamic_template[ $value ];
						}
						include THEPLUS_WSTYLES . 'ajax-load-post/product-style.php';
					} elseif ( 'dynamiclisting' === $widgetname ) {
						$template_id = '';
						if ( ! empty( $dynamic_template ) ) {
							$count = count( $dynamic_template );
							$value = (int) $offset % (int) $count;

							$template_id = $dynamic_template[ $value ];
						}
						include THEPLUS_WSTYLES . 'ajax-load-post/dynamic-listing-style.php';
					} elseif ( 'blogs' === $widgetname ) {
						include THEPLUS_WSTYLES . 'ajax-load-post/blog-style.php';
					} elseif ( 'dynamic_smart' === $widgetname ) {
						include THEPLUS_WSTYLES . 'ajax-load-post/dynamic-smart.php';
					} elseif ( 'clients' === $widgetname ) {
						include THEPLUS_WSTYLES . 'ajax-load-post/client-style.php';
					} elseif ( 'team_member' === $widgetname ) {
						include THEPLUS_WSTYLES . 'ajax-load-post/team-member.php';
					}
					++$ji;
				}
			}

			$alldata = ob_get_contents();
			ob_end_clean();

			$result['HtmlData']    = $alldata;
			$result['totalrecord'] = $totalcount;
			$result['widgetName']  = $widgetname;
			$result['layout']      = $layout;
			$result['filter_id']   = $filter_id;
			$result['load_type']   = $load_type;
			$result['widget_id']   = $widget_id;

			if ( 'yes' === $filter_url && 'onload' !== $load_type ) {
				$result['url_name'] = array( "wish_filter_{$widget_id}" => $filter_id );
			}

			wp_reset_postdata();
			wp_send_json( $result );
		}
	}
	return Tp_Wise_Filter::get_instance();
}
