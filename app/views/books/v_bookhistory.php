<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'parent') {
    die("Access denied! You do not have permission to view this page.");
}
?>
<?php require APPROOT.'/views/inc/components/parent/sidebar.php';?>
<div class="container-notifications">
    <h1>Book History</h1>

    <?php if (!empty($data['transactions'])): ?>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['transactions'] as $transaction): ?>
                    <tr>
                        <td><?= htmlspecialchars($transaction->book_title) ?></td>
                        <td><?= htmlspecialchars($transaction->type) ?></td>
                        <td><?= htmlspecialchars($transaction->status) ?></td>
                        <td> <!-- Add action buttons here -->
                            <!-- Delete button -->
                            <a href="#" class="btn btn-delete">Cancel Request</a>
                        </td>
            
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No unread notifications.</p>
    <?php endif; ?>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
