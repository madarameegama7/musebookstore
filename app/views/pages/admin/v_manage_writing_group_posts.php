<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/button.css">
<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>
    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <?php flash('admin_msg'); ?>
        <section style="margin-bottom: 30px;">
            <h2>Add Writing Group Post</h2>
            <form action="<?php echo URLROOT; ?>/admin/addWritingGroupPost" method="post" class="admin-form" style="max-width: 600px;">
                <label>Writing Group ID:
                    <input type="number" name="writingGroup_id" min="1" required>
                </label>
                <label>Community Member ID:
                    <input type="number" name="community_member_id" min="1" required>
                </label>
                <label>Chapter Title:
                    <input type="text" name="chapter_title" maxlength="255" required>
                </label>
                <label>Chapter Content:
                    <textarea name="chapter_content" rows="6" required></textarea>
                </label>
                <button type="submit" class="btn btn-update">Add Post</button>
            </form>
        </section>
        <h2>All Writing Group Posts</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Group ID</th>
                    <th>Member ID</th>
                    <th>Chapter Title</th>
                    <th>Content</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['posts'])): ?>
                    <?php foreach ($data['posts'] as $p): ?>
                        <tr>
                            <td><?php echo $p->writingGroup_post_id; ?></td>
                            <td><?php echo $p->writingGroup_id; ?></td>
                            <td><?php echo $p->community_member_id; ?></td>
                            <td><?php echo htmlspecialchars($p->chapter_title); ?></td>
                            <td><?php echo htmlspecialchars(mb_strimwidth($p->chapter_content, 0, 60, '...')); ?></td>
                            <td><?php echo $p->created_at; ?></td>
                            <td>
                                <a href="<?php echo URLROOT; ?>/admin/editWritingGroupPost/<?php echo $p->writingGroup_post_id; ?>" class="btn btn-edit">Edit</a>
                                <form action="<?php echo URLROOT; ?>/admin/deleteWritingGroupPost/<?php echo $p->writingGroup_post_id; ?>" method="post" style="display:inline;" onsubmit="return confirm('Delete this post?');">
                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No writing group posts found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="<?php echo URLROOT; ?>/admin" class="btn">Back to Dashboard</a>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>