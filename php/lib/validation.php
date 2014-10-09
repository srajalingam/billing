<?php

/**
 *  class : validate all the user enter data
 *  result : return the result as true or fail and error messages as in error property
 */
	class Validation {
		
		public $errors;
		public $msg;
		
/**
 * func : to initialise the msg as array 
 */
		public function __construct() {
			$msg = [];
		}

/**
 *  func : split all the validate rules into array for a call back functions
 *  desc : conver the error message into string so we can echo all the errors as a single variable
 *  desc : collect all the error message with <p> tag so will display in new line
 *  result : true or false for any data fails
 */
		public function validate($data, $arr_rules) {
			$valid = TRUE;
			if(is_array($arr_rules)) {
				foreach($arr_rules as $field => $rules) {
					$call_back = explode("|", $rules);
					foreach($call_back as $call) {
						$value = $data[$field];
						$valid = $this -> $call($value, $field);
					}
				}
			}
			// check the error is an array to convert into string
			$this -> errors = (is_array($this->msg) && count($this->msg) > 0) ? implode(" ", $this->msg) : $this->msg;
			// return the result as true or fails
			return $valid;
		}
		
		public function required($value, $field_name) {
			$valid = ! empty($value);
			if($valid === FALSE)	$this -> msg[] = "<p>The $field_name is a required field</p>"; 
			
			return $valid;
		}
		
		public function email($value, $field_name) {
			$valid = filter_var($value, FILTER_VALIDATE_EMAIL);
			if($valid === FALSE)	$this -> msg[] = "<p>The $field_name should be a valid email</p>"; 
			
			return $valid;
		}
		
		public function phone($value, $field_name) {
			$valid = (is_numeric($value) && strlen($value) >= 10);
			if($valid === FALSE)	$this -> msg[] = "<p>The $field_name should be a valid phone no</p>"; 
			
			return $valid;
		}
		
		public function pincode($value, $field_name) {
			$valid = (is_numeric($value) && strlen($value) >= 6);
			if($valid === FALSE)	$this -> msg[] = "<p>The $field_name should be a valid Pincode no</p>"; 
			
			return $valid;
		} 
		
		public function isArray($value, $field_name) {
			$valid = (is_array($value) && count($value) > 0);
			if($valid === FALSE) $this -> msg[] = "<p>The $field_name is a required field</p>";
			
			return $valid;
		}
		
		public function number($value, $field_name) {
			$valid = is_numeric($value);
			if($valid === FALSE) $this -> msg[] = "<p>The $field_name should be numeric</p>";
			return $valid;
		}
		
		public function decimal($value, $field_name) {
			$valid = is_float($value);
			if($valid === FALSE) $this -> msg[] = "<p>The $field_name should be decimal</p>";
			return $valid;
		}
		
	}