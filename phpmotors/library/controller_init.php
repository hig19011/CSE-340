<?php
/*
* Standard startup code used in each controller
*/

// Create or access the session
session_start();

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/library/connections.php';
// Get the functions library
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/library/functions.php';

// Get the PHP Motors model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/model/main-model.php';

// Build a navigation bar using the $classifications array
$navList = getClassifications();

?>