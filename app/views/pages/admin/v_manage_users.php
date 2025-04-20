<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <?php flash('admin_msg'); ?> <!-- Display flash messages -->

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1><?php echo $data['title']; ?></h1>
            <a href="<?php echo URLROOT; ?>/admin/addUser" class="btn btn-update" style="margin-bottom: 10px;">Add New User</a>
        </div>

        <!-- Search Form -->
        <div class="search-container admin-search-container" style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <form action="<?php echo URLROOT; ?>/admin/manageUsers" method="get" style="display: flex; flex-grow: 1; gap: 10px;">
                <input type="text" name="search" id="userSearchInput" placeholder="Search by ID, Name, Email..." value="<?php echo htmlspecialchars($data['searchTerm'] ?? ''); ?>" style="flex-grow: 1; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px;">
                <button type="submit" class="btn btn-search" style="padding: 8px 15px; border-radius: 4px; cursor: pointer;">Search</button> <!-- Added Search Button -->
            </form>
            <!-- Clear button -->
            <?php if (!empty($data['searchTerm'])): ?>
                <a href="<?php echo URLROOT; ?>/admin/manageUsers" class="btn btn-grey" style="text-decoration: none; padding: 8px 15px; border-radius: 4px;">Clear</a>
            <?php endif; ?>
        </div>

        <p>Here you can manage all registered users.</p>

        <div id="user-results-container"> <!-- Container for results message -->
            <?php if (empty($data['users']) && !empty($data['searchTerm'])) : ?>
                <p>No users found matching your search term "<?php echo htmlspecialchars($data['searchTerm']); ?>".</p>
            <?php endif; ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="user-table-body"> <!-- ID can remain but is not used by JS now -->
                <?php if (!empty($data['users'])) : ?>
                    <?php foreach ($data['users'] as $user) : ?>
                        <tr>
                            <td><?php echo $user->user_id; ?></td>
                            <td><?php echo htmlspecialchars($user->user_name); ?></td>
                            <td><?php echo htmlspecialchars($user->user_email); ?></td>
                            <td><?php echo htmlspecialchars($user->user_role); ?></td>
                            <td>
                                <a href="<?php echo URLROOT; ?>/admin/viewUser/<?php echo $user->user_id; ?>" class="btn-view">View/Edit Role</a>
                                <?php if ($user->user_id != $_SESSION['user_id']) : ?>
                                    <a href="<?php echo URLROOT; ?>/admin/editUser/<?php echo $user->user_id; ?>" class="btn-edit">Edit Details</a>
                                    <form action="<?php echo URLROOT; ?>/admin/deleteUser/<?php echo $user->user_id; ?>" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                        <button type="submit" class="btn-delete">Delete</button>
                                    </form>
                                <?php else: ?>
                                    (Current Admin)
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php elseif (empty($data['users']) && empty($data['searchTerm'])) : ?>
                    <tr>
                        <td colspan="5">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </main>
</div>

<!-- Removed JavaScript includes for live search -->
<!-- <script> const URLROOT = ... </script> -->
<!-- <script src="<?php echo URLROOT; ?>/js/admin_live_search.js"></script> -->

<?php require APPROOT . '/views/inc/footer.php'; ?>