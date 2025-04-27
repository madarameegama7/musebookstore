<?php require APPROOT.'/views/inc/header.php'; ?>
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<?php if (isset($_SESSION['join_success'])): ?>
    <div class="alert-success">
        <?php echo $_SESSION['join_success']; ?>
    </div>
    <?php unset($_SESSION['join_success']); ?>
<?php endif; ?>


<div class="ambassador-main-container">
    <div class="community-profile-card">
        <h1 class="community-page-title">Community Details</h1>

        <div class="community-detail-section">
            <img src="<?php echo URLROOT . '/' . $data['community']->communityImage; ?>" alt="Community Image" class="community-image">

            <div class="community-info-wrapper">
                <h2 class="community-name"><?php echo $data['community']->communityName; ?></h2>

                <div class="community-action-buttons">
                    <a href="<?php echo URLROOT; ?>/communities/viewCommunityWritingGroups/<?php echo $data['community']->communityId; ?>" class="community-btn">Writing Groups</a>
                    <a href="<?php echo URLROOT; ?>/communities/viewEvent/<?php echo $data['community']->communityId; ?>" class="community-btn">Events</a>
                </div>

                <p class="community-info"><strong>Type:</strong> <?php echo $data['community']->membership_type; ?></p>
                <p class="community-info"><strong>Description:</strong> <?php echo $data['community']->communityDescription; ?></p>
            </div>
        </div>

        <div class="community-blog-section">
            <h2 class="community-page-subtitle">Community Articles</h2>
            <?php if (!empty($data['posts'])): ?>
                <div class="community-posts-list">
                    <?php foreach ($data['posts'] as $post): ?>
                        <div class="community-post-card">
                            <h3 class="community-post-title"><?php echo $post->title; ?></h3>
                            <p class="community-post-body"><?php echo substr($post->content, 0, 100); ?>...</p>
                            <a href="<?php echo URLROOT; ?>/communities/viewPosts/<?php echo $post->id; ?>" class="community-btn view-btn">Read More</a>
                            <a href="<?php echo URLROOT; ?>/communities/deletePost/<?php echo $post->id; ?>/<?php echo $data['community']->communityId; ?>" class="community-btn delete-btn">Delete</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-posts-message">No blog posts yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>
