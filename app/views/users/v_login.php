<?php require APPROOT.'/views/inc/header.php';?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>

<div class="login">
        <br>
        <div class="login-container">
                <div class="login-photo">
                    <img src="/musebookstore/public/img/login photo.jpg" alt="Muse Bookstore Logo">
                </div>
            <div class="login-box">
                <div class="logo">
                    <img src="/musebookstore/public/img/muse logo.png" alt="Muse Bookstore Logo">
                </div>
                <form action="" method="post">

                <label>Email</label>
                <input type="text" name="email" placeholder="Email" value="<?php echo $data['email'] ?>"required>
                <span class="form-invalid"><?php echo $data['email_err'];?></span>

                <label>Password</label>
                <input type="password" name="password" placeholder="Password" value="<?php echo $data['password'] ?>" required>
                <span class="form-invalid"><?php echo $data['password_err'];?></span>
                   <div class="options">
                   <a href="#" style="display: block; text-align: center;">Forgot Password?</a>
                    </div>
                <button type="submit" name="loginSubmit">Login</button>
            </form>
            <br>
            <p>Don't have an account? <a href="<?php echo URLROOT?>/users/signup">Sign Up</a></p>
            </div>
        </div>

</div>


<?php require APPROOT.'/views/inc/footer.php';?>

