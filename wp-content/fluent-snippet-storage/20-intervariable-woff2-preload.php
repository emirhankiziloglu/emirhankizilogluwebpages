<?php
// <Internal Doc Start>
/*
*
* @description: 
* @tags: 
* @group: 
* @name: InterVariable.woff2 Preload
* @type: PHP
* @status: draft
* @created_by: 1
* @created_at: 2025-07-26 21:15:47
* @updated_at: 2025-07-26 21:29:26
* @is_valid: 1
* @updated_by: 1
* @priority: 10
* @run_at: all
* @load_as_file: 
* @condition: {"status":"no","run_if":"assertive","items":[[]]}
*/
?>
<?php if (!defined("ABSPATH")) { return;} // <Internal Doc End> ?>
<?php
function preload_inter_font() {
  echo '<link rel="preload" href="' . get_site_url() . '/wp-content/uploads/2025/07/InterVariable.woff2" as="font" type="font/woff2" crossorigin>' . "\n";
}
add_action('wp_head', 'preload_inter_font');
