<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">
<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>
    <main class="admin-main-content">
        <h1>Edit Writing Group</h1>
        <?php flash('admin_msg'); ?>
        <form action="<?php echo URLROOT; ?>/admin/writingGroup/updateWritingGroup/<?php echo $data['writingGroup_id']; ?>" method="post" class="admin-form" style="max-width: 600px;">
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
                            <?php echo htmlspecialchars($community->communityName); ?> (ID: <?php echo $community->communityId; ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Image Path (optional):
                <input type="text" name="image_path" value="<?php echo htmlspecialchars($data['image_path'] ?? ''); ?>" placeholder="e.g., public/img/community/group.jpg">
            </label>
            <button type="submit" class="btn btn-update">Update Group</button>
            <a href="<?php echo URLROOT; ?>/admin/writingGroup/manageWritingGroups" class="btn btn-grey">Cancel</a>
        </form>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>