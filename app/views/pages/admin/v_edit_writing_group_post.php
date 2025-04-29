<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">
<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>
    <main class="admin-main-content">
        <h1>Edit Writing Group Post</h1>
        <?php flash('admin_msg'); ?>
        <form action="<?php echo URLROOT; ?>/admin/editWritingGroupPost/<?php echo isset($data['post']->writingGroup_post_id) ? $data['post']->writingGroup_post_id : $data['post']['writingGroup_post_id']; ?>" method="post" class="admin-form" style="max-width: 600px;">
            <label>Chapter Title:
                <input type="text" name="chapter_title" maxlength="255" value="<?php echo htmlspecialchars(isset($data['post']->chapter_title) ? $data['post']->chapter_title : $data['post']['chapter_title']); ?>" required>
            </label>
            <label>Chapter Content:
                <textarea name="chapter_content" rows="10" required><?php echo htmlspecialchars(isset($data['post']->chapter_content) ? $data['post']->chapter_content : $data['post']['chapter_content']); ?></textarea>
            </label>
            <button type="submit" class="btn btn-update">Update Chapter</button>
            <a href="<?php echo URLROOT; ?>/admin/writingGroupPosts" class="btn btn-grey">Cancel</a>
        </form>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>