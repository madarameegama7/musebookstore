<?php

/**
 * Admin Reports Model
 * Handles database operations for generating admin reports
 */
class M_Reports
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * Get user registration statistics by date range
     */
    public function getUserRegistrationStats($startDate, $endDate)
    {
        $this->db->query("SELECT 
                            DATE(created_at) as registration_date, 
                            COUNT(*) as user_count,
                            SUM(CASE WHEN user_role = 'parent' THEN 1 ELSE 0 END) as parent_count,
                            SUM(CASE WHEN user_role = 'child' THEN 1 ELSE 0 END) as child_count,
                            SUM(CASE WHEN user_role = 'ambassador' THEN 1 ELSE 0 END) as ambassador_count
                          FROM user 
                          WHERE created_at BETWEEN :start_date AND :end_date
                          GROUP BY DATE(created_at)
                          ORDER BY registration_date");

        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);

        return $this->db->resultSet();
    }

    /**
     * Get book listing statistics by date range
     */
    public function getBookListingStats($startDate, $endDate)
    {
        $this->db->query("SELECT 
                            DATE(created_at) as listing_date,
                            COUNT(*) as book_count,
                            SUM(CASE WHEN listing_type = 'sell' THEN 1 ELSE 0 END) as sell_count,
                            SUM(CASE WHEN listing_type = 'swap' THEN 1 ELSE 0 END) as swap_count,
                            SUM(CASE WHEN book_condition = 'new' THEN 1 ELSE 0 END) as new_condition_count,
                            SUM(CASE WHEN book_condition = 'used' THEN 1 ELSE 0 END) as used_condition_count,
                            SUM(CASE WHEN child_safe = 'yes' THEN 1 ELSE 0 END) as child_safe_count
                          FROM book
                          WHERE created_at BETWEEN :start_date AND :end_date
                          GROUP BY DATE(created_at)
                          ORDER BY listing_date");

        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);

        return $this->db->resultSet();
    }

    /**
     * Get transaction statistics by date range
     */
    public function getTransactionStats($startDate, $endDate)
    {
        $this->db->query("SELECT 
                            DATE(t.created_at) as transaction_date,
                            COUNT(*) as transaction_count,
                            SUM(CASE WHEN t.type = 'sell' THEN 1 ELSE 0 END) as sell_count,
                            SUM(CASE WHEN t.type = 'swap' THEN 1 ELSE 0 END) as swap_count,
                            SUM(CASE WHEN t.status = 'pending' THEN 1 ELSE 0 END) as pending_count,
                            SUM(CASE WHEN t.status = 'approved' THEN 1 ELSE 0 END) as approved_count,
                            SUM(CASE WHEN t.status = 'declined' THEN 1 ELSE 0 END) as declined_count,
                            SUM(CASE WHEN t.status = 'completed' THEN 1 ELSE 0 END) as completed_count
                          FROM transaction t
                          WHERE t.created_at BETWEEN :start_date AND :end_date
                          GROUP BY DATE(t.created_at)
                          ORDER BY transaction_date");

        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);

        return $this->db->resultSet();
    }

    /**
     * Get financial statistics by date range
     */
    public function getFinancialStats($startDate, $endDate)
    {
        $this->db->query("SELECT 
                            DATE(p.created_at) as payment_date,
                            COUNT(*) as payment_count,
                            SUM(p.amount) as total_amount,
                            SUM(CASE WHEN p.transaction_id IS NOT NULL THEN p.amount ELSE 0 END) as book_sales,
                            SUM(CASE WHEN p.transaction_id IS NULL THEN p.amount ELSE 0 END) as token_sales,
                            SUM(CASE WHEN p.status = 'completed' THEN p.amount ELSE 0 END) as completed_amount
                          FROM payment p
                          WHERE p.created_at BETWEEN :start_date AND :end_date
                          GROUP BY DATE(p.created_at)
                          ORDER BY payment_date");

        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);

        return $this->db->resultSet();
    }

    /**
     * Get token usage statistics by date range
     */
    public function getTokenStats($startDate, $endDate)
    {
        $this->db->query("SELECT 
                            DATE(updated_at) as token_date,
                            SUM(token_count) as total_tokens,
                            SUM(amount_paid) as total_amount,
                            COUNT(DISTINCT user_id) as unique_users
                          FROM token
                          WHERE updated_at BETWEEN :start_date AND :end_date
                          GROUP BY DATE(updated_at)
                          ORDER BY token_date");

        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);

        return $this->db->resultSet();
    }

    /**
     * Get book requests statistics by date range
     */
    public function getBookRequestStats($startDate, $endDate)
    {
        $this->db->query("SELECT 
                            DATE(br.created_at) as request_date,
                            COUNT(*) as request_count,
                            SUM(CASE WHEN br.status = 'pending' THEN 1 ELSE 0 END) as pending_count,
                            SUM(CASE WHEN br.status = 'approved' THEN 1 ELSE 0 END) as approved_count,
                            SUM(CASE WHEN br.status = 'denied' THEN 1 ELSE 0 END) as denied_count,
                            COUNT(DISTINCT br.child_id) as unique_children
                          FROM book_request br
                          WHERE br.created_at BETWEEN :start_date AND :end_date
                          GROUP BY DATE(br.created_at)
                          ORDER BY request_date");

        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);

        return $this->db->resultSet();
    }

    /**
     * Get detailed user report
     */
    public function getUserReport()
    {
        $this->db->query("SELECT 
                            u.user_id, 
                            u.user_name, 
                            u.user_email, 
                            u.user_role, 
                            u.created_at,
                            u.user_is_verified,
                            p.user_name as parent_name,
                            (SELECT COUNT(*) FROM book WHERE owner_id = u.user_id) as book_count,
                            (SELECT COUNT(*) FROM transaction WHERE requester_id = u.user_id) as transaction_count,
                            (SELECT COALESCE(SUM(token_count), 0) FROM token WHERE user_id = u.user_id) as token_count
                          FROM user u
                          LEFT JOIN user p ON u.parent_id = p.user_id
                          ORDER BY u.created_at DESC");

        return $this->db->resultSet();
    }

    /**
     * Get detailed book report
     */
    public function getBookReport()
    {
        $this->db->query("SELECT 
                            b.book_id, 
                            b.book_title, 
                            b.book_author, 
                            b.book_genre, 
                            b.book_condition, 
                            b.book_price, 
                            b.listing_type, 
                            b.book_status, 
                            b.created_at,
                            b.child_safe,
                            u.user_name as owner_name,
                            u.user_role as owner_role,
                            (SELECT COUNT(*) FROM book_favorites WHERE book_id = b.book_id) as favorite_count,
                            (SELECT COUNT(*) FROM book_comments WHERE book_id = b.book_id) as comment_count,
                            (SELECT COUNT(*) FROM transaction WHERE book_id = b.book_id) as transaction_count
                          FROM book b
                          JOIN user u ON b.owner_id = u.user_id
                          ORDER BY b.created_at DESC");

        return $this->db->resultSet();
    }

    /**
     * Get detailed transaction report
     */
    public function getTransactionReport()
    {
        $this->db->query("SELECT 
                            t.transaction_id, 
                            t.type, 
                            t.status, 
                            t.created_at,
                            t.updated_at,
                            b.book_title,
                            b.book_price,
                            b.listing_type,
                            req.user_name as requester_name,
                            owner.user_name as owner_name,
                            (SELECT COUNT(*) FROM payment WHERE transaction_id = t.transaction_id) as has_payment
                          FROM transaction t
                          JOIN book b ON t.book_id = b.book_id
                          JOIN user req ON t.requester_id = req.user_id
                          JOIN user owner ON t.owner_id = owner.user_id
                          ORDER BY t.created_at DESC");

        return $this->db->resultSet();
    }

    /**
     * Get detailed payment report
     */
    public function getPaymentReport()
    {
        $this->db->query("SELECT 
                            p.payment_id, 
                            p.amount, 
                            p.currency, 
                            p.status, 
                            p.created_at,
                            p.order_id,
                            u.user_name,
                            u.user_email,
                            CASE WHEN p.transaction_id IS NOT NULL THEN 'Book Purchase' ELSE 'Token Purchase' END as payment_type,
                            t.transaction_id,
                            b.book_title
                          FROM payment p
                          JOIN user u ON p.user_id = u.user_id
                          LEFT JOIN transaction t ON p.transaction_id = t.transaction_id
                          LEFT JOIN book b ON t.book_id = b.book_id
                          ORDER BY p.created_at DESC");

        return $this->db->resultSet();
    }
}
