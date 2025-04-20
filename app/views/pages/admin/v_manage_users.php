<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <?php flash('admin_msg'); ?> <!-- Display flash messages -->

        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1><?php echo $data['title']; ?></h1>
            <a href="<?php echo URLROOT; ?>/admin/addUser" class="btn btn-update" style="margin-bottom: 10px;">Add New User</a> <!-- Use btn-update for green or define btn-add -->
        </div>

        <p>Here you can manage all registered users.</p>

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
            <tbody>
                <?php foreach ($data['users'] as $user) : ?>
                    <tr>
                        <td><?php echo $user->user_id; ?></td>
                        <td><?php echo htmlspecialchars($user->user_name); ?></td>
                        <td><?php echo htmlspecialchars($user->user_email); ?></td>
                        <td><?php echo htmlspecialchars($user->user_role); ?></td>
                        <td>
                            <a href="<?php echo URLROOT; ?>/admin/viewUser/<?php echo $user->user_id; ?>" class="btn-view">View/Edit Role</a>
                            <?php if ($user->user_id != $_SESSION['user_id']) : // Prevent showing edit/delete for self 
                            ?>
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
            </tbody>
        </table>

    </main>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>