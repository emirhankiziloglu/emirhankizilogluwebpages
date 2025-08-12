<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$postid = get_the_ID();

if ( 'yes' === $display_post_category ) { ?>
	<div class="post-metro-category-top">
		<?php include THEPLUS_WSTYLES . 'blog/blog-category-' . $post_category_style . '.php'; ?>
	</div>
<?php } ?>

<div class="post-metro-content">
	<?php
	require THEPLUS_WSTYLES . 'blog/post-meta-title.php';

	if ( ! empty( $display_excerpt ) && 'yes' === $display_excerpt && get_the_excerpt() ) {
		?>
		<div class="post-hover-content">
			<?php include THEPLUS_WSTYLES . 'blog/get-excerpt.php'; ?>
		</div>
		<?php
	}

	if ( ! empty( $display_post_meta ) && 'yes' === $display_post_meta ) {
		include THEPLUS_WSTYLES . 'blog/blog-post-meta-' . $post_meta_tag_style . '.php';
	}

	if ( ! empty( $the_button ) ) {
		echo $the_button;
	}

	?>
</div>
