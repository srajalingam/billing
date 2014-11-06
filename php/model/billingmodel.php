<?php
	
	class BillingModel extends Model {
		
		public function __construct() {
			parent::__construct();
		}
		
		public function LastBill($shop_id) {
			$query_bill_id = "SELECT * FROM bills WHERE shop_id=:shop_id ORDER BY bill_pk DESC LIMIT 1";
			$bill_id = $this -> select($query_bill_id);
			$bill_id -> bindParam(':shop_id', $shop_id);
			$exe_bill_id = $bill_id -> execute();
			$last_bill = $bill_id -> fetch(PDO::FETCH_ASSOC);
			return $last_bill;
		}
				
		public function countBill($shop_id) {
			$query_bill_count = "SELECT COUNT(*) AS total_count FROM bills WHERE shop_id=:shop_id";
			$bill_count = $this -> select($query_bill_count);
			$bill_count -> bindParam(':shop_id', $shop_id);
			$exe_bill_count = $bill_count -> execute();
			$count = $bill_count -> fetch(PDO::FETCH_ASSOC);
			return $count['total_count'];
		}
		
		public function getAllBill($shop_id) {
			$query_all_bill = "SELECT * FROM bills WHERE shop_id=:shop_id";
			$get_all_bill = $this -> selectAll($query_all_bill);
			$get_all_bill -> bindParam(':shop_id', $shop_id);
			$exe_all_bill = $get_all_bill -> execute();
			$all_bill = $get_all_bill -> fetchAll(PDO::FETCH_ASSOC);
			return $all_bill;
		}
		
		public function getBillDetails($shop_id, $bill_id) {
			$query_get_bill = "SELECT * FROM bills WHERE shop_id=:shop_id AND bill_id=:bill_id";
			$get_bill = $this -> select($query_get_bill);
			$get_bill -> bindParam(':shop_id', $shop_id);
			$get_bill -> bindParam(':bill_id', $bill_id);
			$exe_bill = $get_bill -> execute();
			$bill_details = $get_bill -> fetch(PDO::FETCH_ASSOC);
			return $bill_details;
		}
		
		public function insertBill($shop_id, $data) {
			$query_insert_bill = "INSERT INTO bills (bill_id, shop_id, bill_name, bill_date, remarks, bill_by) VALUES (:bill_id, :shop_id, :bill_name, :bill_date, :remarks, :bill_by)";
			$insert_bill = $this -> insert($query_insert_bill);
			$insert_bill -> bindParam(':bill_id', $data['bill_id']);
			$insert_bill -> bindParam(':shop_id', $shop_id);
			$insert_bill -> bindParam(':bill_name', $data['bill_name']);
			$insert_bill -> bindParam(':bill_date', $data['bill_date']);
			$insert_bill -> bindParam(':remarks', $data['remarks']);
			$insert_bill -> bindParam(':bill_by', $data['bill_by']);
			$exe_insert_bill = $insert_bill -> execute();
			return $exe_insert_bill;
		}
		
		public function insertBillItem($bill_id, $item_data) {
			$query_insert_items = "INSERT INTO bill_items (bill_id, item_id, quantity, rate) VALUES (:bill_id, :item_id, :quantity, :rate)";
			$insert_items = $this -> insert($query_insert_items);
			$insert_items -> bindParam(':bill_id', $bill_id);
			$insert_items -> bindParam(':item_id', $item_data['item_id']);
			$insert_items -> bindParam(':quantity', $item_data['qty_value']);
			$insert_items -> bindParam(':rate', $item_data['rate']);
			$exe_insert_items = $insert_items -> execute();
			return $exe_insert_items;
		}
		
	}