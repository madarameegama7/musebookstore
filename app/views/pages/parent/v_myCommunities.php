<?php require APPROOT.'/views/inc/header.php'; ?>
<h1>My Communities</h1>
<?php flash('leave_success'); ?>

<?php if (!empty($data['joinedCommunities'])): ?>
    <ul>
        <?php foreach ($data['joinedCommunities'] as $community): ?>
            <li>
                <?= htmlspecialchars($community->communityName) ?>
                <form action="<?= URLROOT ?>/communities/leaveCommunity/<?= $community->communityId ?>" method="post" style="display:inline;">
                    <button type="submit">Leave</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>You haven't joined any communities yet.</p>
<?php endif; ?>
<?php require APPROOT.'/views/inc/footer.php'; ?>
