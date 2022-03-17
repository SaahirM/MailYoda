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
					je_login_email = ? "
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

		/**
		 * Adds a new user-login combo to the database
		 * @param string $email User's email
		 * @param string $pass User's password in plaintext.
		 * 					It will be hashed before storage
		 * @param string $fname User's firstname
		 * @param string $lname User's lastname
		 * 
		 * @return int|string The user's ID, or error info if failure
		 */
		function register_user($email, $pass, $fname, $lname) {

			// ADD LOGIN COMBO

			// Sanitize for database query (just in case)
			$email = $this->mySqlObj->real_escape_string($email);
			$pass = $this->mySqlObj->real_escape_string($pass);

			// Hash password for storage
			$pass = password_hash($pass, PASSWORD_DEFAULT);

			// Prepare query
			$stmt = $this->mySqlObj->prepare(
				"INSERT INTO
					je_login(je_login_email, je_login_password)
					VALUES ( ? , ? )"
			);

			// Execute query
			if (!$stmt) return $this->mySqlObj->error;
			$stmt->bind_param('ss', $email, $pass);
			$stmt->execute();

			// GET LOGIN_ID
			// Assumes the id of the login data we just entered is
			// the greatest integer in there so far

			// Execute query
			$result = $this->mySqlObj->query(
				"SELECT MAX(je_login_id) FROM je_login;"
			);
			if (!$result) return $this->mySqlObj->error;
			$row = $result->fetch_row();
			if (!$row) return "No ID returned";
			$ID = $row[0];

			// ADD USER DATA
			
			// Sanitize for database query (just in case)
			$fname = $this->mySqlObj->real_escape_string($fname);
			$lname = $this->mySqlObj->real_escape_string($lname);

			// Prepare query
			$stmt = $this->mySqlObj->prepare(
				"INSERT INTO
					je_users(
						je_user_firstname, 
						je_user_lastname, 
						je_user_login_id,
						je_user_role,
						je_user_suspended
					)
				VALUES
					( ? , ? , $ID , 1 , 0 )"
			);

			// Execute query
			if (!$stmt) return $this->mySqlObj->error;
			$stmt->bind_param('ss', $fname, $lname);
			$stmt->execute();

			// RETURN
			return $ID;
		}

		/**
		 * Queries database for all emails sent to
		 * given user ID
		 * @param integer $ID ID of user whose inbox we're getting
		 * @return array|string Assoc-array of all email subjects
		 * 						and senders or error string
		 */
		function get_all_email_previews($ID, $view) {

			// Validate input data
			if (!is_numeric($ID)) return "Invalid User ID";

			// Choose appropriate query
			if ($view == 'inbox') {
				$qry = "SELECT
							je_email_id AS ID,
							je_email_from_email AS sender,
							je_email_subject AS subj
						FROM je_inbox
						WHERE je_email_to_id = {$ID};";

			} else if ($view = 'outbox') {
				$qry = "SELECT
							je_sentdraft_id AS ID,
							je_sentdraft_to_email AS receiver,
							je_sentdraft_subject AS subj
						FROM je_email_sentdrafts
						WHERE je_sentdraft_from_id = {$ID};";
			} else {
				return "Invalid view entered";
			}


			// Make query
			$result = $this->mySqlObj->query($qry);
			if (!$result) return $this->mySqlObj->error;
			
			// Throw all results into an array to return
			$allEmails = [];
			while ($email = $result->fetch_assoc()) {
				array_push($allEmails, $email);
			}
			return $allEmails;
		}

		function get_email($emailID, $userID, $view) {

			// Validate input data
			if (!is_numeric($emailID) || !is_numeric($userID)) return "Invalid ID";

			// Choose appropriate query
			if ($view == 'inbox') {
				$qry = "SELECT
							je_email_from_email AS sender,
							je_email_subject AS subj,
							je_email_content AS content,
							je_email_enc AS isEncrypted,
							je_date_received AS dateTime
						FROM je_inbox
						WHERE
							je_email_id = {$emailID}
							AND je_email_to_id = {$userID};";

			} else if ($view == 'outbox') {
				$qry = "SELECT
							je_sentdraft_to_email AS receiver,
							je_sentdraft_subject AS subj,
							je_sentdraft_content AS content,
							je_sentdraft_draft AS isDraft,
							je_sentdraft_enc AS isEncrypted,
							je_sentdraft_datetime AS dateTime
						FROM je_email_sentdrafts
						WHERE
							je_sentdraft_id = {$emailID}
							AND je_sentdraft_from_id = {$userID};";

			} else {
				return "Invalid view entered";
			}

			// Query for email
			$result = $this->mySqlObj->query($qry);

			// Return appropriate result
			if (!$result) return $this->mySqlObj->error;
			else if ($result->num_rows === 0) return "Email does not exist in this $view";
			else return $result->fetch_assoc();
		}

	}

	// User object?
	// Email object?
?>