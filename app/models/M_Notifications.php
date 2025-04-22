<?php
class M_Notifications
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function createNotification($data)
    {
        $this->db->query("INSERT INTO `notification` 
            (user_id, message, transaction_id) 
            VALUES (:user_id, :message, :transaction_id)");

        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':message', $data['message']);
        $this->db->bind(':transaction_id', $data['transaction_id']);

        return $this->db->execute();
    }
    public function getNotifications($userId)
    {
        $this->db->query("SELECT n.*, 
                                 t.requester_id, 
                                 t.created_at AS requested_date,
                                 u.user_name AS sender_name, 
                                 u.user_address AS city,
                                 u.user_phone AS contact_number,
                                 GROUP_CONCAT(b.book_title SEPARATOR '\n') AS available_books
                          FROM notification n
                          JOIN transaction t ON n.transaction_id = t.transaction_id
                          JOIN user u ON u.user_id = t.requester_id
                          JOIN book b ON b.owner_id = t.requester_id
                          WHERE n.user_id = :user_id
                          GROUP BY n.notification_id, t.requester_id, u.user_name");
    
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
    
    


}
?>