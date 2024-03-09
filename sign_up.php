<?php
/*
 * index.php
 * main form
 */
// Loading global variables and DB connection
require "globals.php";
//
// $_SESSION['queryData'] array holds data from previous forms, 
// if empty it should be initialized to avoid warnings, and set defaults
// also a ...?new=1 allows to clean it from the URL.
//

if (isset($_REQUEST['new']) or !isset($_SESSION['queryData'])) {
    $_SESSION['queryData'] = [
        'search' => ''
    ];
}
// end initialization ===================================================================================
?>
<?= headerDBW()?>
<div class="sign-up">
    <div class="container">
        <form name="MainForm" action="search.php" method="POST" enctype="multipart/form-data">
            <h2 class="title">Sign Up</h2>
            <h4> Username:</h4>
            <div class = "search-bar2">
                <input placeholder="Introduce your username" name="user" ></input>
            </div>
            <h4> Password:</h4>
            <div class = "search-bar2">
                <input placeholder="Introduce your password" name="password1" ></input>
            </div>
            <h4> Repeat password:</h4>
            <div class = "search-bar2">
                <input placeholder="Please, repeat your password" name="password2" ></input>
            </div>
            <h4> Email:</h4>
            <div class = "search-bar2">
                <input placeholder="Introduce your email" name="email" ></input>
            </div>
            <h4> Country:</h4> 
            <div class = "search-bar2">
                <input placeholder="Introduce your country" name="country" ></input>
            </div>
            <button class="submit-button">SignUp</button>
        </form>
    </div>
</div>
<?= footerDBW()?>