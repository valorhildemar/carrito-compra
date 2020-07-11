<?php
  session_start();
  include_once('../class/ProcessLogin.php');
  include_once('../class/Rate.php');

  $user = new ProcessLogin(); 
  $id = $_SESSION['id'];
  if (!$user->get_session()){
      header("location:index.php");
  }
  if (isset($_GET['q'])){
     $user->user_logout();
     header("location:index.php");
  }

  $rate = new Rate();
  $result = $rate->get_one_product($_GET['p']);
  if($result){
    header("location:./view/rate.php");
  }
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Virtual Cart</title>

		<meta charset="utf-8">

    <script type="text/javascript" src="./resources/js/function.js"></script>

    <link rel="stylesheet" type="text/css" href="./resources/css/style.css">

		<link rel="stylesheet" href="./resources/bootstrap/css/bootstrap.min.css">
		<script src="./resources/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	</head>
<body>
<div class="container">
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col" class="text-center">List of Products</th>
    </tr>
    <tr>
      <th class="text-center">Code</th>
      <th class="text-center">Product Name</th>
      <th class="text-center">Description</th>
      <th class="text-center">Price $</th>
      <th class="text-center">Option</th>
    </tr>
  </thead>
  <tbody>
    <?= $rate->get_one_product(); ?>
  </tbody>
</table>
</div>	
</body>
</html>