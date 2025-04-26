<?php
class M_Admin
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Get total count of all users
    public function getUserCount()
    {
        $this->db->query('SELECT COUNT(*) as count FROM user');
        $row = $this->db->single();
        return $row->count ?? 0; // Return 0 if no users
    }

    // Get total count of all books
    public function getBookCount()
    {
        $this->db->query('SELECT COUNT(*) as count FROM book');
        $row = $this->db->single();
        return $row->count ?? 0; // Return 0 if no books
    }

    // Get all users with basic details
    public function getAllUsers()
    {
        $this->db->query('SELECT user_id, user_name, user_email, user_role FROM user ORDER BY user_role, user_name');
        return $this->db->resultSet();
    }

    // Get all books with owner details
    public function getAllBooks()
    {
        $this->db->query('SELECT b.*, u.user_name as owner_name 
                          FROM book b 
                          JOIN user u ON b.owner_id = u.user_id 
                          ORDER BY b.created_at DESC'); // Corrected JOIN condition and used created_at for sorting
        return $this->db->resultSet();
    }

    // Get all communities with details
    public function getAllCommunities()
    {
        $this->db->query('SELECT * FROM community ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    // Get a single user by ID
    public function getUserById($userId)
    {
        $this->db->query('SELECT * FROM user WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        $row = $this->db->single();
        return $row;
    }

    // Update user role
    public function updateUserRole($userId, $role)
    {
        $this->db->query('UPDATE user SET user_role = :user_role WHERE user_id = :user_id');
        $this->db->bind(':user_role', $role);
        $this->db->bind(':user_id', $userId);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Update user details (excluding password and role here, role is separate)
    public function updateUser($data)
    {
        $this->db->query('UPDATE user SET user_name = :user_name, user_email = :user_email, user_address = :user_address, user_phone = :user_phone WHERE user_id = :user_id');
        $this->db->bind(':user_name', $data['name']);
        $this->db->bind(':user_email', $data['email']);
        $this->db->bind(':user_address', $data['address']);
        $this->db->bind(':user_phone', $data['contactNumber']);
        $this->db->bind(':user_id', $data['user_id']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Update book details
    public function updateBook($data)
    {
        $this->db->query('UPDATE book SET 
                            book_title = :book_title, 
                            book_author = :book_author, 
                            book_genre = :book_genre, 
                            book_condition = :book_condition, 
                            book_price = :book_price, 
                            listing_type = :listing_type, 
                            book_publisher = :book_publisher, 
                            book_published_year = :book_published_year, 
                            book_ISBN = :book_ISBN 
                          WHERE book_id = :book_id');

        $this->db->bind(':book_title', $data['booktitle']);
        $this->db->bind(':book_author', $data['author']);
        $this->db->bind(':book_genre', $data['genre']);
        $this->db->bind(':book_condition', $data['bookcondition']);
        $this->db->bind(':book_price', $data['price']);
        $this->db->bind(':listing_type', $data['bookoption']);
        $this->db->bind(':book_publisher', $data['publisher']);
        $this->db->bind(':book_published_year', $data['year']);
        $this->db->bind(':book_ISBN', $data['isbn']);
        $this->db->bind(':book_id', $data['bookid']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Delete a user by ID
    public function deleteUserById($userId)
    {
        // Prevent admin from deleting themselves
        if ($userId == $_SESSION['user_id']) {
            return false;
        }
        $this->db->query('DELETE FROM user WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Get a single book by ID with owner details
    public function getBookById($bookId)
    {
        $this->db->query('SELECT b.*, u.user_name as owner_name, u.user_email as owner_email
                          FROM book b
                          JOIN user u ON b.owner_id = u.user_id
                          WHERE b.book_id = :book_id');
        $this->db->bind(':book_id', $bookId);
        $row = $this->db->single();
        return $row;
    }

    // Delete a book by ID
    public function deleteBookById($bookId)
    {
        $this->db->query('DELETE FROM book WHERE book_id = :book_id');
        $this->db->bind(':book_id', $bookId);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Create a new user (Admin version)
    public function createUser($data)
    {
        $this->db->query('INSERT INTO user(user_name, user_email, user_password, user_role, user_address, user_phone, parent_id) 
                          VALUES (:user_name, :user_email, :user_password, :user_role, :user_address, :user_phone, :parent_id)');
        $this->db->bind(':user_name', $data['name']);
        $this->db->bind(':user_email', $data['email']);
        $this->db->bind(':user_password', $data['password']); // Password should be hashed in controller
        $this->db->bind(':user_role', $data['role']);
        $this->db->bind(':user_address', $data['address']);
        $this->db->bind(':user_phone', $data['contactNumber']);
        // Handle parent_id for child accounts if role is child, otherwise NULL
        $this->db->bind(':parent_id', ($data['role'] === 'child' && !empty($data['parent_id'])) ? $data['parent_id'] : null);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Create a new book (Admin version - requires owner_id)
    public function createBook($data)
    {
        $this->db->query('INSERT INTO book(book_title, book_author, book_genre, book_condition, book_price, listing_type, owner_id, book_publisher, book_published_year, book_ISBN) 
                          VALUES(:book_title, :book_author, :book_genre, :book_condition, :book_price, :listing_type, :owner_id, :book_publisher, :book_published_year, :book_ISBN)');

        $this->db->bind(':book_title', $data['booktitle']);
        $this->db->bind(':book_author', $data['author']);
        $this->db->bind(':book_genre', $data['genre']);
        $this->db->bind(':book_condition', $data['bookcondition']);
        $this->db->bind(':book_price', $data['price']);
        $this->db->bind(':listing_type', $data['bookoption']);
        $this->db->bind(':owner_id', $data['owner_id']); // Admin specifies owner
        $this->db->bind(':book_publisher', $data['publisher']);
        $this->db->bind(':book_published_year', $data['year']);
        $this->db->bind(':book_ISBN', $data['isbn']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Search users by name, email, or ID
    public function searchUsers($searchTerm)
    {
        $this->db->query('SELECT user_id, user_name, user_email, user_role 
                          FROM user 
                          WHERE user_id = :id_term 
                             OR user_name LIKE :name_term 
                             OR user_email LIKE :email_term
                          ORDER BY user_name');
        $likeTerm = '%' . $searchTerm . '%';
        $this->db->bind(':id_term', $searchTerm); // Exact match for ID
        $this->db->bind(':name_term', $likeTerm);
        $this->db->bind(':email_term', $likeTerm);
        return $this->db->resultSet();
    }

    // Search books by title, author, ISBN, or owner name/ID
    public function searchBooks($searchTerm)
    {
        $this->db->query('SELECT b.*, u.user_name as owner_name 
                          FROM book b 
                          JOIN user u ON b.owner_id = u.user_id 
                          WHERE b.book_id = :id_term
                             OR b.book_title LIKE :term
                             OR b.book_author LIKE :term
                             OR b.book_ISBN LIKE :term
                             OR u.user_name LIKE :term
                             OR b.owner_id = :owner_id_term
                          ORDER BY b.created_at DESC');
        $likeTerm = '%' . $searchTerm . '%';
        $this->db->bind(':id_term', $searchTerm); // Exact match for Book ID
        $this->db->bind(':term', $likeTerm);
        $this->db->bind(':owner_id_term', $searchTerm); // Exact match for Owner ID
        return $this->db->resultSet();
    }

    // Update community status (approve/reject)
    public function updateCommunityStatus($communityId, $status)
    {
        $this->db->query('UPDATE community SET status = :status WHERE communityId = :communityId');
        $this->db->bind(':status', $status);
        $this->db->bind(':communityId', $communityId);
        return $this->db->execute();
    }

    // Delete a community by ID
    public function deleteCommunityById($communityId)
    {
        $this->db->query('DELETE FROM community WHERE communityId = :communityId');
        $this->db->bind(':communityId', $communityId);
        return $this->db->execute();
    }

    // Get all transactions with book and user details
    public function getAllTransactions()
    {
        $this->db->query('SELECT t.*, b.book_title, b.book_author, u1.user_name AS requester_name, u2.user_name AS owner_name
                          FROM transaction t
                          JOIN book b ON t.book_id = b.book_id
                          JOIN user u1 ON t.requester_id = u1.user_id
                          JOIN user u2 ON t.owner_id = u2.user_id
                          ORDER BY t.created_at DESC');
        return $this->db->resultSet();
    }

    // Update transaction status (approve/decline/complete)
    public function updateTransactionStatus($transactionId, $status)
    {
        $this->db->query('UPDATE transaction SET status = :status WHERE transaction_id = :transaction_id');
        $this->db->bind(':status', $status);
        $this->db->bind(':transaction_id', $transactionId);
        return $this->db->execute();
    }

    // Delete a transaction
    public function deleteTransactionById($transactionId)
    {
        $this->db->query('DELETE FROM transaction WHERE transaction_id = :transaction_id');
        $this->db->bind(':transaction_id', $transactionId);
        return $this->db->execute();
    }

    // Get all writing groups with community info (show even if community is missing)
    public function getAllWritingGroups()
    {
        $this->db->query('SELECT wg.*, c.communityName FROM writinggroup wg LEFT JOIN community c ON wg.community_id = c.communityId ORDER BY wg.writingGroup_id DESC');
        return $this->db->resultSet();
    }

    // Delete a writing group by ID
    public function deleteWritingGroupById($writingGroupId)
    {
        $this->db->query('DELETE FROM writinggroup WHERE writingGroup_id = :writingGroup_id');
        $this->db->bind(':writingGroup_id', $writingGroupId);
        return $this->db->execute();
    }

    // Get all posts for all writing groups (with group and member info)
    public function getAllWritingGroupPosts()
    {
        $this->db->query('SELECT p.*, wg.writingGroup_name, cm.community_member_name FROM writing_group_posts p JOIN writinggroup wg ON p.writingGroup_id = wg.writingGroup_id LEFT JOIN community_member cm ON p.community_member_id = cm.community_member_id ORDER BY p.created_at DESC');
        return $this->db->resultSet();
    }

    // Delete a writing group post by ID
    public function deleteWritingGroupPostById($postId)
    {
        $this->db->query('DELETE FROM writing_group_posts WHERE writingGroup_post_id = :postId');
        $this->db->bind(':postId', $postId);
        return $this->db->execute();
    }

    // Get all tokens with user info
    public function getAllTokens()
    {
        $this->db->query('SELECT t.*, u.user_name FROM token t JOIN user u ON t.user_id = u.user_id ORDER BY t.updated_at DESC');
        return $this->db->resultSet();
    }

    // Delete a token record by ID
    public function deleteTokenById($tokenId)
    {
        $this->db->query('DELETE FROM token WHERE token_id = :token_id');
        $this->db->bind(':token_id', $tokenId);
        return $this->db->execute();
    }

    // Add a token
    public function addToken($data)
    {
        $this->db->query('INSERT INTO token (user_id, token_count, amount_paid, purchase_date) VALUES (:user_id, :token_count, :amount_paid, :purchase_date)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':token_count', $data['token_count']);
        $this->db->bind(':amount_paid', $data['amount_paid']);
        $this->db->bind(':purchase_date', $data['purchase_date']);
        return $this->db->execute();
    }

    // Edit a token
    public function updateToken($tokenId, $data)
    {
        $this->db->query('UPDATE token SET user_id = :user_id, token_count = :token_count, amount_paid = :amount_paid, purchase_date = :purchase_date WHERE token_id = :token_id');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':token_count', $data['token_count']);
        $this->db->bind(':amount_paid', $data['amount_paid']);
        $this->db->bind(':purchase_date', $data['purchase_date']);
        $this->db->bind(':token_id', $tokenId);
        return $this->db->execute();
    }

    // Get all community posts with community info
    public function getAllCommunityPosts()
    {
        $this->db->query('SELECT p.*, c.communityName FROM posts p JOIN community c ON p.community_id = c.communityId ORDER BY p.created_at DESC');
        return $this->db->resultSet();
    }

    // Delete a community post by ID
    public function deleteCommunityPostById($postId)
    {
        $this->db->query('DELETE FROM posts WHERE id = :postId');
        $this->db->bind(':postId', $postId);
        return $this->db->execute();
    }

    // Add a community post
    public function addCommunityPost($data)
    {
        $this->db->query('INSERT INTO posts (community_id, community_member_id, title, content, created_at) VALUES (:community_id, :community_member_id, :title, :content, NOW())');
        $this->db->bind(':community_id', $data['community_id']);
        $this->db->bind(':community_member_id', $data['community_member_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);
        return $this->db->execute();
    }

    // Edit a community post
    public function updateCommunityPost($postId, $data)
    {
        $this->db->query('UPDATE posts SET title = :title, content = :content WHERE id = :id');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':id', $postId);
        return $this->db->execute();
    }

    // Get all delete requests with community info
    public function getAllDeleteRequests()
    {
        $this->db->query('SELECT dr.*, c.communityName FROM delete_requests dr JOIN community c ON dr.community_id = c.communityId ORDER BY dr.created_at DESC');
        return $this->db->resultSet();
    }

    // Delete a delete request
    public function deleteDeleteRequest($requestId)
    {
        $this->db->query('DELETE FROM delete_requests WHERE request_id = :request_id');
        $this->db->bind(':request_id', $requestId);
        return $this->db->execute();
    }

    // Update delete request status and community delete_status
    public function updateDeleteRequestStatus($requestId, $status)
    {
        // Get community_id for this request
        $this->db->query('SELECT community_id FROM delete_requests WHERE request_id = :request_id');
        $this->db->bind(':request_id', $requestId);
        $row = $this->db->single();
        if (!$row) return false;
        $communityId = $row->community_id;
        // Update delete_requests
        $this->db->query('UPDATE delete_requests SET request_status = :status WHERE request_id = :request_id');
        $this->db->bind(':status', $status);
        $this->db->bind(':request_id', $requestId);
        $this->db->execute();
        // Update community.delete_status
        $this->db->query('UPDATE community SET delete_status = :status WHERE communityId = :communityId');
        $this->db->bind(':status', $status);
        $this->db->bind(':communityId', $communityId);
        return $this->db->execute();
    }

    // Get all events with community info (show even if community is missing)
    public function getAllEvents()
    {
        $this->db->query('SELECT e.*, c.communityName FROM event e LEFT JOIN community c ON e.community_id = c.communityId ORDER BY e.event_date DESC');
        return $this->db->resultSet();
    }

    // Get single event
    public function getEventById($eventId)
    {
        $this->db->query('SELECT e.*, c.communityName FROM event e JOIN community c ON e.community_id = c.communityId WHERE e.event_id = :event_id');
        $this->db->bind(':event_id', $eventId);
        return $this->db->single();
    }

    // Add event
    public function addEvent($data)
    {
        $this->db->query('INSERT INTO event (event_name, event_description, event_place, event_date, event_time, community_id) VALUES (:name, :description, :place, :date, :time, :community_id)');
        $this->db->bind(':name', $data['event_name']);
        $this->db->bind(':description', $data['event_description']);
        $this->db->bind(':place', $data['event_place']);
        $this->db->bind(':date', $data['event_date']);
        $this->db->bind(':time', $data['event_time']);
        $this->db->bind(':community_id', $data['community_id']);
        return $this->db->execute();
    }

    // Update event
    public function updateEvent($eventId, $data)
    {
        $this->db->query('UPDATE event SET event_name = :name, event_description = :description, event_place = :place, event_date = :date, event_time = :time, community_id = :community_id WHERE event_id = :event_id');
        $this->db->bind(':name', $data['event_name']);
        $this->db->bind(':description', $data['event_description']);
        $this->db->bind(':place', $data['event_place']);
        $this->db->bind(':date', $data['event_date']);
        $this->db->bind(':time', $data['event_time']);
        $this->db->bind(':community_id', $data['community_id']);
        $this->db->bind(':event_id', $eventId);
        return $this->db->execute();
    }

    // Delete event
    public function deleteEvent($eventId)
    {
        $this->db->query('DELETE FROM event WHERE event_id = :event_id');
        $this->db->bind(':event_id', $eventId);
        return $this->db->execute();
    }

    // Get members for a given event
    public function getEventMembers($eventId)
    {
        $this->db->query('SELECT cm.*, u.user_name FROM community_member cm JOIN user u ON cm.user_id = u.user_id WHERE cm.event_id = :event_id');
        $this->db->bind(':event_id', $eventId);
        return $this->db->resultSet();
    }

    // Get members for a given writing group
    public function getWritingGroupMembers($writingGroupId)
    {
        $this->db->query('SELECT cm.*, u.user_name FROM community_member cm JOIN user u ON cm.user_id = u.user_id WHERE cm.writingGroup_id = :wg_id');
        $this->db->bind(':wg_id', $writingGroupId);
        return $this->db->resultSet();
    }

    // Add a writing group
    public function addWritingGroup($data)
    {
        $this->db->query('INSERT INTO writinggroup (writingGroup_name, writingGroup_description, community_id, image_path) VALUES (:name, :description, :community_id, :image_path)');
        $this->db->bind(':name', $data['writingGroup_name']);
        $this->db->bind(':description', $data['writingGroup_description']);
        $this->db->bind(':community_id', $data['community_id']);
        $this->db->bind(':image_path', $data['image_path']);
        return $this->db->execute();
    }

    // Edit a writing group
    public function updateWritingGroup($wgId, $data)
    {
        $this->db->query('UPDATE writinggroup SET writingGroup_name = :name, writingGroup_description = :description, community_id = :community_id, image_path = :image_path WHERE writingGroup_id = :wg_id');
        $this->db->bind(':name', $data['writingGroup_name']);
        $this->db->bind(':description', $data['writingGroup_description']);
        $this->db->bind(':community_id', $data['community_id']);
        $this->db->bind(':image_path', $data['image_path']);
        $this->db->bind(':wg_id', $wgId);
        return $this->db->execute();
    }

    // Add a writing group post
    public function addWritingGroupPost($data)
    {
        $this->db->query('INSERT INTO writing_group_posts (writingGroup_id, community_member_id, chapter_title, chapter_content) VALUES (:writingGroup_id, :community_member_id, :chapter_title, :chapter_content)');
        $this->db->bind(':writingGroup_id', $data['writingGroup_id']);
        $this->db->bind(':community_member_id', $data['community_member_id']);
        $this->db->bind(':chapter_title', $data['chapter_title']);
        $this->db->bind(':chapter_content', $data['chapter_content']);
        return $this->db->execute();
    }

    // Edit a writing group post
    public function updateWritingGroupPost($postId, $data)
    {
        $this->db->query('UPDATE writing_group_posts SET chapter_title = :chapter_title, chapter_content = :chapter_content WHERE writingGroup_post_id = :postId');
        $this->db->bind(':chapter_title', $data['chapter_title']);
        $this->db->bind(':chapter_content', $data['chapter_content']);
        $this->db->bind(':postId', $postId);
        return $this->db->execute();
    }

    // Get user count by role
    public function getUserCountByRole($role)
    {
        $this->db->query('SELECT COUNT(*) as count FROM user WHERE user_role = :role');
        $this->db->bind(':role', $role);
        $row = $this->db->single();
        return $row->count ?? 0;
    }

    // Get count of users registered in a specific month and year
    public function getUsersRegisteredInMonth($month, $year)
    {
        $this->db->query('SELECT COUNT(*) as count FROM user WHERE MONTH(created_at) = :month AND YEAR(created_at) = :year');
        $this->db->bind(':month', $month);
        $this->db->bind(':year', $year);
        $row = $this->db->single();
        return $row->count ?? 0;
    }

    // Get books by status (available, swapped, sold)
    public function getBookCountByStatus($status)
    {
        $this->db->query('SELECT COUNT(*) as count FROM book WHERE book_status = :status');
        $this->db->bind(':status', $status);
        $row = $this->db->single();
        return $row->count ?? 0;
    }

    // Get count of books added in a specific month and year
    public function getBooksAddedInMonth($month, $year)
    {
        $this->db->query('SELECT COUNT(*) as count FROM book WHERE MONTH(created_at) = :month AND YEAR(created_at) = :year');
        $this->db->bind(':month', $month);
        $this->db->bind(':year', $year);
        $row = $this->db->single();
        return $row->count ?? 0;
    }

    // Get count of transactions by type (sell, swap)
    public function getTransactionCountByType($type)
    {
        $this->db->query('SELECT COUNT(*) as count FROM transaction WHERE type = :type');
        $this->db->bind(':type', $type);
        $row = $this->db->single();
        return $row->count ?? 0;
    }

    // Get count of transactions by status (pending, approved, declined, completed)
    public function getTransactionCountByStatus($status)
    {
        $this->db->query('SELECT COUNT(*) as count FROM transaction WHERE status = :status');
        $this->db->bind(':status', $status);
        $row = $this->db->single();
        return $row->count ?? 0;
    }

    // Get the sum of all payments received
    public function getTotalPaymentsReceived()
    {
        $this->db->query('SELECT SUM(amount) as total FROM payment');
        $row = $this->db->single();
        return $row->total ?? 0;
    }

    // Get the sum of payments received in a specific month and year
    public function getPaymentsReceivedInMonth($month, $year)
    {
        $this->db->query('SELECT SUM(amount) as total FROM payment WHERE MONTH(created_at) = :month AND YEAR(created_at) = :year');
        $this->db->bind(':month', $month);
        $this->db->bind(':year', $year);
        $row = $this->db->single();
        return $row->total ?? 0;
    }

    // Get the sum of all tokens purchased
    public function getTotalTokensPurchased()
    {
        $this->db->query('SELECT SUM(token_count) as total FROM token');
        $row = $this->db->single();
        return $row->total ?? 0;
    }

    // Get the sum of tokens purchased in a specific month and year
    public function getTokensPurchasedInMonth($month, $year)
    {
        $this->db->query('SELECT SUM(token_count) as total FROM token WHERE MONTH(purchase_date) = :month AND YEAR(purchase_date) = :year');
        $this->db->bind(':month', $month);
        $this->db->bind(':year', $year);
        $row = $this->db->single();
        return $row->total ?? 0;
    }

    // Get all payments with user details
    public function getAllPayments()
    {
        $this->db->query('SELECT p.*, u.user_name FROM payment p JOIN user u ON p.user_id = u.user_id ORDER BY p.created_at DESC');
        return $this->db->resultSet();
    }

    // Delete a payment record by ID
    public function deletePaymentById($paymentId)
    {
        $this->db->query('DELETE FROM payment WHERE payment_id = :payment_id');
        $this->db->bind(':payment_id', $paymentId);
        return $this->db->execute();
    }
}
