<?php

// This is the accounts controller

// Initialize controller
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/library/controller_init.php';

// Get models for controller
require_once '../model/vehicles-model.php';
require_once '../library/vehicle.php';


// consolidate page titles and path to minimize magic strings
$addClassificationTitle = 'Add Car Classification';
$addClassificationPath = '/phpmotors/view/classification-add.php';
$addVehicleTitle = 'Add Vehicle';
$addVehiclePath = '/phpmotors/view/vehicle-add.php';
$manageVehicleTitle = 'Manage Vehicles';
$manageVehiclePath = '/phpmotors/view/vehicle-man.php';
$updateVehicleTitle = 'Update Vehicle';
$updateVehiclePath = '/phpmotors/view/vehicle-update.php';
$deleteVehicleTitle = 'Update Vehicle';
$deleteVehiclePath = '/phpmotors/view/vehicle-delete.php';


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}


switch ($action) {
  case 'add-vehicle-page':
    $pageTitle = $addVehicleTitle;
    $contentPath = $addVehiclePath;
    
    $carMakes = getExistingVehicleMakes();
    break;

  case 'add-vehicle':
    $pageTitle = $addVehicleTitle;
    $contentPath = $addVehiclePath;
    
    $vehicle = new inventory();
    $vehicle->classificationId = filter_input(INPUT_POST, 'classificationId',FILTER_SANITIZE_NUMBER_INT);
    $vehicle->invColor = filter_input(INPUT_POST, 'invColor',FILTER_SANITIZE_STRING);
    $vehicle->invDescription = filter_input(INPUT_POST, 'invDescription',FILTER_SANITIZE_STRING);
    $vehicle->invImage = filter_input(INPUT_POST, 'invImage',FILTER_SANITIZE_STRING);
    $vehicle->invThumbnail = filter_input(INPUT_POST, 'invThumbnail',FILTER_SANITIZE_STRING);
    $vehicle->invMake = filter_input(INPUT_POST, 'invMake',FILTER_SANITIZE_STRING);
    $vehicle->invModel = filter_input(INPUT_POST, 'invModel',FILTER_SANITIZE_STRING);
    $vehicle->invPrice = filter_input(INPUT_POST, 'invPrice',FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
    $vehicle->invStock = filter_input(INPUT_POST, 'invStock',FILTER_SANITIZE_NUMBER_INT);

    // Check for missing data
    if ($vehicle->isInvalid()) {
      $_SESSION['message'] = '<p class="errorMessage">Please enter information for all fields.</p>';
      $carMakes = getExistingVehicleMakes();
      break;
    }    

    // Send the data to the model
    $outcome = createVehicle($vehicle);

    // Check and report the result
    if ($outcome === 1) {
      $_SESSION['message'] = "<p class='successMessage'>New vehicle $vehicle->invColor $vehicle->invMake $vehicle->invModel added.</p>";
    } else {
      $_SESSION['message'] = "<p class='errorMessage'>Sorry, the creation of the new vehicle failed. Please try again.</p>";
    }

    //pull in new vehicle makes;
    $carMakes = getExistingVehicleMakes();
    break;

  case 'update-vehicle':    
    $vehicle = new inventory();
    $vehicle->invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
    $vehicle->classificationId = filter_input(INPUT_POST, 'classificationId',FILTER_SANITIZE_NUMBER_INT);
    $vehicle->invColor = filter_input(INPUT_POST, 'invColor',FILTER_SANITIZE_STRING);
    $vehicle->invDescription = filter_input(INPUT_POST, 'invDescription',FILTER_SANITIZE_STRING);
    $vehicle->invImage = filter_input(INPUT_POST, 'invImage',FILTER_SANITIZE_STRING);
    $vehicle->invThumbnail = filter_input(INPUT_POST, 'invThumbnail',FILTER_SANITIZE_STRING);
    $vehicle->invMake = filter_input(INPUT_POST, 'invMake',FILTER_SANITIZE_STRING);
    $vehicle->invModel = filter_input(INPUT_POST, 'invModel',FILTER_SANITIZE_STRING);
    $vehicle->invPrice = filter_input(INPUT_POST, 'invPrice',FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
    $vehicle->invStock = filter_input(INPUT_POST, 'invStock',FILTER_SANITIZE_NUMBER_INT);

   

    // Check for missing data
    if ($vehicle->isInvalid()) {
      $_SESSION['message'] = '<p class="errorMessage">Please enter information for all fields.</p>';
      $carMakes = getExistingVehicleMakes();
      if(isset($vehicle->invMake) && isset($vehicle->invModel)){ 
        $pageTitle = "Modify $vehicle->invMake $vehicle->invModel";
      }
      // elseif(isset($invMake) && isset($invModel)) { 
      //   $pageTitle = "Modify $invMake $invModel"; 
      // }    
      $contentPath = $updateVehiclePath;
      break;
    }    
    
    // Send the data to the model
    $updateResult = updateVehicle($vehicle);

    // Check and report the result
    if ($updateResult === 1) {
      $_SESSION['message'] = "<p class='noticeMessage'>Congratulations, the $vehicle->invMake $vehicle->invModel was successfully updated.</p>";

      header('location: /phpmotors/vehicles/');
      exit;
    } else {
      $_SESSION['message'] = "<p class='errorMessage'>Sorry, the modification of the vehicle failed. Please try again.</p>";
    }

    if(isset($vehicle->invMake) && isset($vehicle->invModel)){ 
      $pageTitle = "Modify $vehicle->invMake $vehicle->invModel";
    }
    // elseif(isset($invMake) && isset($invModel)) { 
    //   $pageTitle = "Modify $invMake $invModel"; 
    // }    
    $contentPath = $updateVehiclePath;

    //pull in new vehicle makes;
    $carMakes = getExistingVehicleMakes();
    break;
  case 'delete-vehicle':    
    $vehicle = new inventory();
    $vehicle->invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
    $vehicle->invMake = filter_input(INPUT_POST, 'invMake',FILTER_SANITIZE_STRING);
    $vehicle->invModel = filter_input(INPUT_POST, 'invModel',FILTER_SANITIZE_STRING);
    $vehicle->invDescription = filter_input(INPUT_POST, 'invDescription',FILTER_SANITIZE_STRING);

    // Send the data to the model
    $deleteResult = deleteVehicle($vehicle->invId);

    // Check and report the result
    if ($deleteResult === 1) {
      $_SESSION['message'] = "<p class='noticeMessage'>Congratulations, the $vehicle->invMake $vehicle->invModel was successfully deleted.</p>";
      header('location: /phpmotors/vehicles/');
      exit;
    } else {
      $_SESSION['message'] = "<p class='errorMessage'>Error: the deletion of $vehicle->invMake $vehicle->invModel failed.</p>";
    }

    if(isset($vehicle->invMake ) && isset($vehicle->invModel)){ 
      $pageTitle = "Delete $vehicle->invMake  $vehicle->invModel";
    }  
    $contentPath = $deleteVehiclePath;

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
      $_SESSION['message'] = '<p class="errorMessage">Please provide information for the classification Name.</p>';
      break;
    }

    // Send the data to the model
    $outcome = createClassification($classificationName);

    // Check and report the result
    if ($outcome === 1) {
      $pageTitle = $manageVehicleTitle;
      $contentPath = $manageVehiclePath;
      header('Location: ' . "/phpmotors/vehicles");
      exit;
      
    } else {
      $_SESSION['message'] = "<p class='errorMessage'>Sorry, the creation of the new classification $classificationName failed. Please try again.</p>";
    }
    break;
    
 

    /* * ********************************** 
  * Get vehicles by classificationId 
  * Used for starting Update & Delete process 
  * ********************************** */ 
  case 'getInventoryItems': 
    // Get the classificationId 
    $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
    // Fetch the vehicles by classificationId from the DB 
    $inventoryArray = getInventoryByClassification($classificationId); 
    // Convert the array to a JSON object and send it back 
    echo json_encode($inventoryArray); 
    exit;
    break;    
  
  case 'mod':
    $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $vehicle = getInvItemInfo($invId);
    
    if(!$vehicle){
      $_SESSION['message'] = '<p class="noticeMessage">Sorry, no vehicle information could be found.</p>';
    }

    if(isset($vehicle->invMake) && isset($vehicle->invModel)){ 
      $pageTitle = "Modify $vehicle->invMake $vehicle->invModel";
    }
    
    $contentPath = $updateVehiclePath;
    break;

  case 'del':
    $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $vehicle = getInvItemInfo($invId);
    if(!$vehicle){
      $_SESSION['message'] = '<p class="noticeMessage">Sorry, no vehicle information could be found.</p>';
    }

    if(isset($vehicle->invMake) && isset($vehicle->invModel)){ 
      $pageTitle = "Delete $vehicle->invMake $vehicle->invModel";
    }
    
    $contentPath = $deleteVehiclePath;
    break;

  default:
    $pageTitle = $manageVehicleTitle;
    $contentPath = $manageVehiclePath;

    $classificationList = buildClassificationList($classifications);
    break;
}

include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/template-core.php';
