<?php

// load global vars and includes
require "globals.php";

// Store input data in $_SESSION to reload initial form if necessary
$_SESSION['signup'] = $_REQUEST;

$username = $_REQUEST['user'];
$email =  $_REQUEST['email'];
$idcountry = $_REQUEST['country'];
$psswd =  $_REQUEST['password1'];

$sthEntryUser = "INSERT INTO User VALUES ('" . $username . "','',1," . $idcountry . ",'" . $email . "', '')";

// Passowrd encryption:
// Generate a random salt
$salt = bin2hex(random_bytes(16));
// Combine password and salt, then hash
$hashedPassword = password_hash($password . $salt, PASSWORD_BCRYPT);

$sthEntryLogin = "INSERT INTO Login VALUES ('" . $hashedPassword . "','" . $username . "','" . $salt . "')";

if ($mysqli) {
    $result = mysqli_query($mysqli, $sthEntryUser) or print errorPage("mysqli error", "The database request was unsuccessful.");
    $result2 = mysqli_query($mysqli, $sthEntryLogin) or print errorPage("mysqli error", "The database request was unsuccessful.");
} else {
    print errorPage("Connection failed", mysqli_connect_error());
}

// Check if the query was executed successfully
if (!$result || !$result2) {
    print errorPage("Sign-up error", "There was an unexpected error processing your sign-up. Please, try again.");
}


// // To verify a password
// // Retrieve hashedPassword and salt from the database
// // Combine provided password with stored salt, then hash
// $hashedPasswordAttempt = password_hash($providedPassword . $saltFromDatabase, PASSWORD_BCRYPT);

// // Compare the hashed password attempt with the stored hashed password
// if (hash_equals($hashedPasswordFromDatabase, $hashedPasswordAttempt)) {
//     // Passwords match, login successful
// } else {
//     // Passwords do not match, login failed
// }

// end controller section ===================================================================================
?>

<?= headerDBW()?>

<div class = "content-resultstitle">
    <div class="container_resultstitle">
    </div>
</div>

<div class="content-results">
    <div class="container_results">
        <h2 class="title_results">Sign-up success</h2>
        <p>Sign-up was successful. Pleace, proceed to login.</p>
    </div>
</div>

<?= footerDBW() ?>