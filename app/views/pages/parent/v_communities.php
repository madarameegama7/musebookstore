<?php require APPROOT.'/views/inc/header.php';?>
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>



<div class="my-communities-main">
    <div class="my-communities-container">
        <h1 class="my-communities-title">Communities</h1>

        <?php if (!empty($data['error']) && $data['error'] == 'nocommunityid'): ?>
            <p class="my-communities-error">No community ID provided. Please select a community to view details.</p>
        <?php endif; ?>

        <div class="my-communities-grid">
            <?php if (!empty($data['communities'])): ?>
                <?php foreach ($data['communities'] as $community): ?>
                    <div class="my-community-card">
                        <a href="<?php echo $community->status === 'approved' ? URLROOT . '/communities/viewCommunitydetails/' . $community->communityId : '#'; ?>"
                           <?php echo $community->status !== 'approved' ? 'onclick="return false;" style="pointer-events: none; opacity: 0.5;"' : ''; ?>>
                            <img src="<?php echo URLROOT . '/' . $community->communityImage; ?>" alt="Community Image" class="my-community-image">
                        </a>
                        <h2 class="my-community-name"><?php echo $community->communityName; ?></h2>
                        <p class="my-community-type"><?php echo $community->membership_type; ?></p>

                        <?php if ($community->status === 'pending'): ?>
                            <p class="my-community-pending-status">Pending Approval</p>
                        <?php else: ?>
                            <div class="my-community-action-btns">
                                <a href="<?php echo URLROOT; ?>/communities/viewCommunitydetails/<?php echo $community->communityId; ?>" class="my-community-edit-btn">View Details</a>
                                <a href="<?php echo URLROOT; ?>/communities/joinCommunity/<?php echo $community->communityId; ?>" class="my-community-delete-btn">Join Community</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="my-communities-empty">No communities found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php require APPROOT.'/views/inc/footer.php';?>
