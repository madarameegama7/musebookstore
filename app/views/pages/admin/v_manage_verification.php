<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <?php flash('admin_msg'); ?> <!-- Display flash messages -->

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1><?php echo $data['title']; ?></h1>
        </div>

        <!-- Search Form -->
        <div class="search-container admin-search-container" style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <form action="<?php echo URLROOT; ?>/admin/manageVerification" method="get" style="display: flex; flex-grow: 1; gap: 10px;">
                <input type="text" name="search" id="userSearchInput" placeholder="Search by Email, Name or ID..." value="<?php echo htmlspecialchars($data['searchTerm'] ?? ''); ?>" style="flex-grow: 1; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px;">
                <button type="submit" class="btn btn-search" style="padding: 8px 15px; border-radius: 4px; cursor: pointer;">Search</button>
            </form>
            <!-- Clear button -->
            <?php if (!empty($data['searchTerm'])): ?>
                <a href="<?php echo URLROOT; ?>/admin/manageVerification" class="btn btn-grey" style="text-decoration: none; padding: 8px 15px; border-radius: 4px;">Clear</a>
            <?php endif; ?>
        </div>

        <!-- Filter buttons -->
        <div class="filter-buttons" style="margin-bottom: 20px;">
            <a href="<?php echo URLROOT; ?>/admin/manageVerification" class="filter-btn <?php echo empty($data['filter']) ? 'active' : ''; ?>">All Users</a>
            <a href="<?php echo URLROOT; ?>/admin/manageVerification?filter=verified" class="filter-btn <?php echo ($data['filter'] ?? '') === 'verified' ? 'active' : ''; ?>">Verified</a>
            <a href="<?php echo URLROOT; ?>/admin/manageVerification?filter=unverified" class="filter-btn <?php echo ($data['filter'] ?? '') === 'unverified' ? 'active' : ''; ?>">Unverified</a>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Verification Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['users'])) : ?>
                        <?php foreach ($data['users'] as $user) : ?>
                            <tr>
                                <td><?php echo $user->user_id; ?></td>
                                <td><?php echo htmlspecialchars($user->user_name); ?></td>
                                <td><?php echo htmlspecialchars($user->user_email); ?></td>
                                <td><?php echo htmlspecialchars($user->user_role); ?></td>
                                <td>
                                    <?php if ($user->user_is_verified == 1): ?>
                                        <span class="status-badge verified">Verified</span>
                                    <?php else: ?>
                                        <span class="status-badge unverified">Unverified</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($user->user_is_verified == 0): ?>
                                        <form action="<?php echo URLROOT; ?>/admin/verifyUser/<?php echo $user->user_id; ?>" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to verify this user?');">
                                            <button type="submit" class="btn-update">Verify User</button>
                                        </form>
                                        <form action="<?php echo URLROOT; ?>/admin/resendOTP/<?php echo $user->user_id; ?>" method="post" style="display:inline;">
                                            <button type="submit" class="btn-view">Resend OTP</button>
                                        </form>
                                    <?php else: ?>
                                        <form action="<?php echo URLROOT; ?>/admin/unverifyUser/<?php echo $user->user_id; ?>" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to mark this user as unverified?');">
                                            <button type="submit" class="btn-delete">Unverify User</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<style>
    .filter-buttons {
        display: flex;
        gap: 10px;
    }

    .filter-btn {
        padding: 8px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f8f9fa;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s;
    }

    .filter-btn:hover {
        background-color: #e9ecef;
    }

    .filter-btn.active {
        background-color: #4e73df;
        color: white;
        border-color: #4e73df;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-badge.verified {
        background-color: #1cc88a;
        color: white;
    }

    .status-badge.unverified {
        background-color: #f6c23e;
        color: white;
    }

    .table-responsive {
        overflow-x: auto;
    }
</style>

<?php require APPROOT . '/views/inc/footer.php'; ?>