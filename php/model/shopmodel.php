<?php
	
	class ShopModel extends Model {
		
		public function __construct() {
			parent::__construct();
		}
		
		public function shopLogin($user_name, $password) {
			$query_shop_login = "SELECT * FROM shops WHERE shop_username=:user AND shop_password=:pass";
			$shop_login = $this -> select($query_shop_login);
			$shop_login -> bindParam(':user', $user_name);
			$shop_login -> bindParam(':pass', $password);
			$exe_shop_login = $shop_login -> execute();
			$shop_details = $shop_login -> fetch(PDO::FETCH_ASSOC);
			return $shop_details;
		}
		
		public function insertShopDetails($shop_details) {
			$query_insert_shop = "INSERT INTO shops (name, owner, address, email, phone, mobile) VALUES (:name, :owner, :address, :email, :phone, :mobile)";
			$insert_shop = $this -> insert($query_insert_shop);
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
			$get_shop = $this -> select($query_get_shop);
			$get_shop -> bindParam(':name', $shop_name);
			$exe_get_shop = $get_shop -> execute();
			$shop_details = $get_shop -> fetch();
			return $shop_details;
		}
		
		public function getAllShops() {
			$query_get_shop = "SELECT * FROM shops";
			$get_shop = $this -> selectAll($query_get_shop);
			$exe_get_shop = $get_shop -> execute();
			$shop_details = $get_shop -> fetchAll(PDO::FETCH_ASSOC);
			return $shop_details;
		}
		
	}