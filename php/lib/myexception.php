<?php

	class MyException extends Exception {
	
		public function logException() {
			$error_message = "Server error occured in ".$this->getFile()." on line no ".$this->getLine()." and the message is ".$this->getMessage();
			error_log($error_message);
		}
		
		/* public function mailException() {
			$error_message = "Server error occured in ".$this->getFile()." on line no ".$this->getLine()." and the message is ".$this->getMessage();
			$header = "FROM: keviveks@gmail.com";
			// error log to send by mail 
			@error_log($error_message, 1, CMP_MAIL, $header);
		}
		
		public function cookieException() {
			setcookie("cookie_alert", $this->getMessage(), time()+600, "/", NULL);
		} */
		
	}