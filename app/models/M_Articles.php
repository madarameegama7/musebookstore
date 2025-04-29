<?php

class M_Articles {
    private $db;

    public function __construct() {
        $this->db = new Database();
        
        // Create articles table if it doesn't exist
        $this->createTableIfNotExists();
    }

    
    private function createTableIfNotExists() {
        $sql = "CREATE TABLE IF NOT EXISTS `articles` (
            `article_id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `title` varchar(255) NOT NULL,
            `content` text NOT NULL,
            `image_url` varchar(255) DEFAULT NULL,
            `status` enum('published','draft') DEFAULT 'published',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`article_id`),
            KEY `user_id` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        
        $this->db->query($sql);
        $this->db->execute();
    }

    


     
    public function addArticle($userId, $title, $content, $imageUrl = null, $status = 'published') {
        $this->db->query('INSERT INTO articles (user_id, title, content, image_url, status) 
                          VALUES (:user_id, :title, :content, :image_url, :status)');
        
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':title', $title);
        $this->db->bind(':content', $content);
        $this->db->bind(':image_url', $imageUrl);
        $this->db->bind(':status', $status);
        
        if($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }


    public function updateArticle($articleId, $userId, $title, $content, $imageUrl = null, $status = 'published') {
        $this->db->query('UPDATE articles 
                          SET title = :title, content = :content, 
                              image_url = :image_url, status = :status
                          WHERE article_id = :article_id AND user_id = :user_id');
        
        $this->db->bind(':title', $title);
        $this->db->bind(':content', $content);
        $this->db->bind(':image_url', $imageUrl);
        $this->db->bind(':status', $status);
        $this->db->bind(':article_id', $articleId);
        $this->db->bind(':user_id', $userId);
        
        return $this->db->execute();
    }

    
    public function deleteArticle($articleId, $userId) {
        $this->db->query('DELETE FROM articles 
                          WHERE article_id = :article_id AND user_id = :user_id');
        
        $this->db->bind(':article_id', $articleId);
        $this->db->bind(':user_id', $userId);
        
        return $this->db->execute();
    }

   
    public function getAllArticles($limit = null, $offset = 0) {
        $sql = 'SELECT a.*, u.user_name as author_name 
                FROM articles a
                JOIN user u ON a.user_id = u.user_id
                WHERE a.status = "published"
                ORDER BY a.created_at DESC';
        
        if($limit !== null) {
            $sql .= ' LIMIT :offset, :limit';
        }
        
        $this->db->query($sql);
        
        if($limit !== null) {
            $this->db->bind(':offset', $offset);
            $this->db->bind(':limit', $limit);
        }
        
        return $this->db->resultSet();
    }

  
    public function getArticlesByUser($userId) {
        $this->db->query('SELECT a.*, u.user_name as author_name 
                          FROM articles a
                          JOIN user u ON a.user_id = u.user_id
                          WHERE a.user_id = :user_id
                          ORDER BY a.created_at DESC');
        
        $this->db->bind(':user_id', $userId);
        
        return $this->db->resultSet();
    }


    public function getArticleById($articleId) {
        $this->db->query('SELECT a.*, u.user_name as author_name 
                          FROM articles a
                          JOIN user u ON a.user_id = u.user_id
                          WHERE a.article_id = :article_id');
        
        $this->db->bind(':article_id', $articleId);
        
        return $this->db->single();
    }

    
    public function countArticles() {
        $this->db->query('SELECT COUNT(*) as total FROM articles WHERE status = "published"');
        $row = $this->db->single();
        return $row->total;
    }
}
?>
