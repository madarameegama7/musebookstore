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
                <form action="#" method="post">
                <input type="text" name="name" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                   <div class="options">
                      <a href="#">Forgot Password?</a>
                    </div>
                <button type="submit" name="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="<?php echo URLROOT?>/users/signup">Sign Up</a></p>
            </div>
        </div>

</div>


<?php require APPROOT.'/views/inc/footer.php';?>

