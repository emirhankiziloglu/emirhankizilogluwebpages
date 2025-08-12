<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed 
$ij = '';
$tablet_metro_class = '';
	if($layout=='metro'){		
		$ij=theplus_load_metro_style_layout($ji,$metro_column,$metro_style);
		if(!empty($responsive_tablet_metro) && $responsive_tablet_metro=='yes'){
			$tablet_ij=theplus_load_metro_style_layout($ji,$tablet_metro_column,$tablet_metro_style);
			$tablet_metro_class ='tb-metro-item'.esc_attr($tablet_ij);
		}
	}
	
	//category filter
	$category_filter='';
	if($filter_category=='yes'){				
		 $terms = get_the_terms( $loop->ID, $settings['post_taxonomies']);
		 $filter_search_type = !empty($settings['filter_search_type']) ? $settings['filter_search_type'] : 'slug';
		if ( $terms != null ){
			foreach( $terms as $term ) {

				if ( 'term_id' === $filter_search_type ) {
					$term_category = $term->term_id;
				}else{
					$term_category = $term->slug;
				}
				$category_filter .=' '.esc_attr($term_category).' ';
				unset($term);
			}
		}
	}	
    
    $ji % 6 == 1;
    $active = $bssfc = '';
    if ( $ji <= $news_loop_page ) {
        $active = 'show animated fadeInEffect';
    }
    if ( $ji == 0 ) {
        $bssfc = 'bssfc';
    }			

    echo '<div class="grid-item ' . esc_attr( $active ) . ' ' . esc_attr( $category_filter ) . ' active ' . esc_attr( $bssfc ) . ' ' . $news_highlight_style . '">';
    include THEPLUS_WSTYLES . 'dynamic-smart-showcase/bss-' . sanitize_file_name($news_style) . '.php'; 

    ++$ji;
	// }
	echo '</div>';
?>