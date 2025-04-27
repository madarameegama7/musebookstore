<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <a href="<?php echo URLROOT; ?>/admin/addCommunity" class="btn btn-update" style="margin-bottom: 15px;">Add Community</a>
        <?php flash('admin_msg'); ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Membership</th>
                    <th>Status</th>
                    <th>Delete Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $communities = $data['communities'] ?? [];
                if (empty($communities)) {
                    // Dummy data if none provided
                    $communities = [
                        (object)[
                            'communityId' => 1,
                            'communityName' => 'Writers United',
                            'communityDescription' => 'A community for aspiring writers.',
                            'communityImage' => 'public/img/community/sample.jpg',
                            'membership_type' => 'open',
                            'status' => 'pending',
                            'delete_status' => 'none',
                            'created_at' => '2025-04-01 10:00:00'
                        ],
                        (object)[
                            'communityId' => 2,
                            'communityName' => 'Book Lovers',
                            'communityDescription' => 'A place for book enthusiasts.',
                            'communityImage' => 'public/img/community/sample2.jpg',
                            'membership_type' => 'closed',
                            'status' => 'approved',
                            'delete_status' => 'none',
                            'created_at' => '2025-04-10 15:30:00'
                        ]
                    ];
                }
                ?>
                <?php foreach ($communities as $c): ?>
                    <tr>
                        <td><?php echo $c->communityId; ?></td>
                        <td><?php echo htmlspecialchars($c->communityName); ?></td>
                        <td><?php echo htmlspecialchars(substr($c->communityDescription, 0, 40)); ?>...</td>
                        <td><img src="<?php echo URLROOT . '/' . $c->communityImage; ?>" alt="Image" style="width:40px;height:40px;"></td>
                        <td><?php echo htmlspecialchars($c->membership_type); ?></td>
                        <td><?php echo htmlspecialchars($c->status); ?></td>
                        <td><?php echo htmlspecialchars($c->delete_status); ?></td>
                        <td><?php echo $c->created_at; ?></td>
                        <td>
                            <?php if ($c->status === 'pending'): ?>
                                <form action="<?php echo URLROOT; ?>/admin/approveCommunity/<?php echo $c->communityId; ?>" method="post" style="display:inline;">
                                    <button type="submit" class="btn btn-update">Approve</button>
                                </form>
                                <form action="<?php echo URLROOT; ?>/admin/rejectCommunity/<?php echo $c->communityId; ?>" method="post" style="display:inline;">
                                    <button type="submit" class="btn btn-delete">Reject</button>
                                </form>
                            <?php endif; ?>
                            <form action="<?php echo URLROOT; ?>/admin/deleteCommunity/<?php echo $c->communityId; ?>" method="post" style="display:inline;" onsubmit="return confirm('Delete this community?');">
                                <button type="submit" class="btn btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>