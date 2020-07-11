<?php
	include_once('Connection.php');

	class ProcessLogin extends Model{		
	public function __construct(){
			parent::__construct();
	}

	/*** for login process ***/
	public function check_login($username, $password){

		$sql = $this->con->query("SELECT id, balance FROM user WHERE login='$username' AND password='$password'");

		//checking if the username is available in the table
		$user_data = mysqli_fetch_array($sql);
		$count_row = $sql->num_rows;

			if ($count_row == 1) {
				// this login var will use for the session thing
				$_SESSION['login'] = true;
				$_SESSION['id'] = $user_data['id'];
				$_SESSION['balance'] = $user_data['balance'];
				return true;
			}
			else{
				return false;
			}
	}

	/*** for showing the username or fullname ***/
	public function get_fullname($id){
		$sql = $this->con->query("SELECT login FROM user WHERE id='$id'");
	
		$user_data = mysqli_fetch_array($sql);
		echo $user_data['login'];
	}

	/*** starting the session ***/
	public function get_session(){
		return $_SESSION['login'];
	}

	public function user_logout() {
		$_SESSION['login'] = FALSE;
		session_destroy();
	}

	/*** starting the session ***/
	public function get_balance(){
		return $_SESSION['balance'];
	}

}

?>