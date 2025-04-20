<?php
class M_Admin
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Get total count of all users
    public function getUserCount()
    {
        $this->db->query('SELECT COUNT(*) as count FROM user');
        $row = $this->db->single();
        return $row->count ?? 0; // Return 0 if no users
    }

    // Get total count of all books
    public function getBookCount()
    {
        $this->db->query('SELECT COUNT(*) as count FROM book');
        $row = $this->db->single();
        return $row->count ?? 0; // Return 0 if no books
    }

    // Get all users with basic details
    public function getAllUsers()
    {
        $this->db->query('SELECT user_id, user_name, user_email, user_role FROM user ORDER BY user_role, user_name');
        return $this->db->resultSet();
    }

    // Get all books with owner details
    public function getAllBooks()
    {
        $this->db->query('SELECT b.*, u.user_name as owner_name 
                          FROM book b 
                          JOIN user u ON b.owner_id = u.user_id 
                          ORDER BY b.created_at DESC'); // Corrected JOIN condition and used created_at for sorting
        return $this->db->resultSet();
    }

    // Get a single user by ID
    public function getUserById($userId)
    {
        $this->db->query('SELECT * FROM user WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        $row = $this->db->single();
        return $row;
    }

    // Update user role
    public function updateUserRole($userId, $role)
    {
        $this->db->query('UPDATE user SET user_role = :user_role WHERE user_id = :user_id');
        $this->db->bind(':user_role', $role);
        $this->db->bind(':user_id', $userId);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Update user details (excluding password and role here, role is separate)
    public function updateUser($data)
    {
        $this->db->query('UPDATE user SET user_name = :user_name, user_email = :user_email, user_address = :user_address, user_phone = :user_phone WHERE user_id = :user_id');
        $this->db->bind(':user_name', $data['name']);
        $this->db->bind(':user_email', $data['email']);
        $this->db->bind(':user_address', $data['address']);
        $this->db->bind(':user_phone', $data['contactNumber']);
        $this->db->bind(':user_id', $data['user_id']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Update book details
    public function updateBook($data)
    {
        $this->db->query('UPDATE book SET 
                            book_title = :book_title, 
                            book_author = :book_author, 
                            book_genre = :book_genre, 
                            book_condition = :book_condition, 
                            book_price = :book_price, 
                            listing_type = :listing_type, 
                            book_publisher = :book_publisher, 
                            book_published_year = :book_published_year, 
                            book_ISBN = :book_ISBN 
                          WHERE book_id = :book_id');

        $this->db->bind(':book_title', $data['booktitle']);
        $this->db->bind(':book_author', $data['author']);
        $this->db->bind(':book_genre', $data['genre']);
        $this->db->bind(':book_condition', $data['bookcondition']);
        $this->db->bind(':book_price', $data['price']);
        $this->db->bind(':listing_type', $data['bookoption']);
        $this->db->bind(':book_publisher', $data['publisher']);
        $this->db->bind(':book_published_year', $data['year']);
        $this->db->bind(':book_ISBN', $data['isbn']);
        $this->db->bind(':book_id', $data['bookid']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Delete a user by ID
    public function deleteUserById($userId)
    {
        // Prevent admin from deleting themselves
        if ($userId == $_SESSION['user_id']) {
            return false;
        }
        $this->db->query('DELETE FROM user WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Get a single book by ID with owner details
    public function getBookById($bookId)
    {
        $this->db->query('SELECT b.*, u.user_name as owner_name, u.user_email as owner_email
                          FROM book b
                          JOIN user u ON b.owner_id = u.user_id
                          WHERE b.book_id = :book_id');
        $this->db->bind(':book_id', $bookId);
        $row = $this->db->single();
        return $row;
    }

    // Delete a book by ID
    public function deleteBookById($bookId)
    {
        $this->db->query('DELETE FROM book WHERE book_id = :book_id');
        $this->db->bind(':book_id', $bookId);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Create a new user (Admin version)
    public function createUser($data)
    {
        $this->db->query('INSERT INTO user(user_name, user_email, user_password, user_role, user_address, user_phone, parent_id) 
                          VALUES (:user_name, :user_email, :user_password, :user_role, :user_address, :user_phone, :parent_id)');
        $this->db->bind(':user_name', $data['name']);
        $this->db->bind(':user_email', $data['email']);
        $this->db->bind(':user_password', $data['password']); // Password should be hashed in controller
        $this->db->bind(':user_role', $data['role']);
        $this->db->bind(':user_address', $data['address']);
        $this->db->bind(':user_phone', $data['contactNumber']);
        // Handle parent_id for child accounts if role is child, otherwise NULL
        $this->db->bind(':parent_id', ($data['role'] === 'child' && !empty($data['parent_id'])) ? $data['parent_id'] : null);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Create a new book (Admin version - requires owner_id)
    public function createBook($data)
    {
        $this->db->query('INSERT INTO book(book_title, book_author, book_genre, book_condition, book_price, listing_type, owner_id, book_publisher, book_published_year, book_ISBN) 
                          VALUES(:book_title, :book_author, :book_genre, :book_condition, :book_price, :listing_type, :owner_id, :book_publisher, :book_published_year, :book_ISBN)');

        $this->db->bind(':book_title', $data['booktitle']);
        $this->db->bind(':book_author', $data['author']);
        $this->db->bind(':book_genre', $data['genre']);
        $this->db->bind(':book_condition', $data['bookcondition']);
        $this->db->bind(':book_price', $data['price']);
        $this->db->bind(':listing_type', $data['bookoption']);
        $this->db->bind(':owner_id', $data['owner_id']); // Admin specifies owner
        $this->db->bind(':book_publisher', $data['publisher']);
        $this->db->bind(':book_published_year', $data['year']);
        $this->db->bind(':book_ISBN', $data['isbn']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
