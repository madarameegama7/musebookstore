<?php
require_once APPROOT . '/helpers/Alert_Helper.php';

class Admin extends Controller
{
    private $adminModel;
    private $userModel; // Add user model instance
    private $bookModel; // Add book model instance

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

    // User Management
    public function manageUsers()
    {
        // This method handles the page load and search via GET parameter.
        $searchTerm = $_GET['search'] ?? null;
        $users = [];

        if ($searchTerm) {
            $searchTerm = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
            // Trim the search term
            $searchTerm = trim($searchTerm);
            // Only search if the trimmed term is not empty
            if (!empty($searchTerm)) {
                $users = $this->adminModel->searchUsers($searchTerm);
            } else {
                // If search term is empty after trimming, show all users
                $users = $this->adminModel->getAllUsers();
                $searchTerm = null; // Reset searchTerm to null if it was just whitespace
            }
        } else {
            $users = $this->adminModel->getAllUsers();
        }

        $data = [
            'title' => 'Manage Users',
            'users' => $users,
            'searchTerm' => $searchTerm
        ];
        $this->view('pages/admin/v_manage_users', $data);
    }

    // View User Details
    public function viewUser($userId)
    {
        $user = $this->adminModel->getUserById($userId);
        if (!$user) {
            Alert_Helper::error('User not found', 'The requested user does not exist.');
            redirect('admin/manageUsers');
        }
        $data = [
            'title' => 'View User: ' . $user->user_name,
            'user' => $user
        ];
        $this->view('pages/admin/v_view_user', $data);
    }

    // Show Edit User Form
    public function editUser($userId)
    {
        $user = $this->adminModel->getUserById($userId);
        if (!$user) {
            Alert_Helper::error('User not found', 'The requested user does not exist.');
            redirect('admin/manageUsers');
        }

        // Prevent editing self details via this form (can use profile page)
        // Although admin can change their own role via viewUser
        if ($user->user_id == $_SESSION['user_id']) {
            Alert_Helper::warning('Action not allowed', 'Use your profile page to edit your own details.');
            redirect('admin/manageUsers');
        }

        $data = [
            'title' => 'Edit User: ' . $user->user_name,
            'user_id' => $userId,
            'name' => $user->user_name,
            'email' => $user->user_email,
            'address' => $user->user_address ?? '',
            'contactNumber' => $user->user_phone ?? '',
            'name_err' => '',
            'email_err' => '',
            'address_err' => '',
            'contactNumber_err' => ''
        ];
        $this->view('pages/admin/v_edit_user', $data);
    }

