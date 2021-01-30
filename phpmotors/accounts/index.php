<?php 

// THis is the main controller

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';

// Get the array of classifications
$classifications = getClassifications();

// Build a navigation bar using the $classifications array
$navList = getClassifications();

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
}
//echo $action;

switch ($action){
  case 'login-post':
      $clientEmail = $_POST['clientEmail'];
      $clientPassword = $_POST['clientPassword'];      
      $pageTitle = 'Login';
      $contentPath = '/phpmotors/accounts/view/login.php';
    break;
  case 'register-post':
      $clientFirstName = $_POST['clientFirstName'];
      $clientLastName = $_POST['clientLastName'];
      $clientEmail = $_POST['clientEmail'];
      $clientPassword = $_POST['clientPassword'];
      $pageTitle = 'Register';
      $contentPath = '/phpmotors/accounts/view/register.php';
    break;
  case 'login':
      $pageTitle = 'Content Title';
      $contentPath = '/phpmotors/accounts/view/login.php';
      break;
  case 'register':   
    $pageTitle = 'Content Title';
    $contentPath = '/phpmotors/accounts/view/register.php';
    break;
  
  default:
    $pageTitle = 'No Page yet';
    $contentPath = '/phpmotors/view/template.php';
  }
 
  include $_SERVER['DOCUMENT_ROOT'].'/phpmotors/modules/template-core.php';
