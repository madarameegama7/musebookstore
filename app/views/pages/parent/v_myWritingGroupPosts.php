<?php require APPROOT.'/views/inc/header.php'; ?>
<h1>My Chapters</h1>

<?php if (!empty($data['writing_group_posts'])): ?>
    <div class="chapters-container">
        <?php foreach ($data['writing_group_posts'] as $writing_group_posts): ?>
            <div class="chapter-block">
                <h3><?= htmlspecialchars($writing_group_posts->chapter_title) ?></h3>
                <p><?= substr(htmlspecialchars($writing_group_posts->chapter_content), 0, 100) ?>...</p>
                <a href="<?= URLROOT ?>/communities/readChapter/<?= $writing_group_posts->writingGroup_id ?>">Read More</a> |
                <a href="<?= URLROOT ?>/communities/editChapter/<?= $writing_group_posts->writingGroup_id ?>">Edit</a> |
                <a href="<?= URLROOT ?>/communities/deleteChapter/<?= $writing_group_posts->writingGroup_id ?>">Delete</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>You haven't posted any chapters yet.</p>
<?php endif; ?>
<?php require APPROOT.'/views/inc/footer.php'; ?>
