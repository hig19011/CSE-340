<?php

// This is the accounts controller

// Initialize controller
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/library/controller_init.php';

// Get the accounts model for use as needed
require_once '../model/accounts-model.php';


// consolidate page titles and path to avoid magic strings
$adminTitle = 'Admin';
$adminPath = '/phpmotors/view/admin.php';
$loginTitle = 'Login';
$loginPath = '/phpmotors/view/login.php';
$registerTitle = 'Register';
$registerPath = '/phpmotors/view/register.php';



$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {

  case 'register':
    $pageTitle = $registerTitle;
    $contentPath = $registerPath;

    $clientFirstName = filter_input(INPUT_POST, 'clientFirstName', FILTER_SANITIZE_STRING);
    $clientLastName = filter_input(INPUT_POST, 'clientLastName', FILTER_SANITIZE_STRING);
    $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
    $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

    $clientEmail = checkEmail($clientEmail);
    $checkPassword = checkPassword($clientPassword);

    // Check for missing data
    if (empty($clientFirstName) || empty($clientLastName) || empty($clientEmail) || empty($checkPassword)) {
      $_SESSION['message'] = '<p class="errorMessage">Please provide information for all empty form fields.</p>';
      break;
    }

    $emailExists = doesEmailExist($clientEmail);
    if($emailExists){
      $_SESSION['message'] = '<p class="noticeMessage">That email address already exists. Do you want to login instead?</p>';
      break;
    }

    // Hash the checked password
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

    // Send the data to the model
    $regOutcome = regClient($clientFirstName, $clientLastName, $clientEmail, $hashedPassword);

    // Check and report the result
    if ($regOutcome === 1) {
      setcookie('firstName',$clientFirstName, strtotime('+1 year'),'/');
      $_SESSION['message'] = "<p class='successMessage'>Thanks for registering $clientFirstName. Please use your email and password to login.</p>";   
      header('Location: /phpmotors/accounts/?action=login-page');
      exit;
    } else {
      $_SESSION['message'] = "<p class='errorMessage'>Sorry $clientFirstName, but the registration failed. Please try again.</p>";
    }

    break;

  case 'login':
    $pageTitle = $loginTitle;
    $contentPath = $loginPath;

    $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
    $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

    $clientEmail = checkEmail($clientEmail);
    $checkPassword = checkPassword($clientPassword);

    // Check for missing data
    if (empty($clientEmail) || empty($checkPassword)) {
      $_SESSION['message'] = '<p class="errorMessage">Please provide information for all empty form fields.</p>';
      break;
    }

    //Get the client data
    $clientData = getClient($clientEmail);
    if($clientData == false)
    {
      $_SESSION['message'] = '<p class="noticeMessage">Please check your email and try again</p>';
      break;
    }
    //Verify submitted password matches the one on file.  Return error message if mismatch.
    $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
    if(!$hashCheck) {
      $_SESSION['message'] = '<p class="noticeMessage">Please check your password and try again.</p>';
      break;
    }
        
    // User is value, consider them logged in.
    $_SESSION['loggedIn'] = true;

    //The password is the last element in the array, remove it for user protection.
    array_pop($clientData);

    // Store client information in the Session
    $_SESSION['clientData'] = $clientData;

    $pageTitle = $adminTitle;
    $contentPath = $adminPath;
    break;

  case 'login-page':
    $pageTitle = $loginTitle;
    $contentPath = $loginPath;
    break;

  case 'register-page':
    $pageTitle = $registerTitle;
    $contentPath = $registerPath;
    break;

  case 'logout':
    session_unset();
    session_destroy();
    header('Location: /phpmotors/');    
    exit;
    break;

  default:
    $pageTitle = $adminTitle;
    $contentPath = $adminPath;
}

include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/template-core.php';
