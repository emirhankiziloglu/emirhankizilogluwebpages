<?php
// <Internal Doc Start>
/*
*
* @description: [emoji_response]
* @tags: 
* @group: emoji response
* @name: emoji response php
* @type: PHP
* @status: published
* @created_by: 
* @created_at: 
* @updated_at: 2025-05-18 21:16:26
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
// Emoji Tepkisini Kaydet (AJAX)
function save_emoji_response() {
    check_ajax_referer('emoji_response_nonce', 'nonce');

    if (!isset($_POST['post_id']) || !isset($_POST['emoji_type'])) {
        wp_send_json_error('Geçersiz istek');
        return;
    }

    $post_id = intval($_POST['post_id']);
    $emoji_type = sanitize_key($_POST['emoji_type']);

    $cookie_key = "emoji_voted_{$post_id}_{$emoji_type}";
    if (isset($_COOKIE[$cookie_key])) {
        wp_send_json_error('Zaten tepki verdiniz');
        return;
    }

    $responses = get_post_meta($post_id, 'emoji_responses', true);
    if (!is_array($responses)) {
        $responses = [];
    }

    if (!isset($responses[$emoji_type])) {
        $responses[$emoji_type] = 0;
    }

    $responses[$emoji_type]++;

    update_post_meta($post_id, 'emoji_responses', $responses);
    setcookie($cookie_key, '1', time() + 86400, COOKIEPATH, COOKIE_DOMAIN);

    wp_send_json_success($responses);
}
add_action('wp_ajax_save_emoji_response', 'save_emoji_response');
add_action('wp_ajax_nopriv_save_emoji_response', 'save_emoji_response');

// Shortcode: [emoji_response]
function emoji_response_shortcode($atts) {
    $post_id = get_the_ID();
    $responses = get_post_meta($post_id, 'emoji_responses', true);
    if (!is_array($responses)) {
        $responses = [];
    }

    $emojis = [
        'fire' => '🔥',
        'money' => '💸',
        'party' => '🎉',
        'heart_eyes' => '😍',
        'cool' => '😎',
        'smile' => '😊',
    ];

    ob_start();
    ?>
    <div class="post-emojis-container" data-post-id="<?php echo esc_attr($post_id); ?>" data-nonce="<?php echo wp_create_nonce('emoji_response_nonce'); ?>">
        <?php foreach ($emojis as $key => $char): ?>
            <div class="post-emojis-button" data-emoji="<?php echo esc_attr($key); ?>">
                <span class="post-emojis-icon"><?php echo esc_html($char); ?></span>
                <span class="post-emojis-count"><?php echo isset($responses[$key]) ? intval($responses[$key]) : 0; ?></span>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('emoji_response', 'emoji_response_shortcode');
