<?php
// FORM PROCESSING
if (isset($_REQUEST['submit']) && ($_REQUEST['submit'] == 'Save' || $_REQUEST['submit'] == 'Send')) {

	// Sanitize data
	$receiver = sanitize_data($_REQUEST['receiver']);
	$senderID = $_SESSION['user-id'];
	$sender = $_SESSION['user-email'];
	$subject = sanitize_data($_REQUEST['subject']);
	$message = sanitize_data($_REQUEST['msg']);
	$isEnc = isset($_REQUEST['isEncrypted']);

	// Encrypt message?
	if ($isEnc) $message = encrypt($message);

	// Save to database
	$error = $DB->save_send_email($receiver, $senderID, $subject, $message, $isEnc, $_REQUEST['submit'], $sender);
	if ($error) {
		$word = ($_REQUEST['submit'] == 'Save') ? "saving" : "sending";
		display_alert($error, "danger", "Error $word email");
	}

}

?>
<h2>Compose</h2>
<form action="index.php?view=compose" method="post" class="container border border-2 border-dark p-3">
	<div class="row">
		<div class="col col-12 col-md-6 my-2">
			<label class="form-label" for="receiver">To:</label>
			<input class="form-control" type="email" name="receiver" id="receiver">
		</div>
		<div class="col col-12 col-md-6 my-2">
			<label class="form-label" for="sender">From:</label>
			<input class="form-control" type="email" name="sender" id="sender" value="<?php echo $_SESSION['user-email'] ?>" disabled>
		</div>
		<div class="col col-12 my-2">
			<label class="form-label" for="subject">Subject:</label>
			<input class="form-control" type="text" name="subject" id="subject">
		</div>
		<div class="col col-12 my-2">
			<label class="form-label" for="msg">Message:</label>
			<textarea class="form-control" name="msg" id="msg" rows="10"></textarea>
		</div>
		<div class="col col-12 my-2">
			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" role="switch" id="isEncrypted" name="isEncrypted">
				<label class="form-check-label" for="isEncrypted">Encrypt Email</label>
			</div>
		</div>
		<div class="col col-12 my-2">
			<div class="row justify-content-between">
				<div class="col col-auto">
					<input class="btn btn-lg px-sm-5 btn-secondary" type="submit" value="Save" name="submit">
				</div>
				<div class="col col-auto">
					<input class="btn btn-lg px-sm-5 btn-success" type="submit" value="Send" name="submit">
				</div>
			</div>
		</div>
	</div>
</form>