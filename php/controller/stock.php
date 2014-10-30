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
		
	}