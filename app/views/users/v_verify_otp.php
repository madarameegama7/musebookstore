<?php require APPROOT . '/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="verify-otp">
    <br>
    <div class="verify-container">
        <div class="logo">
            <img src="/musebookstore/public/img/muse logo.png" alt="Muse Bookstore Logo">
        </div>
        <h2>Email Verification</h2>

        <?php flash('otp_msg'); ?>

        <p>We've sent a verification code to <strong><?php echo htmlspecialchars($data['email']); ?></strong></p>
        <p>Please enter the code below to verify your account:</p>

        <form action="<?php echo URLROOT; ?>/users/verify_otp" method="post">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($data['email']); ?>">

            <div class="form-group">
                <label for="otp">Verification Code:</label>
                <input type="text" id="otp" name="otp" placeholder="Enter verification code" value="<?php echo $data['otp']; ?>" required>
                <span class="form-invalid"><?php echo $data['otp_err']; ?></span>
            </div>

            <button type="submit" class="btn-verify">Verify Account</button>
        </form>

        <div class="resend-link">
            <p>Didn't receive the code? <a href="<?php echo URLROOT; ?>/users/resend_otp?email=<?php echo urlencode($data['email']); ?>">Resend Code</a></p>
        </div>

        <div class="back-to-login">
            <p><a href="<?php echo URLROOT; ?>/users/login">Back to Login</a></p>
        </div>
    </div>
</div>

<style>
    .verify-otp {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
    }

    .verify-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
        width: 100%;
        max-width: 500px;
        text-align: center;
    }

    .logo img {
        width: 120px;
        margin-bottom: 20px;
    }

    h2 {
        margin-bottom: 20px;
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
    }

    input[type="text"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        margin-top: 10px;
    }

    .btn-verify {
        background-color: #4e73df;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        width: 100%;
        margin-top: 10px;
    }

    .btn-verify:hover {
        background-color: #3a5fc8;
    }

    .form-invalid {
        color: #e74a3b;
        font-size: 14px;
        display: block;
        margin-top: 5px;
    }

    .resend-link,
    .back-to-login {
        margin-top: 20px;
    }

    .resend-link a,
    .back-to-login a {
        color: #4e73df;
        text-decoration: none;
    }

    .resend-link a:hover,
    .back-to-login a:hover {
        text-decoration: underline;
    }
</style>

<?php require APPROOT . '/views/inc/footer.php'; ?>