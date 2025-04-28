<?php require APPROOT.'/views/inc/header.php'; ?>
<h1>My Writing Groups</h1>
<?php flash('leave_success'); ?>

<?php if (!empty($data['joinedWritingGroups'])): ?>
    <ul>
        <?php foreach ($data['joinedWritingGroups'] as $group): ?>
            <li>
                <?= htmlspecialchars($group->writingGroup_name) ?>
                <form action="<?= URLROOT ?>/communities/leaveWritingGroup/<?= $group->writingGroup_id ?>" method="post" style="display:inline;">
                    <button type="submit">Leave</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>You haven't joined any writing groups yet.</p>
<?php endif; ?>
<?php require APPROOT.'/views/inc/footer.php'; ?>
