<?php

/**
 *  class : base abstract controller for common functionalities
 *  desc : controller have some abstract methods to call from all derived controllers
 */
	abstract class Controller {
	
		public $status;
		public $errors;
		
		public $validate;
		
		public function __construct() {
			$this -> status = "fail";
			$this -> errors = "";
			
			// require the validation file path
			require_once(PATH."/php/lib/validation.php");
			// return the instance object of validation controller
			$this -> validate = new validation();
		}
		
/**
 *  func : to load the another controller with model object
 *  desc : return the instantiated controller object to call the functions from the controller
 */
		public function loadController($controller) {
			// check the controller
			require_once(PATH."/php/controller/$controller.php");
			// check the model controller class
			$model = $controller."model";
			require_once(PATH."/php/model/$model.php");
			$obj_model = new $model();
			// instantiate the controller with model object
			$obj_controller = new $controller($obj_model);
			return $obj_controller;
		}
		
/**
 *  func : to load the validation controller to validate the user input data
 *  desc : validate controller get instantiated and return the object of validate controller
 *  result : return the object of validation instance object 
 */
		// public function validate() {
			
			// return 
		// }
		
/**
 *  func : function to check the session data and all user input data
 *  desc : check the request contains data and user is valid with session details
 *  result : return success for valid user and error message for errors
 */
		public function checkSession() {
			// check the post request data is set or not
			if(is_array($_POST) && count($_POST) > 0) {
				// check the session is set or not
				if(isset($_SESSION) && isset($_SESSION['shop_bill_shop_id'])) {
					// check the request session id and emp id is valid for current session
					if(session_id() == $_POST['session_id'] && $_SESSION['shop_bill_shop_id'] == $_POST['shop_id']) {
						return "success";
					} else {
						
						$this -> status = "session";
						return "Invalid session id Login again to continue";
					}
				} else {
					// remove the cookie details
					
					$this -> status = "session";
					return "Session data not found login again";
				}
			} else {
				return "No request data found to perform the action";
			}
		}
		
/**
 *  func : to check the cookie for any alert or message
 *  desc : set the alert into error property and destroy the cookie 
 */
		public function cookieAlert() {
			// check the cookie has values
			if(is_array($_COOKIE) && count($_COOKIE) > 0) {
				// check the alert is set in cookie and not empty
				if(isset($_COOKIE['alert']) && !empty($_COOKIE['alert'])) {
					// assign the cookie to error property and delete the cookie values
					$this -> errors = $_COOKIE['alert'];
					
					// destroy the cookie
					setcookie("alert", "", time()-3600, "/", NULL);
				}
			}
		}
		
	}