<?php
	
	class ItemsModel extends Model {
		
		public function __construct() {
			parent::__construct();
		}

		public function getItem($item_name) {
			$query_get_item = "SELECT * FROM items WHERE name LIKE :name";
			$get_item = $this -> select($query_get_item);
			$get_item -> bindParam(':name', $item_name);
			$exe_get_item = $get_item -> execute();
			$item_details = $get_item -> fetch(PDO::FETCH_ASSOC);
			return $item_details;
		}
		
		public function insertItem($item_details) {
			$query_insert_item = "INSERT into items (name, category, product, quantity, qty_unit, rate) VALUES (:name, :category, :product, :quantity, :qty_unit, :rate)";
			$insert_item = $this -> insert($query_insert_item);
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
		
		public function getAllItems() {
			$query_get_item = "SELECT * FROM items";
			$get_item = $this -> selectAll($query_get_item);
			$exe_get_item = $get_item -> execute();
			$item_details = $get_item -> fetchAll(PDO::FETCH_ASSOC);
			return $item_details;
		}
		
	}