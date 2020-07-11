<?php
	include_once('Connection.php');
	class Product extends Model{
		public $code;
		public $product;
		public $description;
		public $price;

		public function __construct(){
			parent::__construct();
		}

		public function get_average_product(){
		$sql = "SELECT AVG(rate) AS aver, cod_product, name_product FROM averagerate GROUP BY cod_product";
		$result = mysqli_query($this->con,$sql);

			$html = "";
			foreach ($result->fetch_all(MYSQLI_ASSOC) as $value) {
				$html .=  '<tr>
							<td class="text-center">'.$value['cod_product'].'</td>
							<td class="text-center">'.$value['name_product'].'</td>
							<td class="text-center">'.number_format($value['aver'], 2).'</td>
						   </tr>';
			}
			return $html;
		}

		public function get_product(){
			$sql = $this->con->query("SELECT * FROM product");
			$html = "";
			foreach ($sql->fetch_all(MYSQLI_ASSOC) as $value) {
				$code = "'".$value['code']."'";
				$html .=  '<tr>
						    	<td class="text-center"><a href="home.php?code='.$value['code'].'">Qualify</a></td>
						    	<td class="text-center"></td> 	
						    	<td class="text-center"><img src="./resources/image_upload/'.$value['image'].'" height="42" width="42"></td>
								<td class="text-center">'.$value['name'].'</td>
								<td class="text-center">'.$value['description'].'</td>
								<td class="text-center">'.$value['price'].'</td>
								<td align="right">
								<input type="number" id="'.$value['code'].'" value="1" min="1" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57"></td>
								<td class="text-center">
								<button class="btn btn-primary" onClick="addProduct('.$code.');">Add to cart</button>
								</td>
						   </tr>';
			}
			return $html;
		}

		public function search_code($code){
			$sql = $this->con->query("SELECT * FROM product WHERE code = '$code'");
			$product = $sql->fetch_all(MYSQLI_ASSOC);
			$status = 0;
			foreach ($product as $value) {
				$this->code = $value['code'];
				$this->product = $value['name'];
				$this->description = $value['description'];
				$this->price = $value['price'];
				$status++;
			}
			return $status;
		}
	}
?>