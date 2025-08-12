<?php
/*
Plugin Name: Multiple Intelligences Test
Description: A comprehensive Multiple Intelligences Test based on Howard Gardner's theory
Version: 1.0
Author: Your Name
*/

// Security check
if (!defined('ABSPATH')) {
    exit;
}

// Activation hook
register_activation_hook(__FILE__, 'mit_activate');

function mit_activate() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'mit_results';
    
    // Önce tabloyu siliyoruz
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
    
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        test_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        linguistic_score FLOAT NOT NULL,
        logical_mathematical_score FLOAT NOT NULL,
        musical_score FLOAT NOT NULL,
        spatial_score FLOAT NOT NULL,
        bodily_kinesthetic_score FLOAT NOT NULL,
        interpersonal_score FLOAT NOT NULL,
        intrapersonal_score FLOAT NOT NULL,
        naturalistic_score FLOAT NOT NULL
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    if ($wpdb->last_error) {
        error_log('MIT Plugin Database Error: ' . $wpdb->last_error);
    }
}

// Create shortcode
add_shortcode('multiple_intelligences_test', 'mit_test_display');

function mit_test_display() {
    ob_start();
    ?>
    <div class="mit-container">
        <div class="mit-card">
            <div class="mit-header">
                <h2 class="mit-title">Multiple Intelligences Test</h2>
                <p class="mit-subtitle">Discover your intelligence types based on Howard Gardner's theory.</p>
            </div>
    <div class="mit-banner">
        <img src="https://emirhankiziloglu.com/wp-content/uploads/2025/04/multiple-intelligences-banner-681122dd5e1b9.webp" alt="Multiple Intelligences Banner" class="mit-banner-image" style="width: 100%; max-width: 666px; height: auto; margin: 20px 0; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
    </div>
            <div class="mit-instructions">
                <h3 class="mit-section-title">Instructions</h3>
                <ul class="mit-list">
                    <li>Read each statement carefully</li>
                    <li>Select "True" if the statement describes you well</li>
                    <li>Select "False" if it doesn't describe you</li>
                    <li>Select "Sometimes" if it partially describes you</li>
                </ul>
            </div>

            <form id="mit-test-form" class="mit-form">
                <div class="mit-user-info">
                    <div class="mit-input-group">
                        <label for="first_name" class="mit-label">First Name</label>
                        <input type="text" id="first_name" name="first_name" required 
                               class="mit-input" placeholder="Enter your first name">
                    </div>
                    <div class="mit-input-group">
                        <label for="last_name" class="mit-label">Last Name</label>
                        <input type="text" id="last_name" name="last_name" required 
                               class="mit-input" placeholder="Enter your last name">
                    </div>
                </div>

                <div class="mit-questions">
                    <?php
                    $questions = array(
                        // Linguistic Intelligence
                        1 => "I enjoy writing stories, poems, or essays.",
                        2 => "I find it easy to explain ideas clearly to others.",
                        3 => "I love reading books and playing with words.",
                        4 => "I often notice grammar or spelling mistakes when reading.",
                        
                        // Logical-Mathematical Intelligence
                        5 => "I enjoy solving puzzles, riddles, or brainteasers.",
                        6 => "I quickly understand complex patterns or logical sequences.",
                        7 => "I like to experiment, analyze, and figure things out.",
                        8 => "I often find myself questioning why and how things work.",
                        
                        // Musical Intelligence
                        9 => "I easily remember melodies or musical patterns.",
                        10 => "I often tap rhythms with my hands or feet unconsciously.",
                        11 => "Music deeply affects my emotions and moods.",
                        12 => "I enjoy singing, playing instruments, or composing music.",
                        
                        // Spatial Intelligence
                        13 => "I can easily visualize objects or places in my mind.",
                        14 => "I enjoy drawing, designing, or creating visual art.",
                        15 => "I can find my way easily even in new places.",
                        16 => "I enjoy working with maps, charts, or diagrams.",
                        
                        // Bodily-Kinesthetic Intelligence
                        17 => "I learn better by moving, touching, or acting things out.",
                        18 => "I enjoy sports, dance, or physical activities.",
                        19 => "I have good hand-eye coordination.",
                        20 => "I often use gestures when I talk or explain something.",
                        
                        // Intrapersonal Intelligence
                        21 => "I often reflect on my feelings, thoughts, and motivations.",
                        22 => "I know my strengths and weaknesses clearly.",
                        23 => "I set personal goals and work steadily to achieve them.",
                        24 => "I prefer working alone rather than in groups sometimes.",
                        
                        // Interpersonal Intelligence
                        25 => "I easily sense how others are feeling without them telling me.",
                        26 => "I enjoy working and learning in groups.",
                        27 => "I can resolve conflicts between people effectively.",
                        28 => "I naturally take leadership roles in group activities.",
                        
                        // Naturalistic Intelligence
                        29 => "I enjoy being in nature and observing plants or animals.",
                        30 => "I easily recognize different species of animals, flowers, or trees.",
                        31 => "I feel a deep connection with the natural world.",
                        32 => "I enjoy organizing things into categories based on their characteristics."
                    );

                    foreach ($questions as $num => $question) {
                        ?>
                        <div class="mit-question-item">
                            <div class="mit-question-text">
                                <span class="mit-question-number"><?php echo $num; ?>.</span>
                                <?php echo $question; ?>
                            </div>
                            <div class="mit-select-container">
                                <select name="q<?php echo $num; ?>" class="mit-select" required>
                                    <option value="">Select an answer...</option>
                                    <option value="T">True</option>
                                    <option value="F">False</option>
                                    <option value="S">Sometimes</option>
                                </select>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>

                <button type="submit" class="mit-submit-btn">
                    <span>Show Results</span>
                    <svg class="mit-arrow-icon" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
								<div id="mit-credit" class="mit-credit">This Multiple Intelligences test was created by Group B – the Multiple Intelligences group.
Group members: Emirhan Kızıloğlu, Rabia Bayram, and İbrahim Özgür Öveç.
It was developed by Emirhan Kızıloğlu on April 28, 2025.</div>
            </form>

            <div id="mit-results" class="mit-results" style="display:none;">
                <div class="mit-results-header">
                    <h3>Intelligence Profile for <span id="user-full-name"></span></h3>
                </div>
                <div class="results-summary"></div>
                <div class="mit-chart-container">
                    <canvas id="mitChart"></canvas>
                </div>
                <div id="mit-interpretation" class="mit-interpretation"></div>
            </div>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('#mit-test-form').on('submit', function(e) {
            e.preventDefault();
            
            $(this).addClass('mit-loading');
            $('.mit-submit-btn').prop('disabled', true);
            
            var firstName = $('#first_name').val();
            var lastName = $('#last_name').val();
            var formData = $(this).serialize();
            
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'calculate_mit_results',
                    form_data: formData
                },
                success: function(response) {
                    if(response.success) {
                        $('#mit-test-form').removeClass('mit-loading');
                        $('.mit-submit-btn').prop('disabled', false);
                        
                        $('#mit-results').show();
                        $('#user-full-name').text(firstName + ' ' + lastName);
                        
                        var existingChart = Chart.getChart("mitChart");
                        if (existingChart) {
                            existingChart.destroy();
                        }

                        var ctx = document.getElementById('mitChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'radar',
                            data: {
                                labels: Object.keys(response.data.results),
                                datasets: [{
                                    label: 'Intelligence Profile',
                                    data: Object.values(response.data.results),
                                    backgroundColor: 'rgba(99, 102, 241, 0.2)',
                                    borderColor: 'rgb(99, 102, 241)',
                                    pointBackgroundColor: 'rgb(99, 102, 241)',
                                    pointBorderColor: '#fff',
                                    pointHoverBackgroundColor: '#fff',
                                    pointHoverBorderColor: 'rgb(99, 102, 241)',
                                    borderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    r: {
                                        beginAtZero: true,
                                        max: 4,
                                        ticks: {
                                            stepSize: 1
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                }
                            }
                        });

                        var resultsSummary = '<div class="intelligence-summary">';
                        var allTypes = [];

                        Object.entries(response.data.results).forEach(([type, score]) => {
                            var percentage = (score / 4) * 100;
                            allTypes.push({
                                type: type,
                                score: percentage,
                                description: getDescriptionForType(type)
                            });
                        });

                        allTypes.sort((a, b) => b.score - a.score);

                        resultsSummary += '<h4>Your Intelligence Profile:</h4>';
                        allTypes.forEach(type => {
                            resultsSummary += `
                                <div class="dominant-type">
                                    <h5>${type.type} Intelligence (${type.score.toFixed(1)}%)</h5>
                                    <p>${type.description}</p>
                                </div>
                            `;
                        });
                        
                        resultsSummary += '</div>';
                        $('.results-summary').html(resultsSummary);

                        $('html, body').animate({
                            scrollTop: $('#mit-results').offset().top - 20
                        }, 500);

                        // Form reset
                        $('#mit-test-form')[0].reset();
                    } else {
                        alert('Error saving results: ' + response.data);
                    }
                },
                error: function() {
                    $('#mit-test-form').removeClass('mit-loading');
                    $('.mit-submit-btn').prop('disabled', false);
                    alert('An error occurred. Please try again.');
                }
            });
        });

        function getDescriptionForType(type) {
            const descriptions = {
                'Linguistic': "You have a strong ability with words and language. You may excel in reading, writing, telling stories or doing crossword puzzles.",
                'Logical-Mathematical': "You have strong logical reasoning and problem-solving abilities. You're good with numbers, abstract thinking, and scientific investigation.",
                'Musical': "You show sensitivity to rhythm and sound. You may love music, and may be a good singer or musician.",
                'Spatial': "You tend to think in terms of physical space and are very aware of your environment. You may be good at reading maps and diagrams.",
                'Bodily-Kinesthetic': "You have a keen sense of body awareness and handle objects skillfully. You may excel at sports, dance, crafts, or other physical activities.",
                'Intrapersonal': "You have a deep understanding of yourself - your strengths, weaknesses, and what makes you unique. You excel in self-reflection.",
                'Interpersonal': "You understand and interact effectively with others. You may be good at leading, organizing, communicating, and manipulating.",
                'Naturalistic': "You show expertise in recognition and classification of natural environment. You may be good at categorizing and understanding natural phenomena."
            };
            return descriptions[type] || "";
        }
    });
    </script>
    <?php
    return ob_get_clean();
}
// AJAX handler for calculating results
add_action('wp_ajax_calculate_mit_results', 'calculate_mit_results');
add_action('wp_ajax_nopriv_calculate_mit_results', 'calculate_mit_results');

