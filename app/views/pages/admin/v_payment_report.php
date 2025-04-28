<?php
require_once APPROOT . '/helpers/Report_Helper.php';
require APPROOT . '/views/inc/admin_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/report_style.css">

<?php
function getPaymentStatusBadgeClassPHP($status)
{
    switch (strtolower($status)) {
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
?>

<div class="report-container">
    <div class="report-header">
        <h1><?php echo $data['title']; ?></h1>
        <div class="report-actions no-print">
            <a href="<?php echo URLROOT; ?>/admin_controllers/reports" class="btn btn-secondary">Back to Reports</a>
            <a href="<?php echo URLROOT; ?>/admin_controllers/reports/payments/csv" class="btn btn-success">Export CSV</a>
            <a onclick="printWithFilename()" class="btn btn-danger">Export PDF</a>
        </div>
    </div>

    <?php flash('report_message'); ?>

    <!-- Payment Report Table -->
    <div class="card">
        <div class="card-body">
            <?php if (empty($data['payments'])) : ?>
                <p class="text-muted">No payment data available.</p>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered report-table" id="paymentReportTable">
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
                            <?php foreach ($data['payments'] as $payment) :
                                if (!is_object($payment)) continue; ?>
                                <tr>
                                    <td><?php echo $payment->payment_id; ?></td>
                                    <td><?php echo $payment->order_id ?? 'N/A'; ?></td>
                                    <td>
                                        <?php echo $payment->user_name; ?>
                                        <div><small class="text-muted"><?php echo isset($payment->user_email) ? $payment->user_email : ''; ?></small></div>
                                    </td>
                                    <td><?php echo 'LKR ' . number_format($payment->amount, 2); ?></td>
                                    <td><?php echo $payment->currency; ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo ($payment->transaction_id ? 'primary' : 'success'); ?>">
                                            <?php echo $payment->transaction_id ? 'Book Purchase' : 'Token Purchase'; ?>
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
                                        <span class="badge bg-<?php echo getPaymentStatusBadgeClassPHP($payment->status); ?>">
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
                <div class="report-summary">
                    <div class="summary-card">
                        <h3>Total Payments</h3>
                        <div class="value"><?php echo count($data['payments']); ?></div>
                    </div>
                    <?php
                    $totalRevenue = $bookSales = $tokenSales = 0;
                    $bookCount = $tokenCount = 0;

                    foreach ($data['payments'] as $payment) {
                        if ($payment->status == 'completed') {
                            $totalRevenue += $payment->amount;

                            if (isset($payment->payment_type) && $payment->payment_type == 'Book Purchase') {
                                $bookSales += $payment->amount;
                                $bookCount++;
                            } else if (isset($payment->payment_type) && $payment->payment_type == 'Token Purchase') {
                                $tokenSales += $payment->amount;
                                $tokenCount++;
                            }
                        }
                    }
                    ?>
                    <div class="summary-card">
                        <h3>Total Revenue</h3>
                        <div class="value">LKR <?php echo number_format($totalRevenue, 2); ?></div>
                    </div>
                    <div class="summary-card">
                        <h3>Book Sales</h3>
                        <div class="value">LKR <?php echo number_format($bookSales, 2); ?></div>
                        <div class="label"><?php echo $bookCount; ?> books sold</div>
                    </div>
                    <div class="summary-card">
                        <h3>Token Sales</h3>
                        <div class="value">LKR <?php echo number_format($tokenSales, 2); ?></div>
                        <div class="label"><?php echo $tokenCount; ?> token transactions</div>
                    </div>
                </div>

                <!-- Charts -->
                <!-- <div class="row mt-4">
                    <div class="col-md-6 mb-4">
                        <div class="report-chart-container">
                            <h3>Payment Distribution</h3>
                            <canvas id="paymentDistributionChart" class="chart-container"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="report-chart-container">
                            <h3>Payment Status</h3>
                            <canvas id="paymentStatusChart" class="chart-container"></canvas>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="report-filename">
        Musebookstore Payment Report - Generated <?php echo date('Y-m-d H:i'); ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script> -->

                <script>
                    function printWithFilename() {
                        const currentDate = new Date();
                        const dateString = currentDate.toLocaleString().replace(/[^\w\s]/gi, '-');

                        const originalTitle = document.title;
                        const siteName = "musebookstore";

                        document.title = `${siteName}_payment_report_${dateString}`;
                        window.print();
                        document.title = originalTitle;
                    }
                </script>

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
                            const bookPaymentTotal = <?php echo $bookSales; ?>;
                            const tokenPaymentTotal = <?php echo $tokenSales; ?>;

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
                                    maintainAspectRatio: false,
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
                                                    label += 'LKR ' + new Intl.NumberFormat().format(context.raw);
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

                            const statusLabels = Object.keys(statusData).map(status => status.charAt(0).toUpperCase() + status.slice(1));
                            const statusValues = Object.values(statusData);

                            const statusCtx = document.getElementById('paymentStatusChart').getContext('2d');
                            new Chart(statusCtx, {
                                type: 'doughnut',
                                data: {
                                    labels: statusLabels,
                                    datasets: [{
                                        data: statusValues,
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
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            position: 'bottom'
                                        }
                                    }
                                }
                            });
                        <?php endif; ?>
                    });
                </script>

                <?php require APPROOT . '/views/inc/admin_footer.php'; ?>