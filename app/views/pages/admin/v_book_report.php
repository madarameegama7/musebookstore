<?php require APPROOT . '/views/inc/admin_header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><?php echo $data['title']; ?></h1>
                <div class="no-print">
                    <a href="<?php echo URLROOT; ?>/admin/reports/index" class="btn btn-secondary">Back to Reports</a>
                    <a href="<?php echo URLROOT; ?>/admin/reports/books/csv" class="btn btn-success">Export CSV</a>
                    <a onclick="printWithFilename()" class="btn btn-danger">Export PDF</a>
                </div>
            </div>

            <?php flash('report_message'); ?>

            <!-- Book Report Table -->
            <div class="card">
                <!-- <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Book Report</h5>
                </div> -->
                <div class="card-body">
                    <?php if (empty($data['books'])) : ?>
                        <p class="text-muted">No book data available.</p>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="bookReportTable">
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
                                                <span class="badge bg-<?php echo ($book->book_condition == 'new') ? 'success' : 'warning text-dark'; ?>">
                                                    <?php echo $book->book_condition; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php echo ($book->listing_type == 'sell') ? 'KES ' . number_format($book->book_price, 2) : 'N/A'; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo ($book->listing_type == 'sell') ? 'primary' : 'info'; ?>">
                                                    <?php echo $book->listing_type; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo getStatusBadgeClass($book->book_status); ?>">
                                                    <?php echo $book->book_status; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo ($book->child_safe == 'yes') ? 'success' : 'danger'; ?>">
                                                    <?php echo $book->child_safe; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php echo $book->owner_name; ?>
                                                <span class="badge bg-secondary"><?php echo $book->owner_role; ?></span>
                                            </td>
                                            <td><?php echo date('Y-m-d', strtotime($book->created_at)); ?></td>
                                            <td>
                                                <small>
                                                    <i class="fas fa-heart text-danger"></i> <?php echo $book->favorite_count; ?>
                                                    <i class="fas fa-comment text-primary"></i> <?php echo $book->comment_count; ?>
                                                    <i class="fas fa-exchange-alt text-success"></i> <?php echo $book->transaction_count; ?>
                                                </small>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Summary Cards -->
                        <div class="row mt-4">
                            <div class="col-md-3 mb-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Books</h5>
                                        <p class="card-text display-4"><?php echo count($data['books']); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">For Sale</h5>
                                        <?php
                                        $sellCount = 0;
                                        foreach ($data['books'] as $book) {
                                            if ($book->listing_type == 'sell') $sellCount++;
                                        }
                                        ?>
                                        <p class="card-text display-4"><?php echo $sellCount; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">For Swap</h5>
                                        <?php
                                        $swapCount = 0;
                                        foreach ($data['books'] as $book) {
                                            if ($book->listing_type == 'swap') $swapCount++;
                                        }
                                        ?>
                                        <p class="card-text display-4"><?php echo $swapCount; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Available Books</h5>
                                        <?php
                                        $availableCount = 0;
                                        foreach ($data['books'] as $book) {
                                            if ($book->book_status == 'available') $availableCount++;
                                        }
                                        ?>
                                        <p class="card-text display-4"><?php echo $availableCount; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Charts -->
                        <div class="row mt-4">
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Books by Genre</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="genreChart" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0">Books by Status</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="statusChart" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function printWithFilename() {
        const currentDate = new Date();
        const dateString = currentDate.toLocaleString().replace(/[^\w\s]/gi, '-');

        const originalTitle = document.title;
        const siteName = "musebookstore";

        document.title = `${siteName}_transaction_report_${dateString}`;
        window.print();
        document.title = originalTitle;
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable
        $('#bookReportTable').DataTable({
            "order": [
                [0, "desc"]
            ],
            "pageLength": 25,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ]
        });

        <?php if (!empty($data['books'])) : ?>
            // Genre Chart
            const genreData = {};
            <?php foreach ($data['books'] as $book) : ?>
                if (!genreData['<?php echo $book->book_genre; ?>']) {
                    genreData['<?php echo $book->book_genre; ?>'] = 0;
                }
                genreData['<?php echo $book->book_genre; ?>']++;
            <?php endforeach; ?>

            const genreCtx = document.getElementById('genreChart').getContext('2d');
            new Chart(genreCtx, {
                type: 'pie',
                data: {
                    labels: Object.keys(genreData),
                    datasets: [{
                        data: Object.values(genreData),
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
                            'rgba(210, 105, 30, 0.7)',
                            'rgba(128, 0, 128, 0.7)',
                            'rgba(0, 128, 128, 0.7)'
                        ],
                        borderColor: 'white',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
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
                    labels: Object.keys(statusData),
                    datasets: [{
                        data: Object.values(statusData),
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)'
                        ],
                        borderColor: 'white',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        <?php endif; ?>
    });

    // Helper function for book status badge colors
    function getStatusBadgeClass(status) {
        switch (status) {
            case 'available':
                return 'success';
            case 'sold':
                return 'danger';
            case 'swapped':
                return 'info';
            default:
                return 'secondary';
        }
    }
</script>

<?php require APPROOT . '/views/inc/admin_footer.php'; ?>