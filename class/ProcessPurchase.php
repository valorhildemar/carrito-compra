<?php
	include_once('Connection.php');

	class ProcessPurchase extends Model{		
	public function __construct(){
			parent::__construct();
	}

	/*** for login process ***/
	public function purchase_reg($id_user, $product_name, $product_code, $product_price, $product_amount, 
		$product_sub, $carry, $date_purchase, $status){

        $count = count($product_code);
        for($i = 0; $i < $count; $i++){

 		$sql1="INSERT INTO purchase SET product='$product_name[$i]', code='$product_code[$i]', price = '$product_price[$i]', amount = '$product_amount[$i]', subtotal = '$product_sub[$i]', id_user = '$id_user[$i]', kind_trans = '$carry', date_purchase = '$date_purchase', status = '$status'";

           $result = mysqli_query($this->con,$sql1) or die(mysqli_connect_errno()."Data cannot inserted");
        }

	 if ($result){
	           return $result;
	 } else { 
	           return false;
	  }
    }

    public function purchase_result(){
    	$id_user = $_SESSION['id'];
    	$beginning_balance = $_SESSION['balance'];

    $sql="SELECT SUM(subtotal) AS balances FROM purchase WHERE id_user='$id_user'";
		
	       $result = $this->con->query($sql);

	       $data = mysqli_fetch_array($result);

		   $status = $data['status'];
		   $current_balance = $data['balances'];

	       $balance_result = $beginning_balance - $current_balance;

	    return $balance_result;
    }

    public function get_status_purchase(){
    	$id_user = $_SESSION['id'];

    	$sql = $this->con->query("SELECT status FROM purchase WHERE id_user='$id_user'");
		$data = mysqli_fetch_array($sql);
		$row = $data['status'];
		return $row;
    }

    public function get_purchase(){
    	$id_user = $_SESSION['id'];
    	$sql = $this->con->query("SELECT * FROM purchase WHERE id_user = '$id_user'");
			$html = "";
			foreach ($sql->fetch_all(MYSQLI_ASSOC) as $value) {
				$html .=  '<tr>
								<td class="text-center">'.$value['product'].'</td>
								<td class="text-center">'.$value['amount'].'</td>
								<td class="text-center">'.$value['kind_trans'].'</td>
								<td class="text-center">'.$value['date_purchase'].'</td>
						   </tr>';
			}
			return $html;
    }
}