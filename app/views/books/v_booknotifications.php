<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'parent') {
    die("Access denied! You do not have permission to view this page.");
}
?>
<?php require APPROOT.'/views/inc/components/parent/sidebar.php';?>
<div class="container-notifications">
    <h1>Your Notifications</h1>

    <?php if (!empty($data['notifications'])): ?>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Message</th>
                    <th>Transaction ID</th>
                    <th>Actions</th> <!-- Add a new column for actions -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['notifications'] as $notification): ?>
                    <tr>
                        <td><?= htmlspecialchars($notification->message) ?></td>
                        <td><?= htmlspecialchars($notification->transaction_id) ?></td>
                        <td> <!-- Add action buttons here -->
                            <!-- Accept button -->
                            <a href="<?= URLROOT . '/notifications/accept/' . $notification->transaction_id ?>" class="btn btn-accept">Accept</a>

                            <!-- View button -->
                            <a href="<?= URLROOT . '/notifications/view/' . $notification->transaction_id ?>" class="btn btn-view">View</a>

                            <!-- Delete button -->
                            <a href="<?= URLROOT . '/notifications/delete/' . $notification->transaction_id ?>" class="btn btn-delete">Delete</a>
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
