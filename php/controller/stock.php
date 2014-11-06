<?php
	
	class Stock extends Controller {
		
		public $model;
		
		public function __construct(stockModel $stock_model) {
			parent::__construct();
			$this -> model = $stock_model;
		}
		
		public function __destruct() {
			unset($this);
		}
		
		public function addStock($shop_id, $item_id, $quantity) {
			$check_item = $this -> model -> getStockItem($shop_id, $item_id);
			if(is_array($check_item) && count($check_item) > 0) {
				$item_qty = $quantity + $check_item['quantity'];
				$stock_item = $this -> model -> updateStockItem($shop_id, $item_id, $item_qty);
			} else {
				$stock_item = $this -> model -> insertStockItem($shop_id, $item_id, $quantity);
			}
			if(!$stock_item) {
				$result = "fails";
			} else {
				$result = "success";
			}
			return $result;
		}
		
		public function subStock($shop_id, $item_id, $quantity) {
			$check_item = $this -> model -> getStockItem($shop_id, $item_id);
			if(is_array($check_item) && count($check_item) > 0) {
				$item_qty = $check_item['quantity'] - $quantity;
				$stock_item = $this -> model -> updateStockItem($shop_id, $item_id, $item_qty);
			} else {
				// $stock_item = $this -> model -> insertStockItem($shop_id, $item_id, $quantity);
				$stock_item = false;
			}
			if(!$stock_item) {
				$result = "fails";
			} else {
				$result = "success";
			}
			return $result;
		}
		
		public function stockLlist() {
			try {
				$shop_id = $_SESSION['shop_bill_shop_id'];
				$stock_list = [];
				$arr_items = $this -> itemsList($shop_id);
				foreach($arr_items as $item) {
					$stock_item = $this -> model -> getStockItem($shop_id, $item['item_id']);
					if(is_array($stock_item) && count($stock_item) > 0) {
						$qty_count = $stock_item['quantity'];
					} else {
						$qty_count = 0;
					}
					$item['qty_count'] = $qty_count;
					$stock_list[] = $item;
				}
				$result = array(
								'status' => "success",
								'response' => array(
													'stock' => $stock_list
												)
							);
				echo json_encode($result);
			} catch(Exception $ex) {
				$result = array(
								'status' => "fails",
								'response' => array('msg' => $ex->getMessage())
							);
				echo json_encode($result);
			}
		}
		
		public function itemsList($shop_id) {
			$items = $this -> loadController("items");
			$arr_items = $items -> allItemsStock($shop_id);
			return $arr_items;
		}
		
	}