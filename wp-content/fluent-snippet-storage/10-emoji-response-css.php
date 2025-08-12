<?php
// <Internal Doc Start>
/*
*
* @description: 
* @tags: 
* @group: emoji response
* @name: emoji response css
* @type: css
* @status: published
* @created_by: 
* @created_at: 
* @updated_at: 2025-05-18 21:15:08
* @is_valid: 
* @updated_by: 
* @priority: 10
* @run_at: wp_head
* @load_as_file: 
* @condition: {"status":"no","run_if":"assertive","items":[[]]}
*/
?>
<?php if (!defined("ABSPATH")) { return;} // <Internal Doc End> ?>
.post-emojis-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(64px, 1fr));
    gap: 0.5rem;
    max-width: 100%;
    width: 100%;
    margin: 0;
    box-sizing: border-box;
}

.post-emojis-button {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 0.5rem;
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: transform 0.15s ease, background-color 0.15s;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    aspect-ratio: 1;
    width: 100%;
}

.post-emojis-button:hover {
    transform: translateY(-2px);
    background-color: #f9fafb;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
}

.post-emojis-icon {
    font-size: 1.4rem;
    margin-bottom: 0.5rem;
    font-family: "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji", sans-serif;
}

.post-emojis-count {
    font-size: 0.875rem;
    font-weight: 600;
    color: #64748b;
}

@media (max-width: 480px) {
    .post-emojis-container {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
    }

    .post-emojis-icon {
        font-size: 2rem;
    }
}
