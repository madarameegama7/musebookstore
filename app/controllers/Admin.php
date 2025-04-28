<?php
require_once APPROOT . '/helpers/Alert_Helper.php';

class Admin extends Controller
{
    protected $adminModel;
    protected $userModel; // Add user model instance
    protected $bookModel; // Add book model instance

    public function __construct()
    {
        // Ensure user is logged in and is an admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            // Use the new Alert Helper instead of flash
            Alert_Helper::error("Access Denied", "Admin access required");
            redirect('users/login'); // Redirect non-admins
        }

        $this->adminModel = $this->model('M_Admin');
        $this->userModel = $this->model('M_Users'); // Load User Model
        $this->bookModel = $this->model('M_Books'); // Load Book Model
    }

    public function index()
    {
        // Default method for admin dashboard
        $userCount = $this->adminModel->getUserCount();
        $bookCount = $this->adminModel->getBookCount();

        $data = [
            'title' => 'Admin Dashboard',
            'userCount' => $userCount,
            'bookCount' => $bookCount,
            // Add other data needed for the admin view
        ];
        $this->view('pages/admin/v_adminhome', $data);
    }

    // Analytics Dashboard
    public function analytics()
    {
        // Get current month and year for "this month" metrics
        $currentMonth = date('n'); // 1-12
        $currentYear = date('Y');

        // Basic counts
        $userCount = $this->adminModel->getUserCount();
        $bookCount = $this->adminModel->getBookCount();

        // User role breakdown
        $adminCount = $this->adminModel->getUserCountByRole('admin');
        $parentCount = $this->adminModel->getUserCountByRole('parent');
        $childCount = $this->adminModel->getUserCountByRole('child');
        $ambassadorCount = $this->adminModel->getUserCountByRole('ambassador');

        // New users this month
        $newUsersThisMonth = $this->adminModel->getUsersRegisteredInMonth($currentMonth, $currentYear);

        // Book status breakdown - using the book_status from your database
        $availableBooks = $this->adminModel->getBookCountByStatus('available');
        $swappedBooks = $this->adminModel->getBookCountByStatus('swapped');
        $soldBooks = $this->adminModel->getBookCountByStatus('sold');

        // New books this month
        $newBooksThisMonth = $this->adminModel->getBooksAddedInMonth($currentMonth, $currentYear);

        // Transaction data
        $sellTransactions = $this->adminModel->getTransactionCountByType('sell');
        $swapTransactions = $this->adminModel->getTransactionCountByType('swap');
        $pendingTransactions = $this->adminModel->getTransactionCountByStatus('pending');
        $approvedTransactions = $this->adminModel->getTransactionCountByStatus('approved');
        $completedTransactions = $this->adminModel->getTransactionCountByStatus('completed');

        // Payment data
        $totalPayments = $this->adminModel->getTotalPaymentsReceived();
        $paymentsThisMonth = $this->adminModel->getPaymentsReceivedInMonth($currentMonth, $currentYear);

        // Token data
        $totalTokens = $this->adminModel->getTotalTokensPurchased();
        $tokensThisMonth = $this->adminModel->getTokensPurchasedInMonth($currentMonth, $currentYear);

        $data = [
            'title' => 'Site Analytics',
            'userCount' => $userCount,
            'bookCount' => $bookCount,
            'adminCount' => $adminCount,
            'parentCount' => $parentCount,
            'childCount' => $childCount,
            'ambassadorCount' => $ambassadorCount,
            'newUsersThisMonth' => $newUsersThisMonth,
            'availableBooks' => $availableBooks,
            'swappedBooks' => $swappedBooks,
            'soldBooks' => $soldBooks,
            'newBooksThisMonth' => $newBooksThisMonth,
            'sellTransactions' => $sellTransactions,
            'swapTransactions' => $swapTransactions,
            'pendingTransactions' => $pendingTransactions,
            'approvedTransactions' => $approvedTransactions,
            'completedTransactions' => $completedTransactions,
            'totalPayments' => $totalPayments,
            'paymentsThisMonth' => $paymentsThisMonth,
            'totalTokens' => $totalTokens,
            'tokensThisMonth' => $tokensThisMonth,
            'currentMonth' => date('F Y') // Month name and year for display
        ];

        $this->view('pages/admin/v_analytics', $data);
    }

    // Manage Transactions page
    public function manageTransactions()
    {
        $transactions = $this->adminModel->getAllTransactions();
        $data = [
            'title' => 'Manage Transactions',
            'transactions' => $transactions
        ];
        $this->view('pages/admin/v_manage_transactions', $data);
    }

    // Approve a transaction
    public function approveTransaction($transactionId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->updateTransactionStatus($transactionId, 'approved')) {
                Alert_Helper::success('Success', 'Transaction approved successfully.');
            } else {
                Alert_Helper::error('Approval failed', 'Failed to approve transaction.');
            }
            redirect('admin/manageTransactions');
        } else {
            redirect('admin/manageTransactions');
        }
    }

    // Decline a transaction
    public function declineTransaction($transactionId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->updateTransactionStatus($transactionId, 'declined')) {
                Alert_Helper::success('Success', 'Transaction declined.');
            } else {
                Alert_Helper::error('Decline failed', 'Failed to decline transaction.');
            }
            redirect('admin/manageTransactions');
        } else {
            redirect('admin/manageTransactions');
        }
    }

    // Delete a transaction
    public function deleteTransaction($transactionId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deleteTransactionById($transactionId)) {
                Alert_Helper::success('Success', 'Transaction deleted successfully.');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete transaction.');
            }
            redirect('admin/manageTransactions');
        } else {
            redirect('admin/manageTransactions');
        }
    }

    // Manage Writing Groups
    public function writingGroups()
    {
        $groups = $this->adminModel->getAllWritingGroups();
        $data = [
            'title' => 'Manage Writing Groups',
            'groups' => $groups
        ];
        $this->view('pages/admin/v_manage_writing_groups', $data);
    }

    public function deleteWritingGroup($groupId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deleteWritingGroupById($groupId)) {
                Alert_Helper::success('Success', 'Writing group deleted successfully.');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete writing group.');
            }
            redirect('admin/writingGroups');
        } else {
            redirect('admin/writingGroups');
        }
    }

    public function addWritingGroup()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'writingGroup_name' => $_POST['writingGroup_name'],
                'writingGroup_description' => $_POST['writingGroup_description'],
                'community_id' => $_POST['community_id'],
                'image_path' => $_POST['image_path'] ?? null
            ];
            if ($this->adminModel->addWritingGroup($data)) {
                Alert_Helper::success('Success', 'Writing group added.');
            } else {
                Alert_Helper::error('Add failed', 'Failed to add writing group.');
            }
            redirect('admin/writingGroups');
        } else {
            $this->writingGroups();
        }
    }

    public function editWritingGroup($wgId)
    {
        $group = null;
        foreach ($this->adminModel->getAllWritingGroups() as $g) {
            if ($g->writingGroup_id == $wgId) $group = $g;
        }
        if (!$group) {
            Alert_Helper::error('Group not found', 'Writing group not found.');
            redirect('admin/writingGroups');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'writingGroup_name' => $_POST['writingGroup_name'],
                'writingGroup_description' => $_POST['writingGroup_description'],
                'community_id' => $_POST['community_id'],
                'image_path' => $_POST['image_path'] ?? null
            ];
            if ($this->adminModel->updateWritingGroup($wgId, $data)) {
                Alert_Helper::success('Success', 'Writing group updated.');
                redirect('admin/writingGroups');
            } else {
                Alert_Helper::error('Update failed', 'Failed to update writing group.');
                redirect('admin/writingGroups');
            }
        } else {
            $data = [
                'title' => 'Edit Writing Group',
                'group' => $group
            ];
            $this->view('pages/admin/v_edit_writing_group', $data);
        }
    }

    // Manage Writing Group Posts
    public function writingGroupPosts()
    {
        $posts = $this->adminModel->getAllWritingGroupPosts();
        $data = [
            'title' => 'Manage Writing Group Posts',
            'posts' => $posts
        ];
        $this->view('pages/admin/v_manage_writing_group_posts', $data);
    }

    public function deleteWritingGroupPost($postId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deleteWritingGroupPostById($postId)) {
                Alert_Helper::success('Success', 'Writing group post deleted successfully.');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete writing group post.');
            }
            redirect('admin/writingGroupPosts');
        } else {
            redirect('admin/writingGroupPosts');
        }
    }

    public function addWritingGroupPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'writingGroup_id' => $_POST['writingGroup_id'],
                'community_member_id' => $_POST['community_member_id'],
                'chapter_title' => $_POST['chapter_title'],
                'chapter_content' => $_POST['chapter_content']
            ];
            if ($this->adminModel->addWritingGroupPost($data)) {
                Alert_Helper::success('Success', 'Writing group post added.');
            } else {
                Alert_Helper::error('Add failed', 'Failed to add writing group post.');
            }
            redirect('admin/writingGroupPosts');
        } else {
            $this->writingGroupPosts();
        }
    }

    public function editWritingGroupPost($postId)
    {
        $post = null;
        foreach ($this->adminModel->getAllWritingGroupPosts() as $p) {
            if ($p->writingGroup_post_id == $postId) $post = $p;
        }
        if (!$post) {
            Alert_Helper::error('Post not found', 'Writing group post not found.');
            redirect('admin/writingGroupPosts');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'chapter_title' => $_POST['chapter_title'],
                'chapter_content' => $_POST['chapter_content']
            ];
            if ($this->adminModel->updateWritingGroupPost($postId, $data)) {
                Alert_Helper::success('Success', 'Writing group post updated.');
                redirect('admin/writingGroupPosts');
            } else {
                Alert_Helper::error('Update failed', 'Failed to update writing group post.');
                redirect('admin/writingGroupPosts');
            }
        } else {
            $data = [
                'title' => 'Edit Writing Group Post',
                'post' => $post
            ];
            $this->view('pages/admin/v_edit_writing_group_post', $data);
        }
    }

    // Manage Tokens
    public function manageTokens()
    {
        $tokens = $this->adminModel->getAllTokens();
        $users = $this->adminModel->getAllUsers();
        $data = [
            'title' => 'Manage Tokens',
            'tokens' => $tokens,
            'users' => $users
        ];
        $this->view('pages/admin/v_manage_tokens', $data);
    }
    public function addToken()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'user_id' => $_POST['user_id'],
                'token_count' => $_POST['token_count'],
                'amount_paid' => $_POST['amount_paid'],
                'purchase_date' => $_POST['purchase_date']
            ];
            if ($this->adminModel->addToken($data)) {
                Alert_Helper::success('Success', 'Token record added.');
            } else {
                Alert_Helper::error('Add failed', 'Failed to add token.');
            }
            redirect('admin/manageTokens');
        } else {
            $this->manageTokens();
        }
    }
    public function editToken($tokenId)
    {
        $token = null;
        foreach ($this->adminModel->getAllTokens() as $t) {
            if ($t->token_id == $tokenId) $token = $t;
        }
        $users = $this->adminModel->getAllUsers();
        if (!$token) {
            Alert_Helper::error('Token not found', 'Token not found.');
            redirect('admin/manageTokens');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'user_id' => $_POST['user_id'],
                'token_count' => $_POST['token_count'],
                'amount_paid' => $_POST['amount_paid'],
                'purchase_date' => $_POST['purchase_date']
            ];
            if ($this->adminModel->updateToken($tokenId, $data)) {
                Alert_Helper::success('Success', 'Token updated.');
                redirect('admin/manageTokens');
            } else {
                Alert_Helper::error('Update failed', 'Failed to update token.');
                redirect('admin/manageTokens');
            }
        } else {
            $data = [
                'title' => 'Edit Token',
                'token' => $token,
                'users' => $users
            ];
            $this->view('pages/admin/v_edit_token', $data);
        }
    }
    public function deleteToken($tokenId)
    {
        if ($this->adminModel->deleteTokenById($tokenId)) {
            Alert_Helper::success('Success', 'Token deleted.');
        } else {
            Alert_Helper::error('Delete failed', 'Failed to delete token.');
        }
        redirect('admin/manageTokens');
    }

    // Manage Community Posts
    public function manageCommunityPosts()
    {
        $posts = $this->adminModel->getAllCommunityPosts();
        $data = [
            'title' => 'Manage Community Posts',
            'posts' => $posts
        ];
        $this->view('pages/admin/v_manage_community_posts', $data);
    }
    public function addCommunityPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'community_id' => $_POST['community_id'],
                'community_member_id' => $_POST['community_member_id'],
                'title' => $_POST['title'],
                'content' => $_POST['content']
            ];
            if ($this->adminModel->addCommunityPost($data)) {
                Alert_Helper::success('Success', 'Community post added.');
            } else {
                Alert_Helper::error('Add failed', 'Failed to add post.');
            }
            redirect('admin/manageCommunityPosts');
        } else {
            $this->manageCommunityPosts();
        }
    }
    public function editCommunityPost($postId)
    {
        $post = null;
        foreach ($this->adminModel->getAllCommunityPosts() as $p) {
            if ($p->id == $postId) $post = $p;
        }
        if (!$post) {
            Alert_Helper::error('Post not found', 'Post not found.');
            redirect('admin/manageCommunityPosts');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'title' => $_POST['title'],
                'content' => $_POST['content']
            ];
            if ($this->adminModel->updateCommunityPost($postId, $data)) {
                Alert_Helper::success('Success', 'Post updated.');
                redirect('admin/manageCommunityPosts');
            } else {
                Alert_Helper::error('Update failed', 'Failed to update post.');
                redirect('admin/manageCommunityPosts');
            }
        } else {
            $data = [
                'title' => 'Edit Community Post',
                'post' => $post
            ];
            $this->view('pages/admin/v_edit_community_post', $data);
        }
    }
    public function deleteCommunityPost($postId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deleteCommunityPostById($postId)) {
                Alert_Helper::success('Success', 'Community post deleted successfully.');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete community post.');
            }
            redirect('admin/manageCommunityPosts');
        } else {
            redirect('admin/manageCommunityPosts');
        }
    }

    // Manage Payments
    public function managePayments()
    {
        $payments = $this->adminModel->getAllPayments();
        $data = [
            'title' => 'Manage Payments',
            'payments' => $payments
        ];
        $this->view('pages/admin/v_manage_payments', $data);
    }
    public function deletePayment($paymentId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deletePaymentById($paymentId)) {
                Alert_Helper::success('Success', 'Payment record deleted successfully.');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete payment record.');
            }
            redirect('admin/managePayments');
        } else {
            redirect('admin/managePayments');
        }
    }

    // Manage Delete Requests
    public function deleteRequests()
    {
        $requests = $this->adminModel->getAllDeleteRequests();
        $data = [
            'title' => 'Manage Delete Requests',
            'requests' => $requests
        ];
        $this->view('pages/admin/v_manage_delete_requests', $data);
    }
    public function approveDeleteRequest($requestId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->updateDeleteRequestStatus($requestId, 'approved')) {
                Alert_Helper::success('Success', 'Delete request approved. Community marked for deletion.');
            } else {
                Alert_Helper::error('Approval failed', 'Failed to approve delete request.');
            }
            redirect('admin/deleteRequests');
        } else {
            redirect('admin/deleteRequests');
        }
    }
    public function rejectDeleteRequest($requestId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->updateDeleteRequestStatus($requestId, 'rejected')) {
                Alert_Helper::success('Success', 'Delete request rejected.');
            } else {
                Alert_Helper::error('Rejection failed', 'Failed to reject delete request.');
            }
            redirect('admin/deleteRequests');
        } else {
            redirect('admin/deleteRequests');
        }
    }

    // Manage Events
    public function manageEvents()
    {
        $events = $this->adminModel->getAllEvents();
        $data = [
            'title' => 'Manage Events',
            'events' => $events
        ];
        $this->view('pages/admin/v_manage_events', $data);
    }
    public function addEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'event_name' => trim($_POST['event_name']),
                'event_description' => trim($_POST['event_description']),
                'event_place' => trim($_POST['event_place']),
                'event_date' => trim($_POST['event_date']),
                'event_time' => trim($_POST['event_time']),
                'community_id' => trim($_POST['community_id'])
            ];
            if ($this->adminModel->addEvent($data)) {
                Alert_Helper::success('Success', 'Event added successfully.');
                redirect('admin/manageEvents');
            } else {
                Alert_Helper::error('Add failed', 'Failed to add event.');
                redirect('admin/manageEvents');
            }
        } else {
            // Show add event form (reuse manageEvents for simplicity)
            $this->manageEvents();
        }
    }
    public function editEvent($eventId)
    {
        $event = $this->adminModel->getEventById($eventId);
        if (!$event) {
            Alert_Helper::error('Event not found', 'Event not found.');
            redirect('admin/manageEvents');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'event_name' => trim($_POST['event_name']),
                'event_description' => trim($_POST['event_description']),
                'event_place' => trim($_POST['event_place']),
                'event_date' => trim($_POST['event_date']),
                'event_time' => trim($_POST['event_time']),
                'community_id' => trim($_POST['community_id'])
            ];
            if ($this->adminModel->updateEvent($eventId, $data)) {
                Alert_Helper::success('Success', 'Event updated successfully.');
                redirect('admin/manageEvents');
            } else {
                Alert_Helper::error('Update failed', 'Failed to update event.');
                redirect('admin/manageEvents');
            }
        } else {
            $data = [
                'event' => $event,
                'title' => 'Edit Event'
            ];
            $this->view('pages/admin/v_edit_event', $data);
        }
    }
    public function deleteEvent($eventId)
    {
        if ($this->adminModel->deleteEvent($eventId)) {
            Alert_Helper::success('Success', 'Event deleted successfully.');
        } else {
            Alert_Helper::error('Delete failed', 'Failed to delete event.');
        }
        redirect('admin/manageEvents');
    }

    /**
     * Manage User Verification page
     * Shows all users with verification status and options to verify/unverify
     */
    public function manageVerification()
    {
        // Handle search and filter parameters
        $searchTerm = $_GET['search'] ?? null;
        $filter = $_GET['filter'] ?? null;
        $users = [];

        if ($searchTerm) {
            $searchTerm = trim(filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING));
            // Only search if the trimmed term is not empty
            if (!empty($searchTerm)) {
                $users = $this->adminModel->searchUsersWithVerificationStatus($searchTerm, $filter);
            } else {
                // If search term is empty after trimming, show filtered users
                $users = $this->adminModel->getAllUsersWithVerificationStatus($filter);
                $searchTerm = null; // Reset searchTerm
            }
        } else {
            // No search term, get all users (with optional filter)
            $users = $this->adminModel->getAllUsersWithVerificationStatus($filter);
        }

        $data = [
            'title' => 'Manage User Verification',
            'users' => $users,
            'searchTerm' => $searchTerm,
            'filter' => $filter
        ];

        $this->view('pages/admin/v_manage_verification', $data);
    }

    /**
     * Manually verify a user (admin action)
     * 
     * @param int $userId User ID to verify
     */
    public function verifyUser($userId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = $this->adminModel->getUserById($userId);

            if (!$user) {
                Alert_Helper::error('User not found', 'User not found.');
                redirect('admin/manageVerification');
                return;
            }

            if ($this->adminModel->verifyUser($userId)) {
                Alert_Helper::success('Success', 'User verified successfully.');
            } else {
                Alert_Helper::error('Verification failed', 'Failed to verify user.');
            }

            redirect('admin/manageVerification');
        } else {
            redirect('admin/manageVerification');
        }
    }

    /**
     * Mark a user as unverified (admin action)
     * 
     * @param int $userId User ID to unverify
     */
    public function unverifyUser($userId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = $this->adminModel->getUserById($userId);

            if (!$user) {
                Alert_Helper::error('User not found', 'User not found.');
                redirect('admin/manageVerification');
                return;
            }

            if ($this->adminModel->unverifyUser($userId)) {
                Alert_Helper::success('Success', 'User marked as unverified.');
            } else {
                Alert_Helper::error('Update failed', 'Failed to update user status.');
            }

            redirect('admin/manageVerification');
        } else {
            redirect('admin/manageVerification');
        }
    }

    /**
     * Generate and send a new OTP for a user (admin action)
     * 
     * @param int $userId User ID to generate OTP for
     */
    public function resendOTP($userId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Generate new OTP for the user
            $result = $this->adminModel->generateNewOTP($userId);

            if ($result) {
                // Send OTP email
                require_once APPROOT . '/helpers/Email_Helper.php';
                $emailSent = Email_Helper::sendOTP($result['user']->user_email, $result['user']->user_name, $result['otp']);

                if ($emailSent) {
                    Alert_Helper::success('Success', 'OTP generated and sent to user.');
                } else {
                    Alert_Helper::warning('Email failed', 'OTP generated but email sending failed. OTP: ' . $result['otp']);
                }
            } else {
                Alert_Helper::error('Generation failed', 'Failed to generate new OTP.');
            }

            redirect('admin/manageVerification');
        } else {
            redirect('admin/manageVerification');
        }
    }
}
