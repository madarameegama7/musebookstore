<?php require APPROOT . '/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<?php
if (!isset($_SESSION['user_role'])) {
    die("Please login");
}
?>

<div class="main-content">
    <div class="profile-container">
        <h1>Create a New Community</h1>

        <?php if (!empty($data['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($data['error']); ?></p>
        <?php endif; ?>

        <?php if (!empty($data['success'])): ?>
            <p class="success"><?php echo htmlspecialchars($data['success']); ?></p>
        <?php endif; ?>

        <form method="POST" action="<?php echo URLROOT; ?>/communities/create" enctype="multipart/form-data" class="community-form">
            <label for="community_name">Community Name:</label>
            <input type="text" id="community_name" name="community_name" value="<?php echo $data['community_name'] ?? ''; ?>" placeholder="Enter community name" required>

            <label for="community_type">Community Type:</label>
            <input type="text" id="community_type" name="community_type" value="<?php echo $data['community_type'] ?? ''; ?>" placeholder="Enter community type" required>

            <label for="community_description">Description:</label>
            <textarea id="community_description" name="community_description" placeholder="Enter community description" required><?php echo $data['community_description'] ?? ''; ?></textarea>

            <label for="community_image">Upload Community Image:</label>
            <input type="file" id="community_image" name="community_image" accept=".jpg, .jpeg, .png, .gif" required>

            <button type="submit" class="submit-btn">Create Community</button>
        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
