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
            (user_id, requester_id, message, transaction_id) 
            VALUES (:user_id, :requester_id, :message, :transaction_id)");

        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':requester_id', $data['requester_id']);
        $this->db->bind(':message', $data['message']);
        $this->db->bind(':transaction_id', $data['transaction_id']);

        return $this->db->execute();
    }
   public function getNotifications($userId)
{
    $this->db->query("SELECT n.*, b.*,
                             t.requester_id, t.status AS status,
                             t.created_at AS requested_date,
                             u.user_name AS sender_name, 
                             u.user_address AS city,
                             u.user_phone AS contact_number,
                             b.book_title AS available_books
                      FROM notification n
                      JOIN transaction t ON n.transaction_id = t.transaction_id
                      JOIN user u ON u.user_id = t.requester_id
                      JOIN book b ON b.book_id = t.book_id
                      WHERE n.user_id = :user_id
                      ORDER BY t.created_at DESC");

    $this->db->bind(':user_id', $userId);
    return $this->db->resultSet();
}

    
    


}
?>