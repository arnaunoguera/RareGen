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

//get requested data
$sql = "SELECT e.* from entry e where e.idCode='" . $_REQUEST['idCode'] . "'";
?>


<?= headerDBW()?>
<div class = "content-search">
    <div class = "container">
    <h3><?php echo $sql; ?></h3>
<?= footerDBW()?>