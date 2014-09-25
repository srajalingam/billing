<?php
	// set the error display and log files 
	ini_set('log_errors', 1);
	ini_set('display_errors', 1); 
	ini_set('error_log', $_SERVER['DOCUMENT_ROOT']."/git/billing/php/tmp/error.log");
	
	// define the shop details configuration
	define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "password");
	define("DB_NAME", "billing");
	//CHECKING THE CHANGES IN GIT GUI
?>