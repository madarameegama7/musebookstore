<?php
/**
 * Comments Model
 * Handles database operations for book comments
 */
class M_Comments {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Add a new comment to a book
     * @param int $bookId The book ID
     * @param int $userId The user ID
     * @param string $comment The comment text
     * @return bool True if successful, false otherwise
     */
    public function addComment($bookId, $userId, $comment) {
        $this->db->query('INSERT INTO book_comments (book_id, user_id, comment) 
                          VALUES (:book_id, :user_id, :comment)');
        
        $this->db->bind(':book_id', $bookId);
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':comment', $comment);
        
        return $this->db->execute();
    }

    /**
     * Get all comments for a specific book
     * @param int $bookId The book ID
     * @return array Comments for the book
     */
    public function getCommentsByBook($bookId) {
        $this->db->query('SELECT c.*, u.user_name as user_name 
                          FROM book_comments c
                          JOIN user u ON c.user_id = u.user_id
                          WHERE c.book_id = :book_id
                          ORDER BY c.created_at DESC');
        
        $this->db->bind(':book_id', $bookId);
        
        return $this->db->resultSet();
    }

    /**
     * Delete a comment
     * @param int $commentId The comment ID
     * @param int $userId The user ID (for verification)
     * @return bool True if successful, false otherwise
     */
    public function deleteComment($commentId, $userId) {
        $this->db->query('DELETE FROM book_comments 
                          WHERE id = :id AND user_id = :user_id');
        
        $this->db->bind(':id', $commentId);
        $this->db->bind(':user_id', $userId);
        
        return $this->db->execute();
    }

    /**
     * Get a comment by ID
     * @param int $commentId The comment ID
     * @return object|false The comment object or false if not found
     */
    public function getCommentById($commentId) {
        $this->db->query('SELECT * FROM book_comments WHERE id = :id');
        $this->db->bind(':id', $commentId);
        
        return $this->db->single();
    }
    
    /**
     * Update a comment
     * @param int $commentId The comment ID
     * @param int $userId The user ID (for verification)
     * @param string $comment The updated comment text
     * @return bool True if successful, false otherwise
     */
    public function updateComment($commentId, $userId, $comment) {
        $this->db->query('UPDATE book_comments 
                          SET comment = :comment
                          WHERE id = :id AND user_id = :user_id');
        
        $this->db->bind(':comment', $comment);
        $this->db->bind(':id', $commentId);
        $this->db->bind(':user_id', $userId);
        
        return $this->db->execute();
    }
}
?>
