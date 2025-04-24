<?php require APPROOT.'/views/inc/header.php';?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>

<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'parent') {
    die("Access denied! You do not have permission to view this page.");
}
?>


<body>
<?php require APPROOT.'/views/inc/components/parent/sidebar.php';?>
<script>
        // Enable the fields for editing
        function enableEdit() {

            document.getElementById("address").disabled = false;
            document.getElementById("name").disabled = false;
            document.getElementById("contactNumber").disabled = false;
            document.getElementById("password").disabled = false;
            document.getElementById("confirmPassword").disabled = false;
            document.getElementById("saveBtn").style.display = "block";
        }
</script>


    <!-- Main content -->
    <div class="main-content">
    <?php flash('profile_flash'); ?>
    <?php 
    require APPROOT.'/views/pages/parent/v_userprofilestats.php';?>

        <div class="profile-container">
            <h2>User Profile</h2>
            
            <form action="<?php echo URLROOT; ?>/users/edit_profile" method="POST" class="profile-form">
                <!-- Left Column -->
                <div class="profile-column">

                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>" disabled>

                    <label for="name">Username</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" disabled>

                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter new password" disabled>

                </div>

                <!-- Right Column -->
                <div class="profile-column">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($_SESSION['user_address']); ?>" disabled>

                    <label for="contactNumber">Contact Number</label>
                    <input type="text" id="contactNumber" name="contactNumber" value="<?php echo htmlspecialchars($_SESSION['user_phone']); ?>" disabled>

                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Re-enter new password" disabled>

                </div>

                <!-- Edit and Save Buttons -->
                <div style="width: 100%; text-align: center;">
                    <button type="button" class="edit-btn" onclick="enableEdit()">Edit Profile</button>
                    <button type="submit" name="saveprofile" id="saveBtn" class="save-btn" style="display: none;">Save Changes</button>
                </div>
            </form>

        </div>

    </div>


</body>

</html>