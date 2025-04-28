<?php require APPROOT . '/views/inc/admin_header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><?php echo $data['title']; ?></h1>
                <div>
                    <a href="<?php echo URLROOT; ?>/admin_controllers/reports" class="btn btn-secondary">Back to Reports</a>
                    <a href="<?php echo URLROOT; ?>/admin_controllers/reports/payments/csv" class="btn btn-success">Export CSV</a>
                    <a href="<?php echo URLROOT; ?>/admin_controllers/reports/payments/pdf" class="btn btn-danger">Export PDF</a>
                </div>
            </div>

            <?php flash('report_message'); ?>

            <!-- Payment Report Table -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Payment Report</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($data['payments'])) : ?>
                        <p class="text-muted">No payment data available.</p>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="paymentReportTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Order ID</th>
                                        <th>User</th>
                                        <th>Amount</th>
                                        <th>Currency</th>
                                        <th>Type</th>
                                        <th>Book/Transaction</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['payments'] as $payment) : ?>
                                        <tr>
                                            <td><?php echo $payment->payment_id; ?></td>
                                            <td><?php echo $payment->order_id ?? 'N/A'; ?></td>
                                            <td>
                                                <?php echo $payment->user_name; ?>
                                                <div><small class="text-muted"><?php echo $payment->user_email; ?></small></div>
                                            </td>
                                            <td><?php echo 'KES ' . number_format($payment->amount, 2); ?></td>
                                            <td><?php echo $payment->currency; ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo ($payment->payment_type == 'Book Purchase') ? 'primary' : 'success'; ?>">
                                                    <?php echo $payment->payment_type; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($payment->transaction_id) : ?>
                                                    <a href="<?php echo URLROOT; ?>/admin/transactions/view/<?php echo $payment->transaction_id; ?>">
                                                        <?php echo $payment->book_title ?? 'Transaction #' . $payment->transaction_id; ?>
                                                    </a>
                                                <?php else : ?>
                                                    <span class="text-muted">N/A</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo getPaymentStatusBadgeClass($payment->status); ?>">
                                                    <?php echo $payment->status; ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('Y-m-d H:i', strtotime($payment->created_at)); ?></td>
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
                                        <h5 class="card-title">Total Payments</h5>
                                        <p class="card-text display-4"><?php echo count($data['payments']); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Revenue</h5>
                                        <?php
                                        $totalRevenue = 0;
                                        foreach ($data['payments'] as $payment) {
                                            if ($payment->status == 'completed') {
                                                $totalRevenue += $payment->amount;
                                            }
                                        }
                                        ?>
                                        <p class="card-text display-4">KES <?php echo number_format($totalRevenue, 2); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Book Sales</h5>
                                        <?php
                                        $bookSales = 0;
                                        $bookCount = 0;
                                        foreach ($data['payments'] as $payment) {
                                            if ($payment->payment_type == 'Book Purchase' && $payment->status == 'completed') {
                                                $bookSales += $payment->amount;
                                                $bookCount++;
                                            }
                                        }
                                        ?>
                                        <p class="card-text display-4">KES <?php echo number_format($bookSales, 2); ?></p>
                                        <p class="card-text"><?php echo $bookCount; ?> books sold</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-warning text-dark">
                                    <div class="card-body">
                                        <h5 class="card-title">Token Sales</h5>
                                        <?php
                                        $tokenSales = 0;
                                        $tokenCount = 0;
                                        foreach ($data['payments'] as $payment) {
                                            if ($payment->payment_type == 'Token Purchase' && $payment->status == 'completed') {
                                                $tokenSales += $payment->amount;
                                                $tokenCount++;
                                            }
                                        }
                                        ?>
                                        <p class="card-text display-4">KES <?php echo number_format($tokenSales, 2); ?></p>
                                        <p class="card-text"><?php echo $tokenCount; ?> token transactions</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Charts -->
                        <div class="row mt-4">
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Payment Distribution</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="paymentDistributionChart" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0">Payment Status</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="paymentStatusChart" width="400" height="300"></canvas>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable
        $('#paymentReportTable').DataTable({
            "order": [
                [0, "desc"]
            ],
            "pageLength": 25,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ]
        });

        <?php if (!empty($data['payments'])) : ?>
            // Payment Distribution Chart (Book vs Token)
            const bookPaymentTotal = <?php
                                        $bookTotal = 0;
                                        foreach ($data['payments'] as $payment) {
                                            if ($payment->payment_type == 'Book Purchase' && $payment->status == 'completed') {
                                                $bookTotal += $payment->amount;
                                            }
                                        }
                                        echo $bookTotal;
                                        ?>;

            const tokenPaymentTotal = <?php
                                        $tokenTotal = 0;
                                        foreach ($data['payments'] as $payment) {
                                            if ($payment->payment_type == 'Token Purchase' && $payment->status == 'completed') {
                                                $tokenTotal += $payment->amount;
                                            }
                                        }
                                        echo $tokenTotal;
                                        ?>;

            const distributionCtx = document.getElementById('paymentDistributionChart').getContext('2d');
            new Chart(distributionCtx, {
                type: 'pie',
                data: {
                    labels: ['Book Purchases', 'Token Purchases'],
                    datasets: [{
                        data: [bookPaymentTotal, tokenPaymentTotal],
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
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += 'KES ' + new Intl.NumberFormat().format(context.raw);
                                    return label;
                                }
                            }
                        }
                    }
                }
            });

            // Payment Status Chart
            const statusData = {};

            <?php foreach ($data['payments'] as $payment) : ?>
                if (!statusData['<?php echo $payment->status; ?>']) {
                    statusData['<?php echo $payment->status; ?>'] = 0;
                }
                statusData['<?php echo $payment->status; ?>']++;
            <?php endforeach; ?>

            const statusCtx = document.getElementById('paymentStatusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(statusData).map(status => status.charAt(0).toUpperCase() + status.slice(1)),
                    datasets: [{
                        data: Object.values(statusData),
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.7)', // completed
                            'rgba(255, 206, 86, 0.7)', // pending
                            'rgba(255, 99, 132, 0.7)' // failed/other
                        ],
                        borderColor: 'white',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        <?php endif; ?>
    });

    // Helper function for payment status badge colors
    function getPaymentStatusBadgeClass(status) {
        switch (status) {
            case 'completed':
                return 'success';
            case 'pending':
                return 'warning text-dark';
            case 'failed':
                return 'danger';
            default:
                return 'secondary';
        }
    }
</script>

<?php require APPROOT . '/views/inc/admin_footer.php'; ?>