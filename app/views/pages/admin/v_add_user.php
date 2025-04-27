<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <a href="<?php echo URLROOT; ?>/admin/manageUsers" class="btn btn-back"><i class="fa fa-arrow-left"></i> Back to Users</a>

        <?php flash('admin_msg'); ?>

        <h2><?php echo $data['title']; ?></h2>
        <p>Create a new user account.</p>

        <form class="edit-user-form" action="<?php echo URLROOT; ?>/admin/addUser" method="post">

            <label for="name">Name: <sup>*</sup></label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($data['name']); ?>" required>
            <span class="form-invalid"><?php echo $data['name_err']; ?></span>

            <label for="email">Email: <sup>*</sup></label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($data['email']); ?>" required>
            <span class="form-invalid"><?php echo $data['email_err']; ?></span>

            <label for="password">Password: <sup>*</sup></label>
            <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($data['password']); ?>" required>
            <span class="form-invalid"><?php echo $data['password_err']; ?></span>

            <label for="confirmPassword">Confirm Password: <sup>*</sup></label>
            <input type="password" name="confirmPassword" id="confirmPassword" value="<?php echo htmlspecialchars($data['confirmPassword']); ?>" required>
            <span class="form-invalid"><?php echo $data['confirmPassword_err']; ?></span>

            <label for="role">Role: <sup>*</sup></label>
            <select name="role" id="role" required onchange="toggleParentSelect(this.value)">
                <option value="" disabled <?php echo empty($data['role']) ? 'selected' : ''; ?>>Select Role</option>
                <option value="admin" <?php if ($data['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                <option value="parent" <?php if ($data['role'] == 'parent') echo 'selected'; ?>>Parent</option>
                <option value="child" <?php if ($data['role'] == 'child') echo 'selected'; ?>>Child</option>
                <option value="ambassador" <?php if ($data['role'] == 'ambassador') echo 'selected'; ?>>Ambassador</option>
            </select>
            <span class="form-invalid"><?php echo $data['role_err']; ?></span>

            <!-- Parent Selection Dropdown (Initially Hidden) -->
            <div id="parentSelectDiv" style="display: <?php echo ($data['role'] === 'child') ? 'block' : 'none'; ?>;">
                <label for="parent_id">Parent Account: <sup>*</sup></label>
                <select name="parent_id" id="parent_id">
                    <option value="" disabled selected>Select Parent</option>
                    <?php foreach ($data['users'] as $user): ?>
                        <?php if ($user->user_role === 'parent'): ?>
                            <option value="<?php echo $user->user_id; ?>" <?php if ($data['parent_id'] == $user->user_id) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($user->user_name) . ' (' . htmlspecialchars($user->user_email) . ')'; ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <span class="form-invalid"><?php echo $data['parent_id_err']; ?></span>
            </div>


            <label for="address">Address: <sup>*</sup></label>
            <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($data['address']); ?>" required>
            <span class="form-invalid"><?php echo $data['address_err']; ?></span>

            <label for="contactNumber">Contact Number: <sup>*</sup></label>
            <input type="tel" name="contactNumber" id="contactNumber" value="<?php echo htmlspecialchars($data['contactNumber']); ?>" required pattern="07[0-9]{8}" title="Format: 07XXXXXXXX">
            <span class="form-invalid"><?php echo $data['contactNumber_err']; ?></span>

            <button type="submit" class="btn btn-update">Create User</button>
        </form>

        <script>
            // JavaScript to show/hide parent selection based on role
            function toggleParentSelect(selectedRole) {
                const parentDiv = document.getElementById('parentSelectDiv');
                const parentSelect = document.getElementById('parent_id');
                if (selectedRole === 'child') {
                    parentDiv.style.display = 'block';
                    parentSelect.required = true; // Make parent selection required for child
                } else {
                    parentDiv.style.display = 'none';
                    parentSelect.required = false; // Make parent selection not required otherwise
                    parentSelect.value = ''; // Clear selection if role changes from child
                }
            }
            // Initialize on page load in case of validation errors
            document.addEventListener('DOMContentLoaded', function() {
                const roleSelect = document.getElementById('role');
                toggleParentSelect(roleSelect.value);
            });
        </script>

    </main>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>