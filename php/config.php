<?php
	
	// define the shop details configuration
	define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DB_NAME", "billing");


	// define the path and url setting of application
	define("PATH", $_SERVER['DOCUMENT_ROOT']."/git/billing");
	define("URL", "http://".$_SERVER['HTTP_HOST']."/git/billing");
	
	// define the environment of application for error message and security purpose
	define("ENV", "dev"); // it contains "dev" & "pro"
	
?>