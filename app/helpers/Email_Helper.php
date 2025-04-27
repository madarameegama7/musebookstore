<?php

/**
 * Email Helper
 * 
 * Handles sending emails including OTP verification emails
 */
class Email_Helper
{
    /**
     * Generate a random 6-digit OTP
     * 
     * @return string 6-digit OTP
     */
    public static function generateOTP()
    {
        return sprintf("%06d", mt_rand(100000, 999999));
    }

    /**
     * Send OTP email to user
     * 
     * @param string $email User's email address
     * @param string $name User's name
     * @param string $otp The OTP code
     * @return bool Whether the email was sent successfully
     */
    public static function sendOTP($email, $name, $otp)
    {
        // SMTP configuration - make sure these are correct and consistent
        $smtp_host = 'smtp.gmail.com';
        $smtp_port = 587;
        $smtp_username = 'hapuarachchikaviru@gmail.com'; // Your SMTP email
        $smtp_password = 'itro nhqh wqhb wkvp'; // Your app password
        $smtp_from_email = 'hapuarachchikaviru@gmail.com'; // Should match SMTP username
        $smtp_from_name = 'Muse Bookstore';

        // Email content
        $subject = 'Your Verification Code for Muse Bookstore';

        // HTML email content
        $html_message = '
        <html>
        <head>
            <title>Email Verification</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                }
                .header {
                    background-color: #4e73df;
                    color: white;
                    padding: 15px;
                    text-align: center;
                    border-radius: 5px 5px 0 0;
                }
                .content {
                    padding: 20px;
                }
                .otp-code {
                    font-size: 32px;
                    font-weight: bold;
                    text-align: center;
                    letter-spacing: 5px;
                    margin: 20px 0;
                    color: #4e73df;
                    background-color: #f8f9fa;
                    padding: 15px;
                    border-radius: 5px;
                }
                .footer {
                    text-align: center;
                    margin-top: 20px;
                    font-size: 12px;
                    color: #777;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>Email Verification</h2>
                </div>
                <div class="content">
                    <p>Hello ' . htmlspecialchars($name) . ',</p>
                    <p>Thank you for registering with Muse Bookstore. To complete your registration, please use the verification code below:</p>
                    
                    <div class="otp-code">' . $otp . '</div>
                    
                    <p>This code will expire in 15 minutes for security reasons.</p>
                    <p>If you didn\'t request this code, please ignore this email.</p>
                    <p>Best regards,<br>The Muse Bookstore Team</p>
                </div>
                <div class="footer">
                    <p>This is an automated message, please do not reply to this email.</p>
                </div>
            </div>
        </body>
        </html>';

        // Plain text alternative for email clients that don't support HTML
        $text_message = "Hello " . $name . ",\n\n" .
            "Thank you for registering with Muse Bookstore. Your verification code is: " . $otp . "\n\n" .
            "This code will expire in 15 minutes.\n\n" .
            "If you didn't request this code, please ignore this email.\n\n" .
            "Best regards,\nThe Muse Bookstore Team";

        // Set email headers
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: " . $smtp_from_name . " <" . $smtp_from_email . ">\r\n";

        // Try to send using PHPMailer if available
        if (self::sendWithPHPMailer($email, $name, $subject, $html_message, $text_message, $smtp_host, $smtp_port, $smtp_username, $smtp_password, $smtp_from_email, $smtp_from_name)) {
            return true;
        }

        // Fallback to PHP's mail() function
        return mail($email, $subject, $html_message, $headers);
    }

    /**
     * Send email using PHPMailer library if available
     * 
     * @param string $to_email Recipient email
     * @param string $to_name Recipient name
     * @param string $subject Email subject
     * @param string $html_body HTML email content
     * @param string $text_body Plain text email content
     * @param string $smtp_host SMTP host
     * @param int $smtp_port SMTP port
     * @param string $smtp_username SMTP username
     * @param string $smtp_password SMTP password
     * @param string $from_email Sender email
     * @param string $from_name Sender name
     * @return bool Whether the email was sent successfully
     */
    private static function sendWithPHPMailer($to_email, $to_name, $subject, $html_body, $text_body, $smtp_host, $smtp_port, $smtp_username, $smtp_password, $from_email, $from_name)
    {
        // Check if PHPMailer is available
        $phpmailer_path = APPROOT . '/libraries/PHPMailer/PHPMailer.php';
        if (!file_exists($phpmailer_path)) {
            return false;
        }

        try {
            // Include PHPMailer files if not already included
            if (!class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
                require_once APPROOT . '/libraries/PHPMailer/PHPMailer.php';
                require_once APPROOT . '/libraries/PHPMailer/SMTP.php';
                require_once APPROOT . '/libraries/PHPMailer/Exception.php';
            }

            // Initialize PHPMailer
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);

            // Server settings
            $mail->isSMTP();
            $mail->Host = $smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $smtp_username;
            $mail->Password = $smtp_password;
            $mail->SMTPSecure = 'tls';
            $mail->Port = $smtp_port;

            // Recipients
            $mail->setFrom($from_email, $from_name);
            $mail->addAddress($to_email, $to_name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $html_body;
            $mail->AltBody = $text_body;

            // Send email
            $mail->send();
            return true;
        } catch (Exception $e) {
            // Log the error
            error_log('Email sending failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send a general email
     * 
     * @param string $to_email Recipient email
     * @param string $to_name Recipient name
     * @param string $subject Email subject
     * @param string $message Email message (HTML or plain text)
     * @return bool Whether the email was sent successfully
     */
    public static function sendEmail($to_email, $to_name, $subject, $message)
    {
        // SMTP configuration
        $smtp_host = 'smtp.gmail.com';
        $smtp_port = 587;
        $smtp_username = 'your-email@gmail.com'; // Change to your SMTP email
        $smtp_password = 'your-app-password'; // Change to your SMTP password
        $smtp_from_email = 'your-email@gmail.com'; // Change to your from email
        $smtp_from_name = 'Muse Bookstore'; // Change to your from name

        // Set email headers
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: " . $smtp_from_name . " <" . $smtp_from_email . ">\r\n";

        // Try to send using PHPMailer if available
        if (self::sendWithPHPMailer($to_email, $to_name, $subject, $message, strip_tags($message), $smtp_host, $smtp_port, $smtp_username, $smtp_password, $smtp_from_email, $smtp_from_name)) {
            return true;
        }

        // Fallback to PHP's mail() function
        return mail($to_email, $subject, $message, $headers);
    }
}
