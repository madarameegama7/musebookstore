<?php require APPROOT . '/views/inc/admin_header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><?php echo $data['title']; ?></h1>
                <div class="no-print">
                    <a href="<?php echo URLROOT; ?>/admin_controllers/reports" class="btn btn-secondary">Back to Reports</a>
                    <a href="<?php echo URLROOT; ?>/admin_controllers/reports/users/csv" class="btn btn-success">Export CSV</a>
                    <a onclick="printWithFilename()" class="btn btn-danger">Export PDF</a>
                </div>
            </div>

            <?php flash('report_message'); ?>

            <!-- User Report Table -->
            <div class="card">
<!--                <div class="card-header bg-primary text-white">-->
<!--                    <h5 class="mb-0">User Report</h5>-->
<!--                </div>-->
                <div class="card-body">
                    <?php if (empty($data['users'])) : ?>
                        <p class="text-muted">No user data available.</p>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="userReportTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Registration Date</th>
                                        <th>Verified</th>
                                        <th>Parent</th>
                                        <th>Books</th>
                                        <th>Transactions</th>
                                        <th>Tokens</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['users'] as $user) : ?>
                                        <tr>
                                            <td><?php echo $user->user_id; ?></td>
                                            <td><?php echo $user->user_name; ?></td>
                                            <td><?php echo $user->user_email; ?></td>
                                            <td><span class="badge bg-<?php echo getUserRoleBadgeClass($user->user_role); ?>"><?php echo $user->user_role; ?></span></td>
                                            <td><?php echo date('Y-m-d', strtotime($user->created_at)); ?></td>
                                            <td><?php echo $user->user_is_verified ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>'; ?></td>
                                            <td><?php echo $user->parent_name; ?></td>
                                            <td><?php echo $user->book_count; ?></td>
                                            <td><?php echo $user->transaction_count; ?></td>
                                            <td><?php echo $user->token_count; ?></td>
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
                                        <h5 class="card-title">Total Users</h5>
                                        <p class="card-text display-4"><?php echo count($data['users']); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Parents</h5>
                                        <?php
                                        $parentCount = 0;
                                        foreach ($data['users'] as $user) {
                                            if ($user->user_role == 'parent') $parentCount++;
                                        }
                                        ?>
                                        <p class="card-text display-4"><?php echo $parentCount; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Children</h5>
                                        <?php
                                        $childCount = 0;
                                        foreach ($data['users'] as $user) {
                                            if ($user->user_role == 'child') $childCount++;
                                        }
                                        ?>
                                        <p class="card-text display-4"><?php echo $childCount; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-warning text-dark">
                                    <div class="card-body">
                                        <h5 class="card-title">Ambassadors</h5>
                                        <?php
                                        $ambassadorCount = 0;
                                        foreach ($data['users'] as $user) {
                                            if ($user->user_role == 'ambassador') $ambassadorCount++;
                                        }
                                        ?>
                                        <p class="card-text display-4"><?php echo $ambassadorCount; ?></p>
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

    <script>
        function printWithFilename() {
            const currentDate = new Date();
            const dateString = currentDate.toLocaleString().replace(/[^\w\s]/gi, '-');

            const originalTitle = document.title;
            const siteName = "musebookstore";

            document.title = `${siteName}_user_report_${dateString}`;
            window.print();
            document.title = originalTitle;
        }
    </script>

    <script>
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
    });

    // Helper function for user role badge colors
    function getUserRoleBadgeClass(role) {
        switch (role) {
            case 'admin':
                return 'danger';
            case 'parent':
                return 'primary';
            case 'child':
                return 'success';
            case 'ambassador':
                return 'warning text-dark';
            default:
                return 'secondary';
        }
    }
</script>

<?php require APPROOT . '/views/inc/admin_footer.php'; ?>