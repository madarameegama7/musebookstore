<?php require APPROOT . '/views/inc/admin_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/report_style.css">

<div class="report-container">
    <div class="report-header">
        <h1><?php echo $data['title']; ?></h1>
        <div class="report-actions no-print">
            <a href="<?php echo URLROOT; ?>/admin/reports" class="btn btn-secondary">Back to Reports</a>
            <a href="<?php echo URLROOT; ?>/admin/reports/transactions/csv" class="btn btn-success">Export CSV</a>
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
            <form action="<?php echo URLROOT; ?>/admin/reports/transactions" method="POST" class="filter-form">
                <input type="hidden" name="filter_submitted" value="1">
                <div class="filter-group">
                    <label for="start_date">From Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo $data['filters']['start_date'] ?? ''; ?>">
                </div>
                <div class="filter-group">
                    <label for="end_date">To Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="<?php echo $data['filters']['end_date'] ?? ''; ?>">
                </div>
                <div class="filter-group">
                    <label for="type">Type</label>
                    <select id="type" name="type" class="form-control">
                        <option value="">All Types</option>
                        <?php foreach ($data['types'] as $type) : ?>
                            <option value="<?php echo $type; ?>" <?php echo (isset($data['filters']['type']) && $data['filters']['type'] === $type) ? 'selected' : ''; ?>><?php echo ucfirst($type); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <?php foreach ($data['statuses'] as $status) : ?>
                            <option value="<?php echo $status; ?>" <?php echo (isset($data['filters']['status']) && $data['filters']['status'] === $status) ? 'selected' : ''; ?>><?php echo ucfirst($status); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="search">Search</label>
                    <input type="text" id="search" name="search" class="form-control" placeholder="Search by book, requester, or owner" value="<?php echo $data['filters']['search'] ?? ''; ?>">
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="<?php echo URLROOT; ?>/admin/reports/clearFilters/transaction/transactions" class="clear-filters">Clear All Filters</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Transaction Report Table -->
    <div class="card">
        <div class="card-body">
            <?php if (empty($data['transactions'])) : ?>
                <div class="empty-state">
                    <i class="fas fa-exchange-alt"></i>
                    <h4>No Transaction Data Available</h4>
                    <p>There are no transactions matching your filter criteria. Try adjusting your filters or check back later.</p>
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered report-table" id="transactionReportTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Book</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Requester</th>
                                <th>Owner</th>
                                <th>Price</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['transactions'] as $transaction) : ?>
                                <tr>
                                    <td><?php echo $transaction->transaction_id; ?></td>
                                    <td><?php echo $transaction->book_title; ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $transaction->type; ?>">
                                            <?php echo $transaction->type; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo $transaction->status; ?>">
                                            <?php echo $transaction->status; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $transaction->requester_name; ?></td>
                                    <td><?php echo $transaction->owner_name; ?></td>
                                    <td>
                                        <?php echo ($transaction->type == 'sell') ? 'LKR ' . number_format($transaction->book_price, 2) : 'N/A'; ?>
                                    </td>
                                    <td><?php echo date('Y-m-d H:i', strtotime($transaction->created_at)); ?></td>
                                    <td><?php echo date('Y-m-d H:i', strtotime($transaction->updated_at)); ?></td>
                                    <td>
                                        <?php if ($transaction->has_payment > 0) : ?>
                                            <span class="status-badge status-completed">Paid</span>
                                        <?php else : ?>
                                            <?php if ($transaction->type == 'sell') : ?>
                                                <span class="status-badge status-declined">Unpaid</span>
                                            <?php else : ?>
                                                <span class="status-badge status-inactive">N/A</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Summary Cards -->
                <div class="report-summary">
                    <div class="summary-card">
                        <h3><i class="fas fa-exchange-alt"></i> Total Transactions</h3>
                        <div class="value"><?php echo count($data['transactions']); ?></div>
                    </div>
                    <?php
                    $sellCount = 0;
                    $swapCount = 0;
                    $completedCount = 0;
                    foreach ($data['transactions'] as $transaction) {
                        if ($transaction->type == 'sell') $sellCount++;
                        else if ($transaction->type == 'swap') $swapCount++;
                        if ($transaction->status == 'completed') $completedCount++;
                    }
                    ?>
                    <div class="summary-card">
                        <h3><i class="fas fa-tag"></i> Sell Transactions</h3>
                        <div class="value"><?php echo $sellCount; ?></div>
                        <div class="label"><?php echo count($data['transactions']) > 0 ? round(($sellCount / count($data['transactions'])) * 100) : 0; ?>% of transactions</div>
                    </div>
                    <div class="summary-card">
                        <h3><i class="fas fa-sync-alt"></i> Swap Transactions</h3>
                        <div class="value"><?php echo $swapCount; ?></div>
                        <div class="label"><?php echo count($data['transactions']) > 0 ? round(($swapCount / count($data['transactions'])) * 100) : 0; ?>% of transactions</div>
                    </div>
                    <div class="summary-card">
                        <h3><i class="fas fa-check-circle"></i> Completed</h3>
                        <div class="value"><?php echo $completedCount; ?></div>
                        <div class="label"><?php echo count($data['transactions']) > 0 ? round(($completedCount / count($data['transactions'])) * 100) : 0; ?>% completion rate</div>
                    </div>
                </div>

                <!-- Charts -->
                <!-- <div class="row mt-4">
                    <div class="col-md-6 mb-4">
                        <div class="report-chart-container">
                            <h3><i class="fas fa-chart-pie"></i> Transactions by Type</h3>
                            <canvas id="typeChart" class="chart-container"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="report-chart-container">
                            <h3><i class="fas fa-chart-bar"></i> Transactions by Status</h3>
                            <canvas id="statusChart" class="chart-container"></canvas>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="report-filename">
        Musebookstore Transaction Report - Generated <?php echo date('Y-m-d H:i'); ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script> -->
                <!-- function printWithFilename() {
        const currentDate = new Date();
        const dateString = currentDate.toLocaleString().replace(/[^\w\s]/gi, '-');
        const originalTitle = document.title;
        document.title = `musebookstore_transaction_report_${dateString}`;
        window.print();
        document.title = originalTitle;
    }
    document.addEventListener('DOMContentLoaded', function() {
        // Filter toggle functionality
        const filterToggle = document.getElementById('filterToggle');
        const filterSection = document.getElementById('filterSection');
        const hasActiveFilters = <?php echo (!empty($data['filters']['type']) || !empty($data['filters']['status']) || !empty($data['filters']['search'])) ? 'true' : 'false'; ?>;
        if (!hasActiveFilters) {
            filterSection.classList.add('collapsed');
            filterToggle.classList.add('collapsed');
        }
        filterToggle.addEventListener('click', function() {
            filterSection.classList.toggle('collapsed');
            filterToggle.classList.toggle('collapsed');
        });
        // Initialize DataTable
        $('#transactionReportTable').DataTable({
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
                "emptyTable": "No transactions found matching the criteria"
            }
        });
        <?php if (!empty($data['transactions'])) : ?>
            // Transaction Type Chart
            const typeData = {
                'sell': <?php echo $sellCount; ?>,
                'swap': <?php echo $swapCount; ?>
            }; -->
                <!-- const typeCtx = document.getElementById('typeChart').getContext('2d');
            new Chart(typeCtx, {
                type: 'pie',
                data: {
                    labels: Object.keys(typeData).map(type => type.charAt(0).toUpperCase() + type.slice(1)),
                    datasets: [{
                        data: Object.values(typeData),
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(75, 192, 192, 0.7)'
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
                            position: 'right'
                        }
                    }
                }
            });
            // Transaction Status Chart
            const statusData = {
                'pending': 0,
                'approved': 0,
                'declined': 0,
                'completed': 0
            };
            <?php foreach ($data['transactions'] as $transaction) : ?>
                statusData['<?php echo $transaction->status; ?>']++;
            <?php endforeach; ?>
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(statusData).map(status => status.charAt(0).toUpperCase() + status.slice(1)),
                    datasets: [{
                        label: 'Number of Transactions',
                        data: Object.values(statusData),
                        backgroundColor: [
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)'
                        ],
                        borderColor: [
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)'
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
                    }
                }
            });
        <?php endif; ?>
    });
</script> -->
                <?php require APPROOT . '/views/inc/admin_footer.php'; ?>