function calculate_mit_results() {
    if (!isset($_POST['form_data'])) {
        wp_send_json_error('Invalid request');
    }

    $form_data = array();
    parse_str($_POST['form_data'], $form_data);

    $categories = array(
        'Linguistic' => array(1, 2, 3, 4),
        'Logical-Mathematical' => array(5, 6, 7, 8),
        'Musical' => array(9, 10, 11, 12),
        'Spatial' => array(13, 14, 15, 16),
        'Bodily-Kinesthetic' => array(17, 18, 19, 20),
        'Intrapersonal' => array(21, 22, 23, 24),
        'Interpersonal' => array(25, 26, 27, 28),
        'Naturalistic' => array(29, 30, 31, 32)
    );

    $results = array();
    foreach ($categories as $category => $questions) {
        $score = 0;
        $answered_questions = 0;
        foreach ($questions as $q) {
            if (isset($form_data['q' . $q])) {
                switch ($form_data['q' . $q]) {
                    case 'T':
                        $score += 1;
                        $answered_questions++;
                        break;
                    case 'S':
                        $score += 0.5;
                        $answered_questions++;
                        break;
                    case 'F':
                        $answered_questions++;
                        break;
                }
            }
        }
        $results[$category] = $answered_questions > 0 ? $score : 0;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'mit_results';
    
    $insert_result = $wpdb->insert(
        $table_name,
        array(
            'first_name' => sanitize_text_field($form_data['first_name']),
            'last_name' => sanitize_text_field($form_data['last_name']),
            'test_date' => current_time('mysql'),
            'linguistic_score' => $results['Linguistic'],
            'logical_mathematical_score' => $results['Logical-Mathematical'],
            'musical_score' => $results['Musical'],
            'spatial_score' => $results['Spatial'],
            'bodily_kinesthetic_score' => $results['Bodily-Kinesthetic'],
            'intrapersonal_score' => $results['Intrapersonal'],
            'interpersonal_score' => $results['Interpersonal'],
            'naturalistic_score' => $results['Naturalistic']
        )
    );

    if ($insert_result === false) {
        wp_send_json_error('Database error: ' . $wpdb->last_error);
    }

    wp_send_json_success(array(
        'results' => $results,
        'message' => 'Test results saved successfully'
    ));
}

// Admin menu
add_action('admin_menu', 'mit_add_admin_menu');

function mit_add_admin_menu() {
    add_menu_page(
        'Multiple Intelligences Test Results',
        'MI Test Results',
        'manage_options',
        'mit-results',
        'mit_display_results_page',
        'dashicons-chart-area',
        30
    );
}

function mit_display_results_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'mit_results';

    // Pagination
    $per_page = 20;
    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $offset = ($current_page - 1) * $per_page;

    // Search and filter
    $where = "WHERE 1=1";
    $search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
    if ($search) {
        $where .= $wpdb->prepare(
            " AND (first_name LIKE %s OR last_name LIKE %s)",
            '%' . $wpdb->esc_like($search) . '%',
            '%' . $wpdb->esc_like($search) . '%'
        );
    }

    if (isset($_GET['date_filter'])) {
        switch ($_GET['date_filter']) {
            case 'today':
                $where .= " AND DATE(test_date) = CURDATE()";
                break;
            case 'week':
                $where .= " AND YEARWEEK(test_date) = YEARWEEK(CURDATE())";
                break;
            case 'month':
                $where .= " AND MONTH(test_date) = MONTH(CURDATE()) AND YEAR(test_date) = YEAR(CURDATE())";
                break;
        }
    }

    // Get total items
    $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name $where");
    $total_pages = ceil($total_items / $per_page);

    // Get results
    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name $where ORDER BY test_date DESC LIMIT %d OFFSET %d",
            $per_page,
            $offset
        )
    );

    // Handle export
    if (isset($_POST['export_results']) && check_admin_referer('mit_export_results')) {
        mit_export_results_to_csv();
    }

    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Multiple Intelligences Test Results</h1>
        
        <form method="post" style="display: inline-block; margin-left: 10px;">
            <?php wp_nonce_field('mit_export_results'); ?>
            <button type="submit" name="export_results" class="button button-secondary">
                Export to CSV
            </button>
        </form>

        <div class="tablenav top">
            <form method="get" class="alignleft actions">
                <input type="hidden" name="page" value="mit-results">
                <input type="text" name="search" placeholder="Search by name..." 
                       value="<?php echo esc_attr($search); ?>">
                <select name="date_filter">
                    <option value="">All Dates</option>
                    <option value="today" <?php selected(isset($_GET['date_filter']) && $_GET['date_filter'] == 'today'); ?>>Today</option>
                    <option value="week" <?php selected(isset($_GET['date_filter']) && $_GET['date_filter'] == 'week'); ?>>This Week</option>
                    <option value="month" <?php selected(isset($_GET['date_filter']) && $_GET['date_filter'] == 'month'); ?>>This Month</option>
                </select>
                <input type="submit" class="button" value="Filter">
            </form>
        </div>

        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Test Date</th>
                    <th>Linguistic</th>
                    <th>Logical-Mathematical</th>
                    <th>Musical</th>
                    <th>Spatial</th>
                    <th>Bodily-Kinesthetic</th>
                    <th>Intrapersonal</th>
                    <th>Interpersonal</th>
                    <th>Naturalistic</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo esc_html($result->id); ?></td>
                        <td><?php echo esc_html($result->first_name . ' ' . $result->last_name); ?></td>
                        <td><?php echo esc_html(date('Y-m-d H:i', strtotime($result->test_date))); ?></td>
                        <td><?php echo number_format($result->linguistic_score, 2); ?></td>
                        <td><?php echo number_format($result->logical_mathematical_score, 2); ?></td>
                        <td><?php echo number_format($result->musical_score, 2); ?></td>
                        <td><?php echo number_format($result->spatial_score, 2); ?></td>
                        <td><?php echo number_format($result->bodily_kinesthetic_score, 2); ?></td>
                        <td><?php echo number_format($result->intrapersonal_score, 2); ?></td>
                        <td><?php echo number_format($result->interpersonal_score, 2); ?></td>
                        <td><?php echo number_format($result->naturalistic_score, 2); ?></td>
                        <td>
                            <button class="button button-small view-details" 
                                    data-id="<?php echo esc_attr($result->id); ?>">
                                View Details
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="tablenav bottom">
            <div class="tablenav-pages">
                <?php
                echo paginate_links(array(
                    'base' => add_query_arg('paged', '%#%'),
                    'format' => '',
                    'prev_text' => __('&laquo;'),
                    'next_text' => __('&raquo;'),
                    'total' => $total_pages,
                    'current' => $current_page
                ));
                ?>
            </div>
        </div>
    </div>

    <div id="result-detail-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="result-detail-content"></div>
        </div>
    </div>

    <style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        border-radius: 5px;
        position: relative;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: black;
    }

    .result-chart-container {
        height: 400px;
        margin: 20px 0;
    }
    </style>

    <script>
    jQuery(document).ready(function($) {
        $('.view-details').click(function() {
            var resultId = $(this).data('id');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'get_result_details',
                    result_id: resultId,
                    nonce: '<?php echo wp_create_nonce('mit_view_details'); ?>'
                },
                success: function(response) {
                    $('#result-detail-content').html(response);
                    $('#result-detail-modal').show();
                }
            });
        });

        $('.close').click(function() {
            $('#result-detail-modal').hide();
        });

        $(window).click(function(e) {
            if ($(e.target).is('#result-detail-modal')) {
                $('#result-detail-modal').hide();
            }
        });
    });
    </script>
    <?php
}

