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
            document.getElementById("username").disabled = false;
            document.getElementById("email").disabled = false;
            document.getElementById("address").disabled = false;
            document.getElementById("contactNumber").disabled = false;
            document.getElementById("saveBtn").style.display = "block";
        }
</script>


    <!-- Main content -->
    <div class="main-content">
    <?php require APPROOT.'/views/inc/components/parent/v_userprofilestats.php';?>

        <div class="profile-container">
            <h2>User Profile</h2>

            <form action="<?php echo URLROOT?>/users/edit_profile" class="profile-form" action="POST">
                <!-- Left Column -->
                <div class="profile-column">

                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" disabled>
                </div>

                <!-- Right Column -->
                <div class="profile-column">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($_SESSION['address']); ?>" disabled>

                    <label for="contactNumber">Contact Number</label>
                    <input type="text" id="contactNumber" name="contactNumber" value="<?php echo htmlspecialchars($_SESSION['contactNumber']); ?>" disabled>
                </div>

                <!-- Edit and Save Buttons -->
                <div style="width: 100%; text-align: center;">
                    <button type="button" class="edit-btn" onclick="enableEdit()">Edit Profile</button>
                    <button type="submit" name="saveprofile" id="saveBtn" style="display: none;">Save Changes</button>
                    <a href="<?php echo URLROOT ?>/parent_user" class="manage-btn" style="display: inline-block; margin-left: 15px; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 4px;">Manage Children</a>
                </div>
            </form>

        </div>
        <?php include 'mybooks.php'; ?>

    </div>


</body>

</html>