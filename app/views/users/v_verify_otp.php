<?php require APPROOT . '/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="verify-otp">
    <br>
    <div class="verify-otp-container">
        <div class="verify-otp-box">
            <h2>Verify Your Account</h2>
            <?php flash('otp_msg'); ?>

            <div class="verification-icon">
                <i class="fas fa-envelope-open-text"></i>
            </div>

            <p>A verification code has been sent to your email address:</p>
            <p class="user-email"><?php echo isset($data['email']) ? htmlspecialchars($data['email']) : ''; ?></p>
            <p>Please enter the 6-digit code below to verify your account.</p>

            <form action="<?php echo URLROOT ?>/users/verify_otp" method="post">
                <input type="hidden" name="email" value="<?php echo isset($data['email']) ? htmlspecialchars($data['email']) : ''; ?>">

                <div class="otp-input-container">
                    <input type="text" name="otp" maxlength="6" placeholder="Enter 6-digit code" value="<?php echo isset($data['otp']) ? $data['otp'] : ''; ?>" required>
                </div>
                <span class="form-invalid"><?php echo isset($data['otp_err']) ? $data['otp_err'] : ''; ?></span>

                <button type="submit" name="verifyOtpSubmit">Verify Account</button>
            </form>

            <div class="otp-actions">
                <p class="timer">Code expires in: <span id="countdown">15:00</span></p>
                <p>Didn't receive the code? <a href="<?php echo URLROOT ?>/users/resend_otp?email=<?php echo isset($data['email']) ? urlencode($data['email']) : ''; ?>">Resend OTP</a></p>
                <p><a href="<?php echo URLROOT ?>/users/login" class="back-link"><i class="fas fa-arrow-left"></i> Back to Login</a></p>
            </div>
        </div>
    </div>
</div>

<!-- Add improved styling for OTP verification page -->
<style>
    .verify-otp {
        display: flex;
        justify-content: center;
        background-color: #f8f9fa;
        min-height: calc(100vh - 100px);
        padding: 30px 0;
    }

    .verify-otp-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        max-width: 1200px;
    }

    .verify-otp-box {
        background-color: white;
        padding: 35px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        width: 100%;
        max-width: 480px;
        text-align: center;
    }

    .verify-otp-box h2 {
        color: #333;
        margin-bottom: 15px;
        font-size: 28px;
    }

    .verification-icon {
        font-size: 65px;
        color: #4e73df;
        margin: 15px 0 25px;
    }

    .verify-otp-box p {
        margin-bottom: 12px;
        color: #555;
        font-size: 15px;
    }

    .user-email {
        font-weight: bold;
        color: #333;
        font-size: 17px;
        margin-bottom: 20px;
    }

    .otp-input-container {
        margin: 25px 0 10px;
    }

    .verify-otp-box input[type="text"] {
        width: 100%;
        padding: 14px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 20px;
        letter-spacing: 8px;
        text-align: center;
        background-color: #f8fafc;
        transition: all 0.3s;
    }

    .verify-otp-box input[type="text"]:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.25);
        outline: none;
    }

    .verify-otp-box button {
        width: 100%;
        padding: 14px;
        margin-top: 15px;
        background-color: #4e73df;
        border: none;
        color: white;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: background-color 0.3s;
    }

    .verify-otp-box button:hover {
        background-color: #2e59d9;
    }

    .otp-actions {
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #eee;
        color: #666;
    }

    .otp-actions p {
        margin-bottom: 8px;
        font-size: 14px;
    }

    .timer {
        font-weight: bold;
        color: #e74a3b;
        margin-bottom: 15px;
    }

    .otp-actions a {
        color: #4e73df;
        text-decoration: none;
        font-weight: 600;
    }

    .otp-actions a:hover {
        text-decoration: underline;
    }

    .back-link {
        display: inline-block;
        margin-top: 10px;
        color: #666 !important;
        font-weight: normal !important;
    }

    .form-invalid {
        color: #e74a3b;
        display: block;
        margin-top: 8px;
        font-size: 14px;
    }
</style>

<script>
    // Countdown timer for OTP expiration
    document.addEventListener('DOMContentLoaded', function() {
        let timeLeft = 15 * 60; // 15 minutes in seconds
        const countdownElement = document.getElementById('countdown');

        function updateCountdown() {
            const minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;

            // Add leading zero to seconds if needed
            seconds = seconds < 10 ? '0' + seconds : seconds;

            // Update countdown text
            countdownElement.textContent = `${minutes}:${seconds}`;

            if (timeLeft <= 0) {
                clearInterval(timer);
                countdownElement.textContent = '0:00';
                countdownElement.style.color = '#e74a3b';
            } else {
                timeLeft--;
            }
        }

        // Initial call to set the countdown immediately
        updateCountdown();

        // Update countdown every second
        const timer = setInterval(updateCountdown, 1000);
    });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>