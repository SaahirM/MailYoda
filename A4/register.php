<?php
// CONSTANTS
define("CURR_FILE", basename($_SERVER['PHP_SELF']));
define("ROOT", "");

// IMPORT
require_once "includes/header.php";

// REGISTRATION - FORM PROCESSING

// Is form filled/supposed to be processed?
$formKeys = ["email", "fname", "lname", "pass", "num"];
$isFormFilled = true;
foreach ($formKeys as $key) {
    if (!isset($_REQUEST[$key])) {
        $isFormFilled = false;
        break;
    }
}
if ($isFormFilled && ($_REQUEST['token'] == $_SESSION['user-token'])) {

    // Validate file upload status and type
    /*
     * File extension verification idea from w3schools https://www.w3schools.com/php/php_file_upload.asp
     * @ 21:42 13-Mar-2022
     */
    $imageFileType = strtolower(pathinfo(basename($_FILES['pic']['name']),PATHINFO_EXTENSION));
    $acceptableFileTypes = ["jpg", "jpeg", "png"];
    if ($_FILES["pic"]["error"] !== UPLOAD_ERR_OK || array_search($imageFileType, $acceptableFileTypes) === false) {
        display_alert("File upload status: {$_FILES['pic']['error']}\nFile type: $imageFileType", "danger", "Error Uploading File");
    } else {

        // Sanitize data
        foreach ($formKeys as $key) {
            $_REQUEST[$key] = sanitize_data($_REQUEST[$key]);
        }

        // Verify input patterns with regex
        /*
           Note: Assumes specific phone number format:
            Country code, area code, number always 1 digit, 3 digits, 7 digits respectively. 
            All parts always present
         */
        $isEmailValid = preg_match("/^\w+(\.\w+)?@(jediacademy\.edu|theforce\.org|dal\.ca)$/", $_REQUEST['email']);
        $isNamesValid = preg_match("/[A-Z]\w*/", $_REQUEST['fname']) && preg_match("/[A-Z]\w*/", $_REQUEST['lname']);
        $isPhNumValid = preg_match("/^\+?(\d)[-\s]?\(?(\d{3})\)?[-\s]?(\d{7})/", $_REQUEST['num'], $phNumDetails);

        if ($isEmailValid && $isNamesValid && $isPhNumValid) {

            // Capture Country code, Area code, Number. Idk what to do with them
            $countryCode = $phNumDetails[1];
            $areaCode = $phNumDetails[2];
            $number = $phNumDetails[3];

            // Save info to database
            $ID = $DB->register_user($_REQUEST['email'], $_REQUEST['pass'], $_REQUEST['fname'], $_REQUEST['lname']);

            // Save profile img
            // Code modified from zyBooks example, Activity 2.6.7
            // (https://learn.zybooks.com/zybook/DALCSCI2170SampangiWinter2022/chapter/2/section/6)
            // @ 20:45 13-Mar-2022
            if (is_numeric($ID)) {
                $ID = intval($ID);
                $tmp_name = $_FILES["pic"]["tmp_name"];
                
                // Move the temp file and give it a new name
                move_uploaded_file($tmp_name, "img/$ID.$imageFileType");

                // We're done registering! Return to homepage for login
                header("Location: index.php");
            } else {
                display_alert("Error message: '$ID'", "danger", "Error Updating database");
            }
        }

    }

}

?>

<main class="container">
	<form action="register.php" method="post" class="border border-dark row p-5 my-4" enctype="multipart/form-data">
            <h2>Register for a MailYoda Account</h2>
            <input type="hidden" name="token" value="<?php echo $_SESSION['user-token']; ?>">
            <div class="col-12 my-2">
                <label class="form-label" for="email">Email</label>
                <input class="form-control" type="email" name="email" id="email" required>
            </div>
            <div class="col-12 row row-cols-1 row-cols-md-2 pe-0">
				<div class="pe-0">
					<label class="form-label" for="fname">First Name</label>
					<input class="form-control" type="text" name="fname" id="fname" required>
				</div>
				<div class="pe-0">
					<label class="form-label" for="lname">Last Name</label>
					<input class="form-control" type="text" name="lname" id="lname" required>
				</div>
            </div>
            <div class="col-12 my-2">
                <label class="form-label" for="pass">Password</label>
                <input class="form-control" type="password" name="pass" id="pass" required>
            </div>
            <div class="col-12 my-2">
                <label class="form-label" for="num">Phone Number</label>
				<input class="form-control" type="tel" name="num" id="num" required>
            </div>
            <div class="col-12 my-2">
                <label class="form-label" for="pic">Upload Profile Image</label>
                <input class="form-control" type="file" name="pic" id="pic" required>
            </div>
            <div class="col-12 my-2 justify-content-end">
                <input class="btn btn-success col-12 col-md-3" type="submit" value="Register">
            </div>
            <script src="js/register-validation.js"></script>
        </form>
</main>

<?php require_once "includes/footer.php"; ?>