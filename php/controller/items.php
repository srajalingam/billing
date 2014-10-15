<?php
	
	class Items extends Controller {
		
		public $model;
		
		public function __construct(ItemsModel $obj_model) {
			parent::__construct();
			
			$this -> model = $obj_model;
		}

		public function allItems() {
			try {
				$arr_items = $this -> model -> getAllItems();
				if(is_array($arr_items) && count($arr_items) > 0) {
					$response = array(
										'status' => "success",
										'message' => $arr_items
									);
					return json_encode($response);
				} else {
					throw new Exception("No items found register new");
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
		
/**
 *  func : insert the new item data
 */
		public function addItem() {
			try {
				// check the session value and validate the shop user
				$check_session = $this -> checkSession();
				if($check_session === "success") {
					$shop_id = $_POST['shop_id'];
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
					$validate_item = $this -> validate -> validate($item_data, $validate_rules);
					if($validate_item === false) {
						$this -> errors = $this -> validate -> errors;
						throw new Exception("Please fill all the required fields");
					} else {
						// check the item is already inserted or not
						$check_item = $this -> model -> getItem($item_data['name']);
						if(is_array($check_item) && count($check_item) > 0) {
							throw new Exception("Item already inserted");
						} else {
							// item the item details
							$insert_item = $this -> model -> insertItem($item_data);
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