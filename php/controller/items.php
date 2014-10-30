<?php
	
	class Items extends Controller {
		
		public $model;
		
		public function __construct(ItemsModel $obj_model) {
			parent::__construct();
			
			$this -> model = $obj_model;
		}

		public function __destruct() {
			unset($this);
		}
		
		public function allItems() {
			try {
				$check_session = $this -> checkSession();
				if($check_session === "success") {
					$shop_id = $_SESSION['shop_bill_shop_id'];
					$arr_items = $this -> model -> getAllItems($shop_id);
					if(is_array($arr_items) && count($arr_items) > 0) {
						$response = array(
											'status' => "success",
											'message' => $arr_items
										);
						return json_encode($response);
					} else {
						throw new Exception("No items found register new");
					}
				} else {
					throw new Exception($check_session);
				}
			} catch(MyException $ex) {
				$ex->logException();
				$response = array(
									'status' => $this -> status,
									'message' => $ex->getMessage()
								);
				return json_encode($response);
			} catch(Exception $ex) {
				$response = array(
									'status' => $this -> status,
									'message' => $ex->getMessage()
								);
				return json_encode($response);
			}
		}
		
		public function allItemsName($shop_id) {
			$items_name = $this -> model -> getItemsName($shop_id);
			$name_list = [];
			if(is_array($items_name) && count($items_name) > 0) {
				foreach($items_name as $item) {
					$name_list[] = $item['name'];
				}
			}
			return $name_list;
		}

		public function itemDetails() {
			try {
				$shop_id = $_SESSION['shop_bill_shop_id'];
				$item_name = $_POST['item_name'];
				$item_details = $this -> model -> getItem($shop_id, $item_name);
				if(is_array($item_details) && count($item_details) > 0) {
					$result = array(
									'status' => "success",
									'response' => array('item_details' => $item_details)
								);
					echo json_encode($result);
				} else {
					throw new Exception("Item Details not found");
				}
			} catch(MyException $ex) {
				$ex->logException();
				$response = array(
									'status' => $this -> status,
									'errors' => $this->errors,
									'message' => $ex->getMessage()
								);
				return json_encode($response);
			} catch(Exception $ex) {
				$response = array(
									'status' => $this -> status,
									'errors' => $this->errors,
									'message' => $ex->getMessage()
								);
				return json_encode($response);
			}
		}
		
/**
 *  func : insert the new item data
 */
		public function addItem() {
			try {
				// check the session value and validate the shop user
				$check_session = $this -> checkSession();
				if($check_session === "success") {
					$shop_id = $_SESSION['shop_bill_shop_id'];
					$item_data = array(
										'name' => strip_tags($_POST['name']),
										'category' => strip_tags($_POST['category']),
										// 'sub_category' => strip_tags($_POST['sub_category']),
										'product' => strip_tags($_POST['product']),
										'quantity' => strip_tags($_POST['quantity']),
										'qty_unit' => strip_tags($_POST['qty_unit']),
										'rate' => strip_tags($_POST['rate'])
									);
								
					$validate_rules = array(
												'name' => "required",
												'category' => "required",
												// 'sub_category' => "required",
												'product' => "required",
												'quantity' => "required",
												'qty_unit' => "required",
												'rate' => "required"
											);
					$validate_item = $this -> validate -> validator($item_data, $validate_rules);
					if($validate_item === false) {
						$this -> errors = $this -> validate -> errors;
						throw new Exception("Please fill all the required fields");
					} else {
						// check the item is already inserted or not
						$check_item = $this -> model -> getItem($shop_id, $item_data['name']);
						if(is_array($check_item) && count($check_item) > 0) {
							throw new Exception("Item already inserted");
						} else {
							// item the item details
							$insert_item = $this -> model -> insertItem($shop_id, $item_data);
							if(!$insert_item) {
								throw new Exception("Item not inserted try again");
							} else {
								$response = array(
												'status' => "success",
												'message' => "Item details inserted successfully"
											);
								return json_encode($response);
							}
						}
					}
				} else {
					throw new Exception($check_session);
				}
			} catch(MyException $ex) {
				$ex->logException();
				$response = array(
									'status' => $this -> status,
									'errors' => $this->errors,
									'message' => $ex->getMessage()
								);
				return json_encode($response);
			} catch(Exception $ex) {
				$response = array(
									'status' => $this -> status,
									'errors' => $this->errors,
									'message' => $ex->getMessage()
								);
				return json_encode($response);
			}
		}
	
	}