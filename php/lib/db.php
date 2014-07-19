<?php
	
	class DB extends PDO {
		
		public function __construct() {
			parent::__construct('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
			// $this -> setAttribute(PDO::FETCH_ASSOC, PDO::ERRMODE_EXCEPTION);
		}
		
		public function __destruct() {
		
		}
		
		public function insert($query) {
			$insert = $this -> prepare($query);
			return $insert;
		}
		
		public function update($query) {
			$update = $this -> prepare($query);
			return $update;
		}
		
		public function select($query) {
			$select = $this -> prepare($query);
			return $select;
		}
		
		public function selectAll($query) {
			$selectAll = $this -> prepare($query);
			return $selectAll;
		}
		
		public function delete($query) {
			$delete = $this -> prepare($query);
			return $delete;
		}
		
	}