<?php

	// Instantiate a DB obj to use
	$DB = new Database();

	// Database wrapper object to encapsulate SQL queries
	class Database {

		private $mySqlObj;

		/**
		 * Connects to MySQL database
		 */
		function __construct() {
			// Get password from ../secret if available. 
			// Otherwise default to "root"
			$pass = file_get_contents("../secret");
			if ($pass == "") $pass = "root";

			// Make connection, possible echo alert
			$mySqlObj = new mysqli("localhost", "root", $pass, "");
			if ($mySqlObj->error) {
				display_alert("($mySqlObj->errno): $mySqlObj->error", "danger", "Database Connection Error");
			}
		}

	}

	// User object?
	// Email object?
?>