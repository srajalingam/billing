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
		
	}