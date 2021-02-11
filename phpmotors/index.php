<?php 

// This is the main controller

// Get the database connection file
require_once 'library/connections.php';
// Get the PHP Motors model for use as needed
require_once 'model/main-model.php';

// Get the array of classifications for nav bar view
$navList = getClassifications();

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
}

switch ($action){
  case 'template':   
   $pageTitle = 'Content Title';
   $contentPath = '/phpmotors/view/default.php';
   break;
  
  default:
    $pageTitle = 'Home';
    $contentPath = '/phpmotors/view/home.php';
 }

 include 'modules/template-core.php'
?>