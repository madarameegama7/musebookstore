<?php

require_once __DIR__ . '/../Admin.php';

class UserAdminController extends Admin
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
            redirect('admin/user/manageUsers');
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
            redirect('admin/user/manageUsers');
        }

        // Removed restriction on editing self - admins should be able to edit their own details

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
                redirect('admin/user/manageUsers');
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
                    redirect('admin/user/manageUsers'); // Or redirect('admin/user/viewUser/' . $userId);
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
            redirect('admin/user/manageUsers');
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
                redirect('admin/user/viewUser/' . $userId);
                return; // Stop execution
            }

            if ($this->adminModel->updateUserRole($userId, $newRole)) {
                Alert_Helper::success('Success', 'User role updated successfully.');
            } else {
                Alert_Helper::error('Update failed', 'Failed to update user role.');
            }
            redirect('admin/user/viewUser/' . $userId);
        } else {
            // Redirect if not a POST request
            redirect('admin/user/manageUsers');
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
                redirect('admin/user/manageUsers');
                return;
            }

            // Prevent deleting self
            if ($userId == $_SESSION['user_id']) {
                Alert_Helper::error('Action not allowed', 'You cannot delete your own account.');
                redirect('admin/user/manageUsers');
                return;
            }

            if ($this->adminModel->deleteUserById($userId)) {
                Alert_Helper::success('Success', 'User deleted successfully.');
                redirect('admin/user/manageUsers');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete user.');
                redirect('admin/user/manageUsers');
            }
        } else {
            // If accessed via GET, redirect (deletion should be via POST)
            redirect('admin/user/manageUsers');
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
                    redirect('admin/user/manageUsers');
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
}
