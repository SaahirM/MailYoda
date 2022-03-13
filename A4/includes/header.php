<?php
	// INITIALIZATION
	ob_start();
	session_start();
	$_SESSION['user-token'] = hash("sha3-512", session_id());

	// IMPORTS
	require "includes/functions.php";
	include "includes/db.php";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>YodaMail</title>

		<!-- CSS | Bootstrap from https://getbootstrap.com/ @ 18:07 11-Mar-2022 -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

		<!-- CSS | Colours & Bootsrap overrides -->
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
		<!--
			Navbar adapted from boostrap's example navbar
			(https://getbootstrap.com/docs/5.1/components/navbar/)
			@ 19:47 11-Mar-2022
		-->
		<header class="navbar container-fluid sticky-top">
			<h1 class="navbar-brand m-0">YodaMail</h1>
			<nav>
				<ul class="navbar-nav flex-row">

					<?php if (!isset($_SESSION['user-name'])) { ?>
						<li class="navbar-item">
							<a class="navbar-link px-3" href="register.php">Register</a>
						</li>

					<?php } else { ?>
						<li class="nav-item">
							<a class="nav-link px-3" href="index.php?view=inbox">Inbox</a>
						</li>
						<li class="nav-item">
							<a class="nav-link px-3" href="index.php?view=sentdrafts">Sent/Drafts</a>
						</li>
						<li class="nav-item">
							<a class="nav-link px-3" href="index.php?view=compose">Compose</a>
						</li>
						<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<?php echo $_SESSION['user-name']; ?>
						</a>
						<ul class="dropdown-menu" aria-label="User profile actions">
							<li><a class="dropdown-item" href="profile.php">Profile</a></li>
							<li><a class="dropdown-item" href="includes/logout.php">Logout</a></li>
						</ul>
						</li>

					<?php } ?>
				</ul>
			</nav>
		</header>