<?php
/*
 * bdconn.inc.php
 * DB Connection
 */

$host = "localhost";
$dbname = "RareGen";
$user = "arnau";
$password = "DBW";
($mysqli = mysqli_connect($host, $user, $password)) or die(mysqli_error());
mysqli_select_db($mysqli, $dbname) or die(mysqli_error($mysqli));