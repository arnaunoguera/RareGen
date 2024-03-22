<?php
/*
 * globals.inc.php
 * Global variables and settings
 */
// Base directories
// Automatic, taken from CGI variables.
$baseDir = dirname($_SERVER['SCRIPT_FILENAME']);

$baseURL = dirname($_SERVER['SCRIPT_NAME']);

// Include directory
$incDir = "$baseDir/include";

// Load accessory routines
include_once "$incDir/libDBW.inc.php";
include_once "$incDir/bdconn.inc.php";

// Load predefined arrays
// Fulltext search fields
$geneFields = ['g.Name', 'g.Locus', 'g.Ensembl_id', 'g.OMIM_id', 'g.GenAtlas_id', 'g.HGNC_id', 'g.Symbol', 'g.SwissProt_id', 'ga.Alias_name'];
$diseaseFields = ['d.Name', 'd.Orphacode', 'da.Alias_name'];
$associationFields = ['pa.Name', 'pa.Description'];

// Start session to store queries
session_start();