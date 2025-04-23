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
                   <th>Transaction ID</th>
                    <th>Requester Name</th>
                    <th>Available Books</th>
                    <th>Requested Date</th>
                    <th>City</th>
                    <th>Contact Number</th>
                    <th>Actions</th>
                     

                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['notifications'] as $notification): ?>
                    <tr>
                    <td><?= htmlspecialchars($notification->transaction_id) ?></td>
                        <td><?= htmlspecialchars($notification->sender_name) ?></td>
                        <td><?= nl2br(htmlspecialchars($notification->available_books)) ?></td>
                        <td><?= (new DateTime($notification->requested_date))->format('F j, Y \a\t g:i A') ?></td>
                        <td><?= htmlspecialchars($notification->city) ?></td>
                        <td><?= htmlspecialchars($notification->contact_number) ?></td>
                        <td> <!-- Add action buttons here -->
                            <!-- Accept button -->
                            <a href="<?= URLROOT . '/books/acceptswaprequest/' . $notification->book_id . '/'.$notification->transaction_id ?>" class="btn btn-accept">Accept</a>
                            <br><br>

                            <!-- Delete button -->
                            <a href="<?= URLROOT . '/books/delete/' . $notification->transaction_id ?>" class="btn btn-delete">Delete</a>
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
