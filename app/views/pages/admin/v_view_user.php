<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <?php flash('admin_msg'); ?> <!-- Display flash messages -->
        <h1><?php echo $data['title']; ?></h1>
        <a href="<?php echo URLROOT; ?>/admin/manageUsers" class="btn-back">Back to User List</a>

        <div class="user-details-card">
            <h2>User Information</h2>
            <p><strong>ID:</strong> <?php echo $data['user']->user_id; ?></p>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($data['user']->user_name); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($data['user']->user_email); ?></p>
            <p><strong>Current Role:</strong> <?php echo htmlspecialchars($data['user']->user_role); ?></p>
            <!-- Add other relevant user details here -->
        </div>

        <?php if ($data['user']->user_id != $_SESSION['user_id']) : // Prevent role change for self 
        ?>
            <div class="update-role-form">
                <h2>Update User Role</h2>
                <form action="<?php echo URLROOT; ?>/admin/updateUserRole/<?php echo $data['user']->user_id; ?>" method="post">
                    <label for="user_role">New Role:</label>
                    <select name="user_role" id="user_role">
                        <option value="parent" <?php echo ($data['user']->user_role == 'parent') ? 'selected' : ''; ?>>Parent</option>
                        <option value="child" <?php echo ($data['user']->user_role == 'child') ? 'selected' : ''; ?>>Child</option>
                        <option value="ambassador" <?php echo ($data['user']->user_role == 'ambassador') ? 'selected' : ''; ?>>Ambassador</option>
                        <option value="admin" <?php echo ($data['user']->user_role == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    </select>
                    <button type="submit" class="btn-update">Update Role</button>
                </form>
            </div>
        <?php else: ?>
            <p><em>You cannot change your own role.</em></p>
        <?php endif; ?>

    </main>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>