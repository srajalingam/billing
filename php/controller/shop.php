<?php
	
	class Shop extends Controller {
		
		private $model;
		
		public function __construct(ShopModel $shop_model) {
			parent::__construct();
			$this -> model = $shop_model;
			
		}
		
		public function login() {
			try {
				// check the request data is valid and not empty
				if(isset($_POST['shop_username']) && isset($_POST['shop_password'])) {
					if(!empty($_POST['shop_username']) && !empty($_POST['shop_password'])) {
						$user_name = $_POST['shop_username'];
						$password = $_POST['shop_password'];
						$hash_pwd = hash("sha256", $password);
						$shop_login = $this -> model -> shopLogin($user_name, $hash_pwd);
						if(is_array($shop_login) && count($shop_login) > 0) {
							if($shop_login['active'] == 1) {
								// set the session and cookie of shop and user details
								$_SESSION['shop_bill_shop_id'] = $shop_login['shop_id'];
								$_SESSION['shop_bill_user_name'] = $shop_login['shop_username'];
								$_SESSION['shop_bill_shop_name'] = $shop_login['name'];
								
								// set shop name and log in details in cookie also
								setcookie("sb_shop_name", $shop_login['name'], time()+3400, "/", NULL);
								// setcookie("sb_shop_id", $shop_login['shop_id'], time()+3400, "/", NULL);
								setcookie("sb_logged_in", 1, time()+3400, "/", NULL);
								header("Location:".URL."/dashboard.php");
								exit;
							} else {
								// shop is not active set a message and link to make shop active
								throw new Exception("Shop is not active. Contact administrator to make active.");
							}
						} else {
							throw new Exception("Invalid username or password");
						}
					} else {
						throw new Exception("Please fill userName and Password ");
					}
				} else {
					throw new MyException("Invalid request. Try again..");
				}
			} catch(MyException $mex) {
				$mex -> logException();
				setcookie("alert", $mex -> getMessage(), time()+1200, "/", NULL);
				header("Location:".URL."/index.php");
			} catch(Exception $ex) {
				setcookie("alert", $ex -> getMessage(), time()+1200, "/", NULL);
				header("Location:".URL."/index.php");
			}
		} 

/**
 *  func : add new shop details 
 */
		public function addShop($shop_data) {
			try {
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