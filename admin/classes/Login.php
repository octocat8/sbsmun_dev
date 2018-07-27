<?php
class Login{
	private $db_connection = null;
	public $errors = array();
	public $messages = array();
	// constructor
	public function __construct() {
		session_start();
		if(isset($_GET["logout"])) {
			$this->doLogout();
		} elseif (isset($_POST["login"])) {
			$this->doLoginWithPostData();
		}
	}
	// Login fn
	private function doLoginWithPostData() {
		if(!empty($_POST['username']) && !empty($_POST['password'])) {
			$this->db_connection = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
		}
		if(!$this->db_connection->connect_errno) {
			$username = $this->db_connection->real_escape_string($_POST['username']);
			$sql="SELECT * FROM  users WHERE username = {$username}";
			$resultofcheck = $this->db_connection->query($sql);
			if($resultofcheck->num_rows == 1) {
				$resultrow = $resultofcheck0>fetch_object();
				if(password_verify($_POST['password'], $resultrow->password)) {
					$_SESSION['username'] = $resultrow->username;
					$_SESSION['login_status'] = 1;
				} else {
					$this->errors[] = "Wrong Password";
				}
			} else {
				$this->errors[] = "User does not exist";	
			}
		} else {
			$this->errors[] = "Database unreachable";
		}
	}
	// Logout fn
	public function doLogout() {
		session_destroy();
		$this->messages[] = "Logged out";
	}
	// Check if user logged in
	public function isUserloggedIn() {
		if(isset($_SESSION['login_status']) && $_SESSION['login_status'] == 1) {
			return true;
		} else { return false; }
	}
}
?>
