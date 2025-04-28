<?php require APPROOT . '/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="forgot-password">
    <br>
    <h2>Forgot Password</h2>
    <form action="<?php echo URLROOT; ?>/users/forgot_password" method="post">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Send Reset Link</button>
    </form>




</div>


<?php require APPROOT . '/views/inc/footer.php'; ?>