<?php
// <Internal Doc Start>
/*
*
* @description: section-xxl (For extra, extra large sections and small banners)
section-xl (Extra large sections with plenty of spacing)
section-l (Large sections and the one I use for most sections)
section-m (Medium sections)
section-s (Small sections)
section-xs (Extra small sections)
section-xxs (Extra extra small sections)
section-hero (control the VH for hero banners, by default is set to 100vh)
section-full (Creates a full width section removing padding on the sides, add another section class to add padding on the top and bottom)
section-narrow (Creates a narrow section giving the content in the section 1000px)
section-narrow-xs (Creates an extra narrow section giving the content in the section 720px)
section-offset (Use for banners with overlay headers. This will offset the top padding)
* @tags: 
* @group: root
* @name: CSS Framework by Emir
* @type: css
* @status: published
* @created_by: 
* @created_at: 
* @updated_at: 2025-04-05 11:21:41
* @is_valid: 
* @updated_by: 
* @priority: 1
* @run_at: wp_head
* @load_as_file: 
* @condition: {"status":"no","run_if":"assertive","items":[[]]}
*/
?>
<?php if (!defined("ABSPATH")) { return;} // <Internal Doc End> ?>
/* variables (edit here)*/

:root {
    /* Global Padding Variables - Editable */
    /* Left and Right Padding All /Sections/Containers*/
    --fluid-side-padding-min: 1.25rem; /* 20px */
    --fluid-side-padding-max: 5rem;   /* 80px */

    /* Top and Bottom Padding All Containers*/
    --section-xxl-padding-min: 9.375rem; /* 150px */
    --section-xxl-padding-max: 10rem; /* 160px */ 
  
    --section-xl-padding-min: 6.875rem; /* 110px */
    --section-xl-padding-max: 7.5rem; /* 120px */
  
    --section-l-padding-min: 5.625rem; /* 90px */
    --section-l-padding-max: 6.25rem; /* 100px */
  
    --section-m-padding-min: 5rem; /* 80px */
    --section-m-padding-max: 5rem; /* 80px */
  
    --section-s-padding-min: 3.75rem; /* 60px */
    --section-s-padding-max: 3.75rem; /* 60px */
  
    --section-xs-padding-min: 2.5rem; /* 40px */
    --section-xs-padding-max: 2.5rem; /* 40px */
  
    --section-xxs-padding-min: 1.5rem; /* 24px */
    --section-xxs-padding-max: 1.5rem; /* 24px */
    
    --section-header-padding-min: 1.25rem; /* 20px */
    --section-header-padding-max: 1.25rem; /* 20px */

  
    /* Hero Sections Height Variable */
    --section-hero-height: 100vh; /* 100% the screen height */
  
    /* Offset Padding for Overlay Headers */
    --section-offset-header: 80px; /* Adjust to the overlay header's negative margin */

    /* Width For Narrow Sections*/
    --section-narrow: 62.5rem; /* 1000px */
    --section-narrow-xs: 45rem; /* 720px */
  }


