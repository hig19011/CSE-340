<?php

// This is the accounts controller

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
require_once '../model/accounts-model.php';

// consolidate page titles and path to avoid magic strings
$loginTitle = 'Login';
$loginPath = '/phpmotors/view/login.php';
$registerTitle = 'Register';
$registerPath = '/phpmotors/view/register.php';

// Build a navigation bar using the $classifications array
$navList = getClassifications();

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}
//echo $action;

switch ($action) {

  case 'register':
    $pageTitle = $registerTitle;
    $contentPath = $registerPath;

    $clientFirstName = filter_input(INPUT_POST, 'clientFirstName', FILTER_SANITIZE_STRING);
    $clientLastName = filter_input(INPUT_POST, 'clientLastName', FILTER_SANITIZE_STRING);
    $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
    $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

    // Check for missing data
    if (empty($clientFirstName) || empty($clientLastName) || empty($clientEmail) || empty($clientPassword)) {
      $message = '<p class="errorMessage">Please provide information for all empty form fields.</p>';
      break;
    }

    // Send the data to the model
    $regOutcome = regClient($clientFirstName, $clientLastName, $clientEmail, $clientPassword);

    // Check and report the result
    if ($regOutcome === 1) {
      $message = "<p class='successMessage'>Thanks for registering $clientFirstName. Please use your email and password to login.</p>";   
      $pageTitle = $loginTitle;
      $contentPath = $loginPath;  
    } else {
      $message = "<p class='errorMessage'>Sorry $clientFirstName, but the registration failed. Please try again.</p>";
    }

    break;

  case 'login':
    $pageTitle = $loginTitle;
    $contentPath = $loginPath;

    $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
    $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

    break;
  case 'login-page':
    $pageTitle = $loginTitle;
    $contentPath = $loginPath;
    break;
  case 'register-page':
    $pageTitle = $registerTitle;
    $contentPath = $registerPath;
    break;

  default:
    $pageTitle = 'No Page yet';
    $contentPath = '/phpmotors/view/template.php';
}

include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/template-core.php';
