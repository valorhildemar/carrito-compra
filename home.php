<?php
  session_start();
  //import of classes
  include_once('class/ProcessLogin.php');
  include_once('class/Rate.php');

  include_once('class/Product.php');
  include_once('class/VirtualCart.php');
  include_once('class/ProcessPurchase.php');
  //process add or remove products from the shopping cart.
  $product = new Product();
  $cart = new Cart();

  $result = "";
  $message = "";
  if(isset($_GET['action'])){
    switch ($_GET['action']) {
      case 'add':
        $cart->add_item($_GET['code'], $_GET['amount']);
        break;
      case 'remove':
        $cart->remove_item($_GET['code']);
        break;
      case 'removeAll':
        $cart->removeAll_item($_GET['codeAll']);
        break;
    }
  }

 //process user login
  $user = new ProcessLogin(); 
  $id = $_SESSION['id'];
  if (!$user->get_session()){
      header("location:index.php");
  }
  if (isset($_GET['q'])){
     $user->user_logout();
     header("location:index.php");
  }

  //process average product qualification.
  $rate = new Rate();
  $a = "";
  if(isset($_GET['code'])){
    $result = $rate->get_one_product($_GET['code']);
  }
  if (isset($_REQUEST['submit'])) {
        extract($_REQUEST);
        $rating = $rate->reg_average($rate_product, $cod_product, $name_product, $id_user);
        if ($rating) {
            // Registration Success
           $message = '<div class="alert alert-success">Registration Success</div>';
        } else {
            // Registration Failed
           $message = '<div class="alert alert-danger">You have already rated this product</div>';
        }
  }

  //process purchase
    $purchase = new ProcessPurchase();
    $messagePurch = "";
    if (isset($_REQUEST['submitPay'])) {
        extract($_REQUEST);
        $id_user = $_POST["id_user"];
        $product_name = $_POST["product_name"];
        $product_code = $_POST["product_code"];
        $product_price = $_POST["product_price"];
        $product_amount = $_POST["product_amount"];
        $product_sub = $_POST["product_sub"];
        $carry = $_POST["carry"];
        $date = new DateTime();
        $date_purchase = $date->format('Y-m-d H:i:s');
        $status = 1;
        $result = $purchase->purchase_reg($id_user, $product_name, $product_code, $product_price, $product_amount, $product_sub, $carry, $date_purchase, $status);
        if ($result) {
            // Registration Success
           $messagePurch = '<div class="alert alert-success">Successfully registered purchase</div>';
        } else {
            // Registration Failed
            $messagePurch = '<div class="alert alert-danger">Failed registered purchase</div>';
        }
    }

    $status = $purchase->get_status_purchase();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Virtual Cart</title>
		<meta charset="utf-8">

     <link rel="stylesheet" type="text/css" href="css/style.css">
  <script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script type="text/javascript">

      function addProduct(code){
      var amount = document.getElementById(code).value;
      window.location.href = 'home.php?action=add&code='+code+'&amount='+amount;
      }

      function deleteProduct(code){
        window.location.href = 'home.php?action=remove&code='+code;
      }

      function pagoOnChange(sel) {
      if (sel.value=="pick up"){
           divC = document.getElementById("nPickup");
           divC.style.display = "";
           divT = document.getElementById("nUps");
           divT.style.display = "none";

      }else{
           divC = document.getElementById("nPickup");
           divC.style.display="none";
           divT = document.getElementById("nUps");
           divT.style.display = "";
        }
      }  
    </script>
    <script type="text/javascript"> 
    $(document).ready(function(){

      var checkboxes = document.getElementsByName('codeAll[]');
      var vals = "";

      $("#btndeleteValue").click(function() {
            for (var i=0, n=checkboxes.length;i<n;i++) {
                if (checkboxes[i].checked) {
                    vals += ","+checkboxes[i].value;
                    //alert(vals);
                    window.location.href = 'home.php?action=removeAll&codeAll='+vals;
                }
            }
        });
      });
    </script>
	</head>
<body>
  <table align="right">
    <tr>
      <td><img border="0" src="./resources/image/cart1.png" width="50" height="50">Total items: <?= $cart->get_total_items(); ?></td>
      <td></td>
      <td></td>
      <td></td>
      <td><div id="header"><a href="home.php?q=logout"><img border="0" src="./resources/image/logout.png" width="30" height="30"></a></div></td>
      <td><div id="main-body">
      <h2>Hello <font color="blue"><?= $user->get_fullname($id); ?></font></h2>
      </div>
      </div></td>
    </tr>
  </table>
<br><br><br><br><br>
<div class="container">
  <div id="accordion">                
    <div class = "card"> 
    <div class = "card-header"> 
        <a class="collapsed card-link" data-toggle="collapse" href="#description4">Please click here to view purchase history</a> 
    </div> 
    <div id = "description4" class = "collapse" data-parent = "#accordion"> 
        <div class = "card-body"> 
        <form action="" method="post" name="rating">
        <table class="table table-striped">
          <thead>
            <tr>
              <th class="text-center">Product</th>
              <th class="text-center">Amount</th>
              <th class="text-center">Transport</th>
              <th class="text-center">Date</th>
            </tr>
          </thead>
          <tbody>
            <?= $purchase->get_purchase(); ?>
          </tbody>
        </table>
        </form>                
        </div> 
      </div> 
    </div> 
  </div>
  <div class="card panel-default">
    <div class="card-header text-center">
      <h2>MY VIRTUAL CART</h2>
    </div>
    <div class="card-body">
      <div class="container">
  <table class="table table-striped">
  <thead>
    <tr>
      <th scope="row">1</th>
      <td colspan="3">Total pay: <?= $cart->get_total_payment(); ?>$</td>
      <td>Total items: <?= $cart->get_total_items(); ?></td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th></th>
      <th class="text-center">Code</th>
      <th class="text-center">Product Name</th>
      <th class="text-center">Price $</th>
      <th class="text-center">Quantity</th>
      <th class="text-center">Subtotal</th>
      <th class="text-center">Option</th>
    </tr>
    <?= $cart->get_items(); ?>
  </tbody>
