<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>


<div class="single-post-container">
    <?php if (!empty($data['post'])): ?>
        <h2 class="post-title"><?= htmlspecialchars($data['post']->title) ?></h2>
        <p class="post-content"><?= nl2br(htmlspecialchars($data['post']->content)) ?></p>

        <div class="post-actions">
            <a href="<?= URLROOT ?>/communities/viewPosts/<?= $data['post']->community_id ?>" class="btn-secondary">← Back to Community</a>
        </div>
    <?php else: ?>
        <p class="not-found-message">We’re sorry, but the post you’re looking for could not be found.</p>
        <a href="<?= URLROOT ?>/communities" class="btn-secondary">← Back to Communities</a>
    <?php endif; ?>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
