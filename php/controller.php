<?php

/**
 *  class : the one and only controller of our application
 *  desc : every request function goes here
 */
	class Controller {
		
		// create an object for model and validate class
		public $model;
		public $validate;
		public $errors; // to add the validation errors in all response
		
		public function __construct() {
			// model class instantiated to prepare the query with db connection
			require_once("model.php");
			$this -> model = new Model();
			// validation class to validate all the user inputs
			require_once("lib/validate.php");
			$this -> validate = new Validate();
			
			// initialize the errors as null
			$this -> errors = "";
		}
//////////////////////////////////////// index page controllers starts here ///////////////////////////////////////////////

/**
 *  func : add new shop details 
 */
		public function addShop($shop_data) {
			try {
				$validate_rule = array(
										'shop' => "required",
										'owner' => "required",
										'address' => "required",
										'email' => "required|email",
										'phone' => "required|phone",
										'mobile' => "required|phone"
									);
				$validate_shop = $this -> validate -> validator($shop_data, $validate_rule);
				if($validate_shop === false) {
					$this -> errors = $this -> validate -> errors;
					throw new Exception("Please fill all the required fields");
				} else {
					$check_shop = $this -> model -> getShopDetails($shop_data['shop']);
					if(is_array($check_shop) && count($check_shop) > 0) {
						throw new Exception("Shop name already registered");
					} else {
						$add_shop = $this -> model -> insertShopDetails($shop_data);
						if(!$add_shop) {
							throw new Exception("Shop details not inserted");
						} else {
							$response = array(
											'status' => "success",
											'message' => "Shop details inserted successfully"
										);
							return json_encode($response);
						}
					}
				}
			} catch(MyException $ex) {
				$ex->logException();
				$response = array(
									'status' => "fail",
									'errors' => $this->errors,
									'message' => $ex->getMessage()
								);
				return json_encode($response);
			} catch(Exception $ex) {
				$response = array(
									'status' => "fail",
									'errors' => $this->errors,
									'message' => $ex->getMessage()
								);
				return json_encode($response);
			}
			
		}

/**
 *  func : fetch all the shop details 		
 */
		public function allShops() {
			try {
				$arr_shops = $this -> model -> getAllShops();
				if(is_array($arr_shops) && count($arr_shops) > 0) {
					$response = array(
										'status' => "success",
										'message' => $arr_shops
									);
					return json_encode($response);
				} else {
					throw new Exception("No shops found register new");
				}
			} catch(MyException $ex) {
				$ex->logException();
				$response = array(
									'status' => "fail",
									'message' => $ex->getMessage()
								);
				return json_encode($response);
			} catch(Exception $ex) {
				$response = array(
									'status' => "fail",
									'message' => $ex->getMessage()
								);
				return json_encode($response);
			}
		}
	
////////////////////////////////////// items page controllers starts here /////////////////////////////////////////////////

/**
 *  func : insert the new item data
 */
		public function addItem($item_data) {
			try {
				$validate_rules = array(
											'name' => "required",
											'category' => "required",
											'sub_category' => "required",
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
			} catch(MyException $ex) {
				$ex->logException();
				$response = array(
									'status' => "fail",
									'errors' => $this->errors,
									'message' => $ex->getMessage()
								);
				return json_encode($response);
			} catch(Exception $ex) {
				$response = array(
									'status' => "fail",
									'errors' => $this->errors,
									'message' => $ex->getMessage()
								);
				return json_encode($response);
			}
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
									'status' => "fail",
									'message' => $ex->getMessage()
								);
				return json_encode($response);
			} catch(Exception $ex) {
				$response = array(
									'status' => "fail",
									'message' => $ex->getMessage()
								);
				return json_encode($response);
			}
		}
	
	}