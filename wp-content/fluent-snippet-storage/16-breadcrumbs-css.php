<?php
// <Internal Doc Start>
/*
*
* @description: 
* @tags: 
* @group: Breadcrumbs
* @name: Breadcrumbs CSS
* @type: css
* @status: published
* @created_by: 
* @created_at: 
* @updated_at: 2025-05-19 00:39:47
* @is_valid: 
* @updated_by: 
* @priority: 10
* @run_at: wp_head
* @load_as_file: 
* @condition: {"status":"no","run_if":"assertive","items":[[]]}
*/
?>
<?php if (!defined("ABSPATH")) { return;} // <Internal Doc End> ?>
.eael-breadcrumbs .eael-breadcrumbs__content {box-shadow:0 1px 3px 0 var(--tw-shadow-color, rgb(0 0 0 / 0.1)), 0 1px 2px -1px var(--tw-shadow-color, rgb(0 0 0 / 0.1))}

.eael-breadcrumbs {
    display: flex;
    flex-wrap: wrap; /* Satır kayması için */
    gap: 8px; /* Öğeler arası boşluk */
    padding: 0px; /* Kenarlardan nefes alan */
}

.eael-breadcrumbs__prefix {
    display: flex;
    align-items: center;
    font-size: 14px;
    margin-right: 6px;
    white-space: nowrap; /* Taşmayı önler */
}

.eael-breadcrumbs__content {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    font-size: 14px;
    color: #434347;
    padding: 8px 12px;
    border: 1px solid #edecf6;
    border-radius: 8px;
    line-height: 1.4;
    gap: 5px;
    width: 100%; /* Küçük ekranlarda taşmayı engeller */
    box-sizing: border-box;
    overflow-wrap: break-word;
}

.eael-breadcrumbs__content a {
    color: #a5a4b0;
    text-decoration: none;
    word-break: break-word;
}

/* WooCommerce uyumu */
.woocommerce .woocommerce-breadcrumb.eael-breadcrumbs__content {
    font-size: 14px;
    color: #434347;
    padding: 8px 12px;
    border: 1px solid #edecf6;
    border-radius: 8px;
    line-height: 1.4;
    flex-wrap: wrap;
    gap: 5px;
    overflow-wrap: break-word;
    word-break: break-word;
    width: 100%;
}

.woocommerce .woocommerce-breadcrumb.eael-breadcrumbs__content a {
    color: #a5a4b0;
    text-decoration: none;
}

/* Mobil ekran için ekstra düzenleme */
@media (max-width: 480px) {
    .eael-breadcrumbs__content {
        font-size: 13px;
        padding: 10px;
    }

    .eael-breadcrumbs__prefix {
        font-size: 13px;
    }
}
