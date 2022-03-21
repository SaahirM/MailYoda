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
		$allEmails = $DB->get_all_email_previews($_SESSION['user-id'], 'inbox');

		// Format them and echo
		if (is_array($allEmails)) {
			if (count($allEmails) === 0) {
				display_alert("Inbox is empty", 'info');
			} else {
				foreach ($allEmails as $email) {
					?>
						<a href="index.php?view=inbox&email=<?php echo $email['ID']; ?>" class="list-group-item list-group-item-action hstack gap-2">
							<span><?php echo $email['subj']; ?></span>
							<div class="vr ms-auto"></div>
							<span><?php echo $email['sender']; ?></span>
						</a>
					<?php
				}
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
		$email = $DB->get_email($emailID, $_SESSION['user-id'], 'inbox');

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
					<?php if ($email['isEncrypted']) display_alert("This message is encrypted", 'info m-0') // Using param to pass extra style class ?>
				</div>

			<?php
		} else {
			display_alert($email, "danger", "Error fetching email");
		}
	}

	/**
	 * Fetches and displays all sent email subject-lines
	 */
	function generate_sentdrafts_email_list() {

		// Make sure we have a database
		global $DB;
		
		// Get all emails from DB
		$allEmails = $DB->get_all_email_previews($_SESSION['user-id'], 'outbox');

		// Format them and echo
		if (is_array($allEmails)) {
			if (count($allEmails) === 0) {
				display_alert("Outbox is empty", 'info');
			} else {
				foreach ($allEmails as $email) {
					?>
						<a href="index.php?view=sentdrafts&email=<?php echo $email['ID']; ?>" class="list-group-item list-group-item-action hstack gap-2">
							<span><?php echo $email['subj']; ?></span>
							<div class="vr ms-auto"></div>
							<span><?php echo $email['receiver']; ?></span>
						</a>
					<?php
				}
			}
		} else {
			display_alert($allEmails, "danger", "Error fetching emails");
		}
	}

	/**
	 * Fetches information about a sent/draft email with given ID
	 * and displays it
	 * @param integer $emailID ID of the email to fetch
	 */
	function display_sentdrafts_email($emailID) {
		
		// Make sure we have a database
		global $DB;

		// Try getting email data from db
		$email = $DB->get_email($emailID, $_SESSION['user-id'], 'outbox');

		// Display result
		if (is_array($email)) {
			?>

				<div class="card">
					<div class="card-header">To <?php echo $email['receiver']; ?></div>
					<div class="card-body">
						<h3 class="card-title"><?php echo $email['subj']; ?></h3>
						<p class="card-text"><?php echo $email['content']; ?></p>
					</div>
					<div class="card-footer">
						<?php echo $email['isDraft'] ? "Saved" : "Sent"; ?>
						<?php echo $email['dateTime']; ?>
					</div>
					<?php if ($email['isEncrypted']) display_alert("This message is encrypted", 'info m-0') // Using param to pass extra style class ?>
				</div>

			<?php
		} else {
			display_alert($email, "danger", "Error fetching email");
		}
	}

	/**
	 * Mangles certain string patterns by adding
	 * its characters' ascii values % 16 to its
	 * characters ascii values (ASCII shift)
	 * @param string $str string to encrypt
	 * @return string encrypted string
	 */
	function encrypt($str) {

		// Patterns used to find emails and ph nums
		// Note: Assumes sections of ph-num are not space seperated, and
		// are 10 digits long (or 11 with country code)
		$emailPattern = "/\w+@\w+\.\w+/";
		$phNumPattern = "/^(\+?\d-?)?\(?\d{3}\)?-?(\d-?){7}$/";

		// Break message into array of words
		$wordArray = explode(' ', $str);

		// Encrypt words that match patterns
		$wordArray = preg_replace_callback(
				[
					$emailPattern, $phNumPattern, 
					"/c.+p/", "/T.+p/i", "/e.+t/i", "/a.+e/i", 
					"/a.*w/i", "/c.+e/i", "/u.+e/"
				],
				function ($match) {
					$word = $match[0];
					$newWord = "";

					for ($i = 0; $i < strlen($word); $i++) {
						$c = ord($word[$i]);
						$c += ($c >= 33 && $c <= 126) ? ($c % 16) : 0;
						if ($c > 126) $c -= 126; // Wrap numbers back into range
						$newWord .= chr($c);
					}
					
					return "\$eas\$" . $newWord;
				},
				$wordArray
			);

		// Join message array back into string
		$str = "";
		for ($i = 0; $i < count($wordArray) - 1; $i++) {
			$str .= $wordArray[$i] . " ";
		}
		$str .= $wordArray[count($wordArray) - 1];

		return $str;
	}

?>