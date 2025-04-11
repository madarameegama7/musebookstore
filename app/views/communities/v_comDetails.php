<?php require APPROOT.'/views/inc/header.php';?>
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>

<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ambassador') {
    die("Access denied! You do not have permission to view this page.");
}
?>

<div class="main-content">
    <div class="profile-container">
        <h1><center>Community Details</center></h1>

        <div class="community-details">
            <img src="<?php echo URLROOT . '/' . $data['community']->communityImage; ?>" alt="Community Image" style="width: 200px;">
            <h2><?php echo $data['community']->communityName; ?></h2>
            <p><strong>Type:</strong> <?php echo $data['community']->membership_type; ?></p>
            <p><strong>Description:</strong> <?php echo $data['community']->communityDescription; ?></p>
            <a href="<?php echo URLROOT; ?>/communities" class="view-details-btn">Back to Communities</a>
            <a href="<?php echo URLROOT; ?>/communities/addMembers" class="view-details-btn">Add Members</a>
        </div>
    </div>
</div>
 
<?php require APPROOT.'/views/inc/footer.php';?>
