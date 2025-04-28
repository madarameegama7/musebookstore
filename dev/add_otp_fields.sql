-- SQL to add OTP verification fields to the user table
ALTER TABLE user 
ADD COLUMN user_otp VARCHAR
(10) NULL,
ADD COLUMN user_otp_expires DATETIME NULL,
ADD COLUMN user_is_verified TINYINT
(1) DEFAULT 0;