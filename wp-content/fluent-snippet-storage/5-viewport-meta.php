<?php
// <Internal Doc Start>
/*
*
* @description: 
* @tags: 
* @group: 
* @name: viewport meta
* @type: PHP
* @status: published
* @created_by: 
* @created_at: 
* @updated_at: 2025-05-18 14:03:36
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
add_action('after_setup_theme', function() {
    add_filter( 'hello_elementor_viewport_content', function( $content ) {
        return 'width=device-width, initial-scale=1.0, maximum-scale=5.0';
    });
});
