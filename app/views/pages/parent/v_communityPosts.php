<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>


<div class="view-community-posts-container">
    <?php if (!empty($data['community'])): ?>
        <h2 class="view-community-title">Posts from the "<strong><?= htmlspecialchars($data['community']->communityName) ?></strong>" Community</h2>
        <a href="<?php echo URLROOT; ?>/communities/createCommunityPost/<?php echo $data['community']->communityId; ?>" class="community-btn create-blog-btn">Create New Post</a>

        <?php foreach ($data['posts'] as $post): ?>
            <div class="community-post-card">
                <h3 class="community-post-title"><?= htmlspecialchars($post->title) ?></h3>
                <p class="community-post-snippet"><?= htmlspecialchars(substr($post->content, 0, 100)) ?>...</p>
                <a href="<?= URLROOT ?>/communities/viewCommunitySinglePost/<?= $post->id ?>" class="community-read-more-btn">Read More</a>
                <hr class="community-post-divider">
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-posts-message">We’re sorry, but there are currently no posts available in this community.</p>
    <?php endif; ?>

    <a href="<?= URLROOT ?>/communities" class="community-back-btn">← Back to All Communities</a>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
