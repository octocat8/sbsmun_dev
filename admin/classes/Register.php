<?php
class Registration {
    // Register new users
    private $db_connection = null;
    public $errors = array();
    public $messages = array();
    public function __construct() {
        if (isset($_POST['register'])) {
            $this->registerNewUser();
        }
    }

    private function registerNewUser() {
        if (empty($_POST['username'])) {
            $this->errors[] = "Empty Username";
        } elseif (empty($_POST['password']) && empty($_POST['password_repeat'])) {
            $this->errors[] = "Empty Password";
        } elseif ($_POST['password'] !== $_POST['password_repeat']) {
            $this->errors[] = "Password and password repeat are not the same";
        } elseif (strlen($_POST['password']) < 6) {
            $this->errors[] = "Password has a minimum length of 6 characters";
        } elseif (strlen($_POST['username']) > 64 || strlen($_POST['username']) < 2) {
            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['username'])) {
            $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        } else {
            $this->db_connection = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
            if(!$this->db_connection->connect_errno) {
                $username = $this->db_connection->real_escape_string(strip_tags($_POST['username'], ENT_QUOTES));
                $password = $_POST['password'];
                // the #encryption
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "SELECT * FROM users WHERE username = {$username}";
                $checkuser = $this->db_connection->query($sql);
                if ($checkuser->num_rows == 1) {
                    $this->errors[] = "Sorry username taken already";
                } else {
                    $sql = "INSERT INTO users (username, password)
                            VALUES('" . $username . "', '" . $password_hash . "');";
                    $insertNewUser = $this->db_connection->query($sql);

                    // if user has been added successfully
                    if ($insertNewUser) {
                        $this->messages[] = "Your account has been created successfully. You can now log in.";
                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                    } 
                }
            } else {
                $this->errors[] = "Database Unreachable";
            }
        }    
    }
}