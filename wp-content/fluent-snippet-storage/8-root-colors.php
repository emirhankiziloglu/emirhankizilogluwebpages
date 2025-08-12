<?php
// <Internal Doc Start>
/*
*
* @description: 
* @tags: 
* @group: 
* @name: root colors
* @type: css
* @status: published
* @created_by: 
* @created_at: 
* @updated_at: 2025-07-28 15:33:06
* @is_valid: 
* @updated_by: 
* @priority: 10
* @run_at: wp_head
* @load_as_file: 
* @condition: {"status":"no","run_if":"assertive","items":[[]]}
*/
?>
<?php if (!defined("ABSPATH")) { return;} // <Internal Doc End> ?>
:root {
  /* Sistem Renkleri */
  --purple-500: #9810FA;
  --purple-800: #6E11B0;
  --text-main: #030712;
  --accent: #CE4C20;

  /* Özel Renkler */
  --blue-hover: #3655E2;
  --item-2: #1C769B;
  --item-3: #2795B7;

  --emerald-500: #00BC7D;
  --emerald-200: #A4F4CF;
  --emerald-100: #D0FAE5;

  --gray-600: #4B5666;
}
.announcement {
  position: relative;
  display: inline-block;
  font-size: 0.875rem; /* text-sm (default for desktop) */
  line-height: 1.5;
  color: var(--gray-600);
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  border: 1px solid rgba(17, 24, 39, 0.1);
  transition: border-color 0.3s ease;
}

@media (max-width: 640px) {
  .announcement {
    font-size: 0.75rem; /* text-xs for mobile */
  }
}

.announcement:hover {
  border-color: rgba(17, 24, 39, 0.2);
}

.announcement a {
  font-weight: 600;
  color: var(--purple-500);
  text-decoration: none;
  position: relative;
  padding-left: 0.25rem;
}
.blob {
  position: absolute;
  width: 600px;
  height: 600px;
  border-radius: 50%;
  filter: blur(120px);
  opacity: 0.3;
  mix-blend-mode: multiply;
  z-index: 0;
  animation: blob-float 14s ease-in-out infinite;
}

/* Renkler */
.blob-purple {
  background: radial-gradient(circle, #c084fc, #818cf8);
  top: -150px;
  left: -200px;
  animation-delay: 0s;
}

.blob-pink {
  background: radial-gradient(circle, #f9a8d4, #f472b6);
  top: 100px;
  right: -200px;
  animation-delay: 3s;
}

.blob-lila {
  background: radial-gradient(circle, #a78bfa, #818cf8);
  bottom: -150px;
  right: 0;
  animation-delay: 6s;
}

/* Animasyon */
@keyframes blob-float {
  0% {
    transform: translate(0, 0) scale(1);
  }
  33% {
    transform: translate(40px, -30px) scale(1.05);
  }
  66% {
    transform: translate(-30px, 20px) scale(0.95);
  }
  100% {
    transform: translate(0, 0) scale(1);
  }
}

/* Responsive için (isteğe bağlı) */
@media (max-width: 768px) {
  .blob {
    width: 400px;
    height: 400px;
    filter: blur(80px);
  }

  .blob-purple {
    top: -100px;
    left: -150px;
  }

  .blob-pink {
    top: 80px;
    right: -150px;
  }

  .blob-lila {
    bottom: -100px;
    right: -50px;
  }
}
.logo-color svg,
.logo-color u {
  color: var(--purple-500);
}

.logo-color u {
  text-decoration: none;
}

.logo-color a {
  color: var(--text-main);
}
.ff-el-form-check {
  display: flex !important;
  align-items: center !important;
  gap: 0.5rem !important;
  font-size: 1rem !important;
  font-weight: 500 !important;
  color: var(--e-global-color-454ac6a); /* text-gray-700 */
}
.ff-el-form-check-label {
  display: flex !important;
  align-items: center !important;
  cursor: pointer !important;
  gap: 0.5rem !important;
}

.ff-el-form-check-input {
  appearance: none !important;
  height: 1.25rem !important;
  width: 1.25rem !important;
  border: 2px solid #d1d5db !important; /* border-gray-300 */
  border-radius: 0.25rem !important;
  background-color: #ffffff !important;
  display: grid !important;
  place-content: center !important;
  transition: all 0.2s ease-in-out !important;
  cursor: pointer !important;
}

.ff-el-form-check-input:checked {
  background-color: #9810fa !important;
  border-color: #9810fa !important;
}

.ff-el-form-check-input:checked::after {
  content: '' !important;
  width: 0.5rem !important;
  height: 0.5rem !important;
  background-color: #ffffff !important;
  border-radius: 9999px !important;
  display: block !important;
}

.ff-el-form-check-input:focus {
  outline: 2px solid transparent !important;
  outline-offset: 2px !important;
  box-shadow: 0 0 0 3px rgba(218, 178, 255, 1) !important; /* red focus ring */
}
/* Masaüstü görünüm – 3 sütunlu grid */
@media (min-width: 768px) {
  .fluentform .ff-el-group.ff_list_2col .ff-el-input--content {
    display: grid !important;
    grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
    gap: 0.1rem !important;
    align-items: start !important;
  }
}
/* Select kutusunu genel olarak stillendir */
.ff-el-form-control {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  font-size: 0.875rem!important;
  line-height: 1.5rem;
  color: #030712;
  cursor: pointer;
  transition: border-color 0.2s, box-shadow 0.2s;
}

/* Hover ve focus durumları */
.ff-el-form-control:focus {
  border-color: #9810fa!important; /* purple-800 */
  outline: none!important;
  box-shadow: 0 0 0 1px #9810fa!important;
}
.faq-text a {color: var(--purple-500);font-weight:600;}
.faq-text strong {font-weight:600;}