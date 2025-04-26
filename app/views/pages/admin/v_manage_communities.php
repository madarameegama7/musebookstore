<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <p>Manage all communities. Approve, reject, or delete as needed.</p>
        <?php flash('admin_msg'); ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Membership Type</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['communities'])): ?>
                    <?php foreach ($data['communities'] as $community): ?>
                        <tr>
                            <td><?php echo $community->communityId; ?></td>
                            <td><?php echo htmlspecialchars($community->communityName ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($community->communityDescription ?? ''); ?></td>
                            <td><?php echo ucfirst($community->status); ?></td>
                            <td><?php echo htmlspecialchars($community->membership_type ?? ''); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($community->created_at)); ?></td>
                            <td>
                                <?php if ($community->status === 'pending'): ?>
                                    <form action="<?php echo URLROOT; ?>/admin/approveCommunity/<?php echo $community->communityId; ?>" method="post" style="display:inline;">
                                        <button type="submit" class="btn-update">Approve</button>
                                    </form>
                                    <form action="<?php echo URLROOT; ?>/admin/rejectCommunity/<?php echo $community->communityId; ?>" method="post" style="display:inline;">
                                        <button type="submit" class="btn-delete">Reject</button>
                                    </form>
                                <?php endif; ?>
                                <form action="<?php echo URLROOT; ?>/admin/deleteCommunity/<?php echo $community->communityId; ?>" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this community?');">
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No communities found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>