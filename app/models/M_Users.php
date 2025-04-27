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

    public function registerUser($data){
        $this->db->query('INSERT INTO user(user_name,user_photo,user_email,user_password, user_phone, user_address,user_role) VALUES (:user_name, :user_photo, :user_email, :user_password, :user_phone, :user_address, :user_role) ');
        $this->db->bind(':user_photo',$data['profile_image_name']);
        $this->db->bind(':user_name',$data['name']);
        $this->db->bind(':user_email',$data['email']);
        $this->db->bind(':user_password',$data['password']);
        $this->db->bind(':user_phone',$data['contactNumber']);
        $this->db->bind(':user_address',$data['address']);
        $this->db->bind(':user_role', 'parent'); 

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
                return $row; // Login successful
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


    public function updateUserProfile($data) {
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
    public function getTokenCount($user_id){
        $this->db->query('SELECT token_count FROM token WHERE user_id= :user_id');
        $this->db->bind(':user_id',$user_id);
        return $this->db->single();

    }
    public function getChildCount($user_id){
        $this->db->query('SELECT COUNT(*) AS total FROM user WHERE parent_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $row = $this->db->single();
        return $row->total ?? 0;
    }
    
    
    public function getBookCount($user_id){
        $this->db->query('SELECT COUNT(book_id) FROM book WHERE owner_id= :user_id');
        $this->db->bind(':owner_id',$user_id);
        $results = $this->db->resultSet();
        return $this->db->single();
    }
    public function getUserCount()
    {
        $this->db->query('SELECT COUNT(*) as count FROM user');
        $row = $this->db->single();
    }
}