    // Handle Update User Submission
    public function updateUser($userId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Fetch original user data to compare email
            $originalUser = $this->adminModel->getUserById($userId);
            if (!$originalUser) {
                Alert_Helper::error('User not found', 'The requested user does not exist.');
                redirect('admin/manageUsers');
                return;
            }

            $data = [
                'user_id' => $userId,
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'address' => trim($_POST['address']),
                'contactNumber' => trim($_POST['contactNumber']),
                'title' => 'Edit User: ' . $originalUser->user_name, // Keep title for view reload on error
                'name_err' => '',
                'email_err' => '',
                'address_err' => '',
                'contactNumber_err' => ''
            ];

            // Validation (similar to Users controller signup/edit)
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter a name';
            }

            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter an email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Invalid email format';
            } else {
                // Check if the email exists AND belongs to a DIFFERENT user
                $userWithEmail = $this->userModel->getUserByEmail($data['email']);
                if ($userWithEmail && $userWithEmail->user_id != $userId) {
                    $data['email_err'] = 'This email is already taken by another user';
                }
            }

            if (empty($data['address'])) {
                $data['address_err'] = 'Please enter an address';
            }

            if (empty($data['contactNumber'])) {
                $data['contactNumber_err'] = 'Please enter a contact number';
            } elseif (!preg_match('/^07[0-9]{8}$/', $data['contactNumber'])) { // Basic SL phone validation
                $data['contactNumber_err'] = 'Invalid phone number format (e.g., 07XXXXXXXX)';
            }

            // If no errors, attempt update
            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['address_err']) && empty($data['contactNumber_err'])) {
                if ($this->adminModel->updateUser($data)) {
                    Alert_Helper::success('Success', 'User details updated successfully.');
                    redirect('admin/manageUsers'); // Or redirect('admin/viewUser/' . $userId);
                } else {
                    Alert_Helper::error('Update failed', 'Failed to update user details.');
                    // Reload view with data and error message
                    $this->view('pages/admin/v_edit_user', $data);
                }
            } else {
                // Validation failed, reload form with errors
                $this->view('pages/admin/v_edit_user', $data);
            }
        } else {
            // Not a POST request, redirect
            redirect('admin/manageUsers');
        }
    }

    // Update User Role (Handles POST request)
    public function updateUserRole($userId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $newRole = trim($_POST['user_role']);

            // Basic validation (can add more roles if needed)
            $allowedRoles = ['admin', 'parent', 'child', 'ambassador'];
            if (!in_array($newRole, $allowedRoles)) {
                Alert_Helper::error('Invalid Role', 'Invalid user role selected.');
                redirect('admin/viewUser/' . $userId);
                return; // Stop execution
            }

            if ($this->adminModel->updateUserRole($userId, $newRole)) {
                Alert_Helper::success('Success', 'User role updated successfully.');
            } else {
                Alert_Helper::error('Update failed', 'Failed to update user role.');
            }
            redirect('admin/viewUser/' . $userId);
        } else {
            // Redirect if not a POST request
            redirect('admin/manageUsers');
        }
    }

    // Delete User (Handles POST request for confirmation)
    public function deleteUser($userId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ensure user exists before trying to delete
            $user = $this->adminModel->getUserById($userId);
            if (!$user) {
                Alert_Helper::warning('User not found', 'User not found or already deleted.');
                redirect('admin/manageUsers');
                return;
            }

            // Prevent deleting self
            if ($userId == $_SESSION['user_id']) {
                Alert_Helper::error('Action not allowed', 'You cannot delete your own account.');
                redirect('admin/manageUsers');
                return;
            }

            if ($this->adminModel->deleteUserById($userId)) {
                Alert_Helper::success('Success', 'User deleted successfully.');
                redirect('admin/manageUsers');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete user.');
                redirect('admin/manageUsers');
            }
        } else {
            // If accessed via GET, redirect (deletion should be via POST)
            redirect('admin/manageUsers');
        }
    }

    // Show Add User Form (GET) / Handle Add User Submission (POST)
    public function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form submission
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirmPassword' => trim($_POST['confirmPassword']),
                'role' => trim($_POST['role']),
                'address' => trim($_POST['address']),
                'contactNumber' => trim($_POST['contactNumber']),
                'parent_id' => isset($_POST['parent_id']) ? trim($_POST['parent_id']) : null, // For child accounts
                'title' => 'Add New User',
                'users' => $this->adminModel->getAllUsers(), // For parent dropdown if needed
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirmPassword_err' => '',
                'role_err' => '',
                'address_err' => '',
                'contactNumber_err' => '',
                'parent_id_err' => ''
            ];

            // Validation
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Invalid email format';
            } elseif ($this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Email is already taken';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 8) {
                $data['password_err'] = 'Password must be at least 8 characters';
            }
            // Add other password complexity rules if desired (like in Users controller)

            if (empty($data['confirmPassword'])) {
                $data['confirmPassword_err'] = 'Please confirm password';
            } elseif ($data['password'] != $data['confirmPassword']) {
                $data['confirmPassword_err'] = 'Passwords do not match';
            }

            $allowedRoles = ['admin', 'parent', 'child', 'ambassador'];
            if (empty($data['role'])) {
                $data['role_err'] = 'Please select a role';
            } elseif (!in_array($data['role'], $allowedRoles)) {
                $data['role_err'] = 'Invalid role selected';
            }

            if ($data['role'] === 'child' && empty($data['parent_id'])) {
                $data['parent_id_err'] = 'Please select a parent for the child account';
            } elseif ($data['role'] === 'child' && !empty($data['parent_id'])) {
                // Optional: Validate if the selected parent_id actually exists and is a 'parent'
                $parentUser = $this->adminModel->getUserById($data['parent_id']);
                if (!$parentUser || $parentUser->user_role !== 'parent') {
                    $data['parent_id_err'] = 'Invalid parent selected';
                }
            }


            if (empty($data['address'])) {
                $data['address_err'] = 'Please enter address';
            }
            if (empty($data['contactNumber'])) {
                $data['contactNumber_err'] = 'Please enter contact number';
            } elseif (!preg_match('/^07[0-9]{8}$/', $data['contactNumber'])) {
                $data['contactNumber_err'] = 'Invalid phone number format';
            }

            // Check if all errors are empty
            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirmPassword_err']) && empty($data['role_err']) && empty($data['address_err']) && empty($data['contactNumber_err']) && empty($data['parent_id_err'])) {
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Attempt to create user
                if ($this->adminModel->createUser($data)) {
                    Alert_Helper::success('Success', 'New user added successfully.');
                    redirect('admin/manageUsers');
                } else {
                    Alert_Helper::error('Add failed', 'Failed to add user.');
                    $this->view('pages/admin/v_add_user', $data); // Reload form with error
                }
            } else {
                // Validation failed, reload form with errors
                $this->view('pages/admin/v_add_user', $data);
            }
        } else {
            // Display empty form (GET request)
            $users = $this->adminModel->getAllUsers(); // Fetch users for parent dropdown
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirmPassword' => '',
                'role' => '',
                'address' => '',
                'contactNumber' => '',
                'parent_id' => null,
                'title' => 'Add New User',
                'users' => $users, // Pass users to the view
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirmPassword_err' => '',
                'role_err' => '',
                'address_err' => '',
                'contactNumber_err' => '',
                'parent_id_err' => ''
            ];
            $this->view('pages/admin/v_add_user', $data);
        }
    }

    // Book Management
    public function manageBooks()
    {
        // This method handles the page load and search via GET parameter.
        $searchTerm = $_GET['search'] ?? null;
        $books = [];

        if ($searchTerm) {
            $searchTerm = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
            // Trim the search term
            $searchTerm = trim($searchTerm);
            // Only search if the trimmed term is not empty
            if (!empty($searchTerm)) {
                $books = $this->adminModel->searchBooks($searchTerm);
            } else {
                // If search term is empty after trimming, show all books
                $books = $this->adminModel->getAllBooks();
                $searchTerm = null; // Reset searchTerm to null if it was just whitespace
            }
        } else {
            $books = $this->adminModel->getAllBooks();
        }

        $data = [
            'title' => 'Manage Books',
            'books' => $books,
            'searchTerm' => $searchTerm
        ];
        $this->view('pages/admin/v_manage_books', $data);
    }

    // View Book Details
    public function viewBook($bookId)
    {
        $book = $this->adminModel->getBookById($bookId);
        if (!$book) {
            Alert_Helper::error('Book not found', 'The requested book does not exist.');
            redirect('admin/manageBooks');
        }
        $data = [
            'title' => 'View Book: ' . ($book->book_title ?? 'N/A'),
            'book' => $book
        ];
        $this->view('pages/admin/v_view_book', $data);
    }

    // Show Edit Book Form
    public function editBook($bookId)
    {
        $book = $this->adminModel->getBookById($bookId);
        if (!$book) {
            Alert_Helper::error('Book not found', 'The requested book does not exist.');
            redirect('admin/manageBooks');
        }

        $data = [
            'title' => 'Edit Book: ' . $book->book_title,
            'bookid' => $bookId,
            'booktitle' => $book->book_title,
            'author' => $book->book_author,
            'genre' => $book->book_genre,
            'bookcondition' => $book->book_condition,
            'price' => $book->book_price,
            'bookoption' => $book->listing_type,
            'publisher' => $book->book_publisher,
            'year' => $book->book_published_year,
            'isbn' => $book->book_ISBN,
            'book_title_err' => '',
            'book_author_err' => '',
            'book_genre_err' => '',
            'book_condition_err' => '',
            'book_price_err' => '',
            'book_option_err' => '',
            'book_publisher_err' => '',
            'book_year_err' => '',
            'book_isbn_err' => ''
        ];
        $this->view('pages/admin/v_edit_book', $data);
    }

    // Handle Update Book Submission
    public function updateBook($bookId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Fetch original book data in case of errors
            $originalBook = $this->adminModel->getBookById($bookId);
            if (!$originalBook) {
                Alert_Helper::error('Book not found', 'The requested book does not exist.');
                redirect('admin/manageBooks');
                return;
            }

            $data = [
                'bookid' => $bookId,
                'booktitle' => trim($_POST['booktitle']),
                'author' => trim($_POST['author']),
                'genre' => trim($_POST['genre']),
                'bookcondition' => trim($_POST['bookcondition']),
                'price' => trim($_POST['price']),
                'bookoption' => trim($_POST['bookoption']),
                'publisher' => trim($_POST['publisher']),
                'year' => trim($_POST['year']),
                'isbn' => trim($_POST['isbn']),
                'title' => 'Edit Book: ' . $originalBook->book_title, // Keep title for view reload
                'book_title_err' => '',
                'book_author_err' => '',
                'book_genre_err' => '',
                'book_condition_err' => '',
                'book_price_err' => '',
                'book_option_err' => '',
                'book_publisher_err' => '',
                'book_year_err' => '',
                'book_isbn_err' => ''
            ];

            // Validation (similar to Books controller create/edit)
            if (empty($data['booktitle'])) {
                $data['book_title_err'] = "Please enter a title";
            }
            if (empty($data['author'])) {
                $data['book_author_err'] = "Please enter author name";
            }
            if (empty($data['genre'])) {
                $data['book_genre_err'] = "Please select genre";
            }
            if (empty($data['bookcondition'])) {
                $data['book_condition_err'] = "Please select book condition";
            }
            if (empty($data['price']) && $data['price'] !== '0') {
                $data['book_price_err'] = "Please enter a price";
            } // Allow 0 price?
            elseif (!is_numeric($data['price']) || $data['price'] < 0) {
                $data['book_price_err'] = "Please enter a valid price";
            }
            if (empty($data['bookoption'])) {
                $data['book_option_err'] = "Please select an option";
            }
            if (empty($data['publisher'])) {
                $data['book_publisher_err'] = "Please enter publisher name";
            }
            if (empty($data['year'])) {
                $data['book_year_err'] = "Please enter published year";
            } elseif (!is_numeric($data['year']) || strlen($data['year']) != 4) {
                $data['book_year_err'] = "Please enter a valid year (YYYY)";
            }
            if (empty($data['isbn'])) {
                $data['book_isbn_err'] = "Please enter ISBN";
            }
            // Add more specific ISBN validation if needed

            // If no errors, attempt update
            if (
                empty($data['book_title_err']) && empty($data['book_author_err']) && empty($data['book_genre_err']) &&
                empty($data['book_condition_err']) && empty($data['book_price_err']) && empty($data['book_option_err']) &&
                empty($data['book_publisher_err']) && empty($data['book_year_err']) && empty($data['book_isbn_err'])
            ) {

                if ($this->adminModel->updateBook($data)) {
                    Alert_Helper::success('Success', 'Book details updated successfully.');
                    redirect('admin/manageBooks'); // Or redirect('admin/viewBook/' . $bookId);
                } else {
                    Alert_Helper::error('Update failed', 'Failed to update book details.');
                    $this->view('pages/admin/v_edit_book', $data); // Reload form with error
                }
            } else {
                // Validation failed, reload form with errors
                $this->view('pages/admin/v_edit_book', $data);
            }
        } else {
            // Not a POST request, redirect
            redirect('admin/manageBooks');
        }
    }

    // Show Add Book Form (GET) / Handle Add Book Submission (POST)
    public function createBook()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'booktitle' => trim($_POST['booktitle']),
                'author' => trim($_POST['author']),
                'genre' => trim($_POST['genre']),
                'bookcondition' => trim($_POST['bookcondition']),
                'price' => trim($_POST['price']),
                'bookoption' => trim($_POST['bookoption']),
                'publisher' => trim($_POST['publisher']),
                'year' => trim($_POST['year']),
                'isbn' => trim($_POST['isbn']),
                'owner_id' => trim($_POST['owner_id']), // Get owner from form
                'title' => 'Add New Book',
                'users' => $this->adminModel->getAllUsers(), // For owner dropdown reload on error
                'book_title_err' => '',
                'book_author_err' => '',
                'book_genre_err' => '',
                'book_condition_err' => '',
                'book_price_err' => '',
                'book_option_err' => '',
                'book_publisher_err' => '',
                'book_year_err' => '',
                'book_isbn_err' => '',
                'owner_id_err' => ''
            ];

            // Validation (similar to editBook/Books controller)
            if (empty($data['booktitle'])) {
                $data['book_title_err'] = "Please enter a title";
            }
            if (empty($data['author'])) {
                $data['book_author_err'] = "Please enter author name";
            }
            if (empty($data['genre'])) {
                $data['book_genre_err'] = "Please select genre";
            }
            if (empty($data['bookcondition'])) {
                $data['book_condition_err'] = "Please select book condition";
            }
            if (empty($data['price']) && $data['price'] !== '0') {
                $data['book_price_err'] = "Please enter a price";
            } elseif (!is_numeric($data['price']) || $data['price'] < 0) {
                $data['book_price_err'] = "Please enter a valid price";
            }
            if (empty($data['bookoption'])) {
                $data['book_option_err'] = "Please select an option";
            }
            if (empty($data['publisher'])) {
                $data['book_publisher_err'] = "Please enter publisher name";
            }
            if (empty($data['year'])) {
                $data['book_year_err'] = "Please enter published year";
            } elseif (!is_numeric($data['year']) || strlen($data['year']) != 4) {
                $data['book_year_err'] = "Please enter a valid year (YYYY)";
            }
            if (empty($data['isbn'])) {
                $data['book_isbn_err'] = "Please enter ISBN";
            }
            if (empty($data['owner_id'])) {
                $data['owner_id_err'] = "Please select an owner";
            } else {
                // Optional: Validate owner exists
                $ownerUser = $this->adminModel->getUserById($data['owner_id']);
                if (!$ownerUser) {
                    $data['owner_id_err'] = 'Invalid owner selected';
                }
            }

            // If no errors, attempt create
            if (
                empty($data['book_title_err']) && empty($data['book_author_err']) && empty($data['book_genre_err']) &&
                empty($data['book_condition_err']) && empty($data['book_price_err']) && empty($data['book_option_err']) &&
                empty($data['book_publisher_err']) && empty($data['book_year_err']) && empty($data['book_isbn_err']) && empty($data['owner_id_err'])
            ) {

                if ($this->adminModel->createBook($data)) {
                    Alert_Helper::success('Success', 'New book added successfully.');
                    redirect('admin/manageBooks');
                } else {
                    Alert_Helper::error('Add failed', 'Failed to add book.');
                    $this->view('pages/admin/v_add_book', $data); // Reload form with error
                }
            } else {
                // Validation failed, reload form with errors
                $this->view('pages/admin/v_add_book', $data);
            }
        } else {
            // Display empty form (GET request)
            $users = $this->adminModel->getAllUsers(); // Fetch users for owner dropdown
            $data = [
                'booktitle' => '',
                'author' => '',
                'genre' => '',
                'bookcondition' => '',
                'price' => '',
                'bookoption' => '',
                'publisher' => '',
                'year' => '',
                'isbn' => '',
                'owner_id' => '',
                'title' => 'Add New Book',
                'users' => $users, // Pass users to the view
                'book_title_err' => '',
                'book_author_err' => '',
                'book_genre_err' => '',
                'book_condition_err' => '',
                'book_price_err' => '',
                'book_option_err' => '',
                'book_publisher_err' => '',
                'book_year_err' => '',
                'book_isbn_err' => '',
                'owner_id_err' => ''
            ];
            $this->view('pages/admin/v_add_book', $data);
        }
    }

    // Delete Book (Handles POST request for confirmation)
    public function deleteBook($bookId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ensure book exists
            $book = $this->adminModel->getBookById($bookId);
            if (!$book) {
                Alert_Helper::warning('Book not found', 'Book not found or already deleted.');
                redirect('admin/manageBooks');
                return;
            }

            if ($this->adminModel->deleteBookById($bookId)) {
                Alert_Helper::success('Success', 'Book deleted successfully.');
                redirect('admin/manageBooks');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete book.');
                redirect('admin/manageBooks');
            }
        } else {
            // If accessed via GET, redirect
            redirect('admin/manageBooks');
        }
    }

    // Manage Communities page
    public function manageCommunities()
    {
        $communities = $this->adminModel->getAllCommunities();
        $data = [
            'title' => 'Manage Communities',
            'communities' => $communities
        ];
        $this->view('pages/admin/v_manage_communities', $data);
    }

    // Approve a community
    public function approveCommunity($communityId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->updateCommunityStatus($communityId, 'approved')) {
                Alert_Helper::success('Success', 'Community approved successfully.');
            } else {
                Alert_Helper::error('Approval failed', 'Failed to approve community.');
            }
            redirect('admin/manageCommunities');
        } else {
            redirect('admin/manageCommunities');
        }
    }

    // Reject a community
    public function rejectCommunity($communityId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->updateCommunityStatus($communityId, 'rejected')) {
                Alert_Helper::success('Success', 'Community rejected.');
            } else {
                Alert_Helper::error('Rejection failed', 'Failed to reject community.');
            }
            redirect('admin/manageCommunities');
        } else {
            redirect('admin/manageCommunities');
        }
    }

    // Delete a community
    public function deleteCommunity($communityId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deleteCommunityById($communityId)) {
                Alert_Helper::success('Success', 'Community deleted successfully.');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete community.');
            }
            redirect('admin/manageCommunities');
        } else {
            redirect('admin/manageCommunities');
        }
    }

    public function addCommunity()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'communityName' => trim($_POST['communityName']),
                'communityDescription' => trim($_POST['communityDescription']),
                'communityImage' => trim($_POST['communityImage']),
                'membership_type' => trim($_POST['membership_type'])
            ];
            if ($this->adminModel->addCommunity($data)) {
                Alert_Helper::success('Success', 'Community added successfully.');
                redirect('admin/manageCommunities');
            } else {
                Alert_Helper::error('Add failed', 'Failed to add community.');
                $this->view('pages/admin/v_add_community', $data);
            }
        } else {
            $this->view('pages/admin/v_add_community');
        }
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
