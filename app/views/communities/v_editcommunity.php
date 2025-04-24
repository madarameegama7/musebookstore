<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="edit-community-wrapper">
    <div class="edit-community-container">
        <h1 class="edit-community-title">Edit Community</h1>

        <?php if (!empty($data['error'])): ?>
            <p class="edit-community-error"><?php echo htmlspecialchars($data['error']); ?></p>
        <?php endif; ?>

        <form method="POST" action="<?php echo URLROOT; ?>/communities/update/<?php echo $data['community']->communityId; ?>" enctype="multipart/form-data" class="edit-community-form">
            <label for="community_name" class="edit-label">Community Name:</label>
            <input type="text" id="community_name" name="community_name" class="edit-input" value="<?php echo htmlspecialchars($data['community']->communityName); ?>" required>

            <label for="community_type" class="edit-label">Membership Type:</label>
            <input type="text" id="community_type" name="community_type" class="edit-input" value="<?php echo htmlspecialchars($data['community']->membership_type); ?>" required>

            <label for="community_description" class="edit-label">Description:</label>
            <textarea id="community_description" name="community_description" class="edit-textarea" required><?php echo htmlspecialchars($data['community']->communityDescription); ?></textarea>

            <label class="edit-label">Current Image:</label>
            <img src="<?php echo URLROOT . '/' . $data['community']->communityImage; ?>" alt="Community Image" class="edit-image-preview">

            <label for="community_image" class="edit-label">Change Image (optional):</label>
            <input type="file" id="community_image" name="community_image" class="edit-file-input" accept="image/*">

            <button type="submit" class="edit-submit-btn">Update Community</button>
        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
