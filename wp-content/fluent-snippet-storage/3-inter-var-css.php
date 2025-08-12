<?php
// <Internal Doc Start>
/*
*
* @description: Harflerin şekillerini düzenleyen kod
* @tags: 
* @group: root
* @name: Inter var CSS
* @type: css
* @status: published
* @created_by: 
* @created_at: 
* @updated_at: 2025-07-26 21:11:55
* @is_valid: 
* @updated_by: 
* @priority: 10
* @run_at: wp_head
* @load_as_file: 
* @condition: {"status":"no","run_if":"assertive","items":[[]]}
*/
?>
<?php if (!defined("ABSPATH")) { return;} // <Internal Doc End> ?>
html, body {
  font-family: 'Inter', sans-serif !important;
  font-feature-settings: 'cv11', 'cv02', 'cv03', 'cv04', 'cv06', 'cv10', 'cv12', 'cv13';
}
@font-face {
  font-family: 'Inter';
  src: url('/wp-content/uploads/2025/07/InterVariable.woff2') format('woff2');
  font-display: swap;
  font-weight: 100 900; /* variable font weight range */
  font-style: normal;
}