<?php
    // CONSTANTS
    define("CURR_FILE", basename($_SERVER['PHP_SELF']));
    define("ROOT", "");

    // IMPORT
    require_once "includes/header.php";
?>

<?php if (!isset($_SESSION['user-name'])) { ?>
    <form action="includes/login.php" method="post" class="border border-2 border-dark p-5">
        <h2>Login to MailYoda</h2>
        <input type="hidden" name="token" value="<?php echo $_SESSION['user-token']; ?>">
        <div class="row my-2">
            <label class="form-label" for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email">
        </div>
        <div class="row my-2">
            <label class="form-label" for="pass">Password</label>
            <input class="form-control" type="password" name="pass" id="pass">
        </div>
        <div class="row my-2 justify-content-end">
            <input class="btn btn-success col-12 col-md-3" type="submit" value="Login">
        </div>
        <p>New to this MailYoda? <a href="register.php">Register here.</a></p>
    </form>
    <?php if (isset($_REQUEST['error'])) {
        display_alert(sanitize_data(urldecode($_REQUEST['error'])), 'danger', "Login Failed");
    } else if (isset($_REQUEST['registration']) && $_REQUEST['registration'] == 'success') {
        display_alert("Account created successfully. Welcome to MailYoda", 'success', "Registration Success!");
    } ?>

<?php } else if (!isset($_REQUEST['view']) || $_REQUEST['view'] == 'inbox') { 
    include "includes/inbox.php";

} else if ($_REQUEST['view'] == 'sentdrafts') { 
    include "includes/sent-drafts.php";        

} else if ($_REQUEST['view'] == 'compose') { 
    include "includes/compose.php";        
    
} else { // Default to inbox view
    include "includes/inbox.php";
} ?>

<?php require_once "includes/footer.php"; ?>