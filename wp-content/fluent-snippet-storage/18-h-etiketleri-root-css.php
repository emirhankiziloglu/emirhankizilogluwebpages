<?php
// <Internal Doc Start>
/*
*
* @description: 
* @tags: 
* @group: root
* @name: H Etiketleri Root CSS
* @type: css
* @status: draft
* @created_by: 1
* @created_at: 2025-07-26 20:12:58
* @updated_at: 2025-07-28 12:59:42
* @is_valid: 1
* @updated_by: 1
* @priority: 10
* @run_at: wp_head
* @load_as_file: 
* @condition: {"status":"no","run_if":"assertive","items":[[]]}
*/
?>
<?php if (!defined("ABSPATH")) { return;} // <Internal Doc End> ?>
h1, h2, h3, h4, h5, h6 {
  margin: 0;
  padding: 0;
  font-weight: 700;
  line-height: 1.3;
  color: var( --e-global-color-text ); /* Ana metin rengi */
}
p {
  margin: 0;
  padding: 0;
  font-size: 1.25rem;
  line-height: 1.75;
  color: var( --e-global-color-text );
  font-weight: 400;
  letter-spacing: 0.01em;
}

h1 {
  font-size: clamp(2.5rem, 6vw, 4rem);
  letter-spacing: -0.03em;
}

h2 {
  font-size: clamp(2rem, 5vw, 3rem);
  letter-spacing: -0.02em;
  font-weight:600;
}

h3 {
  font-size: clamp(1.75rem, 4vw, 2.5rem);
}

h4 {
  font-size: clamp(1.5rem, 3.5vw, 2rem);
}

h5 {
  font-size: clamp(1.25rem, 3vw, 1.5rem);
}

h6 {
  font-size: clamp(1rem, 2.5vw, 1.25rem);
}
