<?php
class M_Admin
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Get total count of all users
    public function getUserCount() {
        $this->db->query('SELECT COUNT(*) as count FROM user');
        $row = $this->db->single();
        return $row->count ?? 0; // Return 0 if no users
    }

    // Get total count of all books
    public function getBookCount() {
        $this->db->query('SELECT COUNT(*) as count FROM book');
        $row = $this->db->single();
        return $row->count ?? 0; // Return 0 if no books
    }

    // Get all users with basic details
    public function getAllUsers() {
        $this->db->query('SELECT user_id, user_name, user_email, user_role FROM user ORDER BY user_role, user_name');
        return $this->db->resultSet();
    }

    // Get all books with owner details
    public function getAllBooks() {
        $this->db->query('SELECT b.*, u.user_name as owner_name 
                          FROM book b 
                          JOIN user u ON b.owner_id = u.user_id 
                          ORDER BY b.created_at DESC'); // Corrected JOIN condition and used created_at for sorting
        return $this->db->resultSet();
    }

    // Add more methods as needed (e.g., deleteUser, deleteBook, updateBookStatus etc.)
}
