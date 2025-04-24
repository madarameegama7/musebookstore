<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<?php
if (!isset($_SESSION['user_role'])) {
    die("Please login");
}
?>

<div class="create-community-main">
    <div class="create-community-card">
        <h1 class="create-community-title">Create a New Community</h1>

        <?php if (!empty($data['error'])): ?>
            <p class="create-community-error"><?php echo htmlspecialchars($data['error']); ?></p>
        <?php endif; ?>

        <?php if (!empty($data['success'])): ?>
            <p class="create-community-success"><?php echo htmlspecialchars($data['success']); ?></p>
        <?php endif; ?>

        <form method="POST" action="<?php echo URLROOT; ?>/communities/create" enctype="multipart/form-data" class="create-community-form">
            <label for="community_name" class="form-label">Community Name:</label>
            <input type="text" id="community_name" name="community_name" class="form-input" value="<?php echo $data['community_name'] ?? ''; ?>" placeholder="Enter community name" required>

            <label for="community_type" class="form-label">Community Type:</label>
            <input type="text" id="community_type" name="community_type" class="form-input" value="<?php echo $data['community_type'] ?? ''; ?>" placeholder="Enter community type" required>

            <label for="community_description" class="form-label">Description:</label>
            <textarea id="community_description" name="community_description" class="form-textarea" placeholder="Enter community description" required><?php echo $data['community_description'] ?? ''; ?></textarea>

            <label for="community_image" class="form-label">Upload Community Image:</label>
            <input type="file" id="community_image" name="community_image" class="form-file" accept=".jpg, .jpeg, .png, .gif" required>

            <button type="submit" class="form-submit-btn">Create Community</button>
        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
