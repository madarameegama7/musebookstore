<?php
class M_Child{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }
    
    // Create a child account (called by parent)
    public function createChild($data){
        $this->db->query('INSERT INTO user(user_name, user_email, user_password, user_role, parent_id) VALUES(:user_name, :user_email, :user_password, :user_role, :parent_id)');
        $this->db->bind(':user_name', $data['name']);
        $this->db->bind(':user_email', $data['email']);
        $this->db->bind(':user_password', $data['password']);
        $this->db->bind(':user_role', 'child');
        $this->db->bind(':parent_id', $data['parent_id']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
    
    // Get all children for a parent
    public function getChildrenByParent($parentId){
        $this->db->query('SELECT * FROM user WHERE parent_id = :parent_id AND user_role = "child"');
        $this->db->bind(':parent_id', $parentId);
        return $this->db->resultSet();
    }
    
    // Check if email already exists
    public function findChildByEmail($email){
        $this->db->query('SELECT * FROM user WHERE user_email = :email');
        $this->db->bind(':email', $email);
        
        $row = $this->db->single();
        
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }
    
    // Request a book (called by child)
    public function requestBook($childId, $bookId){
        $this->db->query('INSERT INTO book_request(child_id, book_id) VALUES(:child_id, :book_id)');
        $this->db->bind(':child_id', $childId);
        $this->db->bind(':book_id', $bookId);
        
        return $this->db->execute();
    }
    
    // Get all requests by a child
    public function getRequestsByChild($childId){
        $this->db->query('SELECT br.*, b.book_title, b.book_author, b.book_genre 
                         FROM book_request br 
                         JOIN book b ON br.book_id = b.book_id 
                         WHERE br.child_id = :child_id 
                         ORDER BY br.created_at DESC');
        $this->db->bind(':child_id', $childId);
        return $this->db->resultSet();
    }
    
    // Get all requests for a parent's children
    public function getRequestsByParent($parentId){
        $this->db->query('SELECT br.*, b.book_title, b.book_author, u.user_name as child_name
                         FROM book_request br 
                         JOIN book b ON br.book_id = b.book_id 
                         JOIN user u ON br.child_id = u.user_id
                         WHERE u.parent_id = :parent_id
                         ORDER BY br.created_at DESC');
        $this->db->bind(':parent_id', $parentId);
        return $this->db->resultSet();
    }
    
    // Update request status (approve/deny)
    public function updateRequestStatus($requestId, $status){
        $this->db->query('UPDATE book_request SET status = :status, updated_at = NOW() WHERE request_id = :request_id');
        $this->db->bind(':status', $status);
        $this->db->bind(':request_id', $requestId);
        
        return $this->db->execute();
    }
    
    // Create notification for child when request is approved/denied
    public function createNotification($childId, $message){
        $this->db->query('INSERT INTO notification(user_id, message) VALUES(:user_id, :message)');
        $this->db->bind(':user_id', $childId);
        $this->db->bind(':message', $message);
        
        return $this->db->execute();
    }
    
    // Check if child belongs to parent
    public function verifyChildParent($childId, $parentId){
        $this->db->query('SELECT * FROM user WHERE user_id = :child_id AND parent_id = :parent_id');
        $this->db->bind(':child_id', $childId);
        $this->db->bind(':parent_id', $parentId);
        
        $row = $this->db->single();
        
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }
    
    // Get a user by ID
    public function getUserById($userId){
        $this->db->query('SELECT * FROM user WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }
    
    // Update a child account
    public function updateChild($data){
        $this->db->query('UPDATE user SET user_name = :name, user_email = :email, updated_at = NOW() WHERE user_id = :id');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':id', $data['id']);
        
        return $this->db->execute();
    }
    
    // Delete a child account and all associated requests
    public function deleteChild($childId){
        // Delete book requests first
        $this->db->query('DELETE FROM book_request WHERE child_id = :child_id');
        $this->db->bind(':child_id', $childId);
        $this->db->execute();
        
        // Delete notifications if table exists
        $this->db->query('DELETE FROM notification WHERE user_id = :user_id');
        $this->db->bind(':user_id', $childId);
        $this->db->execute();
        
        // Delete child user
        $this->db->query('DELETE FROM user WHERE user_id = :user_id AND user_role = "child"');
        $this->db->bind(':user_id', $childId);
        
        return $this->db->execute();
    }
    
    // Check if a book has been requested by a child and its status
    public function getBookRequestStatus($childId, $bookId){
        $this->db->query('SELECT * FROM book_request 
                         WHERE child_id = :child_id AND book_id = :book_id 
                         ORDER BY created_at DESC LIMIT 1');
        $this->db->bind(':child_id', $childId);
        $this->db->bind(':book_id', $bookId);
        
        return $this->db->single();
    }
    
    // Approve a book request
    public function approveRequest($requestId){
        // First get the request to get the child ID for notification
        $this->db->query('SELECT * FROM book_request WHERE request_id = :request_id');
        $this->db->bind(':request_id', $requestId);
        $request = $this->db->single();
        
        if(!$request){
            return false;
        }
        
        // Update the request status
        if($this->updateRequestStatus($requestId, 'approved')){
            // Create notification for the child
            $book = $this->getBookById($request->book_id);
            $message = "Your request for the book '{$book->book_title}' has been approved!";
            return $this->createNotification($request->child_id, $message);
        }
        
        return false;
    }
    
    // Deny a book request
    public function denyRequest($requestId){
        // First get the request to get the child ID for notification
        $this->db->query('SELECT * FROM book_request WHERE request_id = :request_id');
        $this->db->bind(':request_id', $requestId);
        $request = $this->db->single();
        
        if(!$request){
            return false;
        }
        
        // Update the request status
        if($this->updateRequestStatus($requestId, 'denied')){
            // Create notification for the child
            $book = $this->getBookById($request->book_id);
            $message = "Your request for the book '{$book->book_title}' has been denied.";
            return $this->createNotification($request->child_id, $message);
        }
        
        return false;
    }
    
    // Get book by ID (for notifications)
    private function getBookById($bookId){
        $this->db->query('SELECT * FROM book WHERE book_id = :book_id');
        $this->db->bind(':book_id', $bookId);
        return $this->db->single();
    }

}

?>