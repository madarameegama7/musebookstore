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
                    <a href="<?php echo URLROOT; ?>/communities/viewCommunityEvents/<?php echo $data['community']->communityId; ?>" class="community-btn">Events</a>
                </div>

                <p class="community-info"><strong>Type:</strong> <?php echo $data['community']->membership_type; ?></p>
                <p class="community-info"><strong>Description:</strong> <?php echo $data['community']->communityDescription; ?></p>
            </div>
        </div>

        <!-- Community Posts Section -->
        <div class="community-posts-section">
            <h3 class="community-posts-title">Community Articles</h3>
            
            <?php if (!empty($data['posts'])): ?>
                <div class="community-posts-wrapper">
                    <?php foreach ($data['posts'] as $post): ?>
                        <div class="community-post-card">
                            <h4 class="post-title"><?php echo $post->title; ?></h4>
                            <p class="post-summary"><?php echo substr($post->content, 0, 100) . '...'; ?></p>
                            <a href="<?php echo URLROOT . '/communities/viewSingleCommunityPost/' . $post->id; ?>" class="read-more-btn">Read More</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No community articles found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>
