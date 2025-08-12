<?php
// <Internal Doc Start>
/*
*
* @description: 
* @tags: 
* @group: Mobile Menü
* @name: Drilldown Menü JS
* @type: js
* @status: published
* @created_by: 
* @created_at: 
* @updated_at: 2025-05-18 21:37:25
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
    initializeDrilldownMenu();
});

// Elementor için özel olay dinleyicisi
if (window.elementorFrontend) {
    elementorFrontend.hooks.addAction('frontend/element_ready/widget', function() {
        initializeDrilldownMenu();
    });
}

function initializeDrilldownMenu() {
    // Event listener'ları temizle ve yeniden ekle
    const toggleButtons = document.querySelectorAll('.wd-drill-toggle');
    const backButtons = document.querySelectorAll('.wd-drill-back-btn');

    toggleButtons.forEach(btn => {
        btn.removeEventListener('click', handleSubmenuToggle);
        btn.addEventListener('click', handleSubmenuToggle);
    });

    backButtons.forEach(btn => {
        btn.removeEventListener('click', handleGoBack);
        btn.addEventListener('click', handleGoBack);
    });

    // Alt menüleri başlangıçta gizle
    document.querySelectorAll('.wd-drill-submenu').forEach(submenu => {
        submenu.style.visibility = 'hidden';
        submenu.style.transform = 'translateX(100%)';
        submenu.style.opacity = '0';
    });
}

function handleSubmenuToggle(e) {
    e.preventDefault();
    e.stopPropagation();
    
    console.log('Toggle clicked'); // Debug için

    const submenu = this.nextElementSibling;
    const parentLi = this.closest('.wd-drill-has-children');
    
    if (submenu && parentLi) {
        openSubmenu(submenu, parentLi);
    }
}

function handleGoBack(e) {
    e.preventDefault();
    e.stopPropagation();
    
    console.log('Back clicked'); // Debug için

    const parentLi = this.closest('.wd-drill-submenu').closest('.wd-drill-has-children');
    if (parentLi) {
        closeSubmenu(parentLi);
    }
}

function openSubmenu(submenu, parentLi) {
    // Önce görünür yap
    submenu.style.visibility = 'visible';
    submenu.style.opacity = '1';
    
    // Sonra transform uygula
    requestAnimationFrame(() => {
        submenu.style.transform = 'translateX(-100%)';
        parentLi.classList.add('submenu-open');
    });
}

function closeSubmenu(parentLi) {
    const submenu = parentLi.querySelector('.wd-drill-submenu');
    
    if (submenu) {
        // Önce transform'u geri al
        submenu.style.transform = 'translateX(100%)';
        parentLi.classList.remove('submenu-open');

        // Transition bittikten sonra gizle
        submenu.addEventListener('transitionend', function handler() {
            if (!parentLi.classList.contains('submenu-open')) {
                submenu.style.visibility = 'hidden';
                submenu.style.opacity = '0';
            }
            submenu.removeEventListener('transitionend', handler);
        });
    }
}

// Sayfa yüklendiğinde
document.addEventListener('DOMContentLoaded', initializeDrilldownMenu);

// Elementor için
if (window.elementorFrontend) {
    elementorFrontend.hooks.addAction('frontend/element_ready/widget', initializeDrilldownMenu);
}

// Elementor popup için
document.addEventListener('elementor/popup/show', initializeDrilldownMenu);
