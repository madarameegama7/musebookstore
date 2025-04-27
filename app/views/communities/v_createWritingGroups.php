<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ambassador') {
    die("Access denied! You do not have permission to view this page.");
}
?>

<div class="create-writing-group-page">
    <div class="create-writing-group-container">
        <h1 class="create-writing-group-title">Create Writing Group</h1>

        <?php if (!empty($data['error'])): ?>
            <div class="create-writing-group-alert error"><?php echo $data['error']; ?></div>
        <?php endif; ?>

        <?php if (!empty($data['success'])): ?>
            <div class="create-writing-group-alert success"><?php echo $data['success']; ?></div>
        <?php endif; ?>

        <form action="<?php echo isset($data['community_id']) ? URLROOT . '/communities/createWritingGroups/' . $data['community_id'] : '#'; ?>" method="POST" enctype="multipart/form-data" class="create-writing-group-form">


            <div class="create-writing-group-field">
                <label for="writingGroup_name">Group Name</label>
                <input type="text" name="writingGroup_name" value="<?php echo $data['writingGroup_name'] ?? ''; ?>" required>
            </div>

            <div class="create-writing-group-field">
                <label for="writingGroup_description">Group Description</label>
                <textarea name="writingGroup_description" rows="4"><?php echo $data['writingGroup_description'] ?? ''; ?></textarea>
            </div>

            <div class="create-writing-group-field">
            <label for="image">Group Image</label>
             <input type="file" name="image" accept="image/*">
             </div>


            <div class="create-writing-group-actions">
                <input type="submit" value="Create Group" class="btn-submit">
                <a href="<?php echo isset($data['community_id']) ? URLROOT . '/communities/viewWritingGroups/' . $data['community_id'] : '#'; ?>" class="btn-back">Back to Writing Groups</a>
            </div>
        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
