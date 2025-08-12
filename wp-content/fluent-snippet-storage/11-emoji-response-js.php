<?php
// <Internal Doc Start>
/*
*
* @description: 
* @tags: 
* @group: emoji response
* @name: emoji response js
* @type: js
* @status: published
* @created_by: 
* @created_at: 
* @updated_at: 2025-05-18 21:15:51
* @is_valid: 
* @updated_by: 
* @priority: 10
* @run_at: wp_footer
* @load_as_file: 
* @condition: {"status":"no","run_if":"assertive","items":[[]]}
*/
?>
<?php if (!defined("ABSPATH")) { return;} // <Internal Doc End> ?>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.post-emojis-button').forEach(button => {
        button.addEventListener('click', function () {
            const container = this.closest('.post-emojis-container');
            const postId = container.dataset.postId;
            const emojiType = this.dataset.emoji;
            const nonce = container.dataset.nonce;

            fetch(window.ajaxurl || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'save_emoji_response',
                    post_id: postId,
                    emoji_type: emojiType,
                    nonce: nonce
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Object.entries(data.data).forEach(([key, count]) => {
                        const el = container.querySelector(`[data-emoji="${key}"] .post-emojis-count`);
                        if (el) el.textContent = count;
                    });
                } else {
                    alert(data.data || 'Hata oluştu.');
                }
            });
        });
    });
});
