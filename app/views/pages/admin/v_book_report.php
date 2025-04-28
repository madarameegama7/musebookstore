<?php require APPROOT . '/views/inc/admin_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/report_style.css">

<div class="report-container">
    <div class="report-header">
        <h1><?php echo $data['title']; ?></h1>
        <div class="report-actions no-print">
            <a href="<?php echo URLROOT; ?>/admin/reports" class="btn btn-secondary">Back to Reports</a>
            <a href="<?php echo URLROOT; ?>/admin/reports/books/csv" class="btn btn-success">Export CSV</a>
            <a onclick="printWithFilename()" class="btn btn-danger">Export PDF</a>
        </div>
    </div>

    <?php flash('report_message'); ?>

    <!-- Enhanced Filters Section -->
    <div class="report-filters">
        <button class="filter-toggle" id="filterToggle">
            <i class="fas fa-filter"></i> Filter Options
        </button>
        <div class="filter-section" id="filterSection">
            <form action="<?php echo URLROOT; ?>/admin/reports/books" method="POST" class="filter-form">
                <input type="hidden" name="filter_submitted" value="1">

                <div class="filter-group">
                    <label for="start_date">From Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control"
                        value="<?php echo $data['filters']['start_date'] ?? ''; ?>">
                </div>

                <div class="filter-group">
                    <label for="end_date">To Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control"
                        value="<?php echo $data['filters']['end_date'] ?? ''; ?>">
                </div>

                <div class="filter-group">
                    <label for="genre">Genre</label>
                    <select id="genre" name="genre" class="form-control">
                        <option value="">All Genres</option>
                        <?php foreach ($data['genres'] as $genre) : ?>
                            <option value="<?php echo $genre; ?>" <?php echo (isset($data['filters']['genre']) && $data['filters']['genre'] === $genre) ? 'selected' : ''; ?>>
                                <?php echo ucfirst($genre); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="condition">Condition</label>
                    <select id="condition" name="condition" class="form-control">
                        <option value="">All Conditions</option>
                        <?php foreach ($data['conditions'] as $condition) : ?>
                            <option value="<?php echo $condition; ?>" <?php echo (isset($data['filters']['condition']) && $data['filters']['condition'] === $condition) ? 'selected' : ''; ?>>
                                <?php echo ucfirst($condition); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="listing_type">Listing Type</label>
                    <select id="listing_type" name="listing_type" class="form-control">
                        <option value="">All Types</option>
                        <?php foreach ($data['listingTypes'] as $type) : ?>
                            <option value="<?php echo $type; ?>" <?php echo (isset($data['filters']['listing_type']) && $data['filters']['listing_type'] === $type) ? 'selected' : ''; ?>>
                                <?php echo ucfirst($type); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <?php foreach ($data['statuses'] as $status) : ?>
                            <option value="<?php echo $status; ?>" <?php echo (isset($data['filters']['status']) && $data['filters']['status'] === $status) ? 'selected' : ''; ?>>
                                <?php echo ucfirst($status); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="child_safe">Child Safe</label>
                    <select id="child_safe" name="child_safe" class="form-control">
                        <option value="">All Books</option>
                        <option value="yes" <?php echo (isset($data['filters']['child_safe']) && $data['filters']['child_safe'] === 'yes') ? 'selected' : ''; ?>>Child Safe Only</option>
                        <option value="no" <?php echo (isset($data['filters']['child_safe']) && $data['filters']['child_safe'] === 'no') ? 'selected' : ''; ?>>Not Child Safe Only</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="search">Search</label>
                    <input type="text" id="search" name="search" class="form-control"
                        placeholder="Search by title, author, or ISBN"
                        value="<?php echo $data['filters']['search'] ?? ''; ?>">
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="<?php echo URLROOT; ?>/admin/reports/clearFilters/book/books" class="clear-filters">Clear All Filters</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Book Report Table -->
    <div class="card">
        <div class="card-body">
            <?php if (empty($data['books'])) : ?>
                <div class="empty-state">
                    <i class="fas fa-books"></i>
                    <h4>No Book Data Available</h4>
                    <p>There are no books matching your filter criteria. Try adjusting your filters or adding new books to the system.</p>
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered report-table" id="bookReportTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Genre</th>
                                <th>Condition</th>
                                <th>Price</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Child Safe</th>
                                <th>Owner</th>
                                <th>Created</th>
                                <th>Stats</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['books'] as $book) : ?>
                                <tr>
                                    <td><?php echo $book->book_id; ?></td>
                                    <td><?php echo $book->book_title; ?></td>
                                    <td><?php echo $book->book_author; ?></td>
                                    <td><?php echo $book->book_genre; ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $book->book_condition; ?>">
                                            <?php echo $book->book_condition; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php echo ($book->listing_type == 'sell') ? 'KES ' . number_format($book->book_price, 2) : 'N/A'; ?>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo $book->listing_type; ?>">
                                            <?php echo $book->listing_type; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo $book->book_status; ?>">
                                            <?php echo $book->book_status; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo ($book->child_safe == 'yes') ? 'active' : 'inactive'; ?>">
                                            <?php echo $book->child_safe; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php echo $book->owner_name; ?>
                                        <small class="d-block text-muted"><?php echo $book->owner_role; ?></small>
                                    </td>
                                    <td><?php echo date('Y-m-d', strtotime($book->created_at)); ?></td>
                                    <td>
                                        <small>
                                            <i class="fas fa-heart text-danger" title="Favorites"></i> <?php echo $book->favorite_count; ?>
                                            <i class="fas fa-comment text-primary ml-1" title="Comments"></i> <?php echo $book->comment_count; ?>
                                            <i class="fas fa-exchange-alt text-success ml-1" title="Transactions"></i> <?php echo $book->transaction_count; ?>
                                        </small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Summary Cards -->
                <div class="report-summary">
                    <div class="summary-card">
                        <h3><i class="fas fa-book"></i> Total Books</h3>
                        <div class="value"><?php echo count($data['books']); ?></div>
                    </div>
                    <?php
                    $sellCount = 0;
                    $swapCount = 0;
                    $availableCount = 0;
                    $childSafeCount = 0;
                    $newConditionCount = 0;
                    $usedConditionCount = 0;

                    foreach ($data['books'] as $book) {
                        if ($book->listing_type == 'sell') $sellCount++;
                        if ($book->listing_type == 'swap') $swapCount++;
                        if ($book->book_status == 'available') $availableCount++;
                        if ($book->child_safe == 'yes') $childSafeCount++;
                        if ($book->book_condition == 'new') $newConditionCount++;
                        if ($book->book_condition == 'used') $usedConditionCount++;
                    }
                    ?>
                    <div class="summary-card">
                        <h3><i class="fas fa-tag"></i> For Sale</h3>
                        <div class="value"><?php echo $sellCount; ?></div>
                        <div class="label"><?php echo count($data['books']) > 0 ? round(($sellCount / count($data['books'])) * 100) : 0; ?>% of books</div>
                    </div>
                    <div class="summary-card">
                        <h3><i class="fas fa-sync-alt"></i> For Swap</h3>
                        <div class="value"><?php echo $swapCount; ?></div>
                        <div class="label"><?php echo count($data['books']) > 0 ? round(($swapCount / count($data['books'])) * 100) : 0; ?>% of books</div>
                    </div>
                    <div class="summary-card">
                        <h3><i class="fas fa-child"></i> Child Safe</h3>
                        <div class="value"><?php echo $childSafeCount; ?></div>
                        <div class="label"><?php echo count($data['books']) > 0 ? round(($childSafeCount / count($data['books'])) * 100) : 0; ?>% of books</div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="row mt-4">
                    <div class="col-md-6 mb-4">
                        <div class="report-chart-container">
                            <h3><i class="fas fa-chart-pie"></i> Books by Genre</h3>
                            <canvas id="genreChart" class="chart-container"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="report-chart-container">
                            <h3><i class="fas fa-chart-pie"></i> Books by Status</h3>
                            <canvas id="statusChart" class="chart-container"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="report-chart-container">
                            <h3><i class="fas fa-chart-pie"></i> Books by Condition</h3>
                            <canvas id="conditionChart" class="chart-container"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="report-chart-container">
                            <h3><i class="fas fa-chart-bar"></i> Books by Listing Type</h3>
                            <canvas id="listingTypeChart" class="chart-container"></canvas>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="report-filename">
        Musebookstore Book Report - Generated <?php echo date('Y-m-d H:i'); ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    function printWithFilename() {
        const currentDate = new Date();
        const dateString = currentDate.toLocaleString().replace(/[^\w\s]/gi, '-');

        const originalTitle = document.title;
        const siteName = "musebookstore";

        document.title = `${siteName}_book_report_${dateString}`;
        window.print();
        document.title = originalTitle;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Filter toggle functionality
        const filterToggle = document.getElementById('filterToggle');
        const filterSection = document.getElementById('filterSection');

        // Check if filters are active to decide initial state
        const hasActiveFilters = <?php echo (!empty($data['filters']['genre']) || !empty($data['filters']['condition']) ||
                                        !empty($data['filters']['listing_type']) || !empty($data['filters']['status']) ||
                                        !empty($data['filters']['child_safe']) || !empty($data['filters']['search'])) ? 'true' : 'false'; ?>;

        if (!hasActiveFilters) {
            filterSection.classList.add('collapsed');
            filterToggle.classList.add('collapsed');
        }

        filterToggle.addEventListener('click', function() {
            filterSection.classList.toggle('collapsed');
            filterToggle.classList.toggle('collapsed');
        });

        // Initialize DataTable with responsive features
        $('#bookReportTable').DataTable({
            "order": [
                [0, "desc"]
            ],
            "pageLength": 25,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "responsive": true,
            "language": {
                "emptyTable": "No books found matching the criteria"
            }
        });

        <?php if (!empty($data['books'])) : ?>
            // Genre Chart
            const genreData = {};
            <?php foreach ($data['books'] as $book) : ?>
                if (!genreData['<?php echo addslashes($book->book_genre); ?>']) {
                    genreData['<?php echo addslashes($book->book_genre); ?>'] = 0;
                }
                genreData['<?php echo addslashes($book->book_genre); ?>']++;
            <?php endforeach; ?>

            // Sort genres by count (descending) and take top 10
            const sortedGenres = Object.entries(genreData)
                .sort((a, b) => b[1] - a[1])
                .slice(0, 10);

            const genreLabels = sortedGenres.map(item => item[0]);
            const genreCounts = sortedGenres.map(item => item[1]);

            const genreCtx = document.getElementById('genreChart').getContext('2d');
            new Chart(genreCtx, {
                type: 'pie',
                data: {
                    labels: genreLabels,
                    datasets: [{
                        data: genreCounts,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)',
                            'rgba(199, 199, 199, 0.7)',
                            'rgba(83, 102, 255, 0.7)',
                            'rgba(40, 159, 64, 0.7)',
                            'rgba(210, 105, 30, 0.7)'
                        ],
                        borderColor: 'white',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 15,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = genreCounts.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // Status Chart
            const statusData = {
                'available': 0,
                'sold': 0,
                'swapped': 0
            };

            <?php foreach ($data['books'] as $book) : ?>
                statusData['<?php echo $book->book_status; ?>']++;
            <?php endforeach; ?>

            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(statusData).map(status => status.charAt(0).toUpperCase() + status.slice(1)),
                    datasets: [{
                        data: Object.values(statusData),
                        backgroundColor: [
                            'rgba(25, 135, 84, 0.7)', // available - green
                            'rgba(220, 53, 69, 0.7)', // sold - red
                            'rgba(13, 110, 253, 0.7)' // swapped - blue
                        ],
                        borderColor: 'white',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = Object.values(statusData).reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // Condition Chart
            const conditionData = {
                'new': <?php echo $newConditionCount; ?>,
                'used': <?php echo $usedConditionCount; ?>
            };

            const conditionCtx = document.getElementById('conditionChart').getContext('2d');
            new Chart(conditionCtx, {
                type: 'pie',
                data: {
                    labels: ['New', 'Used'],
                    datasets: [{
                        data: Object.values(conditionData),
                        backgroundColor: [
                            'rgba(25, 135, 84, 0.7)', // new - green
                            'rgba(255, 193, 7, 0.7)' // used - yellow
                        ],
                        borderColor: 'white',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = Object.values(conditionData).reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // Listing Type Chart
            const listingTypeData = {
                'sell': <?php echo $sellCount; ?>,
                'swap': <?php echo $swapCount; ?>
            };

            const listingTypeCtx = document.getElementById('listingTypeChart').getContext('2d');
            new Chart(listingTypeCtx, {
                type: 'bar',
                data: {
                    labels: ['For Sale', 'For Swap'],
                    datasets: [{
                        label: 'Number of Books',
                        data: Object.values(listingTypeData),
                        backgroundColor: [
                            'rgba(13, 110, 253, 0.7)', // sell - blue
                            'rgba(23, 162, 184, 0.7)' // swap - cyan
                        ],
                        borderColor: [
                            'rgba(13, 110, 253, 1)',
                            'rgba(23, 162, 184, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.dataset.label || '';
                                    const value = context.raw || 0;
                                    const total = Object.values(listingTypeData).reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        <?php endif; ?>
    });
</script>

<?php require APPROOT . '/views/inc/admin_footer.php'; ?>