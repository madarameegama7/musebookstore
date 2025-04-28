<?php require APPROOT.'/views/inc/header.php'; ?>
<h1>My Community Posts</h1>

<?php if (!empty($data['posts'])): ?>
    <ul>
        <?php foreach ($data['posts'] as $post): ?>
            <li>
                <h3><?= htmlspecialchars($post->title) ?></h3>
                <p><?= substr(htmlspecialchars($post->content), 0, 100) ?>...</p>
                <a href="<?= URLROOT ?>/communities/editMyPost/<?= $post->id ?>">Edit</a> |
                <a href="<?= URLROOT ?>/communities/deleteMyPost/<?= $post->id ?>">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>You haven't posted anything yet.</p>
<?php endif; ?>
<?php require APPROOT.'/views/inc/footer.php'; ?>
