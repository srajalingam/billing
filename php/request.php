<?php
	
	//////////////////////////////// new request ////////////////////////////////
	
/**
 *  file : to collect all the request from every pages
 *  desc : request with query string url with c (Controller name) and mtd (method name of that controller)
 *  desc : check the controller is exists with the file name (file name and controller name should be same)
 *  desc : check the method is exists in that controller to call the function
 */
 
	// load the config file to set the configuration define constants to controller and model files
	require_once('config.php');
	
	// load the exception file to log the execution errors
	require_once('lib/myexception.php');
	
	// to set a more secure options for every request data
	require_once('lib/secure.php');
	
	// load the base controller which can extends in all controller for common functionalities
	require_once("lib/controller.php");
	
	// load the base model class for db connection and to prepare the query
	require_once("lib/model.php");
	
	// execute all the request with exception handling
	try {
		// check the query string contains controller or not
		if(isset($_GET['c']) && !empty($_GET['c'])) {
			// collect the controller 
			$controller = strip_tags(trim($_GET['c']));
			// check the controller exists or not with the file name which is same as controller name
			$controller_path = PATH."/php/controller/$controller.php";
			if(file_exists($controller_path)) {
				// include the controller file 
				require_once($controller_path);
				// check the corresponding model for controller by appending model
				$model = $controller."model";
				$model_path = PATH."/php/model/$model.php";
				// check the model file is exists
				if(file_exists($model_path)) {
					// instantiate the model for every controller
					require_once($model_path);
					$obj_model = new $model();
				} else {
					// make the model object false for model less controller
					$obj_model = FALSE;
				}
				// now instantiate the controller with model object
				$obj_controller = new $controller($obj_model);
				// var_dump($_POST);
				// get the method name from the post request 
				if(isset($_POST['mtd']) && !empty($_POST['mtd'])) {
					$method = $_POST['mtd'];
					// check the request method is valid in controller
					if(method_exists($obj_controller, $method)) {
						$response = $obj_controller -> $method();
						echo $response;
					} else {
						throw new Exception("Invalid request check the request data");
					}
				} else {
					throw new Exception("Method name not found");
				}
			} else {
				throw new Exception("Invalid request try again");
			}
		} else {
			throw new Exception("Invalid request check again");
		}
	} catch(MyException $ex) {
		$ex->logException();
		echo $ex->getLine();
		$response = array(
							'status' => "fail",
							'response' => array('message' => $ex->getMessage())
						);
		echo json_encode($response);
	} catch(Exception $ex) {
		$response = array(
							'status' => "fail",
							'response' => array('message' => $ex->getMessage())
						);
		echo json_encode($response);
	}
	
?>