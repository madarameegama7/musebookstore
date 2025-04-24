<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'parent') {
    die("Access denied! You do not have permission to view this page.");
}
?>
<?php require APPROOT . '/views/inc/components/parent/sidebar.php'; ?>
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
                        <td>
                            <?php if ($transaction->status === 'pending'): ?>
                                <a href="<?= URLROOT . '/books/cancel/' . $transaction->transaction_id ?>" class="btn btn-delete"
                                    onclick="return confirm('Are you sure you want to cancel this request?');">
                                    Cancel Request
                                </a>
                                <?php elseif ($transaction->status === 'declined'): ?>
                                <div
                                    style="padding: 12px; background-color:rgb(236, 188, 194); color: red;text-align:center; border-left: 5px solidrgb(207, 64, 64); border-radius: 8px;">
                                    <strong>Your book request has been declined</strong><br>
                                </div>
                            <?php else: ?>
                                <div
                                    style="padding: 12px; background-color: #f3e8ff; color: #5e3a87;text-align:center; border-left: 5px solid #a855f7; border-radius: 8px;">
                                    <strong>Your book request has been approved!</strong><br>
                                    Kindly meet with the book owner to <strong>swap your books physically</strong>. Happy reading!
                                </div>


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