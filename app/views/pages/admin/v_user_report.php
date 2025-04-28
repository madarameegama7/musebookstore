<?php require APPROOT . '/views/inc/admin_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/report_style.css">

<div class="report-container">
    <div class="report-header">
        <h1><?php echo $data['title']; ?></h1>
        <div class="report-actions no-print">
            <a href="<?php echo URLROOT; ?>/admin/reports" class="btn btn-secondary">Back to Reports</a>
            <a href="<?php echo URLROOT; ?>/admin/reports/users/csv" class="btn btn-success">Export CSV</a>
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
            <form action="<?php echo URLROOT; ?>/admin/reports/users" method="POST" class="filter-form">
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
                    <label for="role">User Role</label>
                    <select id="role" name="role" class="form-control">
                        <option value="">All Roles</option>
                        <?php foreach ($data['roles'] as $role) : ?>
                            <option value="<?php echo $role; ?>" <?php echo (isset($data['filters']['role']) && $data['filters']['role'] === $role) ? 'selected' : ''; ?>>
                                <?php echo ucfirst($role); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="active" <?php echo (isset($data['filters']['status']) && $data['filters']['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo (isset($data['filters']['status']) && $data['filters']['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="search">Search</label>
                    <input type="text" id="search" name="search" class="form-control"
                        placeholder="Search by name or email"
                        value="<?php echo $data['filters']['search'] ?? ''; ?>">
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="<?php echo URLROOT; ?>/admin/reports/clearFilters/user/users" class="clear-filters">Clear All Filters</a>
                </div>
            </form>
        </div>
    </div>

    <!-- User Report Table -->
    <div class="card">
        <div class="card-body">
            <?php if (empty($data['users'])) : ?>
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <h4>No User Data Available</h4>
                    <p>There are no users matching your filter criteria. Try adjusting your filters or adding new users to the system.</p>
                </div>
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
                                <th>Stats</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['users'] as $user) : ?>
                                <tr>
                                    <td><?php echo $user->user_id; ?></td>
                                    <td><?php echo $user->user_name; ?></td>
                                    <td><?php echo $user->user_email; ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo getUserRoleBadgeClass($user->user_role); ?>">
                                            <?php echo $user->user_role; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo ($user->user_is_verified == 1) ? 'active' : 'inactive'; ?>">
                                            <?php echo ($user->user_is_verified == 1) ? 'Verified' : 'Unverified'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('Y-m-d', strtotime($user->created_at)); ?></td>
                                    <td>
                                        <small>
                                            <i class="fas fa-book text-primary" title="Books"></i> <?php echo $user->book_count; ?>
                                            <i class="fas fa-exchange-alt text-success ml-1" title="Transactions"></i> <?php echo $user->transaction_count; ?>
                                            <i class="fas fa-coins text-warning ml-1" title="Tokens"></i> <?php echo $user->token_count; ?>
                                        </small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- User Summary Cards -->
                <div class="report-summary">
                    <div class="summary-card">
                        <h3><i class="fas fa-users"></i> Total Users</h3>
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
                        <h3><i class="fas fa-user-tie"></i> Parents</h3>
                        <div class="value"><?php echo $roleCount['parent']; ?></div>
                        <div class="label"><?php echo count($data['users']) > 0 ? round(($roleCount['parent'] / count($data['users'])) * 100) : 0; ?>% of users</div>
                    </div>
                    <div class="summary-card">
                        <h3><i class="fas fa-child"></i> Children</h3>
                        <div class="value"><?php echo $roleCount['child']; ?></div>
                        <div class="label"><?php echo count($data['users']) > 0 ? round(($roleCount['child'] / count($data['users'])) * 100) : 0; ?>% of users</div>
                    </div>
                    <div class="summary-card">
                        <h3><i class="fas fa-user-shield"></i> Administrators</h3>
                        <div class="value"><?php echo $roleCount['admin']; ?></div>
                        <div class="label"><?php echo count($data['users']) > 0 ? round(($roleCount['admin'] / count($data['users'])) * 100) : 0; ?>% of users</div>
                    </div>
                </div>

                <!-- Charts
                <div class="row mt-4">
                    <div class="col-md-6 mb-4">
                        <div class="report-chart-container">
                            <h3><i class="fas fa-chart-pie"></i> Users by Role</h3>
                            <canvas id="roleChart" class="chart-container"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="report-chart-container">
                            <h3><i class="fas fa-chart-line"></i> Registration Timeline</h3>
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
        // Filter toggle functionality
        const filterToggle = document.getElementById('filterToggle');
        const filterSection = document.getElementById('filterSection');

        // Check if filters are active to decide initial state
        const hasActiveFilters = <?php echo (!empty($data['filters']['role']) || !empty($data['filters']['status']) || !empty($data['filters']['search'])) ? 'true' : 'false'; ?>;

        if (!hasActiveFilters) {
            filterSection.classList.add('collapsed');
            filterToggle.classList.add('collapsed');
        }

        filterToggle.addEventListener('click', function() {
            filterSection.classList.toggle('collapsed');
            filterToggle.classList.toggle('collapsed');
        });

        // Initialize DataTable with responsive features
        $('#userReportTable').DataTable({
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
                "emptyTable": "No users found matching the criteria"
            }
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
                            'rgba(220, 53, 69, 0.7)', // admin - red
                            'rgba(13, 110, 253, 0.7)', // parent - blue
                            'rgba(25, 135, 84, 0.7)', // child - green
                            'rgba(255, 193, 7, 0.7)' // ambassador - yellow
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
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = Object.values(roleData).reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
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
                    labels: sortedDates.map(date => {
                        const [year, month] = date.split('-');
                        return new Date(year, month - 1).toLocaleDateString(undefined, {
                            year: 'numeric',
                            month: 'short'
                        });
                    }),
                    datasets: [{
                        label: 'New Users',
                        data: sortedDates.map(date => registrationDates[date]),
                        borderColor: 'rgba(13, 110, 253, 1)',
                        backgroundColor: 'rgba(13, 110, 253, 0.2)',
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
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                title: function(context) {
                                    return context[0].label;
                                },
                                label: function(context) {
                                    return `New registrations: ${context.raw}`;
                                }
                            }
                        }
                    }
                }
            });
        <?php endif; ?>
    });
</script> -->

<?php require APPROOT . '/views/inc/admin_footer.php'; ?>