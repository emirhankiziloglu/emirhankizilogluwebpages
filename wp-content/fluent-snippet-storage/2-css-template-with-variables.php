<?php
// <Internal Doc Start>
/*
*
* @description: https://youtu.be/2f62n8aNWbI
* @tags: 
* @group: root
* @name: CSS Template With Variables
* @type: css
* @status: published
* @created_by: 
* @created_at: 
* @updated_at: 2025-08-03 21:46:30
* @is_valid: 
* @updated_by: 
* @priority: 1
* @run_at: wp_head
* @load_as_file: 
* @condition: {"status":"no","run_if":"assertive","items":[[]]}
*/
?>
<?php if (!defined("ABSPATH")) { return;} // <Internal Doc End> ?>
/*----------------------------------------------------------------
Edit The Template Styles Below
----------------------------------------------------------------*/

:root {
  /* Edit Link Colors */
  --color-link: #1391ff;
  --color-link-hover: #06BCC1;
	
	/* Edit Quote */
  --color-quote-border: #06BCC1;
	--width-quote-border: 3px;
  --bg-quote: #F4F8FC;
	
	/* Edit Code */
  --color-code-text: #89E3E4;
	--bg-code: #0B0515;
    --box-shadow-t: 0 0 0 1px #e4e4e7,0 10px 15px -3px rgba(0,0,0,.05),0 4px 6px -4px rgba(0,0,0,.05);

  /* Edit Spacing */
  --space-s: 0.25rem;
  --space-m: 0.75rem;
  --space-l: 1.25rem;
  --space-xl: 2.25rem;
  --space-xxl: 2.5rem;
	
	/* Edit Image Border Radius */
  --radius-m: 0.75rem;
	
	/* Edit Link Transition */
  --transition-default: 0.2s ease-in-out;

  /* Edit Typography */
  --font-weight-light: 300;
  --font-weight-regular: 400;
  --font-weight-medium: 500;
  --font-weight-bold: 700;
  --font-size-xs: .85rem;
  --font-size-p: 1.15rem;
	--mobile-font-size-p: 1.15rem;
  --font-size-m: 1.5rem;
	--mobile-font-size-m: 1.5rem;
  --font-size-l: 2rem;
	--mobile-font-size-l: 2rem;
  --line-height-body: 1.75em;
  --line-height-heading: 1.25em;
  --line-height-list: 1.2em;
}


/*----------------------------------------------------------------
End of template style editing, do not edit below
----------------------------------------------------------------*/


/* Headings */
.post-content h2, 
.post-content h3, 
.post-content h4, 
.post-content h5, 
.post-content h6 {
  padding-top: var(--space-xxl);
  padding-bottom: var(--space-s);
  font-weight: var(--font-weight-bold);
  line-height: var(--line-height-heading);
}

.post-content h2 {
  font-size: var(--font-size-l);
}

.post-content h3, 
.post-content h4, 
.post-content h5, 
.post-content h6 {
  font-size: var(--font-size-m);
}

/* Paragraphs */
.post-content p {
  padding-bottom: var(--space-l);
  margin-bottom: 0;
  line-height: var(--line-height-body);
}

/* Links */
.post-content p a {
  color: var(--color-link);
  font-weight: var(--font-weight-medium);
  text-decoration: underline;
  transition: color var(--transition-default);
}

.post-content p a:hover {
  color: var(--color-link-hover);
}

/* Lists */
.post-content ul,
.post-content ol {
  font-size: var(--font-size-p);
  font-weight: var(--font-weight-medium);
  padding-bottom: var(--space-xl);
}

.post-content ul li {
  line-height: var(--line-height-list);
  margin-bottom: var(--space-l);
}

.c-post-meta ul li:nth-child(2) {
  font-weight: var(--font-weight-regular)!important;
}

/* Images */
.post-content .wp-block-image img {
  margin: var(--space-xxl) 0;
  border-radius: var(--radius-m);
}

/* Blockquotes */
.post-content blockquote {
  border-left: var(--width-quote-border) solid var(--color-quote-border);
  margin: 0;
  padding: var(--space-m) var(--space-l);
  background: var(--bg-quote);
  font-size: var(--font-size-p);
  font-weight: var(--font-weight-regular);
}

.post-content blockquote cite {
  font-size: var(--font-size-xs);
  font-weight: var(--font-weight-light);
}

.post-content blockquote p {
  padding-bottom: 0;
}

/* Code Blocks */
.post-content .wp-block-code {
  background: var(--bg-code);
  padding: var(--space-xl);
  border-radius: var(--radius-m);
}

.post-content code {
  color: var(--color-code-text);
}

/* Mobile responsiveness */
@media screen and (max-width: 767px) {
  .post-content p {
    font-size: var(--mobile-font-size-p);
  }

  .post-content h2 {
    font-size: var(--mobile-font-size-l);
  }

  .post-content h3, 
  .post-content h4, 
  .post-content h5, 
  .post-content h6 {
    font-size: var(--mobile-font-size-m);
  }
}