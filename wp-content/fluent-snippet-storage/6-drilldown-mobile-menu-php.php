<?php
// <Internal Doc Start>
/*
*
* @description: [drilldown_menu]
* @tags: 
* @group: Mobile Menü
* @name: Drilldown Mobile Menu PHP
* @type: PHP
* @status: published
* @created_by: 
* @created_at: 
* @updated_at: 2025-05-18 21:36:30
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
function drilldown_mobile_menu_shortcode($atts) {
    // Mevcut atts'e height ekleyelim
    $atts = shortcode_atts(array(
        'menu' => 'Main Menu',
        'height' => '400px'
    ), $atts);

    // Menü ismini güvenli şekilde al
    $menu_name = isset($atts['menu']) ? sanitize_text_field($atts['menu']) : 'Main Menu';
    
    // Menü ID'sini bul
    $menu_obj = get_term_by('name', $menu_name, 'nav_menu');
    if (!$menu_obj) {
        $menu_obj = get_term_by('slug', $menu_name, 'nav_menu');
    }
    if (!$menu_obj) {
        return '<p>Menü bulunamadı: ' . esc_html($menu_name) . '</p>';
    }

    // Menü öğelerini al
    $menu_items = wp_get_nav_menu_items($menu_obj->term_id);
    if (!$menu_items) return '<p>Menü öğeleri bulunamadı.</p>';

    // Menü öğelerini hiyerarşik hale getir
    $menu_array = array();
    $child_items = array();

    // Önce tüm alt öğeleri grupla
    foreach ($menu_items as $item) {
        if ($item->menu_item_parent == 0) {
            // Ana menü öğesi
            $menu_array[$item->ID] = array(
                'id' => $item->ID,
                'title' => $item->title,
                'url' => $item->url,
                'children' => array()
            );
        } else {
            // Alt menü öğesi
            $child_items[$item->menu_item_parent][] = array(
                'id' => $item->ID,
                'title' => $item->title,
                'url' => $item->url,
                'parent' => $item->menu_item_parent
            );
        }
    }

    // Alt öğeleri ana menü öğelerine ekle
    foreach ($child_items as $parent_id => $children) {
        if (isset($menu_array[$parent_id])) {
            $menu_array[$parent_id]['children'] = $children;
        }
    }

    // HTML çıktısını oluştur - container class'ını güncelle
    $output = sprintf(
        '<nav class="wd-drill-menu-container" style="min-height: %s;">',
        esc_attr($atts['height'])
    );
    $output .= '<ul class="wd-drill-menu">';
    
    foreach ($menu_array as $item) {
        $output .= drilldown_generate_menu_item($item);
    }
    
    $output .= '</ul>';
    $output .= '</nav>';

    return $output;
}

function drilldown_generate_menu_item($item) {
    $has_children = !empty($item['children']);
    
    $html = '<li class="wd-drill-item' . ($has_children ? ' wd-drill-has-children' : '') . '">';
    $html .= '<a href="' . esc_url($item['url']) . '">' . esc_html($item['title']) . '</a>';

    // Sadece alt menüsü olan öğelerde chevron göster
    if ($has_children) {
        $chevron_right = '<svg class="wd-drill-chevron" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        $html .= '<button class="wd-drill-toggle" aria-label="Alt menüyü aç" type="button">' . $chevron_right . '</button>';
        
        $html .= '<ul class="wd-drill-submenu">';
        
        // Geri butonu - "Terug" Felemenkçe "Geri" demek
        $chevron_left = '<svg class="wd-drill-chevron" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        $html .= '<li class="wd-drill-back"><button type="button" class="wd-drill-back-btn">' . $chevron_left . ' Terug</button></li>';
        
        $html .= '<div class="wd-drill-submenu-content">';
        foreach ($item['children'] as $child) {
            $html .= drilldown_generate_menu_item($child);
        }
        $html .= '</div>';
        
        $html .= '</ul>';
    }

    $html .= '</li>';
    return $html;
}

// Shortcode kaydı: [drilldown_menu menu="main-menu"]
add_shortcode('drilldown_menu', 'drilldown_mobile_menu_shortcode');