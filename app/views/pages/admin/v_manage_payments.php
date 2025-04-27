<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">
<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>
    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <?php flash('admin_msg'); ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Currency</th>
                    <th>Status</th>
                    <th>Order ID</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['payments'])): ?>
                    <?php foreach ($data['payments'] as $p): ?>
                        <tr>
                            <td><?php echo $p->payment_id; ?></td>
                            <td><?php echo htmlspecialchars($p->user_name); ?></td>
                            <td><?php echo $p->amount; ?></td>
                            <td><?php echo htmlspecialchars($p->currency); ?></td>
                            <td><?php echo htmlspecialchars($p->status); ?></td>
                            <td><?php echo htmlspecialchars($p->order_id); ?></td>
                            <td><?php echo $p->created_at; ?></td>
                            <td>
                                <form action="<?php echo URLROOT; ?>/admin/deletePayment/<?php echo $p->payment_id; ?>" method="post" style="display:inline;" onsubmit="return confirm('Delete this payment record?');">
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No payment records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>