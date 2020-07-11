<?php
    session_start();
    include_once('class/ProcessLogin.php');
    include_once('class/UserRegister.php');
    //Process Login
    $user = new ProcessLogin();
    if (isset($_REQUEST['submit'])) {
        extract($_REQUEST);
        $username = $_POST["username"];
        $password = $_POST["password"];

        $login = $user->check_login($username, $password);
        if ($login) {
            // Registration Success
           header("location:home.php");
        } else {
            // Registration Failed
            echo 'Wrong username or password';
        }
    }

    //Process user register
    $useregister = new UserRegister();
    $message = "";
    if (isset($_REQUEST['submitRegister'])) {
        extract($_REQUEST);
        $usereg = $_POST["user"];
        $passreg = $_POST["pass"];

        $result = $useregister->user_reg($usereg, $passreg);
        if ($result) {
            // Registration Success
           $message = '<div class="alert alert-success">Successfully created user</div>';
        } else {
            // Registration Failed
            $message = '<div class="alert alert-danger">Failed created user</div>';
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Internet Shop</title>

	<meta charset="utf-8">
	<script type="text/javascript" src="./resources/js/function.js"></script>
	<link rel="stylesheet" type="text/css" href="./resources/css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container"> 
<?= $message ?>
</div>
	<h1 class="text-center">WELCOME TO THE INTERNET STORE</h1>
<div class="container d-flex justify-content-center" id="login" style="width: 100rem;">
	<div class="card panel-default">
		<div class="card-header text-center">
			<h2>LOGIN</h2>
		</div>
		<div class="card-body">
			<form action="" method="post" name="login">
  				<div class="form-group">
			    <label for="exampleInputEmail1">Username</label>
			    <input type="text" name="username" class="form-control" aria-describedby="emailHelp" placeholder="Enter Username">
			  </div>
			  <div class="form-group">
			    <label for="exampleInputPassword1">Password</label>
			    <input type="password" name="password" class="form-control" placeholder="Password">
			  </div>
			  <button class="btn btn-primary" name="submit">Login</button>
			  <a href="#bannerformmodal" data-toggle="modal" data-target="#myModal">Create user</a>
			</form>
		</div>
	</div>
</div>
</body>
</html>

<div class="container">
  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Register User</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <form action="" method="post" name="register">
		  <div class="form-group">
		    <label for="user">User</label>
		    <input type="text" class="form-control" id="user" name="user" required aria-describedby="emailHelp" placeholder="Enter user">
		  </div>
		  <div class="form-group">
		    <label for="password">Password</label>
		    <input type="password" class="form-control" id="pass" name="pass" required placeholder="Password">
		  </div>
		  <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="submitRegister">Register</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
		</form>
        </div>
      </div>
    </div>
  </div>
  
</div>
