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
			$pass = file_get_contents(ROOT . "../secret");
			if ($pass == "") $pass = "root";

			// Make connection, possible echo alert
			$this->mySqlObj = new mysqli("localhost", "root", $pass, "jedi_encrypted_email");
			if ($this->mySqlObj->error) {
				display_alert("($this->mySqlObj->errno): $this->mySqlObj->error", "danger", "Database Connection Error");
			}
		}

		/**
		 * Queries database to check if email-pass
		 * combo exists
		 * @param string $email User email
		 * @param string $pass User password
		 * 		(unhashed, but it's hashed in the db)
		 * @return array|string error-string if failed login,
		 * 			assoc-array with other user details
		 * 			if successful
		 */
		function auth_user($email, $pass) {

			// Sanitize for database query
			$email = $this->mySqlObj->real_escape_string($email);
			$pass = $this->mySqlObj->real_escape_string($pass);

			// Prepare query
			$stmt = $this->mySqlObj->prepare(
				"SELECT
					je_user_id AS userID,
					IF(
						je_user_lastname,
						CONCAT(je_user_firstname, ' ', je_user_lastname),
						je_user_firstname
					) AS userName,
					je_login_password AS userPass
				FROM je_users
					JOIN je_login ON je_user_login_id = je_login_id
				WHERE
					je_login_email = ? ;"
			);

			// Execute query
			if (!$stmt) return $this->mySqlObj->error;
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$result = $stmt->get_result();

			// Return result
			if (!$result) {
				return $this->mySqlObj->error;
			} else if (!($userData = $result->fetch_assoc()) || !password_verify($pass, $userData['userPass'])) {
				return "Failed Login";
			} else {
				// Don't want to return pass hash lol. I had to look this function up on php docs @ 23:12 12-Mar-2022
				unset($userData['userPass']);
				return $userData;
			}
		}

	}

	// User object?
	// Email object?
?>