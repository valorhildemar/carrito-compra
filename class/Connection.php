<?php
	include_once('config_db/config.php');
class Model {

  protected $con;

  public function __construct()
  {
	$this->con = mysqli_connect(db_host, db_user, db_pass, db_name);
	if ($this->con->connect_errno) {
		echo 'Failed to connect to MySQL: ' .$this->con->connect_errno;
		return;
    }
  $this->con->set_charset("utf8");
 }
}
?>