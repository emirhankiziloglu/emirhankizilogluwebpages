<?php
/**
 * The file that defines the core plugin class
 *
 * @link       https://posimyth.com/
 * @since      5.6.2
 *
 * @package    ThePlus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Tpaep_Load_More' ) ) {

	/**
	 * Tpaep_Load_More
	 *
	 * @since 5.6.2
	 */
	class Tpaep_Load_More {

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
		 * @since 5.6.2
		 */
		public function __construct() {
			$this->tp_check_elements();
		}

		/**
		 * Check extra options switcher
		 *
		 * @since 5.6.2
		 */
		public function tp_check_elements() {
			add_action( 'wp_ajax_theplus_more_post', array( $this, 'theplus_more_post_ajax' ) );
			add_action( 'wp_ajax_nopriv_theplus_more_post', array( $this, 'theplus_more_post_ajax' ) );
		}

		/**
		 * Recent View Product
		 *
		 * @since 5.6.2
		 */
		public function theplus_more_post_ajax() {

			global $post;
			
			$load_attr = isset( $_POST['loadattr'] ) ? wp_unslash( $_POST['loadattr'] ) : '';
			if ( empty( $load_attr ) ) {
				ob_start();
				ob_get_contents();
				exit;
				ob_end_clean();
			}

			$load_attr = tp_check_decrypt_key( $load_attr );
			$load_attr = json_decode( $load_attr, true );
			if ( ! is_array( $load_attr ) ) {
				ob_start();
				ob_get_contents();
				exit;
				ob_end_clean();
			}

			$nonce = ( isset( $load_attr['theplus_nonce'] ) ) ? wp_unslash( $load_attr['theplus_nonce'] ) : '';
			if ( ! wp_verify_nonce( $nonce, 'theplus-addons' ) ) {
				die( 'Security checked!' );
			}

			$action = isset( $_POST['doaction'] ) ? wp_unslash( $_POST['doaction'] ) : '';
			$layout = isset( $load_attr['layout'] ) ? sanitize_text_field( wp_unslash( $load_attr['layout'] ) ) : '';
			$style  = isset( $load_attr['style'] ) ? sanitize_text_field( wp_unslash( $load_attr['style'] ) ) : '';
			$paged  = isset( $_POST['paged'] ) && intval( $_POST['paged'] ) ? wp_unslash( $_POST['paged'] ) : '';
			$offset = isset( $_POST['offset'] ) && intval( $_POST['offset'] ) ? wp_unslash( $_POST['offset'] ) : '';

			$widget_id  = ! empty( $load_attr['widget_id'] ) ? wp_unslash( $load_attr['widget_id'] ) : '';
			$filter_cat = isset( $_POST['filter_cat'] ) ? wp_unslash( $_POST['filter_cat'] ) : '';

			$post_load = isset( $load_attr['load'] ) ? sanitize_text_field( wp_unslash( $load_attr['load'] ) ) : '';

			$widgetname = $post_load;
			$post_type = isset( $load_attr['post_type'] ) ? sanitize_text_field( wp_unslash( $load_attr['post_type'] ) ) : '';
			$category  = isset( $load_attr['category'] ) ? wp_unslash( $load_attr['category'] ) : '';
			
			$more_post_optn = ! empty( $load_attr['more_post_option'] ) ? $load_attr['more_post_option'] : 'skeleton';
			$loading_optn   = ! empty( $load_attr['loading_optn'] ) ? $load_attr['loading_optn'] : 'skeleton';
			$loading_class  = ! empty( $load_attr['loading_optn'] ) ? 'style="visibility: visible; opacity: 1; "' : '';

			$filter_type   = isset( $load_attr['listing_type'] ) ? sanitize_text_field( wp_unslash( $load_attr['listing_type'] ) ) : '';
			$display_post  = isset( $load_attr['display_post'] ) && intval( $load_attr['display_post'] ) ? wp_unslash( $load_attr['display_post'] ) : 4;
			$include_posts = isset( $load_attr['include_posts'] ) ? sanitize_text_field( wp_unslash( $load_attr['include_posts'] ) ) : '';
			$exclude_posts = isset( $load_attr['exclude_posts'] ) ? sanitize_text_field( wp_unslash( $load_attr['exclude_posts'] ) ) : '';
			$offset_posts  = isset( $load_attr['offset-posts'] ) && intval( $load_attr['offset-posts'] ) ? wp_unslash( $load_attr['offset-posts'] ) : 0;

			$post_load_more = isset( $load_attr['post_load_more'] ) && intval( $load_attr['post_load_more'] ) ? wp_unslash( $load_attr['post_load_more'] ) : '';
			$desktop_column = isset( $load_attr['desktop-column'] ) && intval( $load_attr['desktop-column'] ) ? wp_unslash( $load_attr['desktop-column'] ) : '';
			$tablet_column  = isset( $load_attr['tablet-column'] ) && intval( $load_attr['tablet-column'] ) ? wp_unslash( $load_attr['tablet-column'] ) : '';
			$mobile_column  = isset( $load_attr['mobile-column'] ) && intval( $load_attr['mobile-column'] ) ? wp_unslash( $load_attr['mobile-column'] ) : '';

			$metro_column = isset( $load_attr['metro_column'] ) ? wp_unslash( $load_attr['metro_column'] ) : '';
			$metro_style  = isset( $load_attr['metro_style'] ) ? wp_unslash( $load_attr['metro_style'] ) : '';

			$responsive_tablet_metro = isset( $load_attr['responsive_tablet_metro'] ) ? wp_unslash( $load_attr['responsive_tablet_metro'] ) : '';

			$tablet_metro_column = isset( $load_attr['tablet_metro_column'] ) ? wp_unslash( $load_attr['tablet_metro_column'] ) : '';
			$tablet_metro_style  = isset( $load_attr['tablet_metro_style'] ) ? wp_unslash( $load_attr['tablet_metro_style'] ) : '';

			$order_by   = isset( $load_attr['order_by'] ) ? sanitize_text_field( wp_unslash( $load_attr['order_by'] ) ) : '';
			$post_order = isset( $load_attr['post_order'] ) ? sanitize_text_field( wp_unslash( $load_attr['post_order'] ) ) : '';

			$filter_category  = isset( $load_attr['filter_category'] ) ? wp_unslash( $load_attr['filter_category'] ) : '';
			$animated_columns = isset( $load_attr['animated_columns'] ) ? sanitize_text_field( wp_unslash( $load_attr['animated_columns'] ) ) : '';

			$featured_image_type = isset( $load_attr['featured_image_type'] ) ? wp_unslash( $load_attr['featured_image_type'] ) : '';
			$display_thumbnail   = isset( $load_attr['display_thumbnail'] ) ? wp_unslash( $load_attr['display_thumbnail'] ) : '';

			$thumbnail     = isset( $load_attr['thumbnail'] ) ? wp_unslash( $load_attr['thumbnail'] ) : '';
			$thumbnail_car = isset( $load_attr['thumbnail_car'] ) ? wp_unslash( $load_attr['thumbnail_car'] ) : '';

			$skin_template    = isset( $load_attr['skin_template'] ) ? $load_attr['skin_template'] : '';
			$dynamic_template = $skin_template;

			$display_theplus_quickview = isset( $load_attr['display_theplus_quickview'] ) ? wp_unslash( $load_attr['display_theplus_quickview'] ) : '';

			$display_post_title = isset( $load_attr['display_post_title'] ) ? wp_unslash( $load_attr['display_post_title'] ) : '';
			$post_title_tag     = isset( $load_attr['post_title_tag'] ) ? wp_unslash( $load_attr['post_title_tag'] ) : '';

			$button_style = isset( $load_attr['button_style'] ) ? sanitize_text_field( wp_unslash( $load_attr['button_style'] ) ) : '';
			$before_after = isset( $load_attr['before_after'] ) ? sanitize_text_field( wp_unslash( $load_attr['before_after'] ) ) : '';
			$button_text  = isset( $load_attr['button_text'] ) ? sanitize_text_field( wp_unslash( $load_attr['button_text'] ) ) : '';
			$button_icon  = isset( $load_attr['button_icon'] ) ? $load_attr['button_icon'] : '';

			$button_icon_style = isset( $load_attr['button_icon_style'] ) ? sanitize_text_field( wp_unslash( $load_attr['button_icon_style'] ) ) : '';
			$button_icons_mind = isset( $load_attr['button_icons_mind'] ) ? $load_attr['button_icons_mind'] : '';

			$ex_cat = isset( $load_attr['ex_cat'] ) ? wp_unslash( $load_attr['ex_cat'] ) : '';
			$ex_tag = isset( $load_attr['ex_tag'] ) ? wp_unslash( $load_attr['ex_tag'] ) : '';

			$filter_search_type = ! empty( $load_attr['filter_search_type'] ) ? $load_attr['filter_search_type'] : '';

			// if( 'dynamiclisting' === $post_load ) {
				$display_post_category = isset( $load_attr['display_post_category'] ) ? wp_unslash( $load_attr['display_post_category'] ) : '';
				$post_category_style   = isset( $load_attr['post_category_style'] ) ? wp_unslash( $load_attr['post_category_style'] ) : '';
				$title_desc_word_break = isset( $load_attr['title_desc_word_break'] ) ? wp_unslash( $load_attr['title_desc_word_break'] ) : '';

				$display_button = isset( $load_attr['display_button'] ) ? wp_unslash( $load_attr['display_button'] ) : '';

				$display_excerpt   = isset( $load_attr['display_excerpt'] ) ? wp_unslash( $load_attr['display_excerpt'] ) : '';
				$texonomy_category = isset( $load_attr['texonomy_category'] ) ? sanitize_text_field( wp_unslash( $load_attr['texonomy_category'] ) ) : '';

				$author_prefix = isset( $load_attr['author_prefix'] ) ? wp_unslash( $load_attr['author_prefix'] ) : '';
				$style_layout  = isset( $load_attr['style_layout'] ) ? sanitize_text_field( wp_unslash( $load_attr['style_layout'] ) ) : '';
				$post_tags     = isset( $load_attr['post_tags'] ) ? wp_unslash( $load_attr['post_tags'] ) : '';
				$post_authors  = isset( $load_attr['post_authors'] ) ? wp_unslash( $load_attr['post_authors'] ) : '';

				$display_post_meta   = isset( $load_attr['display_post_meta'] ) ? wp_unslash( $load_attr['display_post_meta'] ) : '';
				$post_meta_tag_style = isset( $load_attr['post_meta_tag_style'] ) ? wp_unslash( $load_attr['post_meta_tag_style'] ) : '';

				$display_post_meta_date   = isset( $load_attr['display_post_meta_date'] ) ? wp_unslash( $load_attr['display_post_meta_date'] ) : '';
				$display_post_meta_author = isset( $load_attr['display_post_meta_author'] ) ? wp_unslash( $load_attr['display_post_meta_author'] ) : '';

				$display_post_meta_author_pic = isset( $load_attr['display_post_meta_author_pic'] ) ? wp_unslash( $load_attr['display_post_meta_author_pic'] ) : '';

				$dpc_all = isset( $load_attr['dpc_all'] ) ? wp_unslash( $load_attr['dpc_all'] ) : '';

				$post_excerpt_count   = isset( $load_attr['post_excerpt_count'] ) ? wp_unslash( $load_attr['post_excerpt_count'] ) : '';
				$display_title_limit  = isset( $load_attr['display_title_limit'] ) ? wp_unslash( $load_attr['display_title_limit'] ) : '';
				$display_title_by     = isset( $load_attr['display_title_by'] ) ? wp_unslash( $load_attr['display_title_by'] ) : '';
				$display_title_input  = isset( $load_attr['display_title_input'] ) ? wp_unslash( $load_attr['display_title_input'] ) : '';
				$display_title_3_dots = isset( $load_attr['display_title_3_dots'] ) ? wp_unslash( $load_attr['display_title_3_dots'] ) : '';

				$feature_image = isset( $load_attr['feature_image'] ) ? wp_unslash( $load_attr['feature_image'] ) : '';
			// }

			// if ( 'products' === $widgetName ) {
				$out_of_stock    = isset( $load_attr['out_of_stock'] ) ? sanitize_text_field( wp_unslash( $load_attr['out_of_stock'] ) ) : '';
				$display_rating  = isset( $load_attr['display_rating'] ) ? wp_unslash( $load_attr['display_rating'] ) : '';
				$display_product = isset( $load_attr['display_product'] ) ? wp_unslash( $load_attr['display_product'] ) : '';

				$b_dis_badge_switch = isset( $load_attr['badge'] ) ? sanitize_text_field( wp_unslash( $load_attr['badge'] ) ) : '';
				$variation_price_on = isset( $load_attr['variationprice'] ) ? sanitize_text_field( wp_unslash( $load_attr['variationprice'] ) ) : '';
				$hover_image_on_off = isset( $load_attr['hoverimagepro'] ) ? sanitize_text_field( wp_unslash( $load_attr['hoverimagepro'] ) ) : '';

				$display_catagory  = isset( $load_attr['display_catagory'] ) ? wp_unslash( $load_attr['display_catagory'] ) : '';
				$display_yith_list = isset( $load_attr['display_yith_list'] ) ? wp_unslash( $load_attr['display_yith_list'] ) : '';

				$display_yith_compare  = isset( $load_attr['display_yith_compare'] ) ? wp_unslash( $load_attr['display_yith_compare'] ) : '';
				$display_yith_wishlist = isset( $load_attr['display_yith_wishlist'] ) ? wp_unslash( $load_attr['display_yith_wishlist'] ) : '';

				$display_cart_button = isset( $load_attr['cart_button'] ) ? wp_unslash( $load_attr['cart_button'] ) : '';
				$dcb_single_product  = isset( $load_attr['dcb_single_product'] ) ? wp_unslash( $load_attr['dcb_single_product'] ) : '';

				$dcb_variation_product = isset( $load_attr['dcb_variation_product'] ) ? wp_unslash( $load_attr['dcb_variation_product'] ) : '';
			/** }*/

			if ( 'blogs' === $post_load ) {
				$content_html = isset( $load_attr['content_html'] ) ? wp_unslash( $load_attr['content_html'] ) : '';
			}

			$desktop_class = '';
			$tablet_class  = '';
			$mobile_class  = '';

			if ( 'carousel' !== $layout && 'metro' !== $layout ) {
				$desktop_class = 'tp-col-lg-' . esc_attr( $desktop_column );
				$tablet_class  = 'tp-col-md-' . esc_attr( $tablet_column );
				$mobile_class  = 'tp-col-sm-' . esc_attr( $mobile_column );
				$mobile_class .= ' tp-col-' . esc_attr( $mobile_column );
			}

			$clientContentFrom = '';
			if ( 'clients' === $post_load ) {
				$clientContentFrom = isset( $load_attr['SourceType'] ) ? $load_attr['SourceType'] : '';
				$disable_link      = isset( $load_attr['disable_link'] ) ? $load_attr['disable_link'] : '';
			}

			if ( 'team_member' === $post_load ) {
				$selctSource  = isset( $load_attr['SourceType'] ) ? $load_attr['SourceType'] : '';
				$disable_link = isset( $load_attr['disable_link'] ) ? $load_attr['disable_link'] : '';
				$member_url   = isset( $load_attr['member_url'] ) ? $load_attr['member_url'] : '';

				$member_urlBlank    = isset( $load_attr['member_urlBlank'] ) ? $load_attr['member_urlBlank'] : '';
				$member_urlNofollow = isset( $load_attr['member_urlNofollow'] ) ? $load_attr['member_urlNofollow'] : '';
			}

			$j = 1;

			if( 'wishlist' === $filter_type ){
				$wishlistname = ! empty( $_POST['shopname'] ) ? wp_unslash( $_POST['shopname'] ) : '';

				$login = ! empty( $_POST['login'] ) ? wp_unslash( $_POST['login'] ) : '';

				if ( 'true' === $login ) {
					$user = wp_get_current_user();

					$user_wishlist = get_user_meta( $user->ID, $wishlistname, true );
					if ( $user_wishlist ) {
						$uwl = $user_wishlist;
					}
				} else { 
					$uwl = ! empty( $_POST['notloginwl'] ) ? wp_unslash( $_POST['notloginwl'] ) : array();
				}
			}

			if( ! empty( $action ) && 'on-load' === $action ) {
				$loadmoreParams = isset( $_POST['loadmoreParams'] ) ? wp_unslash( $_POST['loadmoreParams'] ) : array();
				$extrapost = 0;
				foreach ( $loadmoreParams as $loadmoreKey => $value ) {
					if ( strpos( $loadmoreKey, $widget_id ) !== false ) {
						$extrapost = intval( $post_load_more * $value );
						$post_load_more = intval( $display_post + $extrapost );
					}
				}
				// $offset = 0;
				$offset = $offset_posts;
			}

			$args = array(
				'post_type'        => $post_type,
				'posts_per_page'   => $post_load_more,
				// $texonomy_category => $category,
				'offset'           => $offset,
				'orderby'          => $order_by,
				'post_status'      => 'publish',
				'order'            => $post_order,
			);

			if( ! empty( $texonomy_category ) ){
				$args[$texonomy_category] = $category;
			}

			if ( 'wishlist' === $filter_type ) {
				$args['post__in'] = $uwl;
			}

			if ( '' !== $ex_tag ) {
				$ex_tag = explode( ',', $ex_tag );

				$args['tag__not_in'] = $ex_tag;
			}
			if ( '' !== $ex_cat ) {
				$ex_cat = explode( ',', $ex_cat );

				$args['category__not_in'] = $ex_cat;
			}

			if ( '' !== $exclude_posts ) {
				$exclude_posts = explode( ',', $exclude_posts );

				$args['post__not_in'] = $exclude_posts;
			}
			if ( '' !== $include_posts ) {
				$include_posts    = explode( ',', $include_posts );
				$args['post__in'] = $include_posts;
			}

			if ( ( ! empty( $post_type ) && 'product' === $post_type ) ) {
				$attr_tax[] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => array( 'exclude-from-search', 'exclude-from-catalog' ),
					'operator' => 'NOT IN',
				);
			}

			if( ! empty( $display_product ) ){
				if ( 'featured' === $display_product ) {
					$attr_tax[] = array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
					);
				}
	
				if ( 'on_sale' === $display_product ) {
					$args['meta_query'] = array(
						'relation' => 'OR',
						array(              // Simple products type.
							'key'     => '_sale_price',
							'value'   => 0,
							'compare' => '>',
							'type'    => 'numeric',
						),
						array(              // Variable products type.
							'key'     => '_min_variation_sale_price',
							'value'   => 0,
							'compare' => '>',
							'type'    => 'numeric',
						),
					);
				}
	
				if ( 'top_sales' === $display_product ) {
					$args['meta_query'] = array(
						array(
							'key'     => 'total_sales',
							'value'   => 0,
							'compare' => '>',
						),
					);
				}
	
				if ( 'instock' === $display_product ) {
					$args['meta_query'] = array(
						array(
							'key'   => '_stock_status',
							'value' => 'instock',
						),
					);
				}
	
				if ( 'outofstock' === $display_product ) {
					$args['meta_query'] = array(
						array(
							'key'   => '_stock_status',
							'value' => 'outofstock',
						),
					);
				}
			}

			if ( '' !== $post_tags && 'post' === $post_type ) {
				$post_tags = explode( ',', $post_tags );

				$attr_tax[] = array(
					'taxonomy'         => 'post_tag',
					'terms'            => $post_tags,
					'field'            => 'term_id',
					'operator'         => 'IN',
					'include_children' => true,
				);
			}

			if ( ! empty( $post_type ) && ( 'post' !== $post_type && 'product' !== $post_type ) ) {
				if ( ! empty( $texonomy_category ) && 'categories' === $texonomy_category && ! empty( $category ) ) {
					$category = explode( ',', $category );

					$args['tax_query'] = array(
						array(
							'taxonomy' => 'categories',
							'field'    => 'slug',
							'terms'    => $category,
						),
					);
				}
			}

			if( !empty( $filter_cat ) ) {
				$attr_tax[] = array(
					'taxonomy' => $texonomy_category,
					'field'    => $filter_search_type,
					'terms'    => explode( ',', $filter_cat ),
				);
			}

			if ( ! empty( $attr_tax ) ) {
				$args['tax_query'] = array( 'relation' => 'AND', $attr_tax );
			}

			if ( '' !== $post_authors && 'post' === $post_type ) {
				$args['author'] = $post_authors;
			}

			$ji = ( $post_load_more * $paged ) - $post_load_more + $display_post + 1;
			$ij = '';

			$tablet_ij = '';
			$content   = '';

			$tablet_metro_class = '';

			ob_start();
			
			$loop = new WP_Query( $args );
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
												$the_button .= include THEPLUS_WSTYLES. 'blog/post-button.php'; 
												$the_button .= '</a>';
	
											$the_button .= '</div>';
	
										$the_button .= '</div>';
	
									$the_button .= '</div>';
	
								$the_button .= '</div>';
	
							$the_button .= '</div>';
	
						}
	
						if ( 'blogs' === $post_load ) {
							include THEPLUS_WSTYLES . 'ajax-load-post/blog-style.php';
						}

						if ( 'clients' === $post_load ) {
							include THEPLUS_WSTYLES . 'ajax-load-post/client-style.php';
						}
						if ( 'team_member' === $post_load ) {
							include THEPLUS_WSTYLES . 'ajax-load-post/team-member.php';
						}
						if ( 'portfolios' === $post_load ) {
							include THEPLUS_WSTYLES . 'ajax-load-post/portfolio-style.php';
						}
						if ( 'products' === $post_load || 'dynamiclisting' === $post_load ) {
							$template_id = '';
							if ( ! empty( $dynamic_template ) ) {
								$count = count( $dynamic_template );
								$value = $offset % $count;

								$template_id = $dynamic_template[ $value ];
							}
							if ( 'dynamiclisting' === $post_load ) {
								include THEPLUS_WSTYLES . 'ajax-load-post/dynamic-listing-style.php';
							}
	
							if ( 'products' === $post_load ) {
								include THEPLUS_WSTYLES . 'ajax-load-post/product-style.php';
							}
	
							++$offset;
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
			$result['widget_id']   = $widget_id;
			// $result['filter_id']   = $filter_id;
			// $result['load_type']   = $load_type;

			wp_reset_postdata();
			wp_send_json( $result );
		}
	}

	return Tpaep_Load_More::get_instance();
}