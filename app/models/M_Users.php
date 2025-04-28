<?php
class M_Users
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM user WHERE user_email= :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function findUserByBookId($book_id) {
        // SQL query to find user by book_id
        $this->db->query('SELECT u.user_name AS book_owner, u.user_phone AS contact_number, u.user_address AS city
        FROM user u, book b
        WHERE u.user_id = b.owner_id AND b.book_id = :book_id');
        
        // Bind the correct parameter book_id
        $this->db->bind(':book_id', $book_id);
        
        // Return the result
        return $this->db->single();
    }
    
    
    public function registerUser($data)
    {
        // First pass - just insert user with OTP info but without verification
        $this->db->query('INSERT INTO user(user_name, user_photo, user_email, user_password, user_phone, user_address, user_role, user_otp, user_otp_expires, user_is_verified) 
            VALUES (:user_name, :user_photo, :user_email, :user_password, :user_phone, :user_address, :user_role, :user_otp, :user_otp_expires, 0)');

        $this->db->bind(':user_photo', $data['profile_image_name']);
        $this->db->bind(':user_name', $data['name']);
        $this->db->bind(':user_email', $data['email']);
        $this->db->bind(':user_password', $data['password']);
        $this->db->bind(':user_phone', $data['contactNumber']);
        $this->db->bind(':user_address', $data['address']);
        $this->db->bind(':user_role', 'parent');
        $this->db->bind(':user_otp', $data['otp']);
        $this->db->bind(':user_otp_expires', $data['otp_expires']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function login($email, $password)
    {
        $this->db->query('SELECT * FROM user WHERE user_email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        // Check if a row is returned
        if ($row) {
            $hashed_password = $row->user_password; // Use 'user_password' as per your DB

            if (password_verify($password, $hashed_password)) {
                // Check if user is verified
                if ($row->user_is_verified == 1) {
                    return $row; // Login successful for verified user
                } else {
                    return 'not_verified'; // User exists but not verified
                }
            }
        }

        return false; // Login failed
    }

    public function getAllUsers()
    {
        $this->db->query("SELECT * FROM user WHERE user_role='parent'");
        $results = $this->db->resultSet();
        return $results;
    }

    public function storeResetToken($email, $token, $expiry)
    {
        $sql = "UPDATE user SET reset_token = :token, token_expiry = :expiry WHERE user_email = :email";
        $this->db->query($sql);
        $this->db->bind(':token', $token);
        $this->db->bind(':expiry', $expiry);
        $this->db->bind(':email', $email);
        return $this->db->execute();
    }

    public function isValidToken($token)
    {
        $sql = "SELECT * FROM user WHERE reset_token = :token AND token_expiry > NOW()";
        $this->db->query($sql);
        $this->db->bind(':token', $token);
        return $this->db->single();
    }

    public function updatePasswordByToken($token, $hashedPassword)
    {
        $sql = "UPDATE user SET user_password = :password, reset_token = NULL, token_expiry = NULL WHERE reset_token = :token";
        $this->db->query($sql);
        $this->db->bind(':password', $hashedPassword);
        $this->db->bind(':token', $token);
        return $this->db->execute();
    }


    public function updateUserProfile($data)
    {
        if ($data['password']) {
            $sql = "UPDATE user SET user_name = :name, user_password = :password, user_phone = :phone, user_address = :address WHERE user_id = :id";
            $this->db->query($sql);
            $this->db->bind(':password', $data['password']);
        } else {
            $sql = "UPDATE user SET user_name = :name, user_phone = :phone, user_address = :address WHERE user_id = :id";
            $this->db->query($sql);
        }

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':phone', $data['contactNumber']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':id', $data['user_id']);

        return $this->db->execute();
    }

    public function getUserByEmail($email)
    {
        $this->db->query('SELECT * FROM user WHERE user_email= :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        // Check if row was returned
        if ($this->db->rowCount() > 0) {
            return $row; // Return the user object
        } else {
            return false; // Return false if no user found
        }
    }
    //user dashboard analytics
    public function getTokenCount($user_id)
    {
        $this->db->query('SELECT token_count FROM token WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
        
    }
    
    public function getTransactionCount($user_id)
    {
        $this->db->query('SELECT COUNT(transaction_id) AS transaction_count FROM transaction WHERE requester_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }
    
    

    public function getChildCount($user_id)
    {
        $this->db->query('SELECT COUNT(user_id) as user_count FROM user WHERE parent_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }

      public function getTransactionByBookAndUser($bookId, $userId) {
        $this->db->query("SELECT * FROM transaction WHERE book_id = :book_id AND requester_id = :user_id LIMIT 1");
        $this->db->bind(':book_id', $bookId);
        $this->db->bind(':user_id', $userId);
    
        return $this->db->single();
    } 



    public function getBookCount($user_id)
    {
        $this->db->query('SELECT COUNT(book_id) as book_count FROM book WHERE owner_id= :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }

    public function getUserCount()
    {
        $this->db->query('SELECT COUNT(*) as count FROM user');
        $row = $this->db->single();
        return $row->total ?? 0;
    }

    /**
     * Verify a user's OTP
     * 
     * @param string $email User's email
     * @param string $otp OTP to verify
     * @return bool Whether the OTP was valid
     */
    public function verifyOTP($email, $otp)
    {
        // Get the user's record to check OTP manually
        $this->db->query('SELECT * FROM user WHERE user_email = :email');
        $this->db->bind(':email', $email);
        $user = $this->db->single();

        if (!$user) {
            return false; // User not found
        }

        $currentTime = date('Y-m-d H:i:s');

        // Check if OTP matches and is not expired
        if ($user->user_otp == $otp && strtotime($user->user_otp_expires) > strtotime($currentTime)) {
            // Valid OTP - mark user as verified
            $this->db->query('UPDATE user SET user_is_verified = 1, user_otp = NULL, user_otp_expires = NULL WHERE user_email = :email');
            $this->db->bind(':email', $email);
            $this->db->execute();
            return true;
        }

        return false; // Invalid or expired OTP
    }

    /**
     * Resend OTP to a user
     * 
     * @param string $email User's email
     * @param string $otp New OTP
     * @param string $otp_expires Expiry timestamp
     * @return bool Whether the OTP was updated successfully
     */
    public function resendOTP($email, $otp, $otp_expires)
    {
        $this->db->query('UPDATE user SET user_otp = :otp, user_otp_expires = :otp_expires WHERE user_email = :email AND user_is_verified = 0');
        $this->db->bind(':otp', $otp);
        $this->db->bind(':otp_expires', $otp_expires);
        $this->db->bind(':email', $email);

        return $this->db->execute();
    }

    /**
     * Get unverified user by email
     * 
     * @param string $email User's email
     * @return object|false User object or false if not found
     */
    public function getUnverifiedUserByEmail($email)
    {
        $this->db->query('SELECT * FROM user WHERE user_email = :email AND user_is_verified = 0');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }
}
