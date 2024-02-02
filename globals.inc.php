<?php
/*
 * globals.inc.php
 * Global variables and settings
 */
// Base directories
$baseDir = dirname($_SERVER['SCRIPT_FILENAME']);

// Include directory
$incDir = "$baseDir/include";

// Load accessory routines
include_once "$incDir/base.php";

// Start session to store queries
session_start();