// Export to CSV
function mit_export_results_to_csv() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'mit_results';
    
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY test_date DESC", ARRAY_A);
    
    if (!empty($results)) {
        // UTF-8 BOM ekleyelim (Excel'de Türkçe karakterler için)
        $bom = chr(239) . chr(187) . chr(191);
        
        // CSV başlıkları
        $headers = array(
            'ID',
            'First Name',
            'Last Name',
            'Test Date',
            'Linguistic Intelligence',
            'Logical-Mathematical Intelligence',
            'Musical Intelligence',
            'Spatial Intelligence',
            'Bodily-Kinesthetic Intelligence',
            'Interpersonal Intelligence',
            'Intrapersonal Intelligence',
            'Naturalistic Intelligence'
        );

        // Buffer'ı temizle
        if (ob_get_length()) ob_clean();
        
        // Header'ları ayarla
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="mi-test-results-' . date('Y-m-d') . '.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        // Dosyayı aç
        $output = fopen('php://output', 'w');
        
        // BOM ekle
        fputs($output, $bom);
        
        // Başlıkları yaz
        fputcsv($output, $headers);
        
        // Verileri yaz
        foreach ($results as $row) {
            $export_row = array(
                $row['id'],
                $row['first_name'],
                $row['last_name'],
                date('Y-m-d H:i', strtotime($row['test_date'])),
                number_format($row['linguistic_score'], 2),
                number_format($row['logical_mathematical_score'], 2),
                number_format($row['musical_score'], 2),
                number_format($row['spatial_score'], 2),
                number_format($row['bodily_kinesthetic_score'], 2),
                number_format($row['interpersonal_score'], 2),
                number_format($row['intrapersonal_score'], 2),
                number_format($row['naturalistic_score'], 2)
            );
            fputcsv($output, $export_row);
        }
        
        fclose($output);
        exit;
    }
}

