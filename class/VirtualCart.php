<?php
	class Cart extends Product{
		public $cart = array();
		public function __construct(){
			parent::__construct();
			if(isset($_SESSION['cart'])){
				$this->cart = $_SESSION['cart'];
			}
		}

		public function add_item($code, $amount){
			$search = $this->search_code($code);
			if($search > 0){
				$code = $this->code;
				$product = $this->product;
				$price = $this->price;
				$item = array(
					'code' => $code,
					'product' => $product,
					'price' => $price,
					'amount' => $amount
				);
				if(!empty($this->cart)){
					foreach ($this->cart as $value) {
						if($value['code'] == $code){
							$item['amount'] = $value['amount'] + $item['amount'];
						}
					}
				}
				$item['subtotal'] = $item['price'] * $item['amount'];
				$id = md5($code);
				$_SESSION['cart'][$id] = $item;
				$this->update_cart();
			}
		}

		public function remove_item($code){
			$id = md5($code);
			unset($_SESSION['cart'][$id]);
			$this->update_cart();
			return true;
		}

		public function removeAll_item($codeAll){
			//$array = var_dump(explode(',', $codeAll));
			$array = explode(',', $codeAll);
			unset($_SESSION['cart'],$array[0],$array[1],$array[2],$array[3],$array[4]);
			$this->update_cart();
			return true;
		}

		public function get_items(){
			$html = "";
			if(!empty($this->cart)){
				foreach ($this->cart as $value) {
					$code = "'".$value['code']."'";
					$html .= '<tr>
							<td class="text-center"><input type="checkbox" class="delCheck" name="codeAll[]" id="codeAll[]" value="'.$value['code'].'"></td>
							<td class="text-center">'.$value['code'].'</td>
							<td class="text-center">'.$value['product'].'</td>
							<td class="text-center">'.number_format($value['price'], 2).'</td>
							<td class="text-center">'.$value['amount'].'</td>
							<td class="text-center">'.number_format($value['subtotal'], 2).'</td>
							<td class="text-center"><button class="btn btn-primary" onClick="deleteProduct('.$code.');">Delete</button></td>
						     </tr>';
				}
			}
			return $html;
		}

		public function get_items_purchase(){
			$html = "";
			if(!empty($this->cart)){
				foreach ($this->cart as $value) {
					$code = "'".$value['code']."'";
					$html .= '<tr>
							<input type="hidden" name="id_user[]" value="'.$_SESSION['id'].'">
							<input type="hidden" value="'.$value['product'].'" name="product_name[]"/>
							<input type="hidden" value="'.$value['code'].'" name="product_code[]"/>
							<input type="hidden" value="'.$value['price'].'" name="product_price[]"/>
							<input type="hidden" value="'.$value['amount'].'" name="product_amount[]"/>
							<input type="hidden" value="'.number_format($value['subtotal'], 2).'" name="product_sub[]"/>
							<td class="text-center">'.$value['code'].'</td>
							<td class="text-center">'.$value['product'].'</td>
							<td class="text-center">'.number_format($value['price'], 2).'</td>
							<td class="text-center">'.$value['amount'].'</td>
							<td class="text-center">'.number_format($value['subtotal'], 2).'</td>
						     </tr>';
				}
			}
			return $html;
		}

		public function get_total_items(){
			$total = 0;
			if(!empty($this->cart)){
				foreach ($this->cart as $value) {
					$total += $value['amount'];
				}
			}
			return $total;
		}

		public function get_total_payment(){
			$total = 0;
			if(!empty($this->cart)){
				foreach ($this->cart as $value) {
					$total += $value['subtotal'];
				}
			}
			return number_format($total, 2);
		}

		function update_cart(){
			self::__construct();
		}
	}
?>