<?php
    // CONSTANTS
    define("CURR_FILE", basename($_SERVER['PHP_SELF']));

    // IMPORT
    require_once "includes/header.php";
?>

<main class="container">

    <?php if (!isset($_SESSION['user-name'])) { ?>
        <form action="includes/login.php" method="post" class="border border-dark p-5 my-4">
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

    <?php } ?>

</main>

<?php require_once "includes/footer.php"; ?>