<?php
class Parent_User extends Controller {
    private $childModel;
    private $bookModel;
    private $userModel;

    public function __construct() {
        // Check if logged in and is parent
        if(!isset($_SESSION['user_id'])) {
            redirect('users/login');
        } elseif($_SESSION['user_role'] !== 'parent') {
            redirect('pages/index');
        }

        $this->childModel = $this->model('M_Child');
        $this->bookModel = $this->model('M_Books');
        $this->userModel=$this->model('M_Users');
    }

    // Child account management
    public function createChild() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Process form
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'parent_id' => $_SESSION['user_id'],
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                // Check email exists
                if($this->childModel->findChildByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already in use';
                }
            }
            
            // Validate name
            if(empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }
            
            // Validate password
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }
            
            // Validate confirm password
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }
            
            // Make sure errors are empty
            if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                
                // Register Child
                if($this->childModel->createChild($data)) {
                    flash('child_created', 'Child account has been created successfully');
                    redirect('parent_user/childrenList');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('pages/parent/v_create_child', $data);
            }
        } else {
            // Init form data
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
            
            // Load view
            $this->view('pages/parent/v_create_child', $data);
        }
    }
    
    // List all children of this parent
    public function childrenList() {
        $parentId = $_SESSION['user_id'];
        $children = $this->childModel->getChildrenByParent($parentId);
        
        $data = [
            'children' => $children
        ];
        
        $this->view('pages/parent/v_children_list', $data);
    }
    
    // View book requests from children
    public function viewRequests() {
        $parentId = $_SESSION['user_id'];
        $requests = $this->childModel->getRequestsByParent($parentId);
        
        $data = [
            'requests' => $requests
        ];
        
        $this->view('pages/parent/v_book_requests', $data);
    }
    
    // Process request (approve/deny)
    public function processRequest($requestId = null, $action = null) {
        if($requestId === null || ($action !== 'approve' && $action !== 'deny')) {
            flash('request_error', 'Invalid request', 'alert alert-danger');
            redirect('parent_user/viewRequests');
        }
        
        // Get request to verify it belongs to one of the parent's children
        $parentId = $_SESSION['user_id'];
        $requests = $this->childModel->getRequestsByParent($parentId);
        
        $validRequest = false;
        $childId = null;
        $bookTitle = '';
        
        foreach($requests as $req) {
            if($req->request_id == $requestId) {
                $validRequest = true;
                $childId = $req->child_id;
                $bookTitle = $req->book_title;
                break;
            }
        }
        
        if(!$validRequest) {
            flash('request_error', 'You cannot process this request', 'alert alert-danger');
            redirect('parent_user/viewRequests');
        }
        
        // Update request status
        $status = ($action === 'approve') ? 'approved' : 'denied';
        if($this->childModel->updateRequestStatus($requestId, $status)) {
            // Create notification for child
            $message = ($action === 'approve') 
                ? "Your request for the book '$bookTitle' has been approved!" 
                : "Your request for the book '$bookTitle' has been denied.";
            
            $this->childModel->createNotification($childId, $message);
            
            flash('request_success', 'Request has been ' . $status, 'alert alert-success');
        } else {
            flash('request_error', 'Unable to process request', 'alert alert-danger');
        }
        
        redirect('parent_user/viewRequests');
    }

    //user dashboard analytics
    public function getchildren() {
        $userid = $_SESSION['user_id'];
        $childcount = $this->userModel->getChildCount($userid);
    
        $data = [
            'childcount' => $childcount
        ];
    
        $this->view('pages/parent/v_userprofile', $data); // <- load view with data
    }    
    

}
?>
