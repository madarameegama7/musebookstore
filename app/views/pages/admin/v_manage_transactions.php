<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">
<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>
    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <?php flash('admin_msg'); ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Book</th>
                    <th>Requester</th>
                    <th>Owner</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['transactions'])): ?>
                    <?php foreach ($data['transactions'] as $t): ?>
                        <tr>
                            <td><?php echo $t->transaction_id; ?></td>
                            <td><?php echo htmlspecialchars($t->book_title); ?></td>
                            <td><?php echo htmlspecialchars($t->requester_name); ?></td>
                            <td><?php echo htmlspecialchars($t->owner_name); ?></td>
                            <td><?php echo ucfirst($t->type); ?></td>
                            <td><?php echo ucfirst($t->status); ?></td>
                            <td><?php echo $t->created_at; ?></td>
                            <td>
                                <?php if ($t->status === 'pending'): ?>
                                    <form action="<?php echo URLROOT; ?>/admin/approveTransaction/<?php echo $t->transaction_id; ?>" method="post" style="display:inline;">
                                        <button type="submit" class="btn btn-update">Approve</button>
                                    </form>
                                    <form action="<?php echo URLROOT; ?>/admin/declineTransaction/<?php echo $t->transaction_id; ?>" method="post" style="display:inline;">
                                        <button type="submit" class="btn btn-delete">Decline</button>
                                    </form>
                                <?php endif; ?>
                                <form action="<?php echo URLROOT; ?>/admin/deleteTransaction/<?php echo $t->transaction_id; ?>" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No transactions found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>