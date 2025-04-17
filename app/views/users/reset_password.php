<?php require APPROOT . '/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="reset-password">
    <br>
    <h2>Reset Password</h2>
    <form action="<?php echo URLROOT; ?>/users/reset_password" method="post">
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
        <input type="password" name="new_password" placeholder="New Password" required>
        <button type="submit">Reset Password</button>
    </form>

</div>


<?php require APPROOT . '/views/inc/footer.php'; ?>