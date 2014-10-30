<?php
	
	class PurchaseModel extends Model {
		
		public function __construct() {
			parent::__construct();
		}
		
		public function purchaseCount($shop_id) {
			$query_purchase_count = "SELECT COUNT(*) AS total_count FROM purchases WHERE shop_id=:shop_id";
			$purchase_count = $this -> select($query_purchase_count);
			$purchase_count -> bindParam(':shop_id', $shop_id);
			$exe_purchase_count = $purchase_count -> execute();
			$count = $purchase_count -> fetch(PDO::FETCH_ASSOC);
			return $count;
		}
		
		public function getAllPurchase($shop_id) {
			$query_all_purchase = "SELECT * FROM purchases WHERE shop_id=:shop_id";
			$get_all_purchase = $this -> selectAll($query_all_purchase);
			$get_all_purchase -> bindParam(':shop_id', $shop_id);
			$exe_all_purchase = $get_all_purchase -> execute();
			$all_purchase = $get_all_purchase -> fetchAll(PDO::FETCH_ASSOC);
			return $all_purchase;
		}
		
		public function itemPurchasedCount($purchase_id) {
			$query_item_count = "SELECT COUNT(*) AS item_count FROM purchase_item WHERE purchase_id=:purchase_id";
			$item_count = $this -> select($query_item_count);
			$item_count -> bindParam(':purchase_id', $purchase_id);
			$exe_item_count = $item_count -> execute();
			$count = $item_count -> fetch(PDO::FETCH_ASSOC);
			return $count['item_count'];
		}
		
		public function getPurchaseDetails($shop_id, $purchase_id) {
			$query_get_purchase = "SELECT * FROM purchases WHERE shop_id=:shop_id AND purchase_id=:purchase_id";
			$get_purchase = $this -> select($query_get_purchase);
			$get_purchase -> bindParam(':shop_id', $shop_id);
			$get_purchase -> bindParam(':purchase_id', $purchase_id);
			$exe_purchase = $get_purchase -> execute();
			$purchase_details = $get_purchase -> fetch(PDO::FETCH_ASSOC);
			return $purchase_details;
		}
		
		public function insertPurchase($shop_id, $data) {
			$query_insert_purchase = "INSERT INTO purchases (purchase_id, shop_id, purchase_from, purchase_date, remarks, purchase_by) VALUES (:purchase_id, :shop_id, :purchase_from, :purchase_date, :remarks, :purchase_by)";
			$insert_purchase = $this -> insert($query_insert_purchase);
			$insert_purchase -> bindParam(':purchase_id', $data['purchase_id']);
			$insert_purchase -> bindParam(':shop_id', $shop_id);
			$insert_purchase -> bindParam(':purchase_from', $data['purchase_from']);
			$insert_purchase -> bindParam(':purchase_date', $data['purchase_date']);
			$insert_purchase -> bindParam(':remarks', $data['remarks']);
			$insert_purchase -> bindParam(':purchase_by', $data['purchase_by']);
			$exe_insert_purchase = $insert_purchase -> execute();
			return $exe_insert_purchase;
		}
		
		public function insertPurchaseItem($purchase_id, $item_data) {
			$query_insert_items = "INSERT INTO purchase_item (purchase_id, item_id, quantity, rate) VALUES (:purchase_id, :item_id, :quantity, :rate)";
			$insert_items = $this -> insert($query_insert_items);
			$insert_items -> bindParam(':purchase_id', $purchase_id);
			$insert_items -> bindParam(':item_id', $item_data['item_id']);
			$insert_items -> bindParam(':quantity', $item_data['qty_value']);
			$insert_items -> bindParam(':rate', $item_data['rate']);
			$exe_insert_items = $insert_items -> execute();
			return $exe_insert_items;
		}
		
	}