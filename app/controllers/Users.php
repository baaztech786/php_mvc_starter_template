<?php
class Users extends Controller
{
    public function __construct()
    {
       $this->userModel = $this->model('User');
    }

    public function register()
    {
        $data = [
            'title'=> 'Register',
            'username' => '',
            'email' => '',
            'password' => '',
            'confirmPassword' => '',
            'usernameError' => '',
            'emailError' => '',
            'passwordError' => '',
            'confirmPasswordError' => ''

        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //Sanitize input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title'=> 'Register',
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirmPassword' => trim($_POST['confirmPassword']),
                'usernameError' => '',
                'emailError' => '',
                'passwordError' => '',
                'confirmPasswordError' => ''

            ];

            $nameValidation = "/^[a-zA-Z0-9]*$/";
            $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";


            // validate username on letters/numbers
            if(empty($data['username']))
            {
                $data['usernameError'] ="Please enter username";
            }
            elseif(!preg_match($nameValidation, $data['username']))
            {
                $data['usernameError'] ="username can only contain letters and number";
            }

            // validate email
            if(empty($data['email']))
            {
                $data['emailError'] ="Please enter email";
            }
            elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            {
                $data['emailError'] ="Please enter the correct format";
            }
            else
            {
                // check if email exists
                if($this->userModel->findUserByEmail($data['email']))
                {
                    $data['emailError'] ="Email is already in use";
                }
            }

            // validate password on length and numeric values
            if(empty($data['password']))
            {
                $data['passwordError'] = "please enter password";
            }
            elseif(strlen($data['password']) < 8)
            {
                $data['passwordError'] = "password must be atleast 8 characters";
            }
            elseif(!preg_match($passwordValidation, $data['password']))
            {
                $data['passwordError'] ="Password must have atleast 1 numeric value";
            }


            // validate confirm password
            if(empty($data['confirmPassword']))
            {
                $data['confirmPasswordError'] = "please enter password";
            }
            else
            {
                if($data['password'] != $data['confirmPassword'])
                {
                    $data['confirmPasswordError'] = "passwords do not match, please try again";
                }
            }


            // make sure if errors are empty
            if(empty($data['usernameError']) && empty($data['emailError']) && empty($data['passwordError']) && empty($data['confirmPasswordError']))
            {
                // hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user from model function
                if($this->userModel->register($data))
                {
                    // redirect to login page
                    header('Location:'. URLROOT . '/users/login');
                }
                else
                {
                    die("something went wrong!");
                }
            }
        }
        $this->view('users/register', $data);
    }

    public function Login()
    {
        $data = [
            'title'=> 'Login',
            'username' => '',
            'password' => '',
            'usernameError' => '',
            'passwordError' => ''
        ];

        // Check for post
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title'=> 'Login',
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'usernameError' => '',
                'passwordError' => ''
            ];


            // Validate username
            if(empty($data['username']))
            {
                $data['usernameError'] = "please enter username";
            }

            // Validate password
            if(empty($data['password']))
            {
                $data['passwordError'] = "please enter password";
            }

            // checkif all errors are empty
            if(empty($data['usernameError']) && empty($data['usernameError']))
            {
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);

                if($loggedInUser)
                {
                    $this->createUserSession($loggedInUser);
                }
                else
                {
                    return $data['passwordError'] = "Username or Password is wrong. Try again";

                    $this->view('users/login', $data);
                }
            }
        }
        else
        {
            $data = [
                'title'=> 'Login',
                'username' => '',
                'password' => '',
                'usernameError' => '',
                'passwordError' => ''
            ];
        }
        $this->view('users/login', $data);
    }

    // create user session when he logs in
    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['username'] = $user->user_name;
        $_SESSION['email'] = $user->user_email;
    }

    // logout user
    public function logout()
    {
      unset($_SESSION['user_id']);
      unset($_SESSION['username']);
      unset($_SESSION['email']);
      session_destroy();
      header('Location:'. URLROOT . '/users/login');
    }
}