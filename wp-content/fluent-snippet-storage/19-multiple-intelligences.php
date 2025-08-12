<?php
// <Internal Doc Start>
/*
*
* @description: 
* @tags: 
* @group: 
* @name: multiple intelligences
* @type: css
* @status: draft
* @created_by: 1
* @created_at: 2025-07-26 20:55:00
* @updated_at: 2025-07-26 20:55:00
* @is_valid: 1
* @updated_by: 1
* @priority: 10
* @run_at: wp_head
* @load_as_file: 
* @condition: {"status":"no","run_if":"assertive","items":[[]]}
*/
?>
<?php if (!defined("ABSPATH")) { return;} // <Internal Doc End> ?>
/* Base Styles - Mobile First Approach */
.mit-container {
    width: 100%;
    max-width: 100%;
    margin: 0;
    padding: 0rem;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background-color: #f9fafb;
    min-height: 100vh;
}


.mit-card {
    background: white;
    border-radius: 0.75rem;
    box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    padding: 0.5rem;
    margin-bottom: 1rem;
}

/* Header Styles */
.mit-header {
    text-align: center;
    margin-bottom: 1.5rem;
    padding: 0 0.5rem;
}

.mit-title {
    font-size: 1.5rem;
    line-height: 1.75rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 0.75rem;
}

.mit-subtitle {
    color: #6b7280;
    font-size: 0.875rem;
    line-height: 1.25rem;
}

/* Instructions */
.mit-instructions {
    background-color: #f3f4f6;
    border-radius: 0.75rem;
    padding: 1rem;
    margin: 0 0.5rem 1.5rem 0.5rem;
}

.mit-section-title {
    font-size: 1rem;
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.75rem;
}

.mit-list {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.mit-list li {
    position: relative;
    padding-left: 1.25rem;
    margin-bottom: 0.5rem;
    color: #4b5563;
    font-size: 0.875rem;
    line-height: 1.25rem;
}

.mit-list li:before {
    content: "";
    position: absolute;
    left: 0;
    top: 0.5rem;
    height: 0.25rem;
    width: 0.25rem;
    border-radius: 50%;
    background-color: #6366f1;
}

/* Form Styles */
.mit-form {
    padding: 0 0.5rem;
}

.mit-user-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.mit-input-group {
    display: flex;
    flex-direction: column;
}

.mit-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.375rem;
}

.mit-input[type=text] {
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 1rem;
    width: 100%;
    -webkit-appearance: none;
    appearance: none;
}

.mit-input:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

/* Questions Styles */
.mit-questions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
	  margin:0!important;
	  padding:0!important
}

.mit-question-item {
    background-color: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    padding: 1rem;
}
.mit-question-item {
    background-color: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    transition: all 0.15s ease-in-out;
}

.mit-question-item:hover {
    background-color: #f3f4f6;
    border-color: #d1d5db;
}

.mit-question-text {
    margin-bottom: 0.75rem;
    color: #111827;
    font-size: 0.875rem;
    line-height: 1.375rem;
}

.mit-question-number {
    font-weight: 600;
    color: #6366f1;
    margin-right: 0.5rem;
}

.mit-select{
    width: 100%!important;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    background-color: white;
    font-size: 1rem;
    color: #111827;
    -webkit-appearance: none;
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
}

/* Submit Button */
.mit-submit-btn {
    width: 100%;
    padding: 0.875rem;
    margin-top: 1.5rem;
    background-color: #6366f1;
    color: white;
    border: none;
    border-radius: 0.5rem;
    font-size: 1rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    -webkit-tap-highlight-color: transparent;
}

.mit-submit-btn:active {
    background-color: #4f46e5;
}
.mit-arrow-icon {width:1rem;height:1rem;line-height:1.4em;margin-top:2px;}

/* Results Styles */
.mit-results {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e5e7eb;
}

.mit-results-header {
    text-align: center;
    margin-bottom: 1.5rem;
    padding: 0 1rem;
}

.mit-results-header h3 {
    font-size: 1.25rem;
    line-height: 1.75rem;
    font-weight: 600;
    color: #111827;
    margin: 0;
}

.mit-chart-container {
    margin: 1.5rem -1rem;
    padding: 1rem;
    background-color: white;
    border-top: 1px solid #e5e7eb;
    border-bottom: 1px solid #e5e7eb;
}

.intelligence-summary {
    margin: 1.5rem 0.5rem;
    background-color: #f9fafb;
    border-radius: 0.75rem;
    padding: 1rem;
}

.dominant-type {
    background-color: white;
    border-radius: 0.75rem;
    padding: 1rem;
    margin-top: 0.75rem;
    border-left: 3px solid #6366f1;
}

.dominant-type h5 {
    color: #111827;
    font-size: 0.875rem;
    font-weight: 600;
    margin: 0 0 0.375rem 0;
}

.dominant-type p {
    color: #6b7280;
    font-size: 0.875rem;
    line-height: 1.25rem;
    margin: 0;
}

/* Loading State */
.mit-loading {
    opacity: 0.7;
    pointer-events: none;
    position: relative;
}

.mit-loading:after {
    content: "";
    position: fixed;
    top: 50%;
    left: 50%;
    width: 2rem;
    height: 2rem;
    margin: -1rem 0 0 -1rem;
    border: 2px solid #6366f1;
    border-top-color: transparent;
    border-radius: 50%;
    animation: mit-spin 0.6s linear infinite;
}
#mit-interpretation {
    margin-top: 30px;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 5px;
}

#mit-interpretation ul {
    list-style-type: none;
    padding: 0;
}

#mit-interpretation li {
    margin-bottom: 10px;
    padding: 5px 0;
}
#mit-credit{
    margin-top: 30px;
    padding: 0.5rem;
    background-color: #f9f9f9;
    border-radius: 5px;
	  font-size:0.875rem;
	  font-weight:500;
}

@keyframes mit-spin {
    to {
        transform: rotate(360deg);
    }
}

/* Touch Device Optimizations */
@media (hover: none) {
    .mit-select,
    .mit-input,
    .mit-submit-btn {
        font-size: 16px; /* Prevents iOS zoom on focus */
    }
    
    .mit-question-item {
        padding: 1rem;
        margin: 0 0.5rem;
    }
	.mit-questions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
	  margin:0!important;
	  padding:0!important
}
    
    .mit-select {
        padding: 0.875rem;
        margin: 0;
    }
}

/* Larger Screen Adjustments */
@media (min-width: 640px) {
    .mit-container {
        max-width: 640px;
        margin: 1rem auto;
        padding: 1rem;
    }
    .mit-questions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
	  margin:0!important;
	  padding:0!important
}
    .mit-card {
        padding: 1.5rem;
    }
    
    .mit-user-info {
        flex-direction: row;
    }
    
    .mit-chart-container {
        margin: 2rem auto;
        max-width: 500px;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
    }
}

/* iOS Specific Fixes */
@supports (-webkit-touch-callout: none) {
    .mit-input,
    .mit-select {
        font-size: 16px;
    }
    .mit-questions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
	  margin:0!important;
	  padding:0!important
}
    .mit-select {
        padding-right: 2rem;
    }
}