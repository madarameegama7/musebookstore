<?php
class M_Notifications{
    private $db;

    public function __construct(){
        $this->db=new Database();
    }

    public function createNotification($data) {
        $this->db->query("INSERT INTO `notification` 
            (user_id, message, transaction_id) 
            VALUES (:user_id, :message, :transaction_id)");
    
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':message', $data['message']);
        $this->db->bind(':transaction_id', $data['transaction_id']);
    
        return $this->db->execute();
    }

    public function getNotifications($userId){
        $this->db->query("SELECT * FROM notification WHERE user_id = :user_id");
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    
}
?>