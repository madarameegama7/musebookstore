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
            <form action="<?php echo URLROOT; ?>/admin/writinggroup/addWritingGroup" method="post" class="admin-form" enctype="multipart/form-data">
                <label for="writingGroup_name">Name:</label>
                <input type="text" id="writingGroup_name" name="writingGroup_name" maxlength="255" required>
                <label for="writingGroup_description">Description:</label>
                <textarea id="writingGroup_description" name="writingGroup_description" rows="4" required></textarea>
                <label for="community_id">Community:</label>
                <select id="community_id" name="community_id" required>
                    <option value="">Select a community</option>
                    <?php if (isset($data['communities']) && !empty($data['communities'])): ?>
                        <?php foreach ($data['communities'] as $community): ?>
                            <option value="<?php echo $community->communityId; ?>"><?php echo htmlspecialchars($community->communityName); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <label for="group_image">Group Image:</label>
                <input type="file" id="group_image" name="group_image" accept="image/*">
                <p class="input-help-text">Recommended image size: 800x600 pixels, max 2MB</p>
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
                    <th>Community</th>
                    <th>Image</th>
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
                            <td><?php echo htmlspecialchars($g->communityName ?? 'Unknown'); ?></td>
                            <td>
                                <?php if (!empty($g->image_path)): ?>
                                    <img src="<?php echo URLROOT . '/' . $g->image_path; ?>" alt="Group image" style="width: 60px; height: 60px; object-fit: cover;">
                                <?php else: ?>
                                    <span>No image</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo URLROOT; ?>/admin/writinggroup/editWritingGroup/<?php echo $g->writingGroup_id; ?>" class="btn btn-edit">Edit</a>
                                <form action="<?php echo URLROOT; ?>/admin/writinggroup/deleteWritingGroup/<?php echo $g->writingGroup_id; ?>" method="post" style="display:inline;" onsubmit="return confirm('Delete this writing group?');">
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