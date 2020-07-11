<?php
	include_once('Connection.php');

	class UserRegister extends Model{		
	public function __construct(){
			parent::__construct();
	}

	/*** for login process ***/
	public function user_reg($usereg, $passreg){

	$sql="SELECT * FROM user WHERE login='$usereg'";
			$status = 1;
			$balance_user = 100;
	       //checking if the username or email is available in db
	       $check = $this->con->query($sql) ;
	       $count_row = $check->num_rows;
	       //if the username is not in db then insert to the table
	    if ($count_row == 0){
	       $sql1="INSERT INTO user SET login='$usereg', password='$passreg', status = '$status', balance = '$balance_user'";
	       $result = mysqli_query($this->con,$sql1) or die(mysqli_connect_errno()."Data cannot inserted");
	            return $result;
	    } else { 
	           return false;
	    }
    }
}