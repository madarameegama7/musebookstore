<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">
<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>
    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <div class="report-summary">
            <h2>Total Tokens Purchased: <?php echo $data['totalTokens']; ?></h2>
            <h3>Tokens Purchased by Month (<?php echo date('Y'); ?>)</h3>
            <ul>
                <?php foreach ($data['tokensByMonth'] as $month => $count): ?>
                    <li><?php echo date('F', mktime(0, 0, 0, $month, 1)); ?>: <?php echo $count ? $count : 0; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="table-responsive">
            <h3>All Token Purchases</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Token ID</th>
                        <th>User</th>
                        <th>Token Count</th>
                        <th>Amount Paid</th>
                        <th>Purchase Date</th>
                        <th>Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['tokens'] as $token): ?>
                        <tr>
                            <td><?php echo $token->token_id; ?></td>
                            <td><?php echo htmlspecialchars($token->user_name); ?></td>
                            <td><?php echo $token->token_count; ?></td>
                            <td><?php echo number_format($token->amount_paid, 2); ?></td>
                            <td><?php echo $token->purchase_date; ?></td>
                            <td><?php echo $token->updated_at; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>