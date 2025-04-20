<?php
class Admin extends Controller
{
    private $adminModel;
    private $userModel; // Add user model instance
    private $bookModel; // Add book model instance

    public function __construct()
    {
        // Ensure user is logged in and is an admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            // Optionally flash a message
            flash('auth_err', 'Admin access required.', 'alert alert-danger');
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
        // Fetch data needed for analytics (start with basic counts)
        $userCount = $this->adminModel->getUserCount();
        $bookCount = $this->adminModel->getBookCount();
        // Add more complex data fetching later (e.g., signups per month, listings per category)

        $data = [
            'title' => 'Site Analytics',
            'userCount' => $userCount,
            'bookCount' => $bookCount,
            // Add other analytics data here
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
            flash('admin_msg', 'User not found.', 'alert alert-danger');
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
            flash('admin_msg', 'User not found.', 'alert alert-danger');
            redirect('admin/manageUsers');
        }

        // Prevent editing self details via this form (can use profile page)
        // Although admin can change their own role via viewUser
        if ($user->user_id == $_SESSION['user_id']) {
            flash('admin_msg', 'Use your profile page to edit your own details.', 'alert alert-warning');
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
                flash('admin_msg', 'User not found.', 'alert alert-danger');
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
                    flash('admin_msg', 'User details updated successfully.');
                    redirect('admin/manageUsers'); // Or redirect('admin/viewUser/' . $userId);
                } else {
                    flash('admin_msg', 'Failed to update user details.', 'alert alert-danger');
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
                flash('admin_msg', 'Invalid user role selected.', 'alert alert-danger');
                redirect('admin/viewUser/' . $userId);
                return; // Stop execution
            }

            if ($this->adminModel->updateUserRole($userId, $newRole)) {
                flash('admin_msg', 'User role updated successfully.');
            } else {
                flash('admin_msg', 'Failed to update user role.', 'alert alert-danger');
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
                flash('admin_msg', 'User not found or already deleted.', 'alert alert-warning');
                redirect('admin/manageUsers');
                return;
            }

            // Prevent deleting self
            if ($userId == $_SESSION['user_id']) {
                flash('admin_msg', 'You cannot delete your own account.', 'alert alert-danger');
                redirect('admin/manageUsers');
                return;
            }

            if ($this->adminModel->deleteUserById($userId)) {
                flash('admin_msg', 'User deleted successfully.');
                redirect('admin/manageUsers');
            } else {
                flash('admin_msg', 'Failed to delete user.', 'alert alert-danger');
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
                    flash('admin_msg', 'New user added successfully.');
                    redirect('admin/manageUsers');
                } else {
                    flash('admin_msg', 'Failed to add user.', 'alert alert-danger');
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
            flash('admin_msg', 'Book not found.', 'alert alert-danger');
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
            flash('admin_msg', 'Book not found.', 'alert alert-danger');
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
                flash('admin_msg', 'Book not found.', 'alert alert-danger');
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
                    flash('admin_msg', 'Book details updated successfully.');
                    redirect('admin/manageBooks'); // Or redirect('admin/viewBook/' . $bookId);
                } else {
                    flash('admin_msg', 'Failed to update book details.', 'alert alert-danger');
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
                    flash('admin_msg', 'New book added successfully.');
                    redirect('admin/manageBooks');
                } else {
                    flash('admin_msg', 'Failed to add book.', 'alert alert-danger');
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
                flash('admin_msg', 'Book not found or already deleted.', 'alert alert-warning');
                redirect('admin/manageBooks');
                return;
            }

            if ($this->adminModel->deleteBookById($bookId)) {
                flash('admin_msg', 'Book deleted successfully.');
                redirect('admin/manageBooks');
            } else {
                flash('admin_msg', 'Failed to delete book.', 'alert alert-danger');
                redirect('admin/manageBooks');
            }
        } else {
            // If accessed via GET, redirect
            redirect('admin/manageBooks');
        }
    }
}
