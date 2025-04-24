<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="create-post-container">
    <h2 class="create-post-title">Create Chapter</h2>

    <?php if (!empty($data['error'])): ?>
        <div class="alert alert-danger"><?= $data['error']; ?></div>
    <?php endif; ?>

    <form action="<?= URLROOT ?>/communities/createWritingGroupPost/<?= $data['writingGroup_id'] ?>" method="POST" class="create-post-form">
        <div class="form-group">
            <label for="chapter_title">Chapter Title</label>
            <input type="text" name="chapter_title" id="chapter_title" value="<?= $data['chapter_title'] ?? '' ?>" required>
        </div>

        <div class="form-group">
            <label for="chapter_content">Chapter Content</label>
            <textarea name="chapter_content" id="chapter_content" rows="8" required><?= $data['chapter_content'] ?? '' ?></textarea>
        </div>

        <input type="submit" value="Create Chapter" class="btn btn-primary">
    </form>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
