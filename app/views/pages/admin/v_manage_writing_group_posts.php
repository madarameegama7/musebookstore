<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">
<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>
    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <?php flash('admin_msg'); ?>
        <section style="margin-bottom: 30px;">
            <h2>Add Writing Group Post</h2>
            <form action="<?php echo URLROOT; ?>/admin/addWritingGroupPost" method="post" class="admin-form">
                <label for="writingGroup_id">Writing Group:</label>
                <select id="writingGroup_id" name="writingGroup_id" required>
                    <option value="">Select a writing group</option>
                    <?php if (isset($data['writingGroups']) && !empty($data['writingGroups'])): ?>
                        <?php foreach ($data['writingGroups'] as $group): ?>
                            <option value="<?php echo $group->writingGroup_id; ?>"><?php echo htmlspecialchars($group->writingGroup_name); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <label for="community_member_id">Community Member:</label>
                <select id="community_member_id" name="community_member_id" required>
                    <option value="">Select a community member</option>
                    <?php if (isset($data['communityMembers']) && !empty($data['communityMembers'])): ?>
                        <?php foreach ($data['communityMembers'] as $member): ?>
                            <option value="<?php echo $member->community_member_id; ?>"><?php echo htmlspecialchars($member->community_member_name); ?> <?php echo $member->communityName ? '(Community: ' . htmlspecialchars($member->communityName) . ')' : ''; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <label for="chapter_title">Chapter Title:</label>
                <input type="text" id="chapter_title" name="chapter_title" maxlength="255" required>

                <label for="chapter_content">Chapter Content:</label>
                <textarea id="chapter_content" name="chapter_content" rows="6" required></textarea>

                <button type="submit" class="btn btn-update">Add Post</button>
            </form>
        </section>
        <h2>All Writing Group Posts</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Writing Group</th>
                    <th>Member</th>
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
                            <td><?php echo htmlspecialchars($p->writingGroup_name ?? 'Unknown Group'); ?></td>
                            <td><?php echo htmlspecialchars($p->community_member_name ?? 'Unknown Member'); ?></td>
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
        <a href="<?php echo URLROOT; ?>/admin" class="btn btn-back">Back to Dashboard</a>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>