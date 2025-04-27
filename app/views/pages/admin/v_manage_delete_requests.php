<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">
<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>
    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <?php flash('admin_msg'); ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Community</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Requested At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['requests'])): ?>
                    <?php foreach ($data['requests'] as $r): ?>
                        <tr>
                            <td><?php echo $r->request_id; ?></td>
                            <td><?php echo $r->communityName !== null ? htmlspecialchars($r->communityName) : 'N/A'; ?></td>
                            <td><?php echo htmlspecialchars($r->reason); ?></td>
                            <td>
                                <span class="status-badge <?php echo $r->request_status; ?>">
                                    <?php echo ucfirst($r->request_status); ?>
                                </span>
                            </td>
                            <td><?php echo $r->created_at; ?></td>
                            <td>
                                <?php if ($r->request_status === 'pending'): ?>
                                    <form action="<?php echo URLROOT; ?>/admin/approveDeleteRequest/<?php echo $r->request_id; ?>" method="post" style="display:inline;">
                                        <button type="submit" class="btn-update">Approve</button>
                                    </form>
                                    <form action="<?php echo URLROOT; ?>/admin/rejectDeleteRequest/<?php echo $r->request_id; ?>" method="post" style="display:inline;">
                                        <button type="submit" class="btn-delete">Reject</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="no-results">No delete requests found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="action-buttons" style="margin-top: 20px;">
            <a href="<?php echo URLROOT; ?>/admin" class="btn-back">Back to Dashboard</a>
        </div>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>