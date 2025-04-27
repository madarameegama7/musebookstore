<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">
<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>
    <main class="admin-main-content">
        <h1>Edit Token Record</h1>
        <?php flash('admin_msg'); ?>
        <form action="<?php echo URLROOT; ?>/admin/editToken/<?php echo $data['token']->token_id; ?>" method="post" class="admin-form" style="max-width: 500px;">
            <label>User:
                <select name="user_id" required>
                    <option value="">Select User</option>
                    <?php foreach ($data['users'] as $user): ?>
                        <option value="<?php echo $user->user_id; ?>" <?php if ($user->user_id == $data['token']->user_id) echo 'selected'; ?>><?php echo htmlspecialchars($user->user_name); ?> (ID: <?php echo $user->user_id; ?>)</option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Token Count:
                <input type="number" name="token_count" min="0" value="<?php echo $data['token']->token_count; ?>" required>
            </label>
            <label>Amount Paid:
                <input type="number" name="amount_paid" min="0" step="0.01" value="<?php echo $data['token']->amount_paid; ?>" required>
            </label>
            <label>Purchase Date:
                <input type="date" name="purchase_date" value="<?php echo $data['token']->purchase_date; ?>" required>
            </label>
            <button type="submit" class="btn btn-update">Update Token</button>
            <a href="<?php echo URLROOT; ?>/admin/manageTokens" class="btn btn-grey">Cancel</a>
        </form>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>