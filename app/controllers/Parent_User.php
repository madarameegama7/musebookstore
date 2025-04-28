<?php
/**
 * Parent User Controller
 * 
 * Handles all parent-specific operations including child account management
 * and book request approvals
 */
class Parent_User extends Controller 
{
    private $_childModel;
    private $_bookModel;

    /**
     * Constructor
     */
    public function __construct() 
    {
        // Redirect if not logged in as parent
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'parent') {
            redirect('users/login');
        }

        $this->_childModel = $this->model('M_Child');
        $this->_bookModel = $this->model('M_Books');
    }

    /**
     * Show children list for the logged in parent
     * 
     * @return void
     */
    public function index() 
    {
        $children = $this->_childModel->getChildrenByParent($_SESSION['user_id']);
        
        $data = [
            'children' => $children
        ];
        
        $this->view('pages/parent/v_children_list', $data);
    }

    /**
     * Show form to create a child account
     */
    public function createChild() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter an email';
            } else {
                // Check if email exists
                $userModel = $this->model('M_Users');
                if($userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }
            
            // Validate name
            if(empty($data['name'])) {
                $data['name_err'] = 'Please enter a name';
            }
            
            // Validate password
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter a password';
            } elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }
            
            // Validate confirm password
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } elseif($data['password'] != $data['confirm_password']) {
                $data['confirm_password_err'] = 'Passwords do not match';
            }
            
            // Make sure errors are empty
            if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Use the provided password
                $plain_password = $data['password']; // Store for display
                $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
                
                // Prepare data for child account
                $childData = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $hashed_password,
                    'parent_id' => $_SESSION['user_id']
                ];
                
                // Create child account
                $result = $this->_childModel->createChild($childData);
                
                if($result) {
                    flash('child_account', 'Child account created successfully.', 'alert alert-success');
                    redirect('parent_user');
                } else {
                    flash('child_account', 'Something went wrong creating the child account', 'alert alert-danger');
                    $this->view('pages/parent/v_create_child', $data);
                }
            } else {
                // Load view with errors
                $this->view('pages/parent/v_create_child', $data);
            }
        } else {
            // Init form
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            $this->view('pages/parent/v_create_child', $data);
        }
    }

    /**
     * Show pending book requests
     * 
     * @return void
     */
    public function requests() 
    {
        $requests = $this->_childModel->getRequestsByParent($_SESSION['user_id']);
        
        $data = [
            'requests' => $requests
        ];
        
        $this->view('pages/parent/v_book_requests', $data);
    }

    /**
     * Approve a book request
     * 
     * @param int $id Request ID to approve
     * @return void
     */
    public function approveRequest($id) 
    {
        if (!$id) {
            redirect('parent_user/requests');
        }
        
        if ($this->_childModel->approveRequest($id)) {
            flash('request_message', 'Request approved');
        } else {
            flash('request_message', 'Something went wrong', 'alert alert-danger');
        }
        
        redirect('parent_user/requests');
    }

    /**
     * Deny a book request
     * 
     * @param int $id Request ID to deny
     * @return void
     */
    public function denyRequest($id) 
    {
        if (!$id) {
            redirect('parent_user/requests');
        }
        
        if ($this->_childModel->denyRequest($id)) {
            flash('request_message', 'Request denied');
        } else {
            flash('request_message', 'Something went wrong', 'alert alert-danger');
        }
        
        redirect('parent_user/requests');
    }
    
    /**
     * Show edit child form
     * 
     * @param int $id Child user ID to edit
     * @return void
     */
    public function editChild($id = null) 
    {
        // Verify this child belongs to the logged in parent
        if (!$id || !$this->_childModel->verifyChildParent($id, $_SESSION['user_id'])) {
            flash('child_error', 'Unauthorized access', 'alert alert-danger');
            redirect('parent_user');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'name_err' => '',
                'email_err' => ''
            ];
            
            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter an email';
            } else {
                // Check if email exists and is not the current child's email
                $userModel = $this->model('M_Users');
                $child = $this->_childModel->getUserById($id);
                
                if ($userModel->findUserByEmail($data['email']) && $data['email'] != $child->user_email) {
                    $data['email_err'] = 'Email is already taken';
                }
            }
            
            // Validate name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter a name';
            }
            
            // Make sure errors are empty
            if (empty($data['email_err']) && empty($data['name_err'])) {
                // Update child account
                if ($this->_childModel->updateChild($data)) {
                    flash('child_updated', 'Child account updated successfully', 'alert alert-success');
                    redirect('parent_user');
                } else {
                    flash('child_updated', 'Something went wrong updating the child account', 'alert alert-danger');
                    $this->view('pages/parent/v_edit_child', $data);
                }
            } else {
                // Load view with errors
                $this->view('pages/parent/v_edit_child', $data);
            }
        } else {
            // Get child data
            $child = $this->_childModel->getUserById($id);
            
            // Init form
            $data = [
                'id' => $id,
                'name' => $child->user_name,
                'email' => $child->user_email,
                'name_err' => '',
                'email_err' => ''
            ];
            
            $this->view('pages/parent/v_edit_child', $data);
        }
    }
    
    /**
     * Delete a child account
     * 
     * @param int $id Child user ID to delete
     * @return void
     */
    public function deleteChild($id = null) 
    {
        // Verify this child belongs to the logged in parent
        if (!$id || !$this->_childModel->verifyChildParent($id, $_SESSION['user_id'])) {
            flash('child_error', 'Unauthorized access', 'alert alert-danger');
            redirect('parent_user');
        }
        
        // Get child name for success message
        $child = $this->_childModel->getUserById($id);
        $childName = $child ? $child->user_name : 'Child';
        
        if ($this->_childModel->deleteChild($id)) {
            flash('child_deleted', $childName . '\'s account was successfully deleted', 'alert alert-success');
        } else {
            flash('child_deleted', 'Something went wrong deleting the child account', 'alert alert-danger');
        }
        
        redirect('parent_user');
    }
}
?>