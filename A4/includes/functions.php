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

?>