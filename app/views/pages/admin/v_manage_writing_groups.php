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
            <h2>Add Writing Group</h2>
            <form action="<?php echo URLROOT; ?>/admin/addWritingGroup" method="post" class="admin-form">
                <label for="writingGroup_name">Name:</label>
                <input type="text" id="writingGroup_name" name="writingGroup_name" maxlength="255" required>
                <label for="writingGroup_description">Description:</label>
                <textarea id="writingGroup_description" name="writingGroup_description" rows="4" required></textarea>
                <label for="community_id">Community ID:</label>
                <input type="number" id="community_id" name="community_id" min="1" required>
                <label for="image_path">Image Path (optional):</label>
                <input type="text" id="image_path" name="image_path" placeholder="e.g., public/img/community/group.jpg">
                <button type="submit" class="btn btn-update">Add Group</button>
            </form>
        </section>
        <h2>All Writing Groups</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Community ID</th>
                    <th>Image Path</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['groups'])): ?>
                    <?php foreach ($data['groups'] as $g): ?>
                        <tr>
                            <td><?php echo $g->writingGroup_id; ?></td>
                            <td><?php echo htmlspecialchars($g->writingGroup_name); ?></td>
                            <td><?php echo htmlspecialchars(mb_strimwidth($g->writingGroup_description, 0, 60, '...')); ?></td>
                            <td><?php echo $g->community_id; ?></td>
                            <td><?php echo htmlspecialchars($g->image_path ?? 'N/A'); ?></td>
                            <td>
                                <a href="<?php echo URLROOT; ?>/admin/editWritingGroup/<?php echo $g->writingGroup_id; ?>" class="btn btn-edit">Edit</a>
                                <form action="<?php echo URLROOT; ?>/admin/deleteWritingGroup/<?php echo $g->writingGroup_id; ?>" method="post" style="display:inline;" onsubmit="return confirm('Delete this writing group?');">
                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No writing groups found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="<?php echo URLROOT; ?>/admin" class="btn btn-back">Back to Dashboard</a>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>