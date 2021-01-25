<?php 

// This is the main controller

// Get the database connection file
require_once 'library/connections.php';
// Get the PHP Motors model for use as needed
require_once 'model/main-model2.php';

// Get the array of classifications for nav bar view
$navList = getClassifications();

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
}

switch ($action){
  case 'template':
   include 'view/template.php';
   break;
  
  default:
    $pageTitle = 'Home';
    $contentPath = '/phpmotors/view/home2.php';
 }

 include 'modules/template-core2.php'
?>