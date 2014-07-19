<?php
/**
 *  file : to collect all the request from every pages
 *  desc : request with query string url with msg to call a particular function
 *  desc : query string msg should be a function from controller
 */
 
	// load the config file to set the configuration define constants to controller and model files
	require_once('config.php');
	
	// load the exception file to log the execution errors
	require_once('lib/myexception.php');
	
	// instantiate controller to execute all the requests
	require_once('controller.php');
	$controller = new Controller();
	
	// execute all the request with exception handling
	try {
		// check the query string contains msg or not
		if(isset($_GET['msg']) && !empty($_GET['msg'])) {
			// check the msg in switch condition to function call
			$request = strip_tags($_GET['msg']);
			// check the request method is valid in controller
			if(method_exists($controller, $request)) {
				switch($request) {
				/////////// index page request starts here ////////////////////
					case 'addShop':
						if(is_array($_POST) && count($_POST)) {
							$shop_data = array(
												'shop' => strip_tags($_POST['shop']),
												'owner' => strip_tags($_POST['owner']),
												'address' => strip_tags($_POST['address']),
												'email' => strip_tags($_POST['email']),
												'phone' => strip_tags($_POST['phone']),
												'mobile' => strip_tags($_POST['mobile'])
											);
							$response = $controller -> addShop($shop_data);
							echo $response;
						} else {
							throw new Exception("No request data found");
						}
					break;
						
					case 'allShops':
						$response = $controller -> allShops();
						echo $response;
					break;
					
					case 'addItem':
						if(is_array($_POST) && count($_POST) > 0) {
							$item_data = array(
												'name' => strip_tags($_POST['name']),
												'category' => strip_tags($_POST['category']),
												'sub_category' => strip_tags($_POST['sub_category']),
												'product' => strip_tags($_POST['product']),
												'quantity' => strip_tags($_POST['quantity']),
												'qty_unit' => strip_tags($_POST['qty_unit']),
												'rate' => strip_tags($_POST['rate'])
											);
							$response = $controller -> addItem($item_data);
							echo $response;
						} else {
							throw new Exception("No request data found");
						}
					break;
					
					case 'allItems':
						$response = $controller -> allItems();
						echo $response;
					break;
					
					define:
						$response = array(
											'status' => "fail",
											'message' => "Invalid request try again"
										);
						echo json_encode($response);
					break;
				}
			} else {
				throw new MyException("Request method not found check again");
			}
		} else {
			throw new MyException("Invalid request try again");
		}

	} catch(MyException $ex) {
		$ex->logException();
		$response = array(
							'status' => "fail",
							'message' => $ex->getMessage()
						);
		echo json_encode($response);
	} catch(Exception $ex) {
		$response = array(
							'status' => "fail",
							'message' => $ex->getMessage()
						);
		echo json_encode($response);
	}
	
?>