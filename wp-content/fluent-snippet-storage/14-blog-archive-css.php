<?php
// <Internal Doc Start>
/*
*
* @description: 
* @tags: 
* @group: Blog
* @name: Blog Archive CSS
* @type: css
* @status: published
* @created_by: 
* @created_at: 
* @updated_at: 2025-05-19 10:56:30
* @is_valid: 
* @updated_by: 
* @priority: 10
* @run_at: wp_head
* @load_as_file: 
* @condition: {"status":"no","run_if":"assertive","items":[[]]}
*/
?>
<?php if (!defined("ABSPATH")) { return;} // <Internal Doc End> ?>
.from-blog-section {
    margin: 0 auto;
    padding: 0rem;
}

.blog-section-title {
    font-size: 36px;
    font-weight: 700;
    text-align: center;
    color: #1a1a1a;
    margin-bottom: 8px;
}

.blog-section-subtitle {
    font-size: 20px;
    text-align: center;
    color: #666;
    margin-bottom: 48px;
}

.blog-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 32px;
}

@media (min-width: 768px) {
    .blog-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .blog-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

.blog-card {
    background: #fff;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.blog-card-image {
    position: relative;
    height: 255px;
    width: 100%;
    border-radius:1.125rem;
    overflow: hidden;
    border:1px solid #E5E7EB;
}

.blog-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.blog-card-content {
    padding-top: 2rem;
}

.blog-card-meta {
    display: flex;
    align-items: center;
    gap: 16px;
    font-size: 0.75rem;
    color: #E5E7EB;
    margin-bottom: 12px;
}

.blog-date {
    color: #111827;
}

.blog-category {
    padding: 4px 12px;
    border-radius: 0.5rem;
    background-color: #f9fafb;
    color: #111827;
}

.blog-card-title {
    font-size: 1rem;
    font-weight: 600;
    color: #111827;
    margin-bottom: 1.25rem;
}

.blog-card-title a {
    text-decoration: none;
    color: inherit;
}

.blog-card-title a:hover {
    color: #9810fa;
}

.blog-card-excerpt {
    color: #4B5666;
    font-size: 0.75rem;
    margin-bottom: 24px;
}

.blog-card-author {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-top: 0.5rem;
}

.author-avatar {
    width: 40px!important;
    height: 40px!important;
    border-radius:50%!important;
    padding:0.2rem;
    background-color:#e5e7eb;
}

.author-info {
    display: flex;
    flex-direction: column;
}

.author-name {
    font-weight: 500;
    font-size:0.875rem;
    color: #111827;
}

.author-role {
    font-size: 0.75rem;
    color: #111827;
}

.blog-container {
    margin: 0 auto;
    padding:0;
}

.view-toggle {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}

.toggle-btn {
    padding: 0.5rem;
    border: 1px solid #E5E7EB;
    border-radius: 0.5rem;
    background: white;
    cursor: pointer;
    color: #030712;
    transition: all 0.2s;
}

.toggle-btn:hover {
    background: #F9FAFB;
    color: #030712;
}

.toggle-btn.active {
    background: #030712;
    color: white;
    border-color: #030712;
}
.toggle-btn.active svg, .toggle-btn svg{margin-bottom:-6px!important;}
/* Grid View (default) */
.view-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 32px;
}

@media (min-width: 768px) {
    .view-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .view-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* List View */
.view-list {
    display: grid;
    grid-template-columns: 1fr;
    gap: 32px;
}

.view-list .blog-card {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 32px;
}

.view-list .blog-card-image {
    height: 100%;
    margin: 0;
}

.view-list .blog-card-content {
    padding: 24px 0;
}

/* Responsive List View */
@media (max-width: 768px) {
    .view-list .blog-card {
        grid-template-columns: 1fr;
    }
    
    .view-list .blog-card-image {
        height: 255px;
    }
}

.filter-toggle-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    gap: 1rem;
}

.category-filter {
    display: flex;
    gap: 0.5rem;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
    padding-bottom: 0.5rem;
}

.category-filter::-webkit-scrollbar {
    display: none; /* Chrome, Safari and Opera */
}

.filter-btn {
    white-space: nowrap;
    padding: 0.5rem 1rem;
    border: 1px solid #E5E7EB;
    border-radius: 0.5rem;
    background: white;
    cursor: pointer;
    color: #030712;
    transition: all 0.2s;
    font-size: 0.875rem;
}

.filter-btn:hover {
    background: #F9FAFB;
    color: #030712;
}

.filter-btn.active {
    background: #030712;
    color: white;
    border-color: #030712;
}

.no-posts {
    text-align: center;
    color: #666;
    padding: 2rem;
    grid-column: 1 / -1;
}

@media (max-width: 768px) {
    .filter-toggle-wrapper {
        flex-direction: column;
        align-items: stretch;
    }
    .filter-btn {
    font-size: 0.75rem;
}
    
    .view-toggle {
        display: none;
    }

    .blog-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 32px;
    }

    .view-list .blog-card {
        display: block;
    }

    .view-list .blog-card-image {
        height: 255px;
        width: 100%;
        margin-bottom: 1rem;
    }

    .view-list .blog-card-content {
        padding: 1rem 0;
    }
} 