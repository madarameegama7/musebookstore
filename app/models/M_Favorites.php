<?php
/**
 * Favorites Model
 * Handles database operations for book favorites
 */
class M_Favorites {
    private $db;

    public function __construct() {
        $this->db = new Database();
        
        // Create favorites table if it doesn't exist
        $this->createTableIfNotExists();
    }

    /**
     * Create the favorites table if it doesn't exist
     */
    private function createTableIfNotExists() {
        $sql = "CREATE TABLE IF NOT EXISTS `book_favorites` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `book_id` int(11) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `user_book_unique` (`user_id`, `book_id`),
            KEY `user_id` (`user_id`),
            KEY `book_id` (`book_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        
        $this->db->query($sql);
        $this->db->execute();
    }

    /**
     * Add a book to user's favorites
     * @param int $userId The user ID
     * @param int $bookId The book ID
     * @return bool True if successful, false otherwise
     */
    public function addFavorite($userId, $bookId) {
        // Check if already in favorites to avoid unique constraint error
        if ($this->isBookFavorited($userId, $bookId)) {
            return true;
        }
        
        $this->db->query('INSERT INTO book_favorites (user_id, book_id) 
                          VALUES (:user_id, :book_id)');
        
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':book_id', $bookId);
        
        return $this->db->execute();
    }

    /**
     * Remove a book from user's favorites
     * @param int $userId The user ID
     * @param int $bookId The book ID
     * @return bool True if successful, false otherwise
     */
    public function removeFavorite($userId, $bookId) {
        $this->db->query('DELETE FROM book_favorites 
                          WHERE user_id = :user_id AND book_id = :book_id');
        
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':book_id', $bookId);
        
        return $this->db->execute();
    }

    /**
     * Check if a book is in user's favorites
     * @param int $userId The user ID
     * @param int $bookId The book ID
     * @return bool True if book is in favorites, false otherwise
     */
    public function isBookFavorited($userId, $bookId) {
        $this->db->query('SELECT * FROM book_favorites 
                          WHERE user_id = :user_id AND book_id = :book_id');
        
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':book_id', $bookId);
        
        $row = $this->db->single();
        
        return $row ? true : false;
    }

    /**
     * Get all favorite books for a user
     * @param int $userId The user ID
     * @return array Array of favorite books with book details
     */
    public function getFavoriteBooks($userId) {
        $this->db->query('SELECT b.* FROM book_favorites f
                          JOIN book b ON f.book_id = b.book_id
                          WHERE f.user_id = :user_id
                          ORDER BY f.created_at DESC');
        
        $this->db->bind(':user_id', $userId);
        
        return $this->db->resultSet();
    }
}
?>
