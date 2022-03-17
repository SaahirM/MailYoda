<?php

	/**
	 * Removes trailing/leading whitespace and escapes
	 * html tokens and backslash-escaped chars from given
	 * string
	 * @param string $rawData data to sanitize
	 * @return string Data after sanitization
	 */
	function sanitize_data($rawData) {
		$data = trim($rawData);
		$data = htmlspecialchars($data);
		$data = stripslashes($rawData);
		return $data;
	}

	/**
	 * Echoes an alerted, formatted as a bootstrap alert component
	 * @param string $text Main alert text with details
	 * @param string $type The type of alert (from bootstrap alert docs)
	 * @param string $title Optional title
	 */
	function display_alert($text, $type, $title=null) {
		echo "<div class='alert alert-$type'>";
			if ($title) echo "<h3 class='alert-heading'>$title</h3>";
			echo $text;
		echo "</div>";
	}

	/**
	 * Fetches and displays all email subject-lines
	 */
	function generate_email_list() {

		// Make sure we have a database
		global $DB;
		
		// Get all emails from DB
		$allEmails = $DB->get_all_email_previews($_SESSION['user-id']);

		// Format them and echo
		if (is_array($allEmails)) {
			foreach ($allEmails as $email) {
				?>
					<a href="index.php?view=inbox&email=<?php echo $email['ID']; ?>" class="list-group-item list-group-item-action hstack gap-2">
						<span><?php echo $email['subj']; ?></span>
						<div class="vr ms-auto"></div>
						<span><?php echo $email['sender']; ?></span>
					</a>
				<?php
			}
		} else {
			display_alert($allEmails, "danger", "Error fetching emails");
		}
	}

	/**
	 * Fetches information about email with given ID
	 * and displays it
	 * @param integer $emailID ID of the email to fetch
	 */
	function display_email($emailID) {
		
		// Make sure we have a database
		global $DB;

		// Try getting email data from db
		$email = $DB->get_email($emailID, $_SESSION['user-id']);

		// Display result
		if (is_array($email)) {
			?>

				<div class="card">
					<div class="card-header">From <?php echo $email['sender']; ?></div>
					<div class="card-body">
						<h3 class="card-title"><?php echo $email['subj']; ?></h3>
						<p class="card-text"><?php echo $email['content']; ?></p>
					</div>
					<div class="card-footer">Sent <?php echo $email['dateTime']; ?></div>
				</div>

			<?php
		} else {
			display_alert($email, "danger", "Error fetching email");
		}
	}

?>