<?php
    class User {
        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }

        // register user
        public function register($data)
        {
            // prepared statement
            $this->db->query('INSERT INTO users (user_name, user_email, user_pass) VALUES(:username, :email, :password)');

            // bind values
            $this->db->bind(':username',$data['username']);
            $this->db->bind(':email',$data['email']);
            $this->db->bind(':password',$data['password']);

            // execute function
            if($this->db->execute())
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        // login user
        public function login($username, $password)
        {
            // prepared statement
            $this->db->query('SELECT * FROM users where user_name = :username');

            // bind params
            $this->db->bind(':username', $username);

            // get single row
            $row = $this->db->single();

            $hashedPassword = $row->user_pass;
            if(password_verify($password, $hashedPassword))
            {
                return $row;
            }
            else
            {
                return false;
            }
        }
        // find user by email
        public function findUserByEmail($email)
        {
            // prepared statement
            $this->db->query('SELECT * FROM users WHERE user_email =:email');

            // email param will be binded with email variable
            $this->db->bind(':email',$email);

            // check if email already exists
            if($this->db->rowCount() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        // get all users
        public function getUsers() {
            $this->db->query("SELECT * FROM users");
            $result = $this->db->resultSet();

            return $result;
        }
    }