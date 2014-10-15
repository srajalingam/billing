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
						
						// result with status and purchase id and date
						$result = array(
										'status' => "success",
										'response' => array(
															'purchase_id' => $purchase_id,
															'purchase_date' => date('d-m-Y')
														)
									);
						echo json_encode($result);
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
		
	}