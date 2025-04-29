<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">
<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>
    <main class="admin-main-content">
        <h1>Edit Writing Group</h1>
        <?php flash('admin_msg'); ?>
        <form action="<?php echo URLROOT; ?>/admin/writingGroup/updateWritingGroup/<?php echo $data['writingGroup_id']; ?>" method="post" class="admin-form" style="max-width: 600px;" enctype="multipart/form-data">
            <label>Name:
                <input type="text" name="writingGroup_name" maxlength="255" value="<?php echo htmlspecialchars($data['writingGroup_name']); ?>" required>
            </label>
            <label>Description:
                <textarea name="writingGroup_description" rows="4" required><?php echo htmlspecialchars($data['writingGroup_description']); ?></textarea>
            </label>
            <label>Community:
                <select name="community_id" required>
                    <option value="">-- Select Community --</option>
                    <?php foreach ($data['communities'] as $community): ?>
                        <option value="<?php echo $community->communityId; ?>" <?php echo ($data['community_id'] == $community->communityId) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($community->communityName); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <div class="form-group">
                <label>Current Image:</label>
                <?php if (!empty($data['image_path'])): ?>
                    <div class="current-image">
                        <img src="<?php echo URLROOT . '/' . $data['image_path']; ?>" alt="Group image" style="max-width: 200px; max-height: 150px;">
                        <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($data['image_path']); ?>">
                    </div>
                <?php else: ?>
                    <p>No image currently set</p>
                <?php endif; ?>
            </div>

            <label>Change Image:
                <input type="file" name="group_image" accept="image/*">
                <p class="input-help-text">Leave empty to keep current image</p>
            </label>

            <button type="submit" class="btn btn-update">Update Group</button>
            <a href="<?php echo URLROOT; ?>/admin/writingGroup/manageWritingGroups" class="btn btn-grey">Cancel</a>
        </form>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>