<?php require APPROOT.'/views/inc/header.php'; ?>
<h1>My Events</h1>
<?php flash('leave_success'); ?>

<?php if (!empty($data['joinedEvents'])): ?>
    <ul>
        <?php foreach ($data['joinedEvents'] as $event): ?>
            <li>
                <?= htmlspecialchars($event->event_name) ?> - <?= htmlspecialchars($event->event_date) ?>
                <form action="<?= URLROOT ?>/communities/leaveEvent/<?= $event->event_id ?>" method="post" style="display:inline;">
                    <button type="submit">Leave</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>You haven't joined any events yet.</p>
<?php endif; ?>
<?php require APPROOT.'/views/inc/footer.php'; ?>
