<?php

// start the session to load session variable on every controllers 
@session_start();

	/** Check if environment is development and display errors **/
	function setReporting() {
		if (ENV == "dev") {
			error_reporting(E_ALL);
			ini_set('display_errors','ON');
		} else {
			error_reporting(E_ALL);
			ini_set('display_errors','OFF');
			ini_set('log_errors', 'ON');
			ini_set('error_log', PATH."/php/tmp/error.log");
		}
	}
	
	// func to set the error reporting ON OFF
	setReporting();