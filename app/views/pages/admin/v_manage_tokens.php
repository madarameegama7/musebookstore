<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/button.css">
<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>
    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <?php flash('admin_msg'); ?>
        <section style="margin-bottom: 30px;">
            <h2>Add Token Record</h2>
            <form action="<?php echo URLROOT; ?>/admin/addToken" method="post" class="admin-form" style="max-width: 500px;">
                <label>User:
                    <select name="user_id" required>
                        <option value="">Select User</option>
                        <?php foreach ($data['users'] as $user): ?>
                            <option value="<?php echo $user->user_id; ?>"><?php echo htmlspecialchars($user->user_name); ?> (ID: <?php echo $user->user_id; ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>Token Count:
                    <input type="number" name="token_count" min="0" required>
                </label>
                <label>Amount Paid:
                    <input type="number" name="amount_paid" min="0" step="0.01" required>
                </label>
                <label>Purchase Date:
                    <input type="date" name="purchase_date" required>
                </label>
                <button type="submit" class="btn btn-update">Add Token</button>
            </form>
        </section>
        <h2>All Token Records</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Token Count</th>
                    <th>Amount Paid</th>
                    <th>Purchase Date</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['tokens'])): ?>
                    <?php foreach ($data['tokens'] as $t): ?>
                        <tr>
                            <td><?php echo $t->token_id; ?></td>
                            <td><?php echo htmlspecialchars($t->user_name); ?></td>
                            <td><?php echo $t->token_count; ?></td>
                            <td><?php echo $t->amount_paid; ?></td>
                            <td><?php echo $t->purchase_date; ?></td>
                            <td><?php echo $t->updated_at; ?></td>
                            <td>
                                <a href="<?php echo URLROOT; ?>/admin/editToken/<?php echo $t->token_id; ?>" class="btn btn-edit">Edit</a>
                                <form action="<?php echo URLROOT; ?>/admin/deleteToken/<?php echo $t->token_id; ?>" method="post" style="display:inline;" onsubmit="return confirm('Delete this token record?');">
                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No token records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="<?php echo URLROOT; ?>/admin" class="btn">Back to Dashboard</a>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>