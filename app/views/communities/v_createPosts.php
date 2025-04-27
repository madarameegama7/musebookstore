<?php require APPROOT.'/views/inc/header.php'; ?>
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<link rel="stylesheet" href="<?= URLROOT ?>/css/createPost.css">

<div class="create-post-container">
    <h2 class="create-post-title">Create a New Blog Post</h2>

    <form action="<?= URLROOT ?>/communities/createPost/<?= $data['community_id'] ?>" method="POST" class="create-post-form">
        <div class="form-group">
            <label for="title">Title of the Post</label>
            <input type="text" name="title" id="title" value="<?= $data['title'] ?? '' ?>" required placeholder="Enter a title that best fits your content">
        </div>

        <div class="form-group">
            <label for="content">Post Content</label>
            <textarea name="content" id="content" rows="8" required placeholder="Share your thoughts, ideas, or stories here..."><?= $data['content'] ?? '' ?></textarea>
        </div>

        <input type="submit" value="Publish Post" class="btn-primary">
    </form>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>
