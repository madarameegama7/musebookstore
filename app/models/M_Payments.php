<?php
class M_Payments {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function addPayment($data) {
        $this->db->query('
            INSERT INTO payment 
            (user_id, amount, currency, status) 
            VALUES (:user_id, :amount, :currency, :status)
        ');

        // Bind parameters
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':currency', $data['currency']);
        $this->db->bind(':status', $data['status']);

        return $this->db->execute();
    }

    public function getTokenByUserId($user_id) {
        $this->db->query('SELECT * FROM token WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }
    
    public function updateToken($user_id, $token_count, $amount_paid) {
        $this->db->query('UPDATE token 
                          SET token_count = token_count + :token_count, 
                              amount_paid = amount_paid + :amount_paid, 
                              purchase_date = CURDATE()
                          WHERE user_id = :user_id');
        $this->db->bind(':token_count', $token_count);
        $this->db->bind(':amount_paid', $amount_paid);
        $this->db->bind(':user_id', $user_id);
    
        return $this->db->execute();
    }
    
    public function addToken($user_id, $token_count, $amount_paid) {
        $this->db->query('INSERT INTO token (user_id, token_count, amount_paid, purchase_date)
                          VALUES (:user_id, :token_count, :amount_paid, CURDATE())');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':token_count', $token_count);
        $this->db->bind(':amount_paid', $amount_paid);
    
        return $this->db->execute();
    }
    

}
?>