<?php
class Users extends Controller
{
    private $userModel;
    private $notificationModel;

    public function __construct()
    {
        $this->userModel = $this->model('M_Users');
        $this->notificationModel =  $this->model('M_Notifications');
    }
    public function loadProfile()
    {
        $data = [];
        $this->view('pages/parent/v_userprofile', $data);
    }

    public function forgotPassword()
    {
        $data = [];
        $this->view('users/v_forgotpassword', $data);
    }

    public function notifications() {
        $userId = $_SESSION['user_id']; 
    
        $notifications = $this->notificationModel->getNotifications($userId);
    
        $data = [
            'notifications' => $notifications
        ];
    
        // Load the view and pass the data to it
        $this->view('books/v_booknotifications', $data);
    }
    
    
    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Form is submitting
            //validate data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'profile_image' => $_FILES['profile_image'],
                'profile_image_name' => time().'_'.$_FILES['profile_image']['name'],
                'email' => trim($_POST['email']),
                'name' => trim($_POST['name']),
                'password' => trim($_POST['password']),
                'confirmPassword' => trim($_POST['confirmPassword']),
                'address' => trim($_POST['address']),
                'contactNumber' => trim($_POST['contactNumber']),

                'profile_image_err' => '',
                'email_err' => '',
                'name_err' => '',
                'password_err' => '',
                'confirmPassword_err' => '',
                'address_err' => '',
                'contactNumber_err' => ''

            ];
            //validate each input

            //validate profile image and upload
            if(uploadImage($data['profile_image']['tmp_name'], $data['profile_image_name'], '/img/profileImgs/')){
                //done
            }
            else{

                $data['profile_image_err'] = 'Profile image uploaded unsuccesfully';
            }

            //validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter a email';
            } else {
                //Check if email is already registered or not
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'This email already exists';
                }
            }


            //validate name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter a name';
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

            // Validate Address
            if (empty($data['address'])) {
                $data['address_err'] = 'Please enter your address';
            }

            // Validate Contact Number (Sri Lankan format)
            if (empty($data['contactNumber'])) {
                $data['contactNumber_err'] = 'Please enter your contact number';
            } elseif (!preg_match('/^07[0-9]{8}$/', $data['contactNumber'])) {
                $data['contactNumber_err'] = 'Invalid phone number (should be 10 digits, starting with 07X)';
            }

            //Validatation is completed and no error then register user
            if (
                empty($data['email_err']) && empty($data['profile_image_err'])&& empty($data['name_err']) && empty($data['password_err']) && empty($data['confirmPassword_err']) && empty($data['address_err']) && empty($data['contactNumber_err'])
            ) {
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                //Register user
                if ($this->userModel->registerUser($data)) {

                    //create a flash message
                    flash('reg_flash', 'You are suceesfully regsitered!');
                    redirect('users/login');
                } else {
                    redirect('users/signup');
                }
            } else {
                //load view
                $this->view('users/v_signup', $data);
            }
        } else {
            //Initial form
            $data = [
                'profile_image' => '',
                'profile_image_name' => '',
                'email' => '',
                'name' => '',
                'password' => '',
                'confirmPassword' => '',
                'address' => '',
                'contactNumber' => '',

                'profile_image_err' => '',
                'email_err' => '',
                'name_err' => '',
                'password_err' => '',
                'confirmPassword_err' => '',
                'address_err' => '',
                'contactNumber_err' => ''

            ];
            //Load view
            $this->view('users/v_signup', $data);
        }
    }
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //form is submitting
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),

                'email_err' => '',
                'password_err' => ''

            ];
            //validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter the email';
            } else {
                if ($this->userModel->findUserByEmail($data['email'])) {
                    //User is found
                } else {
                    //User is not found
                    $data['email_err'] = 'User not found';
                }
            }
            //validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            //if no error found in login
            if (empty($data['email_err']) && empty($data['password_err'])) {
                //log the user
                $loggedUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedUser) {
                    //user is authenticated
                    //create user session
                    $this->createUserSession($loggedUser);
                } else {
                    $data['password_err'] = 'Invalid Password';

                    //load view with errors
                    $this->view('users/v_login', $data);
                }
            } else {
                //load view with errors
                $this->view('users/v_login', $data);
            }
        } else {
            //Initial form

            $data = [
                'email' => '',
                'password' => '',

                'email_err' => '',
                'password_err' => ''

            ];
            //Load view
            $this->view('users/v_login', $data);
        }
    }
    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['user_photo']=$user->user_photo;
        $_SESSION['user_email'] = $user->user_email;
        $_SESSION['user_name'] = $user->user_name;
        $_SESSION['user_role'] = $user->user_role;
        $_SESSION['user_address']=$user->user_address;
        $_SESSION['user_phone']=$user->user_phone;

        if ($_SESSION['user_role'] === 'parent') {
            redirect('Pages/parentView'); // Parent view
        } elseif ($_SESSION['user_role'] === 'admin') {
            redirect('admin'); // Corrected: Redirect admin to Admin controller index
        } elseif ($_SESSION['user_role'] === 'ambassador') {
            redirect('Pages/ambassadorView'); // Ambassador view
        } else {
            // Assuming the only other role is 'child'
            redirect('Pages/childView'); // Child view
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        unset($_SESSION['user_photo']);
        unset($_SESSION['user_role']);
        unset($_SESSION['user_address']);
        session_destroy();

        redirect('Users/login');
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
    public function forgot_password()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);

            if ($this->userModel->findUserByEmail($email)) {
                $token = bin2hex(random_bytes(50));
                $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

                $this->userModel->storeResetToken($email, $token, $expiry);

                // Send reset link (you can use PHPMailer or simple mail())
                $resetLink = URLROOT . "/users/reset_password?token=$token";
                $subject = "Password Reset Request";
                $message = "Click the following link to reset your password: $resetLink";

                mail($email, $subject, $message);

                flash('reset_link_sent', 'Check your email for the reset link.');
                redirect('users/login');
            } else {
                flash('email_not_found', 'No user found with that email.', 'alert alert-danger');
                redirect('users/forgot_password');
            }
        } else {
            $this->view('users/forgot_password');
        }
    }

    public function reset_password()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $token = $_POST['token'];
            $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

            if ($this->userModel->isValidToken($token)) {
                $this->userModel->updatePasswordByToken($token, $newPassword);
                flash('password_reset_success', 'Password updated successfully. You can now log in.');
                redirect('users/login');
            } else {
                flash('invalid_token', 'Invalid or expired token.', 'alert alert-danger');
                redirect('users/forgot_password');
            }
        } else {
            $this->view('users/reset_password');
        }
    }
    public function edit_profile()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            $data = [
                'user_id' => $_SESSION['user_id'], // get current logged-in user ID
                'name' => trim($_POST['name']),
                'password' => trim($_POST['password']),
                'confirmPassword' => trim($_POST['confirmPassword']),
                'address' => trim($_POST['address']),
                'contactNumber' => trim($_POST['contactNumber']),
    
                // error messages

                'name_err' => '',
                'password_err' => '',
                'confirmPassword_err' => '',
                'address_err' => '',
                'contactNumber_err' => ''
            ];
    
    
            // Name validation
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter a name';
            }
    
            // Address validation
            if (empty($data['address'])) {
                $data['address_err'] = 'Please enter your address';
            }
    
            // Contact number validation (Sri Lankan format)
            if (empty($data['contactNumber'])) {
                $data['contactNumber_err'] = 'Please enter your contact number';
            } elseif (!preg_match('/^07[0-9]{8}$/', $data['contactNumber'])) {
                $data['contactNumber_err'] = 'Invalid phone number format';
            }
    
            // Password validation (if user entered something)
            if (!empty($data['password']) || !empty($data['confirmPassword'])) {
                if (strlen($data['password']) < 8 ||
                    !preg_match('/[A-Z]/', $data['password']) ||
                    !preg_match('/[a-z]/', $data['password']) ||
                    !preg_match('/\d/', $data['password']) ||
                    !preg_match('/[\W]/', $data['password'])) {
                    $data['password_err'] = 'Password must be 8+ chars and include uppercase, lowercase, digit, and special char';
                }
    
                if ($data['password'] !== $data['confirmPassword']) {
                    $data['confirmPassword_err'] = 'Passwords do not match';
                }
            }
    
            // If no errors
            if (
                empty($data['name_err']) &&
                empty($data['password_err']) && empty($data['confirmPassword_err']) &&
                empty($data['address_err']) && empty($data['contactNumber_err'])
            ) {

                // Hash password if changed
                if (!empty($data['password'])) {
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                } else {
                    $data['password'] = null; // signal to model that password isn't changing
                }
                $newdata=$this->userModel->updateUserProfile($data);
    
                // Update user
                if ($newdata) {
                    // Update session data
                    $_SESSION['user_name'] = $data['name'];
                    $_SESSION['user_address'] = $data['address'];
                    $_SESSION['user_phone'] = $data['contactNumber'];
    
                    flash('profile_flash', 'Profile updated successfully');
                    redirect('users/loadProfile'); // or wherever the profile page is
                } else {
                    die('Something went wrong');
                }
            } else {

                // Load the same profile form with errors
                $this->view('users/v_userprofile', $data);

            }
        } else {
            // Not POST request
            $user = $this->userModel->getUserById($_SESSION['user_id']);
            $data = [
                'name' => $user->name,
                'address' => $user->address,
                'contactNumber' => $user->contact_number,
                'password' => '',
                'confirmPassword' => '',
                'name_err' => '',
                'password_err' => '',
                'confirmPassword_err' => '',
                'address_err' => '',
                'contactNumber_err' => ''
            ];
            flash('profile_flash', 'Profile updated successfully');
            $this->view('users/v_userprofile', $data);
        }
    }

}
