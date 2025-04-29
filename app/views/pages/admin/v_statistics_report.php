<?php require APPROOT . '/views/inc/admin_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/report_style.css">

<div class="report-container">
    <div class="report-header">
        <h1><?php echo $data['title']; ?></h1>
        <div class="report-actions no-print">
            <a href="<?php echo URLROOT; ?>/admin_controllers/reports" class="btn btn-secondary">Back to Reports</a>
            <a href="<?php echo URLROOT; ?>/admin_controllers/reports/customPeriod?report_type=<?php echo $data['report_type']; ?>&start_date=<?php echo $data['start_date']; ?>&end_date=<?php echo $data['end_date']; ?>&format=csv" class="btn btn-success">Export CSV</a>
            <a onclick="printWithFilename()" class="btn btn-danger">Export PDF</a>
        </div>
    </div>

    <?php flash('report_message'); ?>

    <!-- Period Info -->
    <div class="alert alert-info">
        <strong>Period:</strong> <?php echo date('F j, Y', strtotime($data['start_date'])); ?> to <?php echo date('F j, Y', strtotime($data['end_date'])); ?>
        <strong class="ms-3">Report Type:</strong> <?php echo ucfirst($data['report_type']); ?> Statistics
    </div>

    <!-- Statistics Table -->
    <div class="card">
        <div class="card-body">
            <?php if (empty($data['stats'])) : ?>
                <p class="text-muted">No data available for the selected period.</p>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered report-table" id="statisticsTable">
                        <thead>
                            <tr>
                                <?php foreach (array_keys((array)$data['stats'][0]) as $header) : ?>
                                    <th><?php echo str_replace('_', ' ', ucfirst($header)); ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['stats'] as $stat) : ?>
                                <tr>
                                    <?php foreach ((array)$stat as $key => $value) : ?>
                                        <td>
                                            <?php
                                            // Format numeric values
                                            if (is_numeric($value) && strpos($key, 'date') === false && strpos($key, 'count') === false) {
                                                echo number_format($value, 2);
                                            } else {
                                                echo $value;
                                            }
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Chart -->
                <div class="report-chart-container mt-4">
                    <h3>Data Visualization</h3>
                    <canvas id="statisticsChart" class="chart-container"></canvas>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="report-filename">
        Musebookstore <?php echo ucfirst($data['report_type']); ?> Statistics Report - Generated <?php echo date('Y-m-d H:i'); ?>
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
        const reportType = '<?php echo $data['report_type']; ?>';

        const originalTitle = document.title;
        document.title = `musebookstore_${reportType}_statistics_${dateString}`;
        window.print();
        document.title = originalTitle;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable
        $('#statisticsTable').DataTable({
            "order": [
                [0, "asc"]
            ],
            "pageLength": 25,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ]
        });

        <?php if (!empty($data['stats'])) : ?>
            // Create chart based on report type
            const reportType = '<?php echo $data['report_type']; ?>';
            const ctx = document.getElementById('statisticsChart').getContext('2d');

            // Parse data
            const labels = [];
            const datasets = [];
            const dateKey = Object.keys((<?php echo json_encode($data['stats'][0]); ?>)).find(key => key.includes('date'));

            <?php foreach ($data['stats'] as $stat) : ?>
                labels.push('<?php echo is_object($stat) ? ($stat->{array_keys((array)$stat)[0]} ?? '') : ''; ?>');
            <?php endforeach; ?>

            // Determine which columns to chart
            let columnsToChart = [];
            let colors = [
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 99, 132, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)'
            ];

            switch (reportType) {
                case 'user':
                    columnsToChart = ['user_count', 'parent_count', 'child_count', 'ambassador_count'];
                    break;
                case 'book':
                    columnsToChart = ['book_count', 'sell_count', 'swap_count', 'child_safe_count'];
                    break;
                case 'transaction':
                    columnsToChart = ['transaction_count', 'sell_count', 'swap_count', 'completed_count'];
                    break;
                case 'financial':
                    columnsToChart = ['total_amount', 'book_sales', 'token_sales'];
                    break;
                case 'token':
                    columnsToChart = ['total_tokens', 'total_amount', 'unique_users'];
                    break;
                case 'request':
                    columnsToChart = ['request_count', 'pending_count', 'approved_count', 'denied_count'];
                    break;
                default:
                    // For a generic chart, use 2nd column
                    const keys = Object.keys((<?php echo json_encode($data['stats'][0]); ?>));
                    if (keys.length > 1) {
                        columnsToChart = [keys[1]];
                    }
            }

            // Create dataset for each column
            columnsToChart.forEach((column, index) => {
                const data = [];
                <?php foreach ($data['stats'] as $stat) : ?>
                    data.push(<?php echo is_object($stat) ? ($stat->{$column} ?? 0) : 0; ?>);
                <?php endforeach; ?>

                datasets.push({
                    label: column.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()),
                    data: data,
                    backgroundColor: colors[index % colors.length],
                    borderColor: colors[index % colors.length].replace('0.7', '1'),
                    borderWidth: 1,
                    fill: reportType === 'financial' ? false : true,
                    tension: 0.4
                });
            });

            // Create chart
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (reportType === 'financial' && context.dataset.label.includes('Amount')) {
                                        label += 'LKR ' + context.formattedValue;
                                    } else {
                                        label += context.formattedValue;
                                    }
                                    return label;
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