<?php
class M_Payments {
    private $db;
    private $merchantSecret; // Add class property

    public function __construct() {
        $this->db = new Database();
        $this->merchantSecret = 'MTMyNjg4MjE4NjI0OTYwOTkzNjIxMTE2OTQ2NDUyMTA2NTg2NDY0NQ=='; // Set secret directly
    }

    public function addPayment($data) {
        $this->db->query('
            INSERT INTO payments 
            (order_id, payment_id, user_id, amount, currency, status) 
            VALUES (:order_id, :payment_id, :user_id, :amount, :currency, :status)
        ');

        // Bind parameters
        $this->db->bind(':order_id', $data['order_id']);
        $this->db->bind(':payment_id', $data['payment_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':currency', $data['currency']);
        $this->db->bind(':status', $data['status']);

        return $this->db->execute();
    }

    public function getMerchantSecret() {
        return $this->merchantSecret; // Return stored secret
    }
}
?>