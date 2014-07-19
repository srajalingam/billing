<?php
/**
 *  class : all queries for insert, delete, select goes here 
 *  desc : db class got instantiated for db connect
 */
	class Model {
	
		private $db;
		
		public function __construct() {
			require_once('lib/db.php');
			$this -> db = new DB();
		}
		
		public function insertShopDetails($shop_details) {
			$query_insert_shop = "INSERT INTO shops (name, owner, address, email, phone, mobile) VALUES (:name, :owner, :address, :email, :phone, :mobile)";
			$insert_shop = $this -> db -> insert($query_insert_shop);
			$insert_shop -> bindParam(':name', $shop_details['shop']);
			$insert_shop -> bindParam(':owner', $shop_details['owner']);
			$insert_shop -> bindParam(':address', $shop_details['address']);
			$insert_shop -> bindParam(':email', $shop_details['email']);
			$insert_shop -> bindParam(':phone', $shop_details['phone']);
			$insert_shop -> bindParam(':mobile', $shop_details['mobile']);
			
			$exe_insert_shop = $insert_shop -> execute();
			return $exe_insert_shop;
		}
		
		public function getShopDetails($shop_name) {
			$query_get_shop = "SELECT * FROM shops WHERE name LIKE :name";
			$get_shop = $this -> db -> select($query_get_shop);
			$get_shop -> bindParam(':name', $shop_name);
			$exe_get_shop = $get_shop -> execute();
			$shop_details = $get_shop -> fetch();
			return $shop_details;
		}
		
		public function getAllShops() {
			$query_get_shop = "SELECT * FROM shops";
			$get_shop = $this -> db -> selectAll($query_get_shop);
			$exe_get_shop = $get_shop -> execute();
			$shop_details = $get_shop -> fetchAll(PDO::FETCH_ASSOC);
			return $shop_details;
		}
		
		public function getItem($item_name) {
			$query_get_item = "SELECT * FROM items WHERE name LIKE :name";
			$get_item = $this -> db -> select($query_get_item);
			$get_item -> bindParam(':name', $item_name);
			$exe_get_item = $get_item -> execute();
			$item_details = $get_item -> fetch(PDO::FETCH_ASSOC);
			return $item_details;
		}
		
		public function insertItem($item_details) {
			$query_insert_item = "INSERT into items (name, category, sub_category, product, quantity, qty_unit, rate) VALUES (:name, :category, :sub_category, :product, :quantity, :qty_unit, :rate)";
			$insert_item = $this -> db -> insert($query_insert_item);
			$insert_item -> bindParam(':name', $item_details['name']);
			$insert_item -> bindParam(':category', $item_details['category']);
			$insert_item -> bindParam(':sub_category', $item_details['sub_category']);
			$insert_item -> bindParam(':product', $item_details['product']);
			$insert_item -> bindParam(':quantity', $item_details['quantity']);
			$insert_item -> bindParam(':qty_unit', $item_details['qty_unit']);
			$insert_item -> bindParam(':rate', $item_details['rate']);
			$exe_insert_item = $insert_item -> execute();
			return $exe_insert_item;
		}
		
		public function getAllItems() {
			$query_get_item = "SELECT * FROM items";
			$get_item = $this -> db -> selectAll($query_get_item);
			$exe_get_item = $get_item -> execute();
			$item_details = $get_item -> fetchAll(PDO::FETCH_ASSOC);
			return $item_details;
		}
		
	}