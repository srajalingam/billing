<?php
	
	class ItemsModel extends Model {
		
		public function __construct() {
			parent::__construct();
		}

		public function getItem($shop_id, $item_name) {
			$query_get_item = "SELECT * FROM items WHERE shop_id=:shop_id AND name LIKE :name";
			$get_item = $this -> select($query_get_item);
			$get_item -> bindParam(':shop_id', $shop_id);
			$get_item -> bindParam(':name', $item_name);
			$exe_get_item = $get_item -> execute();
			$item_details = $get_item -> fetch(PDO::FETCH_ASSOC);
			return $item_details;
		}
		
		public function insertItem($shop_id, $item_details) {
			$query_insert_item = "INSERT into items (shop_id, name, category, product, quantity, qty_unit, rate) VALUES (:shop_id, :name, :category, :product, :quantity, :qty_unit, :rate)";
			$insert_item = $this -> insert($query_insert_item);
			$insert_item -> bindParam(':shop_id', $shop_id);
			$insert_item -> bindParam(':name', $item_details['name']);
			$insert_item -> bindParam(':category', $item_details['category']);
			// $insert_item -> bindParam(':sub_category', $item_details['sub_category']);
			$insert_item -> bindParam(':product', $item_details['product']);
			$insert_item -> bindParam(':quantity', $item_details['quantity']);
			$insert_item -> bindParam(':qty_unit', $item_details['qty_unit']);
			$insert_item -> bindParam(':rate', $item_details['rate']);
			$exe_insert_item = $insert_item -> execute();
			return $exe_insert_item;
		}
		
		public function getAllItems($shop_id) {
			$query_get_item = "SELECT * FROM items WHERE shop_id=:shop_id";
			$get_item = $this -> selectAll($query_get_item);
			$get_item -> bindParam(':shop_id', $shop_id);
			$exe_get_item = $get_item -> execute();
			$item_details = $get_item -> fetchAll(PDO::FETCH_ASSOC);
			return $item_details;
		}
		
		public function getItemsName($shop_id) {
			$query_item_name = "SELECT name FROM items WHERE shop_id=:shop_id";
			$item_name = $this -> selectAll($query_item_name);
			$item_name -> bindParam(':shop_id', $shop_id);
			$exe_item_name = $item_name -> execute();
			$item_list = $item_name -> fetchAll(PDO::FETCH_ASSOC);
			return $item_list;
		}
		
		
		
	}