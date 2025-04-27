<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">
<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>
    <main class="admin-main-content">
        <h1>Edit Community Post</h1>
        <?php flash('admin_msg'); ?>
        <form action="<?php echo URLROOT; ?>/admin/editCommunityPost/<?php echo $data['post']->id; ?>" method="post" class="admin-form" style="max-width: 600px;">
            <label>Title:
                <input type="text" name="title" maxlength="255" value="<?php echo htmlspecialchars($data['post']->title); ?>" required>
            </label>
            <label>Content:
                <textarea name="content" rows="4" required><?php echo htmlspecialchars($data['post']->content); ?></textarea>
            </label>
            <button type="submit" class="btn btn-update">Update Post</button>
            <a href="<?php echo URLROOT; ?>/admin/manageCommunityPosts" class="btn btn-grey">Cancel</a>
        </form>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>