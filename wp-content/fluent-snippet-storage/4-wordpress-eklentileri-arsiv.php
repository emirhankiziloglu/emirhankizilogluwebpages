<?php
// <Internal Doc Start>
/*
*
* @description: [eklenti_kartlari]
* @tags: 
* @group: 
* @name: WordPress Eklentileri Arşiv
* @type: PHP
* @status: published
* @created_by: 
* @created_at: 
* @updated_at: 2025-05-18 12:20:19
* @is_valid: 
* @updated_by: 
* @priority: 10
* @run_at: all
* @load_as_file: 
* @condition: {"status":"no","run_if":"assertive","items":[[]]}
*/
?>
<?php if (!defined("ABSPATH")) { return;} // <Internal Doc End> ?>
<?php
function eklenti_kartlari_shortcode() {
    $args = array(
        'post_type' => 'eklentiler',
        'posts_per_page' => -1
    );

    $query = new WP_Query($args);
    ob_start();

    echo '<div class="eklenti-grid">';

    while ($query->have_posts()) {
        $query->the_post();

        $pricing = get_field('pricing');
        $badge_class = '';
        $badge_label = '';

        if ($pricing === 'Ücretsiz') {
            $badge_class = 'badge badge-green';
            $badge_label = 'Ücretsiz';
        } elseif ($pricing === 'Ücretli') {
            $badge_class = 'badge badge-red';
            $badge_label = 'Ücretli';
        }

        $thumbnail = get_the_post_thumbnail(get_the_ID(), 'thumbnail', ['class' => 'avatar']);

        echo '<div class="eklenti-card">';
        echo '<div class="eklenti-header">';
        // Kart başlığı ve badge artık yan yana
        echo '<div class="eklenti-title-row">';
        echo '<h2 class="eklenti-title">' . get_the_title() . '</h2>';
        echo '<span class="' . $badge_class . '">' . $badge_label . '</span>';
        echo '</div>';
        echo $thumbnail ? $thumbnail : '';
        echo '</div>';
        echo '<p class="eklenti-excerpt">' . get_the_excerpt() . '</p>';
        echo '<div class="eklenti-buttons">';
        echo '<a href="' . get_permalink() . '" class="eklenti-btn">İncele</a>';
        echo '<a href="mailto:info@siteniz.com" class="eklenti-btn">Soru Sor</a>';
        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('eklenti_kartlari', 'eklenti_kartlari_shortcode');
