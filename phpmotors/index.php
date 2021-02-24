<?php 

// This is the main controller

// Initialize controller
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/library/controller_init.php';

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