</table>
<button class="btn btn-primary" id="btndeleteValue" name="btndeleteValue">Delete All</button>
<hr>
    <?= $messagePurch ?>
    <?php if($status == 1) { ?>
    <div id="nBalance">
      <font color="red"><p>Current Balance:  <?= number_format($purchase->purchase_result(), 2) ?>$</p></font> 
    </div>
    <?php } else {?>
    <div id="nBalance">
      <font color="red"><p>Current Balance: <?= number_format($user->get_balance(), 2) ?>$</p></font> 
    </div>
    <?php }?>
    <a href="#bannerformmodal" data-toggle="modal" data-target="#myModal">Please click here to finalize the purchase</a>
    </div>
  </div>
</div>
</div>  <!--end container-->
<div class="container"> 
<div class="card panel-default"><!--Inicio Container-->
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col" class="text-center" colspan="4">List of Products</th>
    </tr>
    <tr>
      <th></th>
      <th></th>
      <th class="text-center">Image</th>
      <th class="text-center">Product Name</th>
      <th class="text-center">Description</th>
      <th class="text-center">Price $</th>
      <th class="text-center">Quantity</th>
      <th class="text-center">Option</th>
    </tr>
  </thead>
  <tbody>
    <?= $product->get_product(); ?>
  </tbody>
</table>


<div id="accordion">                
    <div class = "card"> 
    <div class = "card-header"> 
        <a class="collapsed card-link" data-toggle="collapse" href="#description2">Please click here to see product rating</a> 
    </div> 
    <div id="description2" class="collapse" data-parent="#accordion"> 
        <div class = "card-body"> 
        <form action="" method="post" name="rating">
        <table class="table table-striped">
          <thead>
            <tr>
              <th class="text-center">Product Code</th>
              <th class="text-center">Product Name</th>
              <th class="text-center">Rating Range</th>
            </tr>
          </thead>
          <tbody>
            <?= $product->get_average_product(); ?>
          </tbody>
        </table>
        </form>                
        </div> 
      </div> 
    </div> 
  </div>

<div class="alert alert-info" role="alert">
  <h4 class="alert-heading">Qualify Products!</h4>
  <p>Please to rate a product. Please click on the link Qualify. Will show you information in the table below. Finally click the Rate button.</p>
  <hr>
  <p class="mb-0">Thank you for rating our products.</p>
</div>
</div>
<!--Rate-->
<?= $message ?>
    <div id="accordion">                
    <div class = "card"> 
    <div class = "card-header"> 
        <a class="collapsed card-link" data-toggle="collapse" href="#description3">Qualify Products</a> 
    </div> 
    <div id = "description3" class = "collapse" data-parent = "#accordion"> 
        <div class = "card-body"> 
        <form action="" method="post" name="rating">
        <table class="table table-striped">
          <thead>
            <tr>
              <th class="text-center">Rating Range</th>
              <th class="text-center">Code</th>
              <th class="text-center">Product Name</th>
              <th class="text-center">Description</th>
              <th class="text-center">Option</th>
            </tr>
          </thead>
          <tbody>
            <?= $result ?>
          </tbody>
        </table>
        </form>                
        </div> 
      </div> 
    </div> 
  </div> 
</div>
</div>
</div><!--Fin container-->
</body>
<br><br><br>
<div class="container"> 
<div class="alert alert-success" role="alert">
  <hr>
  <p class="text-center" class="mb-0">Adress: </p>
</div>
</div>
</html>


<div class="container">
  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Finalize The Purchase</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
      <div class="modal-body">
        <?php if($status == 1) { ?>
        <table>
          <tr><td>
          <font color="red"><p>Current Balance:  <?= number_format($purchase->purchase_result(), 2) ?>$</p></font></td>
          <?php } else {?>
          <td><font color="red"><p>Current Balance: <?= number_format($user->get_balance(), 2) ?>$</p></font></td> 
          <?php }?>
          </tr>
        </table>
          <form action="" method="post" name="formpay" id="formpay">
          <table class="table table-striped">
          <tbody>
            <tr>
              <th class="text-center">Code</th>
              <th class="text-center">Product Name</th>
              <th class="text-center">Price $</th>
              <th class="text-center">Quantity</th>
              <th class="text-center">Subtotal</th>
            </tr>
            <?= $cart->get_items_purchase(); ?>
          </tbody>
        </table>
        <div>
      <div>
        <table>
          <tr>
            <td><select name="carry" id="carry" required onChange="pagoOnChange(this)">
            <option value="">Choose</option>
            <option value="pick up">pick up</option>
            <option value="ups">UPS</option>
            </select></td>
            <td><div id="nPickup" style="display:none;">
            Cost: 0 $
            </div></td>
            <td><div id="nUps" style="display:none;">
            Cost: 5 $
            </div></td>
          </tr>
        </table>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="submitPay" id="submitPay">Pay</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
      </form>
        </div>
        </div>
      </div>
    </div>
  </div>
  
</div>
