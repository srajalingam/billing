<?php
	
	class StockModel extends Model {
		
		public function __construct() {
			parent::__construct();
		}
		
		public function __destruct() {
			unset($this);
		}
		
		public function getStockItem($shop_id, $item_id) {
			$query_stock_item = "SELECT * FROM stocks WHERE shop_id=:shop_id AND item_id=:item_id";
			$stock_item = $this -> select($query_stock_item);
			$stock_item -> bindParam(':shop_id', $shop_id);
			$stock_item -> bindParam(':item_id', $item_id);
			$exe_stock_item = $stock_item -> execute();
			$item = $stock_item -> fetch(PDO::FETCH_ASSOC);
			return $item;
		}
		
		public function insertStockItem($shop_id, $item_id, $quantity) {
			$query_insert_stock = "INSERT INTO stocks (shop_id, item_id, quantity) VALUES (:shop_id, :item_id, :quantity)";
			$insert_stock = $this -> insert($query_insert_stock);
			$insert_stock -> bindParam(':shop_id', $shop_id);
			$insert_stock -> bindParam(':item_id', $item_id);
			$insert_stock -> bindParam(':quantity', $quantity);
			$exe_insert_stock = $insert_stock -> execute();
			return $exe_insert_stock;
		}
		
		public function updateStockItem($shop_id, $item_id, $quantity) {
			$query_update_stock = "UPDATE stocks SET quantity=:quantity WHERE shop_id=:shop_id AND item_id=:item_id";
			$update_stock = $this -> update($query_update_stock);
			$update_stock -> bindParam(':shop_id', $shop_id);
			$update_stock -> bindParam(':item_id', $item_id);
			$update_stock -> bindParam(':quantity', $quantity);
			$exe_update_stock = $update_stock -> execute();
			return $exe_update_stock;
		}
		
	}