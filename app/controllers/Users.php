<?php
class Users extends Controller{
    private $userModel;

    public function __construct(){
        $this->userModel = $this->model('M_Users');

    }
    public function signup(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Form is submitting
            //validate data
            $_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data=[
                'email'=>trim($_POST['email']),
                'name'=>trim($_POST['name']),
                'password'=>trim($_POST['password']),
                'confirmPassword'=>trim($_POST['confirmPassword']),
                'nic'=>trim($_POST['nic']),
                'address'=>trim($_POST['address']),
                'contactNumber'=>trim($_POST['contactNumber']),

                'email_err'=>'',
                'name_err'=>'',
                'password_err'=>'',
                'confirmPassword_err'=>'',
                'nic_err'=>'',
                'address_err'=>'',
                'contactNumber_err'=>''

            ];
            //validate each input

            //validate email
            if(empty($data['email'])){
                $data['email_err']='Please enter a email';
            }
            else{
                //Check if email is already registered or not
                if($this->userModel->findUserByEmail($data['email'])){
                    $data['email_err']='This email already exists';
                }

            }


            //validate name
            if(empty($data['name'])){
                $data['name_err']='Please enter a name';
            }

           // Validate password
if (empty($data['password']) || empty($data['confirmPassword'])) {
    $data['password_err'] = 'Please enter a password';
} else {
    // Check minimum length
    if (strlen($data['password']) < 8) {
        $data['password_err'] = 'Password must be at least 8 characters long';
    }
    // Check for at least one uppercase letter
    elseif (!preg_match('/[A-Z]/', $data['password'])) {
        $data['password_err'] = 'Password must contain at least one uppercase letter';
    }
    // Check for at least one lowercase letter
    elseif (!preg_match('/[a-z]/', $data['password'])) {
        $data['password_err'] = 'Password must contain at least one lowercase letter';
    }
    // Check for at least one digit
    elseif (!preg_match('/\d/', $data['password'])) {
        $data['password_err'] = 'Password must contain at least one number';
    }
    // Check for at least one special character
    elseif (!preg_match('/[\W]/', $data['password'])) {
        $data['password_err'] = 'Password must contain at least one special character (@, #, $, etc.)';
    }
}

// Validate password confirmation
if (empty($data['confirmPassword'])) {
    $data['confirmPassword_err'] = 'Please confirm your password';
} elseif ($data['password'] !== $data['confirmPassword']) {
    $data['confirmPassword_err'] = 'Passwords do not match';
}

            //validate NIC
            if (empty($data['nic'])) {
                $data['nic_err'] = 'Please enter your NIC number';
            } elseif (!preg_match('/^\d{9}[VvXx]$|^\d{12}$/', $data['nic'])) {
                $data['nic_err'] = 'Invalid NIC format (e.g., 123456789V or 200012345678)';
            }

             // Validate Address
            if (empty($data['address'])) {
               $data['address_err'] = 'Please enter your address';
            }
   
            // Validate Contact Number (Sri Lankan format)
            if (empty($data['contactNumber'])) {
               $data['contactNumber_err'] = 'Please enter your contact number';
            } 
            elseif (!preg_match('/^07[0-9]{8}$/', $data['contactNumber'])) {
               $data['contactNumber_err'] = 'Invalid phone number (should be 10 digits, starting with 07X)';
    }

            //Validatation is completed and no error then register user
            if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirmPassword_err']) && 
            empty($data['nic_err']) &&empty($data['address_err']) && empty($data['contactNumber_err'])) {
            // Hash password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                      //Register user
                      if ($this->userModel->registerUser($data)) {

                        redirect('users/login');
                
                    } else {
                        redirect('users/signup');
                    }
                    }            

            else{
                //load view
                $this->view('users/v_signup',$data);

            }



        }

        else{
            //Initial form
            $data=[
                'email'=>'',
                'name'=>'',
                'password'=>'',
                'confirmPassword'=>'',
                'nic'=>'',
                'address'=>'',
                'contactNumber'=>'',

                'email_err'=>'',
                'name_err'=>'',
                'password_err'=>'',
                'confirmPassword_err'=>'',
                'nic_err'=>'',
                'address_err'=>'',
                'contactNumber_err'=>''

            ];
            //Load view
            $this->view('users/v_signup',$data);
        }
    } 
    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //form is submitting
            $_POST=filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data=[
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),

                'email_err' => '',
                'password_err' => ''

            ];
            //validate email
            if(empty($data['email'])){
                $data['email_err'] = 'Please enter the email';
            }
            else{
                if($this->userModel->findUserByEmail($data['email'])){
                    //User is found
                }
                else{
                    //User is not found
                    $data['email_err'] = 'User not found';
                }
            }
            //validate password
            if(empty($data['password'])){
                $data['password_err'] = 'Please enter password';
            }

            //if no error found in login
            if(empty($data['email_err']) && empty($data['password_err'])){
                //log the user
                $loggedUser=$this->userModel->login($data['email'],$data['password']);

                if($loggedUser){
                    //user is authenticated
                    //create user session
                    $this->createUserSession($loggedUser);
                    
                }
                else{
                    $data['password_err']='Invalid Password';

                    //load view with errors
                    $this->view('users/v_login',$data);
                }
            }
            else{
                //load view with errors
                $this->view('users/v_login',$data);

            }   
        }
        else{
            //Initial form

            $data=[
                'email' => '',
                'password' => '',

                'email_err' => '',
                'password_err' => ''

            ];
            //Load view
            $this->view('users/v_login',$data);
        }
        


    }
    public function createUserSession($user){
        $_SESSION['user_id']=$user->user_id;
        $_SESSION['user_email']=$user->user_email;
        $_SESSION['user_name']=$user->user_name;
        $_SESSION['user_role']=$user->user_role;

        if ($_SESSION['user_role'] === 'parent') {
            redirect('Pages/parentView'); // Parent view
        } elseif ($_SESSION['user_role'] === 'admin') {
            redirect('Pages/adminView'); // Admin view
        }elseif($_SESSION['user_role'] === 'ambassador'){
            redirect('Pages/ambassadorView'); // Ambassador view
        }
         else {
            redirect('Pages/childView'); // Child view
        }
        

    }

    public function logout(){
        unset( $_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();

        redirect('Users/login');

    }

    public function isLoggedIn(){
        if(isset($_SESSION['user_id'])){
            return true;
        }
        else{
            return false;
        }
    }

}
?>