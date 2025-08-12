<?php
// <Internal Doc Start>
/*
*
* @description: 
* @tags: 
* @group: 
* @name: Hizmetler Archive CSS
* @type: css
* @status: draft
* @created_by: 1
* @created_at: 2025-05-22 22:11:55
* @updated_at: 2025-05-22 22:17:37
* @is_valid: 1
* @updated_by: 1
* @priority: 10
* @run_at: wp_head
* @load_as_file: 
* @condition: {"status":"no","run_if":"assertive","items":[[]]}
*/
?>
<?php if (!defined("ABSPATH")) { return;} // <Internal Doc End> ?>
.service-grid {
    display: grid;
    gap: 1rem;
}

.view-grid .service-row {
    display: grid;
    grid-template-columns: 1fr;
    background: #fff;
    border: 1px solid #E5E7EB;
    border-radius: 0.5rem;
    padding: 1rem;
    transition: 0.2s;
}
@media (min-width: 768px) {
    .view-grid .service-row {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media (min-width: 1024px) {
    .view-grid .service-row {
        grid-template-columns: repeat(3, 1fr);
    }
}

.view-list {
    display: block;
}
.view-list .service-row {
    display: grid;
    grid-template-columns: 2fr 3fr 1fr 1fr;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid #E5E7EB;
}
.view-list .service-row:hover {
    background-color: #F9FAFB;
}

.service-cell {
    padding: 0.5rem;
    font-size: 0.875rem;
    color: #1f2937;
}

.service-title a {
    font-weight: 600;
    color: #111827;
    text-decoration: none;
}
.service-title a:hover {
    color: #9810fa;
}

.service-filter-toggle-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    gap: 1rem;
}
.service-category-filter {
    display: flex;
    gap: 0.5rem;
    overflow-x: auto;
    padding-bottom: 0.5rem;
    scrollbar-width: none;
}
.service-category-filter::-webkit-scrollbar {
    display: none;
}

.service-filter-btn,
.service-toggle-btn {
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
.service-filter-btn:hover,
.service-toggle-btn:hover {
    background: #F9FAFB;
    color: #030712;
}
.service-filter-btn.active,
.service-toggle-btn.active {
    background: #030712;
    color: white;
    border-color: #030712;
}

.service-no-posts {
    text-align: center;
    color: #666;
    padding: 2rem;
}
