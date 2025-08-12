<?php
// <Internal Doc Start>
/*
*
* @description: 
* @tags: 
* @group: 
* @name: Dark Mode JS
* @type: js
* @status: published
* @created_by: 1
* @created_at: 2025-07-28 15:13:59
* @updated_at: 2025-07-28 15:18:07
* @is_valid: 1
* @updated_by: 1
* @priority: 10
* @run_at: wp_footer
* @load_as_file: 
* @condition: {"status":"no","run_if":"assertive","items":[[]]}
*/
?>
<?php if (!defined("ABSPATH")) { return;} // <Internal Doc End> ?>
document.addEventListener("DOMContentLoaded", function() {
  
  // Dark mode yönetimi için tek class
  class DarkModeManager {
    constructor() {
      this.storageKey = 'dark-mode';
      this.darkClass = 'dark';
      this.init();
    }

    // Başlangıç ayarları
    init() {
      const savedPreference = this.getPreference();
      if (savedPreference) {
        document.body.classList.toggle(this.darkClass, savedPreference === 'dark');
      }
      this.bindEvents();
    }

    // Tercih okuma (localStorage öncelikli)
    getPreference() {
      return localStorage.getItem(this.storageKey) || this.getCookie(this.storageKey);
    }

    // Tercih kaydetme
    setPreference(isDark) {
      const value = isDark ? 'dark' : 'light';
      localStorage.setItem(this.storageKey, value);
      this.setCookie(this.storageKey, value, 365); // 1 yıl
    }

    // Toggle fonksiyonu
    toggle() {
      const isDark = document.body.classList.toggle(this.darkClass);
      this.setPreference(isDark);
      return isDark;
    }

    // Event binding
    bindEvents() {
      document.querySelectorAll('.dark-toggle').forEach(btn => {
        btn.addEventListener('click', () => this.toggle());
      });
    }

    // Cookie yardımcı fonksiyonları
    setCookie(name, value, days) {
      const expires = new Date(Date.now() + days * 864e5).toUTCString();
      document.cookie = `${name}=${value}; expires=${expires}; path=/; SameSite=Lax`;
    }

    getCookie(name) {
      return document.cookie
        .split('; ')
        .find(row => row.startsWith(name + '='))
        ?.split('=')[1] || '';
    }
  }

  // Dark mode manager'ı başlat
  new DarkModeManager();
});