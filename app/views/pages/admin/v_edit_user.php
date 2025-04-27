<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <a href="<?php echo URLROOT; ?>/admin/manageUsers" class="btn btn-back"><i class="fa fa-arrow-left"></i> Back to Users</a>

        <?php flash('admin_msg'); ?> <!-- Display flash messages if update fails on reload -->

        <h2><?php echo $data['title']; ?></h2>
        <p>Edit user details below. Role must be changed via the 'View/Edit Role' button on the user list.</p>

        <form class="edit-user-form" action="<?php echo URLROOT; ?>/admin/updateUser/<?php echo $data['user_id']; ?>" method="post">

            <label for="name">Name: <sup>*</sup></label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($data['name'] ?? ''); ?>" required>
            <span class="form-invalid"><?php echo $data['name_err']; ?></span>

            <label for="email">Email: <sup>*</sup></label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>" required>
            <span class="form-invalid"><?php echo $data['email_err']; ?></span>

            <label for="address">Address: <sup>*</sup></label>
            <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($data['address'] ?? ''); ?>" required>
            <span class="form-invalid"><?php echo $data['address_err']; ?></span>

            <label for="contactNumber">Contact Number: <sup>*</sup></label>
            <input type="tel" name="contactNumber" id="contactNumber" value="<?php echo htmlspecialchars($data['contactNumber'] ?? ''); ?>" required pattern="07[0-9]{8}" title="Format: 07XXXXXXXX">
            <span class="form-invalid"><?php echo $data['contactNumber_err']; ?></span>

            <button type="submit" class="btn btn-update">Save Changes</button>
        </form>

    </main>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>