<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed 

$team_taxonomy = theplus_team_member_post_category();

	//category filter
	$category_filter='';
	if($filter_category=='yes'){				
		 $terms = get_the_terms( $loop->ID, $team_taxonomy);
		 $filter_search_type = !empty($settings['filter_search_type']) ? $settings['filter_search_type'] :'slug';
		 
		if ( $terms != null ){
			foreach( $terms as $term ) {

				if ('term_id' === $filter_search_type) {
					$term_category = $term->term_id;
				}else{
					$term_category = $term->slug;
				} 

				$category_filter .=' '.esc_attr($term_category).' ';
				unset($term);
			}
		}
	}	
    

    echo '<div class="grid-item ' . $desktop_class . ' ' . $tablet_class . ' ' . $mobile_class . ' ' . $category_filter . ' ' . $animated_columns . '">';
   
    include THEPLUS_WSTYLES . 'team-member/team-member-' . sanitize_file_name( $style ) . '.php'; 

	// }
	echo '</div>';
?>