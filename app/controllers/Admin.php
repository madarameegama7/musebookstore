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

    // User Management
    public function manageUsers() {
        $users = $this->adminModel->getAllUsers();
        $data = [
            'title' => 'Manage Users',
            'users' => $users
        ];
        $this->view('pages/admin/v_manage_users', $data);
    }

    // Add methods for viewing/editing/deleting users later

    // Book Management
    public function manageBooks() {
        $books = $this->adminModel->getAllBooks(); // Need to implement this in M_Admin
        $data = [
            'title' => 'Manage Books',
            'books' => $books
        ];
        $this->view('pages/admin/v_manage_books', $data);
    }

     // Add methods for viewing/editing/deleting books later

    // Add other admin-specific methods here (e.g., manageBooks, etc.)
}
