<?php require APPROOT . '/views/inc/admin_header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <h1>Reports Dashboard</h1>

            <?php flash('report_message'); ?>

            <!-- Date Range Selection -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Select Date Range</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo URLROOT; ?>/admin_controllers/reports" method="POST" class="row g-3">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="<?php echo isset($data['start_date']) ? $data['start_date'] : date('Y-m-01'); ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="<?php echo isset($data['end_date']) ? $data['end_date'] : date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary d-block">Update Reports</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Users</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo !empty($data['user_stats']) ? $data['user_stats'][0]->user_count : 0; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <a href="<?php echo URLROOT; ?>/admin/reports/users" class="text-primary">View Report <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Books</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo !empty($data['book_stats']) ? $data['book_stats'][0]->book_count : 0; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-book fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <a href="<?php echo URLROOT; ?>/admin/reports/books" class="text-success">View Report <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Transactions</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo !empty($data['transaction_stats']) ? $data['transaction_stats'][0]->transaction_count : 0; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <a href="<?php echo URLROOT; ?>/admin/reports/transactions" class="text-info">View Report <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Revenue</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        KES <?php echo !empty($data['financial_stats']) ? number_format($data['financial_stats'][0]->total_amount, 2) : '0.00'; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <a href="<?php echo URLROOT; ?>/admin/reports/payments" class="text-warning">View Report <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <h4 class="card-title">View Full Reports</h4>
                <p class="card-text">Access detailed reports for each section:</p>
                <div class="mb-3">
                    <a href="<?php echo URLROOT; ?>/admin/reports/users" class="btn btn-primary me-2">User Reports</a>
                    <a href="<?php echo URLROOT; ?>/admin/reports/books" class="btn btn-success me-2">Book Reports</a>
                    <a href="<?php echo URLROOT; ?>/admin/reports/transactions" class="btn btn-warning me-2">Transaction Reports</a>
                    <a href="<?php echo URLROOT; ?>/admin/reports/payments" class="btn btn-info">Payment Reports</a>
                </div>
            </div>

            <!-- Statistics Tables -->
            <div class="row">
                <!-- User Statistics -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">User Statistics</h5>
                            <form action="<?php echo URLROOT; ?>/admin/reports/customPeriod" method="POST" class="d-inline">
                                <input type="hidden" name="report_type" value="user">
                                <input type="hidden" name="start_date" value="<?php echo isset($data['start_date']) ? $data['start_date'] : date('Y-m-01'); ?>">
                                <input type="hidden" name="end_date" value="<?php echo isset($data['end_date']) ? $data['end_date'] : date('Y-m-d'); ?>">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="submit" name="format" value="html" class="btn btn-light btn-sm">Full Report</button>
                                    <button type="submit" name="format" value="csv" class="btn btn-success btn-sm">CSV</button>
                                    <button type="submit" name="format" value="pdf" class="btn btn-danger btn-sm">PDF</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
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
                </div>

                <!-- Book Statistics -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Book Statistics</h5>
                            <form action="<?php echo URLROOT; ?>/admin/reports/customPeriod" method="POST" class="d-inline">
                                <input type="hidden" name="report_type" value="book">
                                <input type="hidden" name="start_date" value="<?php echo isset($data['start_date']) ? $data['start_date'] : date('Y-m-01'); ?>">
                                <input type="hidden" name="end_date" value="<?php echo isset($data['end_date']) ? $data['end_date'] : date('Y-m-d'); ?>">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="submit" name="format" value="html" class="btn btn-light btn-sm">Full Report</button>
                                    <button type="submit" name="format" value="csv" class="btn btn-success btn-sm">CSV</button>
                                    <button type="submit" name="format" value="pdf" class="btn btn-danger btn-sm">PDF</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
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
                </div>

                <!-- Transaction Statistics -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Transaction Statistics</h5>
                            <form action="<?php echo URLROOT; ?>/admin/reports/customPeriod" method="POST" class="d-inline">
                                <input type="hidden" name="report_type" value="transaction">
                                <input type="hidden" name="start_date" value="<?php echo isset($data['start_date']) ? $data['start_date'] : date('Y-m-01'); ?>">
                                <input type="hidden" name="end_date" value="<?php echo isset($data['end_date']) ? $data['end_date'] : date('Y-m-d'); ?>">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="submit" name="format" value="html" class="btn btn-light btn-sm">Full Report</button>
                                    <button type="submit" name="format" value="csv" class="btn btn-success btn-sm">CSV</button>
                                    <button type="submit" name="format" value="pdf" class="btn btn-danger btn-sm">PDF</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
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
                </div>

                <!-- Financial Statistics -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Financial Statistics</h5>
                            <form action="<?php echo URLROOT; ?>/admin/reports/customPeriod" method="POST" class="d-inline">
                                <input type="hidden" name="report_type" value="financial">
                                <input type="hidden" name="start_date" value="<?php echo isset($data['start_date']) ? $data['start_date'] : date('Y-m-01'); ?>">
                                <input type="hidden" name="end_date" value="<?php echo isset($data['end_date']) ? $data['end_date'] : date('Y-m-d'); ?>">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="submit" name="format" value="html" class="btn btn-light btn-sm">Full Report</button>
                                    <button type="submit" name="format" value="csv" class="btn btn-success btn-sm">CSV</button>
                                    <button type="submit" name="format" value="pdf" class="btn btn-danger btn-sm">PDF</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <?php if (empty($data['financial_stats'])) : ?>
                                <p class="text-muted">No financial statistics available for the selected period.</p>
                            <?php else : ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Payments</th>
                                                <th>Total (KES)</th>
                                                <th>Book Sales (KES)</th>
                                                <th>Token Sales (KES)</th>
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
    </div>
</div>

<?php require APPROOT . '/views/inc/admin_footer.php'; ?>