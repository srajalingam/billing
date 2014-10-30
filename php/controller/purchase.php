<?php
	
	class Purchase extends Controller {
		
		public $model;
		
		public function __construct(PurchaseModel $obj_model) {
			parent::__construct();
			$this -> model = $obj_model;
		}

/**
 *  func : to generate the new purchase id 
 *  desc : for purchase id take first 3 letters of shop and append by PUR and count of purchases made by that shop 
 */
		public function loadPurchase() {
			try {
				$check_session = $this -> checkSession();
				if($check_session === "success") {
					// get the shop id from the session
					$shop_id = $_SESSION['shop_bill_shop_id'];
					// get the count of purchase for this shop id
					$purchase_count = $this -> model -> purchaseCount($shop_id);
					if(is_array($purchase_count) && count($purchase_count) > 0) {
						// generate a purchase id
						$count = ++$purchase_count['total_count'];
						// get the fist 3 letters of shop name
						$shop_name = $_SESSION['shop_bill_shop_name'];
						$name = strtoupper(substr($shop_name, 0, 3));
						$purchase_id = $name."/PUR/".$count;
						
						// get the item suggestion (name)
						$item_name = $this -> suggestItem($shop_id);
						
						// get the array of all purchase list details 
						$purchase_list = $this -> purchaseList($shop_id);
						
						// check the purchase id is available or not
						$check_purchase = $this -> model -> getPurchaseDetails($shop_id, $purchase_id);
						if(is_array($check_purchase) && count($check_purchase) > 0) {
							throw new Exception("Purchase Id not created try again");
						} else {
							// result with status and purchase id and date
							$result = array(
											'status' => "success",
											'response' => array(
																'purchase_id' => $purchase_id,
																'purchase_date' => date('d-m-Y'),
																'items' => $item_name,
																'purchase_list' => $purchase_list
															)
										);
							echo json_encode($result);
						}
					} else {
						throw new Exception("Some error occurred try again");
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
		
		public function suggestItem($shop_id) {
			$items = $this -> loadController("items");
			$item_list = $items -> allItemsName($shop_id);
			return $item_list;
		}
		
		public function purchaseList($shop_id) {
			$purchase_list = [];
			$arr_purchase = $this -> model -> getAllPurchase($shop_id);
			if(is_array($arr_purchase) && count($arr_purchase) > 0) {
				foreach($arr_purchase as $purchase) {
					$items_purchased = $this -> model -> itemPurchasedCount($purchase['purchase_id']);
					$purchase_list[] = array(
												'purchase_id' => $purchase['purchase_id'],
												'purchase_from' => $purchase['purchase_from'],
												'purchase_date' => $purchase['purchase_date'],
												'items_purchased' => $items_purchased
											);
				}
			}
			return $purchase_list;
		}
		
		public function newPurchase() {
			try {
				$check_session = $this -> checkSession();
				if($check_session === "success") {
					$shop_id = $_SESSION['shop_bill_shop_id'];
					// validate all new purchase data
					$purchase_data = array(
												'purchase_id' => $_POST['purchase_id'],
												'purchase_date' => $_POST['purchase_date'],
												'purchase_from' => $_POST['purchase_from'],
												'remarks' => $_POST['remarks'],
												'purchase_by' => $_POST['purchase_by']
											);
					$validate_rules = array(
												'purchase_id' => "required",
												'purchase_date' => "required",
												'purchase_from' => "required",
												// 'remarks' => "required",
												'purchase_by' => "required"
											);
					$validate_purchase = $this -> validate -> validator($purchase_data, $validate_rules);
					if($validate_purchase === false) {
						$this -> errors = $this -> validate -> errors;
						throw new Exception("Please fill all the required fields");
					} else {
						$item_list = [];
						// validate the purchase items
						$arr_items = $_POST['items'];
						
						foreach($arr_items as $item) {
							$purchase_item = array(
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
							$validate_items = $this -> validate -> validator($purchase_item, $validate_rule);
							if($validate_items === false) {
								$this -> errors = $this -> validate -> errors;
								throw new Exception("Please fill all the required fields");
							} else {
								$item_list[] = $purchase_item;
							}
						}
					}
					
					// check the purchase id is already inserted or not
					$check_purchase = $this -> model -> getPurchaseDetails($shop_id, $purchase_data['purchase_id']);
					if(is_array($check_purchase) && count($check_purchase) > 0) {
						throw new Exception("Purchase ID already inserted try again");
					} else {
						// insert the purchase details
						$insert_purchase = $this -> model -> insertPurchase($shop_id, $purchase_data);
						if(!$insert_purchase) {
							throw new Exception("Purchase details not inserted try again");
						} else {
							// create stock object to insert/ update for new purchase
							$stock = $this -> loadController("stock");
							// insert the purchase item details 
							foreach($item_list as $item) {
								$insert_item = $this -> model -> insertPurchaseItem($purchase_data['purchase_id'], $item);
								if($insert_item) {
									$stock -> addStock($shop_id, $item['item_id'], $item['qty_value']);
								}
							}
						}
						$result = array(
										'status' => "success",
										'response' => array(
															'msg' => "Purchase details inserted successfully"
														)
									);
						return json_encode($result);
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
	
	}
	