<?php
    session_start();
    include_once('../class/Product.php');
    include_once('../class/ProcessLogin.php');
    $product = new Product();
    if (isset($_REQUEST['submit'])) {
        extract($_REQUEST);
        $rate = $_POST["username"];
        $id_user = $_SESSION['id'];

        $reg = $product->reg_rate($rate, $id_user);
        if ($reg) {
            // Registration Success
           echo 'Successful registration';
        } else {
            // Registration Failed
            echo 'Wrong registration';
        }
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Virtual Cart</title>

		<meta charset="utf-8">
    <script type="text/javascript" src="js/function.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	</head>
<body>
<div id="container">
<form name="">
	<table class="table table-striped">
	  <thead>
	    <tr>
	      <th scope="col" class="text-center">I can rate it</th>
	    </tr>
	  </thead>
	  <tbody>
	  </tbody>
	</table>
</form>
<br><br>
</div>	
</body>
</html>