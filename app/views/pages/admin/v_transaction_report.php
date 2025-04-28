<?php require APPROOT . '/views/inc/admin_header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><?php echo $data['title']; ?></h1>
                <div class="no-print">
                    <a href="<?php echo URLROOT; ?>/admin_controllers/reports" class="btn btn-secondary">Back to Reports</a>
                    <a href="<?php echo URLROOT; ?>/admin_controllers/reports/transactions/csv" class="btn btn-success">Export CSV</a>
                    <a onclick="printWithFilename()" class="btn btn-danger">Export PDF</a>
                </div>
            </div>

            <?php flash('report_message'); ?>

            <!-- Transaction Report Table -->
            <div class="card">
<!--                <div class="card-header bg-primary text-white">-->
<!--                    <h5 class="mb-0">Transaction Report</h5>-->
<!--                </div>-->
                <div class="card-body">
                    <?php if (empty($data['transactions'])) : ?>
                        <p class="text-muted">No transaction data available.</p>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="transactionReportTable">
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
                                                <span class="badge bg-<?php echo ($transaction->type == 'sell') ? 'primary' : 'info'; ?>">
                                                    <?php echo $transaction->type; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo getTransactionStatusBadgeClass($transaction->status); ?>">
                                                    <?php echo $transaction->status; ?>
                                                </span>
                                            </td>
                                            <td><?php echo $transaction->requester_name; ?></td>
                                            <td><?php echo $transaction->owner_name; ?></td>
                                            <td>
                                                <?php echo ($transaction->type == 'sell') ? 'KES ' . number_format($transaction->book_price, 2) : 'N/A'; ?>
                                            </td>
                                            <td><?php echo date('Y-m-d H:i', strtotime($transaction->created_at)); ?></td>
                                            <td><?php echo date('Y-m-d H:i', strtotime($transaction->updated_at)); ?></td>
                                            <td>
                                                <?php if ($transaction->has_payment > 0) : ?>
                                                    <span class="badge bg-success">Paid</span>
                                                <?php else : ?>
                                                    <?php if ($transaction->type == 'sell') : ?>
                                                        <span class="badge bg-danger">Unpaid</span>
                                                    <?php else : ?>
                                                        <span class="badge bg-secondary">N/A</span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
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
                                        <h5 class="card-title">Total Transactions</h5>
                                        <p class="card-text display-4"><?php echo count($data['transactions']); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Sell Transactions</h5>
                                        <?php
                                        $sellCount = 0;
                                        foreach ($data['transactions'] as $transaction) {
                                            if ($transaction->type == 'sell') $sellCount++;
                                        }
                                        ?>
                                        <p class="card-text display-4"><?php echo $sellCount; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Swap Transactions</h5>
                                        <?php
                                        $swapCount = 0;
                                        foreach ($data['transactions'] as $transaction) {
                                            if ($transaction->type == 'swap') $swapCount++;
                                        }
                                        ?>
                                        <p class="card-text display-4"><?php echo $swapCount; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-warning text-dark">
                                    <div class="card-body">
                                        <h5 class="card-title">Completed</h5>
                                        <?php
                                        $completedCount = 0;
                                        foreach ($data['transactions'] as $transaction) {
                                            if ($transaction->status == 'completed') $completedCount++;
                                        }
                                        ?>
                                        <p class="card-text display-4"><?php echo $completedCount; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Charts -->
                        <div class="row mt-4">
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Transactions by Type</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="typeChart" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0">Transactions by Status</h5>
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
        $('#transactionReportTable').DataTable({
            "order": [
                [0, "desc"]
            ],
            "pageLength": 25,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ]
        });

        <?php if (!empty($data['transactions'])) : ?>
            // Transaction Type Chart
            const typeData = {
                'sell': 0,
                'swap': 0
            };

            <?php foreach ($data['transactions'] as $transaction) : ?>
                typeData['<?php echo $transaction->type; ?>']++;
            <?php endforeach; ?>

            const typeCtx = document.getElementById('typeChart').getContext('2d');
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
                            'rgba(255, 206, 86, 0.7)', // pending
                            'rgba(75, 192, 192, 0.7)', // approved
                            'rgba(255, 99, 132, 0.7)', // declined
                            'rgba(54, 162, 235, 0.7)' // completed
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

    // Helper function for transaction status badge colors
    function getTransactionStatusBadgeClass(status) {
        switch (status) {
            case 'pending':
                return 'warning text-dark';
            case 'approved':
                return 'info';
            case 'declined':
                return 'danger';
            case 'completed':
                return 'success';
            default:
                return 'secondary';
        }
    }
</script>

<?php require APPROOT . '/views/inc/admin_footer.php'; ?>