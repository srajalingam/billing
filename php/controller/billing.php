<?php
	
	class Billing extends Controller {
		
		public $model;
		
		public function __construct(BillingModel $obj) {
			parent::__construct();
			
			$this -> model = $obj;
		}
		
		public function __destruct() {
			unset($this);
		}
		
		public function loadBill() {
			try {
				$check_session = $this -> checkSession();
				if($check_session === "success") {
					// get the shop id from the session
					$shop_id = $_SESSION['shop_bill_shop_id'];
					
					// generate a unique ID for bill
					$bill_id = $this -> generateBillID($shop_id);
					
					// get the item suggestion (name)
					$item_name = $this -> suggestItem($shop_id);
						
					// result with status and bill id and date
					$result = array(
									'status' => "success",
									'response' => array(
														'bill_id' => $bill_id,
														'bill_date' => date('d-m-Y'),
														'items' => $item_name
													)
								);
					echo json_encode($result);
				} else {
					throw new Exception($check_session);
				}
			} catch(Exception $ex) {
				$result = array(
								'status' => $this -> status,
								'response' => array(
													'errors' => $this->errors,
													'msg' => $ex->getMessage()
												)
							);
				return json_encode($result);
			}
		}
		
		public function generateBillID($shop_id) {
			$last_bill = $this -> model -> LastBill($shop_id);
			if(is_array($last_bill) && count($last_bill) > 0) {
				// generate a bill id
				$id = ++$last_bill['bill_pk'];
			} else {
				$id = 1;
			}
			
			// get the fist 3 letters of shop name
			$shop_name = $_SESSION['shop_bill_shop_name'];
			$name = strtoupper(substr($shop_name, 0, 3));
			$bill_id = $name."/BILL/".$id;
			// check the bill id is available or not
			$check_bill = $this -> model -> getbillDetails($shop_id, $bill_id);
			if(is_array($check_bill) && count($check_bill) > 0) {
				throw new Exception("bill Id not created try again");
			} else {
				return $bill_id;
			}
		}
		
		public function suggestItem($shop_id) {
			$items = $this -> loadController("items");
			$item_list = $items -> allItemsName($shop_id);
			return $item_list;
		}
		
		public function newBilling() {
			try {
				$check_session = $this -> checkSession();
				if($check_session === "success") {
					$shop_id = $_SESSION['shop_bill_shop_id'];
					// validate all new bill data
					$bill_data = array(
										'bill_id' => $_POST['bill_id'],
										'bill_date' => $_POST['bill_date'],
										'bill_name' => $_POST['bill_name'],
										'remarks' => $_POST['remarks'],
										'bill_by' => $_POST['bill_by']
									);
					$validate_rules = array(
												'bill_id' => "required",
												'bill_date' => "required",
												'bill_name' => "required",
												// 'remarks' => "required",
												'bill_by' => "required"
											);
					$validate_bill = $this -> validate -> validator($bill_data, $validate_rules);
					if($validate_bill === false) {
						$this -> errors = $this -> validate -> errors;
						throw new Exception("Please fill all the required fields");
					} else {
					
						// change the date format before insert in DB
						$bill_data['bill_date'] = date('Y-m-d', strtotime($bill_data['bill_date']));
						$item_list = [];
						// validate the bill items
						$arr_items = $_POST['items'];
						
						foreach($arr_items as $item) {
							$bill_item = array(
												'item_id' => $item['item_id'],
												// 'item' => $item['item'],
												'qty_value' => $item['qty_value'],
												// 'qty_unit' => $item['qty_unit'],
												'rate' => $item['rate']
											);
							$validate_rule = array(
													'item_id' => "required",
													// 'item' => "required",
													'qty_value' => "required",
													// 'qty_unit' => "required",
													'rate' => "required"
												);
							$validate_items = $this -> validate -> validator($bill_item, $validate_rule);
							if($validate_items === false) {
								$this -> errors = $this -> validate -> errors;
								throw new Exception("Please fill all the required fields");
							} else {
								$item_list[] = $bill_item;
							}
						}
					}
					
					// check the bill id is already inserted or not
					$check_bill = $this -> model -> getBillDetails($shop_id, $bill_data['bill_id']);
					if(is_array($check_bill) && count($check_bill) > 0) {
						throw new Exception("Bill ID already inserted try again");
					} else {
						// insert the bill details
						$insert_bill = $this -> model -> insertBill($shop_id, $bill_data);
						if(!$insert_bill) {
							throw new Exception("Bill details not inserted try again");
						} else {
							// create stock object to insert/ update for new bill
							$stock = $this -> loadController("stock");
							// insert the bill item details 
							foreach($item_list as $item) {
								$insert_item = $this -> model -> insertBillItem($bill_data['bill_id'], $item);
								if($insert_item) {
									$stock -> subStock($shop_id, $item['item_id'], $item['qty_value']);
								}
							}
						}
						$result = array(
										'status' => "success",
										'response' => array(
															'msg' => "Bill details inserted successfully"
														)
									);
						return json_encode($result);
					}
				} else {
					throw new Exception($check_session);
				}
			} catch(MyException $ex) {
				$ex->logException();
				$result = array(
								'status' => $this -> status,
								'response' => array(
													'errors' => $this->errors,
													'msg' => $ex->getMessage()
												)
							);
				return json_encode($result);
			} catch(Exception $ex) {
				$result = array(
								'status' => $this -> status,
								'response' => array(
													'errors' => $this->errors,
													'msg' => $ex->getMessage()
												)
							);
				return json_encode($result);
			}
		}
		
	}