<?php
    // CONSTANTS
    define("CURR_FILE", basename($_SERVER['PHP_SELF']));
    define("ROOT", "");

    // IMPORT
    require_once "includes/header.php";
?>
<section class="container-fluid">
	<h2>Profile</h2>
	<div class="row">
		<div class="col col-12 col-sm-4">
			<?php
			// Determine path to profile image (if exists).
			// First determine file extension (iterate through all extensions)
			if (file_exists("img/{$_SESSION['user-id']}.jpg")) {
				$imgFilepath = "img/{$_SESSION['user-id']}.jpg";
			} else if (file_exists("img/{$_SESSION['user-id']}.jpeg")) {
				$imgFilepath = "img/{$_SESSION['user-id']}.jpeg";
			} else if (file_exists("img/{$_SESSION['user-id']}.png")) {
				$imgFilepath = "img/{$_SESSION['user-id']}.png";
			} else { // Default
				$imgFilepath = 'img/user-profile.jpg';
			}
			?>
			<img class="img-fluid" src="<?php echo $imgFilepath; ?>" alt="<?php echo $_SESSION['user-name']; ?>">
		</div>
		<div class="col col-12 col-sm-8">
			<p class="py-1"><?php echo $_SESSION['user-name']; ?></p>
			<p class="py-1"><?php echo $_SESSION['user-email']; ?></p>
		</div>
	</div>
</section>

<?php require_once "includes/footer.php"; ?>