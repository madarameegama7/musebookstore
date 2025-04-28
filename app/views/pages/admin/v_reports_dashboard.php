<?php require APPROOT . '/views/inc/admin_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/report_style.css">

<div class="container-fluid">
    <div class="report-container">
        <div class="report-header">
            <h1>Reports Dashboard</h1>
            <div class="report-actions no-print">
                <button onclick="printWithFilename()" class="btn btn-danger">
                    <i class="fas fa-print me-1"></i> Print Dashboard
                </button>
            </div>
        </div>

        <?php flash('report_message'); ?>

        <!-- Date Range Selection -->
        <div class="report-filters">
            <form action="<?php echo URLROOT; ?>/admin_controllers/reports" method="POST" class="filter-form">
                <div class="filter-group">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                        value="<?php echo isset($data['start_date']) ? $data['start_date'] : date('Y-m-01'); ?>">
                </div>
                <div class="filter-group">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date"
                        value="<?php echo isset($data['end_date']) ? $data['end_date'] : date('Y-m-d'); ?>">
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">Update Reports</button>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="report-summary">
            <div class="summary-card">
                <h3>Users</h3>
                <div class="value"><?php echo !empty($data['user_stats']) ? $data['user_stats'][0]->user_count : 0; ?></div>
                <div class="label">Total registered users</div>
                <a href="<?php echo URLROOT; ?>/admin/reports/users" class="btn btn-sm btn-primary mt-3">View Report</a>
            </div>

            <div class="summary-card">
                <h3>Books</h3>
                <div class="value"><?php echo !empty($data['book_stats']) ? $data['book_stats'][0]->book_count : 0; ?></div>
                <div class="label">Books in the system</div>
                <a href="<?php echo URLROOT; ?>/admin/reports/books" class="btn btn-sm btn-success mt-3">View Report</a>
            </div>

            <div class="summary-card">
                <h3>Transactions</h3>
                <div class="value"><?php echo !empty($data['transaction_stats']) ? $data['transaction_stats'][0]->transaction_count : 0; ?></div>
                <div class="label">Total transactions</div>
                <a href="<?php echo URLROOT; ?>/admin/reports/transactions" class="btn btn-sm btn-warning mt-3">View Report</a>
            </div>

            <div class="summary-card">
                <h3>Revenue</h3>
                <div class="value">LKR <?php echo !empty($data['financial_stats']) ? number_format($data['financial_stats'][0]->total_amount, 2) : '0.00'; ?></div>
                <div class="label">Total revenue generated</div>
                <a href="<?php echo URLROOT; ?>/admin/reports/payments" class="btn btn-sm btn-info mt-3">View Report</a>
            </div>
        </div>

        <!-- Report Options Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Full Reports</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-users text-primary me-2"></i> User Reports</h5>
                                        <p class="card-text">Analyze user registration, activity, and demographic data.</p>
                                        <div class="d-flex justify-content-between">
                                            <a href="<?php echo URLROOT; ?>/admin/reports/users" class="btn btn-outline-primary">View Report</a>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userReportDropdown" data-bs-toggle="dropdown">
                                                    Export
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/admin/reports/users/csv">CSV Export</a></li>
                                                    <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/admin/reports/users/pdf">PDF Export</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-book text-success me-2"></i> Book Reports</h5>
                                        <p class="card-text">Track book listings, sales, swaps, and popularity metrics.</p>
                                        <div class="d-flex justify-content-between">
                                            <a href="<?php echo URLROOT; ?>/admin/reports/books" class="btn btn-outline-success">View Report</a>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="bookReportDropdown" data-bs-toggle="dropdown">
                                                    Export
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/admin/reports/books/csv">CSV Export</a></li>
                                                    <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/admin/reports/books/pdf">PDF Export</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-exchange-alt text-warning me-2"></i> Transaction Reports</h5>
                                        <p class="card-text">Analyze book transactions, swaps, and status metrics.</p>
                                        <div class="d-flex justify-content-between">
                                            <a href="<?php echo URLROOT; ?>/admin/reports/transactions" class="btn btn-outline-warning">View Report</a>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="transactionReportDropdown" data-bs-toggle="dropdown">
                                                    Export
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/admin/reports/transactions/csv">CSV Export</a></li>
                                                    <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/admin/reports/transactions/pdf">PDF Export</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-dollar-sign text-info me-2"></i> Payment Reports</h5>
                                        <p class="card-text">Track financial metrics, revenue, and payment processing.</p>
                                        <div class="d-flex justify-content-between">
                                            <a href="<?php echo URLROOT; ?>/admin/reports/payments" class="btn btn-outline-info">View Report</a>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="paymentReportDropdown" data-bs-toggle="dropdown">
                                                    Export
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/admin/reports/payments/csv">CSV Export</a></li>
                                                    <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/admin/reports/payments/pdf">PDF Export</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Tables -->
        <div class="row mt-4">
            <!-- User Statistics -->
            <div class="col-lg-6 mb-4">
                <div class="report-chart-container">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>User Statistics</h3>
                        <form action="<?php echo URLROOT; ?>/admin/reports/customPeriod" method="POST" class="d-inline">
                            <input type="hidden" name="report_type" value="user">
                            <input type="hidden" name="start_date" value="<?php echo isset($data['start_date']) ? $data['start_date'] : date('Y-m-01'); ?>">
                            <input type="hidden" name="end_date" value="<?php echo isset($data['end_date']) ? $data['end_date'] : date('Y-m-d'); ?>">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="submit" name="format" value="html" class="btn btn-outline-primary btn-sm">Full Report</button>
                                <button type="submit" name="format" value="csv" class="btn btn-outline-success btn-sm">CSV</button>
                                <button type="submit" name="format" value="pdf" class="btn btn-outline-danger btn-sm">PDF</button>
                            </div>
                        </form>
                    </div>
                    <?php if (empty($data['user_stats'])) : ?>
                        <p class="text-muted">No user statistics available for the selected period.</p>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Parents</th>
                                        <th>Children</th>
                                        <th>Ambassadors</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['user_stats'] as $stat) : ?>
                                        <tr>
                                            <td><?php echo isset($stat->registration_date) ? $stat->registration_date : 'N/A'; ?></td>
                                            <td><?php echo isset($stat->user_count) ? $stat->user_count : 0; ?></td>
                                            <td><?php echo isset($stat->parent_count) ? $stat->parent_count : 0; ?></td>
                                            <td><?php echo isset($stat->child_count) ? $stat->child_count : 0; ?></td>
                                            <td><?php echo isset($stat->ambassador_count) ? $stat->ambassador_count : 0; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Book Statistics -->
            <div class="col-lg-6 mb-4">
                <div class="report-chart-container">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Book Statistics</h3>
                        <form action="<?php echo URLROOT; ?>/admin/reports/customPeriod" method="POST" class="d-inline">
                            <input type="hidden" name="report_type" value="book">
                            <input type="hidden" name="start_date" value="<?php echo isset($data['start_date']) ? $data['start_date'] : date('Y-m-01'); ?>">
                            <input type="hidden" name="end_date" value="<?php echo isset($data['end_date']) ? $data['end_date'] : date('Y-m-d'); ?>">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="submit" name="format" value="html" class="btn btn-outline-primary btn-sm">Full Report</button>
                                <button type="submit" name="format" value="csv" class="btn btn-outline-success btn-sm">CSV</button>
                                <button type="submit" name="format" value="pdf" class="btn btn-outline-danger btn-sm">PDF</button>
                            </div>
                        </form>
                    </div>
                    <?php if (empty($data['book_stats'])) : ?>
                        <p class="text-muted">No book statistics available for the selected period.</p>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>For Sale</th>
                                        <th>For Swap</th>
                                        <th>New</th>
                                        <th>Used</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['book_stats'] as $stat) : ?>
                                        <tr>
                                            <td><?php echo isset($stat->listing_date) ? $stat->listing_date : 'N/A'; ?></td>
                                            <td><?php echo isset($stat->book_count) ? $stat->book_count : 0; ?></td>
                                            <td><?php echo isset($stat->sell_count) ? $stat->sell_count : 0; ?></td>
                                            <td><?php echo isset($stat->swap_count) ? $stat->swap_count : 0; ?></td>
                                            <td><?php echo isset($stat->new_condition_count) ? $stat->new_condition_count : 0; ?></td>
                                            <td><?php echo isset($stat->used_condition_count) ? $stat->used_condition_count : 0; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Transaction Statistics -->
            <div class="col-lg-6 mb-4">
                <div class="report-chart-container">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Transaction Statistics</h3>
                        <form action="<?php echo URLROOT; ?>/admin/reports/customPeriod" method="POST" class="d-inline">
                            <input type="hidden" name="report_type" value="transaction">
                            <input type="hidden" name="start_date" value="<?php echo isset($data['start_date']) ? $data['start_date'] : date('Y-m-01'); ?>">
                            <input type="hidden" name="end_date" value="<?php echo isset($data['end_date']) ? $data['end_date'] : date('Y-m-d'); ?>">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="submit" name="format" value="html" class="btn btn-outline-primary btn-sm">Full Report</button>
                                <button type="submit" name="format" value="csv" class="btn btn-outline-success btn-sm">CSV</button>
                                <button type="submit" name="format" value="pdf" class="btn btn-outline-danger btn-sm">PDF</button>
                            </div>
                        </form>
                    </div>
                    <?php if (empty($data['transaction_stats'])) : ?>
                        <p class="text-muted">No transaction statistics available for the selected period.</p>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Sales</th>
                                        <th>Swaps</th>
                                        <th>Pending</th>
                                        <th>Completed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['transaction_stats'] as $stat) : ?>
                                        <tr>
                                            <td><?php echo isset($stat->transaction_date) ? $stat->transaction_date : 'N/A'; ?></td>
                                            <td><?php echo isset($stat->transaction_count) ? $stat->transaction_count : 0; ?></td>
                                            <td><?php echo isset($stat->sell_count) ? $stat->sell_count : 0; ?></td>
                                            <td><?php echo isset($stat->swap_count) ? $stat->swap_count : 0; ?></td>
                                            <td><?php echo isset($stat->pending_count) ? $stat->pending_count : 0; ?></td>
                                            <td><?php echo isset($stat->completed_count) ? $stat->completed_count : 0; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Financial Statistics -->
            <div class="col-lg-6 mb-4">
                <div class="report-chart-container">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Financial Statistics</h3>
                        <form action="<?php echo URLROOT; ?>/admin/reports/customPeriod" method="POST" class="d-inline">
                            <input type="hidden" name="report_type" value="financial">
                            <input type="hidden" name="start_date" value="<?php echo isset($data['start_date']) ? $data['start_date'] : date('Y-m-01'); ?>">
                            <input type="hidden" name="end_date" value="<?php echo isset($data['end_date']) ? $data['end_date'] : date('Y-m-d'); ?>">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="submit" name="format" value="html" class="btn btn-outline-primary btn-sm">Full Report</button>
                                <button type="submit" name="format" value="csv" class="btn btn-outline-success btn-sm">CSV</button>
                                <button type="submit" name="format" value="pdf" class="btn btn-outline-danger btn-sm">PDF</button>
                            </div>
                        </form>
                    </div>
                    <?php if (empty($data['financial_stats'])) : ?>
                        <p class="text-muted">No financial statistics available for the selected period.</p>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Payments</th>
                                        <th>Total (LKR)</th>
                                        <th>Book Sales (LKR)</th>
                                        <th>Token Sales (LKR)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['financial_stats'] as $stat) : ?>
                                        <tr>
                                            <td><?php echo isset($stat->payment_date) ? $stat->payment_date : 'N/A'; ?></td>
                                            <td><?php echo isset($stat->payment_count) ? $stat->payment_count : 0; ?></td>
                                            <td><?php echo isset($stat->total_amount) ? number_format($stat->total_amount, 2) : '0.00'; ?></td>
                                            <td><?php echo isset($stat->book_sales) ? number_format($stat->book_sales, 2) : '0.00'; ?></td>
                                            <td><?php echo isset($stat->token_sales) ? number_format($stat->token_sales, 2) : '0.00'; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function printWithFilename() {
        const currentDate = new Date();
        const dateString = currentDate.toLocaleString().replace(/[^\w\s]/gi, '-');

        const originalTitle = document.title;
        document.title = `musebookstore_reports_dashboard_${dateString}`;
        window.print();
        document.title = originalTitle;
    }
</script>

<?php require APPROOT . '/views/inc/admin_footer.php'; ?>