// AJAX handler for result details
add_action('wp_ajax_get_result_details', 'mit_get_result_details');
add_action('wp_ajax_nopriv_get_result_details', 'mit_get_result_details');

function mit_get_result_details() {
    check_ajax_referer('mit_view_details', 'nonce');

    if (!isset($_POST['result_id'])) {
        wp_die('Invalid request');
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'mit_results';
    
    $result = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE id = %d",
        intval($_POST['result_id'])
    ));

    if ($result) {
        $html = '<h2>' . esc_html($result->first_name . ' ' . $result->last_name) . '</h2>';
        $html .= '<p>Test Date: ' . esc_html(date('Y-m-d H:i', strtotime($result->test_date))) . '</p>';
        
        $html .= '<div class="result-chart-container"><canvas id="detailChart"></canvas></div>';
        
        $html .= '<table class="wp-list-table widefat fixed">';
        $html .= '<thead><tr><th>Intelligence Type</th><th>Score</th><th>Percentage</th></tr></thead>';
        $html .= '<tbody>';
        
        $intelligence_types = array(
            'Linguistic' => $result->linguistic_score,
            'Logical-Mathematical' => $result->logical_mathematical_score,
            'Musical' => $result->musical_score,
            'Spatial' => $result->spatial_score,
            'Bodily-Kinesthetic' => $result->bodily_kinesthetic_score,
            'Intrapersonal' => $result->intrapersonal_score,
            'Interpersonal' => $result->interpersonal_score,
            'Naturalistic' => $result->naturalistic_score
        );

        foreach ($intelligence_types as $type => $score) {
            $percentage = ($score / 4) * 100;
            $html .= sprintf(
                '<tr><td>%s</td><td>%.2f</td><td>%.1f%%</td></tr>',
                esc_html($type),
                $score,
                $percentage
            );
        }
        
        $html .= '</tbody></table>';

        echo $html;
    }
    
    wp_die();
}

// Enqueue scripts and styles
add_action('wp_enqueue_scripts', 'mit_enqueue_scripts');

function mit_enqueue_scripts() {
    wp_enqueue_style('mit-styles', plugins_url('/css/style.css', __FILE__));
    wp_enqueue_script('jquery');
    wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', array(), null, true);
}

// Add viewport meta tag
function mit_add_viewport_meta() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">';
}
add_action('wp_head', 'mit_add_viewport_meta');