/* CSS Template (do not edit below) */
  
  
  /* Section/Container Padding - Fluid Variants */
  .section-xxl {
    padding-top: clamp(var(--section-xxl-padding-min), 1.087vw + 9.13rem, var(--section-xxl-padding-max));
    padding-bottom: clamp(var(--section-xxl-padding-min), 1.087vw + 9.13rem, var(--section-xxl-padding-max));
    padding-left: clamp(var(--fluid-side-padding-min), 6.522vw + -0.217rem, var(--fluid-side-padding-max))!important;
    padding-right: clamp(var(--fluid-side-padding-min), 6.522vw + -0.217rem, var(--fluid-side-padding-max))!important;
  }
  
  .section-xl {
    padding-top: clamp(var(--section-xl-padding-min), 1.087vw + 6.63rem, var(--section-xl-padding-max));
    padding-bottom: clamp(var(--section-xl-padding-min), 1.087vw + 6.63rem, var(--section-xl-padding-max));
    padding-left: clamp(var(--fluid-side-padding-min), 6.522vw + -0.217rem, var(--fluid-side-padding-max))!important;
    padding-right: clamp(var(--fluid-side-padding-min), 6.522vw + -0.217rem, var(--fluid-side-padding-max))!important;
  }
  
  .section-l {
    padding-top: clamp(var(--section-l-padding-min), 1.087vw + 5.38rem, var(--section-l-padding-max));
    padding-bottom: clamp(var(--section-l-padding-min), 1.087vw + 5.38rem, var(--section-l-padding-max));
    padding-left: clamp(var(--fluid-side-padding-min), 6.522vw + -0.217rem, var(--fluid-side-padding-max))!important;
    padding-right: clamp(var(--fluid-side-padding-min), 6.522vw + -0.217rem, var(--fluid-side-padding-max))!important;
  }
  
  .section-m {
    padding-top: clamp(var(--section-m-padding-min), 0vw + 5rem, var(--section-m-padding-max));
    padding-bottom: clamp(var(--section-m-padding-min), 0vw + 5rem, var(--section-m-padding-max));
    padding-left: clamp(var(--fluid-side-padding-min), 6.522vw + -0.217rem, var(--fluid-side-padding-max))!important;
    padding-right: clamp(var(--fluid-side-padding-min), 6.522vw + -0.217rem, var(--fluid-side-padding-max))!important;
  }
  
  .section-s {
    padding-top: clamp(var(--section-s-padding-min), 0vw + 3.75rem, var(--section-s-padding-max));
    padding-bottom: clamp(var(--section-s-padding-min), 0vw + 3.75rem, var(--section-s-padding-max));
    padding-left: clamp(var(--fluid-side-padding-min), 6.522vw + -0.217rem, var(--fluid-side-padding-max))!important;
    padding-right: clamp(var(--fluid-side-padding-min), 6.522vw + -0.217rem, var(--fluid-side-padding-max))!important;
  }
  
  .section-xs {
    padding-top: clamp(var(--section-xs-padding-min), 0vw + 2.5rem, var(--section-xs-padding-max));
    padding-bottom: clamp(var(--section-xs-padding-min), 0vw + 2.5rem, var(--section-xs-padding-max));
    padding-left: clamp(var(--fluid-side-padding-min), 6.522vw + -0.217rem, var(--fluid-side-padding-max))!important;
    padding-right: clamp(var(--fluid-side-padding-min), 6.522vw + -0.217rem, var(--fluid-side-padding-max))!important;
  }
  
  .section-xxs {
    padding-top: clamp(var(--section-xxs-padding-min), 0vw + 1.5rem, var(--section-xxs-padding-max));
    padding-bottom: clamp(var(--section-xxs-padding-min), 0vw + 1.5rem, var(--section-xxs-padding-max));
    padding-left: clamp(var(--fluid-side-padding-min), 6.522vw + -0.217rem, var(--fluid-side-padding-max))!important;
    padding-right: clamp(var(--fluid-side-padding-min), 6.522vw + -0.217rem, var(--fluid-side-padding-max))!important;
  }
  
  .section-header {
    padding-top: clamp(var(--section-header-padding-min), 0vw + 1.25rem, var(--section-header-padding-max));
    padding-bottom: clamp(var(--section-header-padding-min), 0vw + 1.25rem, var(--section-header-padding-max));
    padding-left: clamp(var(--fluid-side-padding-min), 6.522vw + -0.217rem, var(--fluid-side-padding-max))!important;
    padding-right: clamp(var(--fluid-side-padding-min), 6.522vw + -0.217rem, var(--fluid-side-padding-max))!important;
  }
  
  /* Hero Container/Sections Height */
  .section-hero {
    min-height: var(--section-hero-height)!important;
  }

  .section-hero .e-con-inner {
    justify-content: center!important;
}
  
  /* Full Width Sections - No Side Padding */

  .section-full div {
    max-width: 100%!important;
  }
  

  /* Narrow Sections */
  .section-narrow .e-con-inner {
    max-width: var(--section-narrow)!important;
  }

  .section-narrow-xs .e-con-inner {
    max-width: var(--section-narrow-xs)!important;
  }


  /* Offset Padding for Overlay Headers */
  .section-offset {
    padding-top: calc(var(--section-offset-header) + var(--section-xxl-padding-min));
  }
