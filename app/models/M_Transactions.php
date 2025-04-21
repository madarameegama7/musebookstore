<?php
class M_Transactions{
    private $db;

    public function __construct(){
        $this->db=new Database();
    }
    
    public function createSwapTransaction($bookId, $buyerId, $sellerId) {
        $this->db->query("INSERT INTO `transaction` (book_id, requester_id, owner_id, type) 
                          VALUES (:book_id, :requester_id, :owner_id, 'swap')");
    
        $this->db->bind(':book_id', $bookId);
        $this->db->bind(':requester_id', $buyerId);
        $this->db->bind(':owner_id', $sellerId);
    
        if ($this->db->execute()) {
            return $this->db->lastInsertId(); // return the new transaction_id
        } else {
            return false;
        }
    }
    public function getTransactionByBookAndUser($bookId, $userId) {
        $this->db->query("SELECT * FROM transaction WHERE book_id = :book_id AND requester_id = :user_id LIMIT 1");
        $this->db->bind(':book_id', $bookId);
        $this->db->bind(':user_id', $userId);
    
        return $this->db->single();  // Return the entire transaction object
    }    
    
    
}
?>