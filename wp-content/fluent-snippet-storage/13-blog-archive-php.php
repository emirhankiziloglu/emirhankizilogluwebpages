<?php
// <Internal Doc Start>
/*
*
* @description: [blog_posts]
* @tags: 
* @group: Blog
* @name: Blog Archive PHP
* @type: PHP
* @status: published
* @created_by: 
* @created_at: 
* @updated_at: 2025-06-08 22:58:33
* @is_valid: 
* @updated_by: 
* @priority: 10
* @run_at: all
* @load_as_file: 
* @condition: {"status":"no","run_if":"assertive","items":[[]]}
*/
?>
<?php if (!defined("ABSPATH")) { return;} // <Internal Doc End> ?>
<?php
// Add shortcode function
function custom_blog_posts_shortcode() {
    ob_start();
    
    // Tüm kategorileri al
    $categories = get_categories();
    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 6,
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    $query = new WP_Query($args);
    
    if($query->have_posts()) : ?>
        <div class="blog-container">
            <div class="filter-toggle-wrapper">
                <div class="category-filter">
                    <button class="filter-btn active" data-category="all">Tümü</button>
                    <?php foreach($categories as $category) : ?>
                        <button class="filter-btn" data-category="<?php echo $category->term_id; ?>">
                            <?php echo $category->name; ?>
                        </button>
                    <?php endforeach; ?>
                </div>
                <div class="view-toggle">
                    <button class="toggle-btn active" data-view="grid">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    </button>
                    <button class="toggle-btn" data-view="list">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                    </button>
                </div>
            </div>
            <div class="blog-grid view-grid">
                <?php while($query->have_posts()) : $query->the_post(); ?>
                    <article class="blog-card">
                        <?php if(has_post_thumbnail()) : ?>
                            <div class="blog-card-image">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="blog-card-content">
                            <div class="blog-card-meta">
                                <span class="blog-date"><?php echo get_the_date('j F Y'); ?></span>
                                <?php
                                $categories = get_the_category();
                                if($categories) : ?>
                                    <span class="blog-category"><?php echo $categories[0]->name; ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <h3 class="blog-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <div class="blog-card-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                            </div>
                            
                            <div class="blog-card-author">
                                <?php
                                $author_id = get_the_author_meta('ID');
                                $author_avatar = get_avatar_url($author_id, array('size' => 40));
                                ?>
                                <img src="/wp-content/uploads/2025/05/emir-author.svg" alt="Emirhanın fotoğrafı" class="author-avatar">

                                <div class="author-info">
                                    <span class="author-name"><?php echo get_the_author(); ?></span>
                                    <span class="author-role">WordPress Uzmanı</span>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif;
    
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('blog_posts', 'custom_blog_posts_shortcode');

// AJAX handler fonksiyonu ekleyelim
function filter_posts() {
    $category = $_POST['category'];
    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 6,
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    if($category != 'all') {
        $args['cat'] = $category;
    }
    
    $query = new WP_Query($args);
    
    if($query->have_posts()) {
        while($query->have_posts()) : $query->the_post();
            // Mevcut blog card template'ini include et
            include(locate_template('template-parts/blog-card.php'));
        endwhile;
    } else {
        echo '<p class="no-posts">Bu kategoride henüz yazı bulunmuyor.</p>';
    }
    
    wp_reset_postdata();
    die();
}
add_action('wp_ajax_filter_posts', 'filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');

// JavaScript'i güncelleyelim
function add_view_toggle_script() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtns = document.querySelectorAll('.toggle-btn');
        const filterBtns = document.querySelectorAll('.filter-btn');
        const blogGrid = document.querySelector('.blog-grid');
        
        // View toggle functionality
        toggleBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                toggleBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const view = this.dataset.view;
                blogGrid.className = `blog-grid view-${view}`;
            });
        });
        
        // Category filter functionality
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const category = this.dataset.category;
                
                // AJAX request
                fetch(ajaxurl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=filter_posts&category=${category}`
                })
                .then(response => response.text())
                .then(html => {
                    blogGrid.innerHTML = html;
                });
            });
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'add_view_toggle_script'); 