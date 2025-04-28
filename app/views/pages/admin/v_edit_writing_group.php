<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">
<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>
    <main class="admin-main-content">
        <h1>Edit Writing Group</h1>
        <?php flash('admin_msg'); ?>
        <form action="<?php echo URLROOT; ?>/admin/writinggroup/editWritingGroup/<?php echo $data['group']->writingGroup_id; ?>" method="post" class="admin-form" style="max-width: 600px;">
            <label>Name:
                <input type="text" name="writingGroup_name" maxlength="255" value="<?php echo htmlspecialchars($data['group']->writingGroup_name); ?>" required>
            </label>
            <label>Description:
                <textarea name="writingGroup_description" rows="4" required><?php echo htmlspecialchars($data['group']->writingGroup_description); ?></textarea>
            </label>
            <label>Community ID:
                <input type="number" name="community_id" min="1" value="<?php echo $data['group']->community_id; ?>" required>
            </label>
            <label>Image Path (optional):
                <input type="text" name="image_path" value="<?php echo htmlspecialchars($data['group']->image_path ?? ''); ?>" placeholder="e.g., public/img/community/group.jpg">
            </label>
            <button type="submit" class="btn btn-update">Update Group</button>
            <a href="<?php echo URLROOT; ?>/admin/writinggroup/writingGroups" class="btn btn-grey">Cancel</a>
        </form>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>