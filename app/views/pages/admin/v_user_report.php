<?php require APPROOT . '/views/inc/admin_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/report_style.css">

<div class="report-container">
    <div class="report-header">
        <h1><?php echo $data['title']; ?></h1>
        <div class="report-actions no-print">
            <a href="<?php echo URLROOT; ?>/admin_controllers/reports" class="btn btn-secondary">Back to Reports</a>
            <a href="<?php echo URLROOT; ?>/admin_controllers/reports/users/csv" class="btn btn-success">Export CSV</a>
            <a onclick="printWithFilename()" class="btn btn-danger">Export PDF</a>
        </div>
    </div>

    <?php flash('report_message'); ?>

    <!-- User Report Table -->
    <div class="card">
        <div class="card-body">
            <?php if (empty($data['users'])) : ?>
                <p class="text-muted">No user data available.</p>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered report-table" id="userReportTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Registered</th>
                                <th>Last Login</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['users'] as $user) : ?>
                                <tr>
                                    <td><?php echo $user->user_id; ?></td>
                                    <td><?php echo $user->user_name; ?></td>
                                    <td><?php echo $user->user_email; ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo ($user->user_role == 'admin') ? 'danger' : (($user->user_role == 'parent') ? 'primary' : 'success'); ?>">
                                            <?php echo $user->user_role; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo ($user->active == 1) ? 'success' : 'secondary'; ?>">
                                            <?php echo ($user->active == 1) ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('Y-m-d', strtotime($user->created_at)); ?></td>
                                    <td><?php echo $user->last_login ? date('Y-m-d H:i', strtotime($user->last_login)) : 'Never'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- User Summary Cards -->
                <div class="report-summary">
                    <div class="summary-card">
                        <h3>Total Users</h3>
                        <div class="value"><?php echo count($data['users']); ?></div>
                    </div>
                    <?php
                    $roleCount = [
                        'admin' => 0,
                        'parent' => 0,
                        'child' => 0,
                        'ambassador' => 0
                    ];

                    foreach ($data['users'] as $user) {
                        if (isset($roleCount[$user->user_role])) {
                            $roleCount[$user->user_role]++;
                        }
                    }
                    ?>
                    <div class="summary-card">
                        <h3>Parents</h3>
                        <div class="value"><?php echo $roleCount['parent']; ?></div>
                        <div class="label"><?php echo round(($roleCount['parent'] / count($data['users'])) * 100); ?>% of users</div>
                    </div>
                    <div class="summary-card">
                        <h3>Children</h3>
                        <div class="value"><?php echo $roleCount['child']; ?></div>
                        <div class="label"><?php echo round(($roleCount['child'] / count($data['users'])) * 100); ?>% of users</div>
                    </div>
                    <div class="summary-card">
                        <h3>Administrators</h3>
                        <div class="value"><?php echo $roleCount['admin']; ?></div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="row mt-4">
                    <div class="col-md-6 mb-4">
                        <div class="report-chart-container">
                            <h3>Users by Role</h3>
                            <canvas id="roleChart" class="chart-container"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="report-chart-container">
                            <h3>Registration Timeline</h3>
                            <canvas id="registrationChart" class="chart-container"></canvas>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="report-filename">
        Musebookstore User Report - Generated <?php echo date('Y-m-d H:i'); ?>
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
        document.title = `musebookstore_user_report_${dateString}`;
        window.print();
        document.title = originalTitle;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable
        $('#userReportTable').DataTable({
            "order": [
                [0, "desc"]
            ],
            "pageLength": 25,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ]
        });

        <?php if (!empty($data['users'])) : ?>
            // Role Chart
            const roleData = {
                'admin': <?php echo $roleCount['admin']; ?>,
                'parent': <?php echo $roleCount['parent']; ?>,
                'child': <?php echo $roleCount['child']; ?>,
                'ambassador': <?php echo $roleCount['ambassador'] ?? 0; ?>
            };

            const roleCtx = document.getElementById('roleChart').getContext('2d');
            new Chart(roleCtx, {
                type: 'pie',
                data: {
                    labels: Object.keys(roleData).map(role => role.charAt(0).toUpperCase() + role.slice(1)),
                    datasets: [{
                        data: Object.values(roleData),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)', // admin
                            'rgba(54, 162, 235, 0.7)', // parent
                            'rgba(255, 206, 86, 0.7)', // child
                            'rgba(75, 192, 192, 0.7)' // ambassador
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

            // Registration Timeline Chart (group users by month)
            const registrationDates = {};
            <?php foreach ($data['users'] as $user) : ?>
                const regDate = '<?php echo date('Y-m', strtotime($user->created_at)); ?>';
                if (!registrationDates[regDate]) {
                    registrationDates[regDate] = 0;
                }
                registrationDates[regDate]++;
            <?php endforeach; ?>

            // Sort dates chronologically
            const sortedDates = Object.keys(registrationDates).sort();

            const registrationCtx = document.getElementById('registrationChart').getContext('2d');
            new Chart(registrationCtx, {
                type: 'line',
                data: {
                    labels: sortedDates,
                    datasets: [{
                        label: 'New Users',
                        data: sortedDates.map(date => registrationDates[date]),
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        tension: 0.1,
                        fill: true
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
</script>

<?php require APPROOT . '/views/inc/admin_footer.php'; ?>