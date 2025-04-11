<?php require APPROOT.'/views/inc/header.php';?>
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>

<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ambassador') {
    die("Access denied! You do not have permission to view this page.");
}
?>


<div class="main-content">
    <div class="profile-container">
        <h1><center>Communities</center></h1>

        <!-- Display error message if any -->
        <?php if (!empty($data['error']) && $data['error'] == 'nocommunityid'): ?>
            <p class="error">No community ID provided. Please select a community to view details.</p>
        <?php endif; ?>

        <a href="<?php echo URLROOT; ?>/communities/create" class="create-community-btn">Create Community</a>

        <!-- Communities Blocks -->
        <div class="communities-grid">
    <?php if (!empty($data['communities'])): ?>
        <?php foreach ($data['communities'] as $community): ?>
            <div class="community-block">
                <img src="<?php echo URLROOT; ?>/<?php echo $community->communityImage; ?>" alt="Community Image">
                <h2><?php echo $community->communityName; ?></h2>
                <p class="community-type"><?php echo $community->membership_type; ?></p>
                <a href="<?php echo URLROOT; ?>/communities/details/<?php echo $community->communityId; ?>" class="view-details-btn">View Details</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No communities found.</p>
    <?php endif; ?>
</div>

    </div>
</div>

<?php require APPROOT.'/views/inc/footer.php';?>
