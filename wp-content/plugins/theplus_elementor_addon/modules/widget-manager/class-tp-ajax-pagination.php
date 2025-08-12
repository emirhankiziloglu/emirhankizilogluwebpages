<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://posimyth.com/
 * @since      5.4.2
 *
 * @package    ThePlus
 */

/**
 * Exit if accessed directly.
 * */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Tp_ajax_pagination' ) ) {

	/**
	 * It is Tp_ajax_pagination Main Class
	 *
	 * @since 5.4.2
	 */
	class Tp_ajax_pagination {

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
		 * @since 5.4.2
		 */
		public function __construct() {
			add_action( 'wp_ajax_theplus_ajax_based_pagination', array( $this, 'theplus_ajax_based_pagination' ) );
			add_action( 'wp_ajax_nopriv_theplus_ajax_based_pagination', array( $this, 'theplus_ajax_based_pagination' ) );
		}

		/**
		 * AJAX Pagination for the listing
		 *
		 * @since 5.4.2
		 */
		public function theplus_ajax_based_pagination() {

			/**Security checked wp nonce */
			$nonce = ! empty( $_POST['nonce'] ) ? wp_unslash( $_POST['nonce'] ) : '';
			if ( ! isset( $nonce ) || empty( $nonce ) || ! wp_verify_nonce( $nonce, 'theplus-addons' ) ) {
				die( 'Security checked!' );
			}

			/**Security checked wp nonce */
			check_ajax_referer( 'theplus-addons', 'nonce' );

			$postdata = isset( $_POST['option'] ) ? wp_unslash( $_POST['option'] ) : '';
			if ( empty( $postdata ) || ! is_array( $postdata ) ) {
				ob_start();
					ob_get_contents();
				ob_end_clean();
				exit;
			}

			/** $filter_type = ( !empty($postdata['filtertype']) && 'search_list' === $postdata['filtertype'] ) ? $postdata['filtertype'] : ''; */
			$widgetname = isset( $postdata['load'] ) ? sanitize_text_field( wp_unslash( $postdata['load'] ) ) : '';
			$post_load  = $widgetname;

			$desktop_class = '';
			$tablet_class  = '';
			$mobile_class  = '';

			$tablet_metro_class = 0;

			$kij = 0;
			$ji  = 1;
			$ij  = '';

			$offset = 0;

			$paginationType = ! empty( $postdata['paginationType'] ) ? $postdata['paginationType'] : 'standard';
			$loading_optn  = ! empty( $postdata['loading_optn'] ) ? $postdata['loading_optn'] : 'skeleton';

			if ( 'dynamiclisting' === $widgetname || 'products' === $widgetname ) {
				$layout = isset( $postdata['layout'] ) ? sanitize_text_field( wp_unslash( $postdata['layout'] ) ) : '';
				$style  = isset( $postdata['style'] ) ? sanitize_text_field( wp_unslash( $postdata['style'] ) ) : 'style-1';

				$post_type = isset( $postdata['post_type'] ) ? sanitize_text_field( wp_unslash( $postdata['post_type'] ) ) : '';

				$texonomy_category = isset( $postdata['texonomy_category'] ) ? sanitize_text_field( wp_unslash( $postdata['texonomy_category'] ) ) : '';

				$DisplayPost  = isset( $postdata['display_post'] ) && intval( $postdata['display_post'] ) ? sanitize_text_field( $postdata['display_post'] ) : 4;
				$display_post = $DisplayPost;       // Not used.

				$post_load_more = isset( $postdata['post_load_more'] ) && intval( $postdata['post_load_more'] ) ? wp_unslash( $postdata['post_load_more'] ) : 1;
				$post_title_tag = isset( $postdata['post_title_tag'] ) ? wp_unslash( $postdata['post_title_tag'] ) : '';
				$desktop_column = isset( $postdata['desktop-column'] ) && intval( $postdata['desktop-column'] ) ? wp_unslash( $postdata['desktop-column'] ) : 3;
				$tablet_column  = isset( $postdata['tablet-column'] ) && intval( $postdata['tablet-column'] ) ? wp_unslash( $postdata['tablet-column'] ) : 4;
				$mobile_column  = isset( $postdata['mobile-column'] ) && intval( $postdata['mobile-column'] ) ? wp_unslash( $postdata['mobile-column'] ) : 6;

				$metro_column = isset( $postdata['metro_column'] ) ? wp_unslash( $postdata['metro_column'] ) : '';
				$metro_style  = isset( $postdata['metro_style'] ) ? wp_unslash( $postdata['metro_style'] ) : '';

				$responsive_tablet_metro = isset( $postdata['responsive_tablet_metro'] ) ? wp_unslash( $postdata['responsive_tablet_metro'] ) : '';

				$tablet_metro_column = isset( $postdata['tablet_metro_column'] ) ? wp_unslash( $postdata['tablet_metro_column'] ) : '';
				$tablet_metro_style  = isset( $postdata['tablet_metro_style'] ) ? wp_unslash( $postdata['tablet_metro_style'] ) : '';

				$category = isset( $postdata['category'] ) ? wp_unslash( $postdata['category'] ) : '';
				$order_by = isset( $postdata['order_by'] ) ? sanitize_text_field( wp_unslash( $postdata['order_by'] ) ) : '';

				$post_order    = isset( $postdata['post_order'] ) ? sanitize_text_field( wp_unslash( $postdata['post_order'] ) ) : '';
				$category_type = isset( $postdata['category_type'] ) ? $postdata['category_type'] : 'false';

				$filter_category  = isset( $postdata['filter_category'] ) ? sanitize_text_field( wp_unslash( $postdata['filter_category'] ) ) : '';
				$animated_columns = isset( $postdata['animated_columns'] ) ? sanitize_text_field( wp_unslash( $postdata['animated_columns'] ) ) : '';

				$featured_image_type = isset( $postdata['featured_image_type'] ) ? wp_unslash( $postdata['featured_image_type'] ) : '';
				$display_thumbnail   = isset( $postdata['display_thumbnail'] ) ? wp_unslash( $postdata['display_thumbnail'] ) : '';

				$thumbnail     = isset( $postdata['thumbnail'] ) ? wp_unslash( $postdata['thumbnail'] ) : '';
				$thumbnail_car = isset( $postdata['thumbnail_car'] ) ? wp_unslash( $postdata['thumbnail_car'] ) : '';

				$display_theplus_quickview = isset( $postdata['display_theplus_quickview'] ) ? wp_unslash( $postdata['display_theplus_quickview'] ) : '';

				$includePosts = isset( $postdata['include_posts'] ) && intval( $postdata['include_posts'] ) ? wp_unslash( $postdata['include_posts'] ) : '';
				$excludePosts = isset( $postdata['exclude_posts'] ) && intval( $postdata['exclude_posts'] ) ? wp_unslash( $postdata['exclude_posts'] ) : '';

				$paged = isset( $postdata['page'] ) && intval( $postdata['page'] ) ? wp_unslash( $postdata['page'] ) : '';      // Not used.

				$dynamic_template = isset( $postdata['skin_template'] ) ? $postdata['skin_template'] : '';

				$is_archivePage  = isset( $postdata['is_archive'] ) ? $postdata['is_archive'] : 0;
				$Archivepage     = isset( $postdata['archive_page'] ) ? $postdata['archive_page'] : '';
				$ArchivepageType = ! empty( $Archivepage ) && ! empty( $Archivepage['archive_Type'] ) ? sanitize_text_field( $Archivepage['archive_Type'] ) : '';
				$ArchivepageID   = ! empty( $Archivepage ) && ! empty( $Archivepage['archive_Id'] ) ? $Archivepage['archive_Id'] : '';
				$ArchivepageName = ! empty( $Archivepage ) && ! empty( $Archivepage['archive_Name'] ) ? $Archivepage['archive_Name'] : '';

				$is_searchPage = isset( $postdata['is_search'] ) ? $postdata['is_search'] : 0;
				$SearchPage    = isset( $postdata['is_search_page'] ) ? $postdata['is_search_page'] : '';
				$SearchPageval = ! empty( $SearchPage ) && ! empty( $SearchPage['is_search_value'] ) ? sanitize_text_field( $SearchPage['is_search_value'] ) : '';
				$CustonQuery   = ! empty( $postdata['custon_query'] ) ? $postdata['custon_query'] : '';
				$author_prefix = isset( $load_attr['author_prefix'] ) ? wp_unslash( $load_attr['author_prefix'] ) : '';
				$listing_type  = isset( $postdata['listing_type'] ) ? $postdata['listing_type'] : '';

				$enable_archive_search = ! empty( $postdata['enable_archive_search'] ) ? 'true' : 'false';

				if ( 'carousel' !== $layout && 'metro' !== $layout ) {
					$desktop_class = 'tp-col-lg-' . esc_attr( $desktop_column );
					$tablet_class  = 'tp-col-md-' . esc_attr( $tablet_column );
					$mobile_class  = 'tp-col-sm-' . esc_attr( $mobile_column );
					$mobile_class .= ' tp-col-' . esc_attr( $mobile_column );
				}
			}

			if ( 'dynamiclisting' === $widgetname ) {
				$title_desc_word_break = isset( $postdata['title_desc_word_break'] ) ? wp_unslash( $postdata['title_desc_word_break'] ) : '';

				$style_layout = isset( $postdata['style_layout'] ) ? sanitize_text_field( wp_unslash( $postdata['style_layout'] ) ) : '';
				$post_tags    = isset( $postdata['post_tags'] ) ? wp_unslash( $postdata['post_tags'] ) : '';
				$post_authors = isset( $postdata['post_authors'] ) ? wp_unslash( $postdata['post_authors'] ) : '';

				$display_post_meta   = isset( $postdata['display_post_meta'] ) ? sanitize_text_field( wp_unslash( $postdata['display_post_meta'] ) ) : '';
				$post_meta_tag_style = isset( $postdata['post_meta_tag_style'] ) ? wp_unslash( $postdata['post_meta_tag_style'] ) : '';

				$display_post_meta_date   = isset( $postdata['display_post_meta_date'] ) ? wp_unslash( $postdata['display_post_meta_date'] ) : '';
				$display_post_meta_author = isset( $postdata['display_post_meta_author'] ) ? wp_unslash( $postdata['display_post_meta_author'] ) : '';

				$display_post_meta_author_pic = isset( $postdata['display_post_meta_author_pic'] ) ? wp_unslash( $postdata['display_post_meta_author_pic'] ) : '';

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

				$texo_category = ! empty( $postdata['texo_category'] ) ? $postdata['texo_category'] : '';
				$texo_post_tag = ! empty( $postdata['texo_post_tag'] ) ? $postdata['texo_post_tag'] : '';

				$texo_post_taxonomies = ! empty( $postdata['texo_post_taxonomies'] ) ? $postdata['texo_post_taxonomies'] : '';

				$texo_include_slug = ! empty( $postdata['texo_include_slug'] ) ? $postdata['texo_include_slug'] : '';
				$author_prefix     = isset( $postdata['author_prefix'] ) ? wp_unslash( $postdata['author_prefix'] ) : 'By';
			} elseif ( 'products' === $widgetname ) {
				$out_of_stock = isset( $postdata['out_of_stock'] ) ? sanitize_text_field( wp_unslash( $postdata['out_of_stock'] ) ) : '';

				$b_dis_badge_switch = isset( $postdata['badge'] ) ? sanitize_text_field( wp_unslash( $postdata['badge'] ) ) : '';
				$variation_price_on = isset( $postdata['variationprice'] ) ? sanitize_text_field( wp_unslash( $postdata['variationprice'] ) ) : '';
				$hover_image_on_off = isset( $postdata['hoverimagepro'] ) ? sanitize_text_field( wp_unslash( $postdata['hoverimagepro'] ) ) : '';

				$display_product = isset( $postdata['display_product'] ) ? wp_unslash( $postdata['display_product'] ) : '';
				$display_rating  = isset( $postdata['display_rating'] ) ? wp_unslash( $postdata['display_rating'] ) : '';

				$display_catagory  = isset( $postdata['display_catagory'] ) ? wp_unslash( $postdata['display_catagory'] ) : '';
				$display_yith_list = isset( $postdata['display_yith_list'] ) ? wp_unslash( $postdata['display_yith_list'] ) : '';

				$display_yith_compare   = isset( $postdata['display_yith_compare'] ) ? wp_unslash( $postdata['display_yith_compare'] ) : '';
				$display_yith_wishlist  = isset( $postdata['display_yith_wishlist'] ) ? wp_unslash( $postdata['display_yith_wishlist'] ) : '';
				$display_yith_quickview = isset( $postdata['display_yith_quickview'] ) ? wp_unslash( $postdata['display_yith_quickview'] ) : '';
				$dcb_variation_product  = isset( $postdata['dcb_variation_product'] ) ? wp_unslash( $postdata['dcb_variation_product'] ) : '';

				$display_cart_button = isset( $postdata['cart_button'] ) ? wp_unslash( $postdata['cart_button'] ) : '';
				$dcb_single_product  = isset( $postdata['dcb_single_product'] ) ? wp_unslash( $postdata['dcb_single_product'] ) : '';
			}

			$Paginate_sf = ! empty( $postdata['Paginate_sf'] ) ? $postdata['Paginate_sf'] : 0;
			$new_offset  = ! empty( $postdata['new_offset'] ) ? $postdata['new_offset'] : 0;

			$offset = (int) $new_offset;

			if ( 'wishlist' === $listing_type || 'recently_viewed' === $listing_type ) {
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

			if ( ! empty( $CustonQuery ) ) {
				$args = array();
				if ( has_filter( $CustonQuery ) ) {
					$args = apply_filters( $CustonQuery, $args );
				}
			} elseif ( 'dynamiclisting' === $widgetname || 'products' === $widgetname ) {
				$args = array(
					'post_type'      => $post_type,
					'post_status'    => 'publish',
					'posts_per_page' => $DisplayPost,
					'offset'         => $offset,
					'orderby'        => $order_by,
					'order'          => $post_order,
				);

				if ( 'wishlist' === $listing_type || 'recently_viewed' === $listing_type ) {
					$args['post__in'] = $uwl;
				}
			}

			/**Display Product Option ListingWidget*/
			if ( 'products' === $widgetname ) {
				if ( ! empty( $texonomy_category ) && ! empty( $category ) && empty( $is_archivePage ) ) {
					$attr_tax[] = array(
						'taxonomy' => $texonomy_category,
						'field'    => 'slug',
						'terms'    => explode( ',', $category ),
					);
				} 

				if( 'recently_viewed' === $listing_type ){
					$display_product = 'all';
				}

				if ( 'all' !== $display_product ) {
					$wooProductType = theplus_woo_product_type( $display_product );

					if ( ! empty( $wooProductType ) ) {
						if ( 'featured' === $display_product ) {
							$attr_tax[] = $wooProductType;
						}

						if ( 'featured' !== $display_product ) {
							$meta_keyArr[] = $wooProductType;
						}
					}
				}

				if ( 'all' === $display_product ) {
					$attr_tax[] = array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => array( 'exclude-from-search', 'exclude-from-catalog' ),
						'operator' => 'NOT IN',
					);
				}
			}

			if ( 'dynamiclisting' === $widgetname && empty( $is_archivePage ) ) {
				if ( 'post' === $post_type ) {
					if ( ! empty( $texo_category ) ) {
						$attr_tax[] = array(
							'taxonomy' => $texo_category,
							'field'    => 'id',
							'terms'    => explode( ',', $category ),
						);
					}

					if ( ! empty( $texo_post_tag ) ) {
						$attr_tax[] = array(
							'taxonomy' => $texo_post_tag,
							'field'    => 'id',
							'terms'    => explode( ',', $post_tags ),
						);
					}
				} elseif ( ! empty( $texo_include_slug ) && ! empty( $texo_post_taxonomies ) ) {
						$attr_tax[] = array(
							'taxonomy' => $texo_post_taxonomies,
							'field'    => 'slug',
							'terms'    => explode( ',', $texo_include_slug ),
						);
				}
			}

			/**Archive Page*/
			if ( ( 'products' === $widgetname && ! empty( $is_archivePage ) && $ArchivepageType && $ArchivepageID ) && ( 'archive_listing' === $listing_type || 'search_list' === $listing_type ) ) {
				$attr_tax[] = array(
					'taxonomy' => $ArchivepageType,
					'field'    => 'id',
					'terms'    => $ArchivepageID,
				);
			} elseif ( ( 'dynamiclisting' === $widgetname && ! empty( $is_archivePage ) ) && ( 'archive_listing' === $listing_type || 'search_list' === $listing_type ) ) {
				if ( 'post' === $post_type ) {
					$attr_tax[] = array(
						'taxonomy' => $ArchivepageName,
						'field'    => 'id',
						'terms'    => $ArchivepageID,
					);
				} else {
					$attr_tax[] = array(
						'taxonomy' => $texo_post_taxonomies,
						'field'    => 'slug',
						'terms'    => $category,
					);
				}
			}

			/**Search Page*/
			if ( ! empty( $is_searchPage ) ) {
				$args['s']     = $SearchPageval;
				$args['exact'] = false;
			}

			if ( ! empty( $excludePosts ) ) {
				$args['post__not_in'] = explode( ',', $excludePosts );
			}

			if ( ! empty( $includePosts ) ) {
				$args['post__in'] = explode( ',', $includePosts );
			}

			if ( ! empty( $attr_tax ) ) {
				$args['tax_query'] = array(
					'relation' => 'AND',
					$attr_tax,
				);
			}

			if ( ! empty( $meta_keyArr ) ) {
				$args['meta_query'] = array(
					'relation' => 'AND',
					$meta_keyArr,
				);
			}

			$totalcount = '';
			ob_start();
			$loop       = new WP_Query( $args );
			$totalcount = $loop->found_posts;

			if ( $loop->have_posts() ) {
				while ( $loop->have_posts() ) {
					$loop->the_post();

					$template_id = '';
					if ( ! empty( $dynamic_template ) ) {
						$count = count( $dynamic_template );
						$value = (int) $offset % (int) $count;

						$template_id = $dynamic_template[ $value ];
					}

					if ( 'products' === $widgetname && 'product' === $post_type ) {
						include THEPLUS_WSTYLES . 'ajax-load-post/product-style.php';
					} elseif ( 'dynamiclisting' === $widgetname ) {
						include THEPLUS_WSTYLES . 'ajax-load-post/dynamic-listing-style.php';
					}

					++$ji;
					++$kij;
				}
			}
			$alldata = ob_get_contents();
			ob_end_clean();

			if ( ! empty( $alldata ) ) {
				$result['HtmlData']    = $alldata;
				$result['totalrecord'] = $totalcount;
				$result['widgetName']  = $widgetname;
			}

			wp_send_json( $result );
		}
	}

	return Tp_ajax_pagination::get_instance();
}