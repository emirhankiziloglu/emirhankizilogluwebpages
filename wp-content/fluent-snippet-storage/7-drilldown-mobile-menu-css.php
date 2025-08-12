<?php
// <Internal Doc Start>
/*
*
* @description: 
* @tags: 
* @group: Mobile Menü
* @name: Drilldown Mobile Menü CSS
* @type: css
* @status: published
* @created_by: 
* @created_at: 
* @updated_at: 2025-05-18 21:36:39
* @is_valid: 
* @updated_by: 
* @priority: 10
* @run_at: wp_head
* @load_as_file: 
* @condition: {"status":"no","run_if":"assertive","items":[[]]}
*/
?>
<?php if (!defined("ABSPATH")) { return;} // <Internal Doc End> ?>
/* Ana container */
.wd-drill-menu-container {
    position: relative;
    width: 100%;
    overflow: hidden;
    min-height: 320px!important;
    background: var(--e-global-color-background, #fff);
    font-family: "Inter var";
    font-size:1rem;
}

/* Ana menü container */
.wd-drill-menu {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    list-style: none;
    background: inherit;
}

/* Tüm liste ve alt listeler için temel stiller */
.wd-drill-menu,
.wd-drill-menu ul,
.wd-drill-submenu {
    list-style: none;
    margin: 0;
    padding: 0;
}

/* Menü öğeleri */
.wd-drill-item {
    position: relative;
    width: 100%;
    margin: 0;
    padding: 0;
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

/* Menü linkleri - Ana menü için */
.wd-drill-menu > .wd-drill-item > a {
    display: flex;
    align-items: center;
    padding: 15px 0px;
    text-decoration: none;
    font-weight: 500;
    color: inherit;
    line-height: 1.4;
}

/* Alt menü öğeleri için */
.wd-drill-submenu .wd-drill-item > a {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    text-decoration: none;
    font-weight: 500;
    color: inherit;
    line-height: 1.4;
}

/* Alt menüsü olan öğeler için padding */
.wd-drill-has-children > a {
    padding-right: 50px !important; /* !important ekledik çünkü spesifik olmalı */
}

/* Toggle butonu */
.wd-drill-toggle {
    display: none !important; /* Varsayılan olarak gizli */
    position: absolute !important;
    right: 0;
    top: 0;
    width: 50px;
    height: 100%;
    padding: 0;
    border: none;
    background: none;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 2;
}

/* Sadece alt menüsü olan öğelerde göster */
.wd-drill-has-children > .wd-drill-toggle {
    display: flex !important;
}

/* Alt menü */
.wd-drill-submenu {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--e-global-color-background, #fff);
    transform: translateX(100%);
    transition: all 0.2s ease;
    visibility: hidden;
    opacity: 0;
    z-index: 99;
    padding: 0;
    margin: 0;
    list-style: none;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

/* Alt menü açık durumu */
.submenu-open > .wd-drill-submenu {
    transform: translateX(0) !important;
    visibility: visible !important;
    opacity: 1 !important;
}

/* Alt menü içeriği */
.wd-drill-submenu-content {
    background: inherit;
    min-height: 100%;
    width: 100%;
    position: relative;
    padding: 0;
    margin: 0;
}

/* Geri butonu container */
.wd-drill-back {
    background: rgba(0,0,0,0.03);
    border-bottom: 1px solid rgba(0,0,0,0.1);
    position: relative;
    z-index: 3;
}

/* Geri butonu */
.wd-drill-back-btn {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 15px 20px;
    border: none;
    background: none;
    color: inherit;
    font-size: inherit;
    text-align: left;
    cursor: pointer;
    font-weight: 500;
}

/* İkonlar */
.wd-drill-chevron {
    width: 20px;
    height: 20px;
    stroke: currentColor;
    stroke-width: 2px;
    flex-shrink: 0; /* İkonun küçülmesini önle */
}

.wd-drill-toggle .wd-drill-chevron {
    margin-left: auto;
    position: absolute;
    right: 15px;
}

.wd-drill-back-btn .wd-drill-chevron {
    margin-right: 10px;
}

/* Hover efektleri */
.wd-drill-item:hover,
.wd-drill-back:hover {
    background: rgba(0,0,0,0.02);
}

/* Son öğede border olmasın */
.wd-drill-item:last-child {
    border-bottom: none;
}
