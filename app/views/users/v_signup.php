<?php require APPROOT . '/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="signup">
    <br>
    <div class="signup-container">
        <div class="signup-photo">
            <img src="/musebookstore/public/img/signup photo.jpg" alt="Muse Bookstore Logo">
        </div>
        <div class="signup-box">
            <div class="logo">
                <img src="/musebookstore/public/img/muse logo.png" alt="Muse Bookstore Logo">
            </div>
            <form action="<?php echo URLROOT ?>/users/signup" method="post" enctype="multipart/form-data">


            <div class="form-drag-area">
                <div class="icon">
                    <img src="<?php echo URLROOT; ?>/img/components/profilephoto/profile image placeholder.png" alt="placeholder" width="150px" height="150px" id="profile_image_placeholder">
                </div>
                <div class="right-content">
                    <div class="description">Drag & Drop to Upload File</div>
                    <div class="form-upload">
                        <input type="file" name="profile_image" id="profile_image" style="display: none;">
                        Browse File
                    </div>
                </div>
            </div>

            <br><br>
            <div class="form-validation">
                <div class="profile-image-validation">
                    <img src="<?php echo URLROOT; ?>/img/components/profilephoto/green-tick.png" alt="green-tick" width="15px" height="15px">
                    Select a Profile picture
                </div>
            </div>
            <span class="form-invalid"><?php echo $data['profile_image_err']; ?></span>

                <br>
                <label>Email</label>
                <input type="email" id="email" name="email" placeholder="Email Address"
                    value="<?php echo $data['email']; ?>" required>
                <span class="form-invalid"><?php echo $data['email_err']; ?></span>

                <label>Name</label>
                <input type="text" id="name" name="name" placeholder="Name" value="<?php echo $data['name']; ?>"
                    required>
                <span class="form-invalid"><?php echo $data['name_err']; ?></span>

                <label>Password</label>
                <input type="password" id="password" name="password" placeholder="Password"
                    value="<?php echo $data['password']; ?>" required>
                <span class="form-invalid"><?php echo $data['password_err']; ?></span>

                <label>Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Re-enter Password"
                    value="<?php echo $data['confirmPassword']; ?>" required>
                <span class="form-invalid"><?php echo $data['confirmPassword_err']; ?></span>

                <label>City</label>
                <input type="text" id="address" name="address" placeholder="Enter Address"
                    value="<?php echo $data['address']; ?>" required></input>
                <span class="form-invalid"><?php echo $data['address_err']; ?></span>

                <label>Contact Number</label>
                <input type="tel" id="contactNumber" name="contactNumber" placeholder="Enter Contact Number"
                    value="<?php echo $data['contactNumber']; ?>" required pattern="[0-9]{10}"
                    title="Please enter a valid 10-digit phone number">
                <span class="form-invalid"><?php echo $data['contactNumber_err']; ?></span>

                <button type="submit" name="signupSubmit">Sign Up</button>
            </form>
        </div>
    </div>

</div>

<!-- js for profile image-->
<script src="/musebookstore/public/js/imageUpload.js"></script>

<?php require APPROOT . '/views/inc/footer.php'; ?>