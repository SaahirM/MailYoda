<?php
session_start();

// IMPORTS
define("ROOT", "../");
require "functions.php";
require "db.php";

// Make sure user is supposed to be here
if (!isset($_REQUEST['email']) || !isset($_REQUEST['pass']) || $_REQUEST['token'] != $_SESSION['user-token']) {
	header("Location: ../index.php");
	die();
}

// Check database for user
$email = sanitize_data($_REQUEST['email']);
$pass = sanitize_data($_REQUEST['pass']);
$userData = $DB->auth_user($email, $pass);
if (!isset($userData['userID'])) {
	$userData = urlencode($userData);
	header("Location: ../index.php?login=fail&error=$userData");
	die();
}

$_SESSION['user-name'] = $userData['userName'];
$_SESSION['user-id'] = $userData['userID'];
$_SESSION['user-email'] = $email;
header("Location: ../index.php");
die();

?>