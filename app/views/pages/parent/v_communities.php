<?php require APPROOT.'/views/inc/header.php';?>
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>



<div class="communities-main">
    <div class="communities-container">
        <h1 class="communities-title">Communities</h1>

        <?php if (!empty($data['error']) && $data['error'] == 'nocommunityid'): ?>
            <p class="communities-error">No community ID provided. Please select a community to view details.</p>
        <?php endif; ?>

        <div class="communities-grid">
            <?php if (!empty($data['communities'])): ?>
                <?php foreach ($data['communities'] as $community): ?>
    <div class="community-card">
        <a href="<?php echo $community->status === 'approved' ? URLROOT . '/communities/viewCommunitydetails/' . $community->communityId : '#'; ?>"
           <?php echo $community->status !== 'approved' ? 'onclick="return false;" style="pointer-events: none; opacity: 0.5;"' : ''; ?>>
            <img src="<?php echo URLROOT . '/' . $community->communityImage; ?>" alt="Community Image" class="community-image">
        </a>
        <h2 class="community-name"><?php echo $community->communityName; ?></h2>
        <p class="community-type"><?php echo $community->membership_type; ?></p>

        <?php if ($community->status === 'pending'): ?>
            <p class="community-pending-status">Pending Approval</p>
        <?php else: ?>
            <div class="community-action-btns">
                <a href="<?php echo URLROOT; ?>/communities/viewCommunitydetails/<?php echo $community->communityId; ?>" class="community-edit-btn">View Details</a>
                <a href="<?php echo URLROOT; ?>/communities/joinCommunity/<?php echo $community->communityId; ?>" class="community-delete-btn">Join Community</a>

            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

            <?php else: ?>
                <p class="communities-empty">No communities found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require APPROOT.'/views/inc/footer.php';?>
