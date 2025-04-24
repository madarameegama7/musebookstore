<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'parent') {
    die("Access denied! You do not have permission to view this page.");
}
?>
<?php require APPROOT . '/views/inc/components/parent/sidebar.php'; ?>
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
                        <td>
                            <?php if ($notification->status === 'pending'): ?>
                                <!-- Show Accept and Decline buttons only for pending requests -->
                                <?php if ($notification->requester_id == $_SESSION['user_id']): ?>
                                    <!-- Show buttons only for the requester -->
                                    <form action="<?= URLROOT . '/books/accept/' . $notification->book_id . '/' . $notification->transaction_id ?>" method="post" onsubmit="return confirm('Your token will be reduced by one from both the requester and owner. Do you want to continue?');">
                                        <button type="submit" class="btn btn-accept">Accept</button>
                                    </form>
                                    <br><br>
                                    <a href="<?= URLROOT . '/books/delete/' . $notification->transaction_id ?>" class="btn btn-delete">Decline</a>
                                <?php endif; ?>

                                <?php if ($notification->owner_id == $_SESSION['user_id']): ?>
                                    <!-- Show Accept button for book owner -->
                                    <form action="<?= URLROOT . '/books/accept/' . $notification->book_id . '/' . $notification->transaction_id ?>" method="post" onsubmit="return confirm('Your token will be reduced by one from both the requester and owner. Do you want to continue?');">
                                        <button type="submit" class="btn btn-accept">Accept</button>
                                    </form>
                                    <br><br>
                                    <a href="<?= URLROOT . '/books/delete/' . $notification->transaction_id ?>" class="btn btn-delete">Decline</a>
                                <?php endif; ?>
                            <?php elseif ($notification->status === 'approved'): ?>
                                <!-- Show message when approved -->
                                <span class="btn btn-status approved">Approved</span>
                                <p class="notification-message">💜 Your book request has been approved! Kindly meet with the book owner to <strong>swap your books physically</strong>. 📚</p>
                            <?php elseif ($notification->status === 'declined'): ?>
                                <!-- Show message when declined -->
                                <span class="btn btn-status declined">Declined</span>
                            <?php endif; ?>
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
