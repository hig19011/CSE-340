<?php

// This is the accounts controller

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
require_once '../model/vehicles-model.php';

// consolidate page titles and path to minimize magic strings
$addClassificationTitle = 'Add Car Classification';
$addClassificationPath = '/phpmotors/view/add-classification.php';
$addVehicleTitle = 'Add Vehicle';
$addVehiclePath = '/phpmotors/view/add-vehicle.php';
$manageVehicleTitle = 'Manage Vehicles';
$manageVehiclePath = '/phpmotors/view/vehicle-man.php';

// Build a navigation bar using the $classifications array
$navList = getClassifications();

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}
//echo $action;

switch ($action) {
  case 'add-vehicle-page':
    $pageTitle = $addVehicleTitle;
    $contentPath = $addVehiclePath;
    $classificationList = $navList;
    
    $carMakes = getExistingVehicleMakes();
    break;

  case 'add-vehicle':
    $pageTitle = $addVehicleTitle;
    $contentPath = $addVehiclePath;
    $classificationList = $navList;
    
    $vehicle = new inventory();
    $vehicle->classificationId = filter_input(INPUT_POST, 'classificationId');
    $vehicle->invColor = filter_input(INPUT_POST, 'invColor');
    $vehicle->invDescription = filter_input(INPUT_POST, 'invDescription');
    $vehicle->invImage = filter_input(INPUT_POST, 'invImage');
    $vehicle->invThumbnail = filter_input(INPUT_POST, 'invThumbnail');
    $vehicle->invMake = filter_input(INPUT_POST, 'invMake');
    $vehicle->invModel = filter_input(INPUT_POST, 'invModel');
    $vehicle->invPrice = filter_input(INPUT_POST, 'invPrice');
    $vehicle->invStock = filter_input(INPUT_POST, 'invStock');

    // Check for missing data
    if ($vehicle->isInvalid()) {
      $message = '<p class="errorMessage">Please enter information for all fields.</p>';
      $carMakes = getExistingVehicleMakes();
      break;
    }    

    // Send the data to the model
    $outcome = createVehicle($vehicle);

    // Check and report the result
    if ($outcome === 1) {
      $message = "<p class='successMessage'>New vehicle $vehicle->invColor $vehicle->invMake $vehicle->invModel added.</p>";
    } else {
      $message = "<p class='errorMessage'>Sorry, the creation of the new vehicle failed. Please try again.</p>";
    }

    //pull in new vehicle makes;
    $carMakes = getExistingVehicleMakes();
    break;

  case 'add-classification-page':
      $pageTitle = $addClassificationTitle;
      $contentPath = $addClassificationPath;
      break;

  case 'add-classification':
    $pageTitle = $addClassificationTitle;
    $contentPath = $addClassificationPath;

    $classificationName = filter_input(INPUT_POST, 'classificationName',FILTER_SANITIZE_STRING);

    // Check for missing data
    if (empty($classificationName)) {
      $message = '<p class="errorMessage">Please provide information for the classification Name.</p>';
      break;
    }

    // Send the data to the model
    $outcome = createClassification($classificationName);

    // Check and report the result
    if ($outcome === 1) {
      $pageTitle = $manageVehicleTitle;
      $contentPath = $manageVehiclePath;
      header('Location: ' . "/phpmotors/vehicles");
    } else {
      $message = "<p class='errorMessage'>Sorry, the creation of the new classification $classificationName failed. Please try again.</p>";
    }
    break;
 
  default:
    $pageTitle = $manageVehicleTitle;
    $contentPath = $manageVehiclePath;
    break;
}

include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/template-core.php';
