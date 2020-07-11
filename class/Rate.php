<?php
	include_once('Connection.php');
	class Rate extends Model{
		public $average;

		public function __construct(){
			parent::__construct();
		}

		/*** for registration process ***/
	    public function reg_average($rate, $cod_product, $name_product, $user){
	       $sql="SELECT * FROM averagerate WHERE id_user='$user' AND cod_product = '$product'";
	       //checking if the username or email is available in db
	       $check = $this->con->query($sql) ;
	       $count_row = $check->num_rows;
	       //if the username is not in db then insert to the table
	    if ($count_row == 0){
	       $sql1="INSERT INTO averagerate SET rate='$rate', cod_product='$cod_product', 
	       name_product='$name_product', id_user='$user'";
	       $result = mysqli_query($this->con,$sql1) or die(mysqli_connect_errno()."Data cannot inserted");
	            return $result;
	    } else {
	           return false;
	        }
	    }

		public function get_one_product($code){
			$sql = $this->con->query("SELECT * FROM product WHERE code = '$code'");
			$html = "";
			foreach ($sql->fetch_all(MYSQLI_ASSOC) as $value) {
				$code = "'".$value['code']."'";
				$html .=  '<tr>
								<input type="hidden" name="id_user" value="'.$_SESSION['id'].'">
								<input type="hidden" name="cod_product" value="'.$value['code'].'">
								<input type="hidden" name="name_product" value="'.$value['name'].'">
								<td class="text-center"><select required name="rate_product">
								<option value="">Choose</option>
							    <option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								</select></td>
								<td class="text-center">'.$value['code'].'</td>
								<td class="text-center">'.$value['name'].'</td>
								<td class="text-center">'.$value['description'].'</td>
								<td class="text-center">
								<button type="submit" name="submit" class="btn btn-primary">Rate</button>
								</td>
						   </tr>';
			}
			return $html;
		}

		public function get_average($code){
		$sql = $this->con->query("SELECT AVG(rate) AS aver FROM averagerate WHERE cod_product = '$code' GROUP BY rate");
			$product = $sql->fetch_all(MYSQLI_ASSOC);
			$average = 0;
			foreach ($product as $value) {
				$average = "'".$value['aver']."'";
		    }
			return $average;
		}
	}
?>