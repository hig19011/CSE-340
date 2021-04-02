<?php

// This is the accounts controller

// Initialize controller
require_once $_SERVER['DOCUMENT_ROOT'].'/phpmotors/library/controller_init.php';

// Get models for controller

require_once '../model/service-request-model.php';
require_once '../model/service-request-note-model.php';
require_once '../model/vehicles-model.php';
require_once '../library/service-request.php';


// consolidate page titles and path to minimize magic strings
$createRequestTitle = 'Create Service Request';
$createRequestPath = '/phpmotors/view/service-request-create.php';
$reviewRequestsTitle = 'Review Service Requests';
$reviewRequestsPath = '/phpmotors/view/service-request-review.php';
$editRequestTitle = 'Edit Service Request';
$editRequestPath = '/phpmotors/view/service-request-edit.php';
$manageRequestsTitle = 'Manage Service Requests';
$manageRequestsPath = '/phpmotors/view/service-request-manage.php';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
  case 'create':
    $pageTitle = $createRequestTitle;
    $contentPath = $createRequestPath;
    
    $serviceRequest = new ServiceRequest();

    
    $serviceRequest->clientFirstName = $_SESSION['clientData']['clientFirstName'];
    $serviceRequest->clientLastName = $_SESSION['clientData']['clientLastName'];

    // Get vehicles information from database
    $vehicles = getVehicles();
    // Build a select list of vehicle information for the view
    $prodSelect = buildVehiclesSelect($vehicles);

    $serviceRequest->requestStatus = "Creating";

    break;

  case 'submit':

    $serviceRequest = new ServiceRequest();
    $serviceRequest->clientId = $_SESSION['clientData']['clientId'];
    $serviceRequest->clientFirstName = $_SESSION['clientData']['clientFirstName'];
    $serviceRequest->clientLastName = $_SESSION['clientData']['clientLastName'];
      
    $serviceRequest->requestDescription = filter_input(INPUT_POST, 'requestDescription',FILTER_SANITIZE_STRING);
    $serviceRequest->requestStatus = filter_input(INPUT_POST, 'requestStatus',FILTER_SANITIZE_STRING);
    
    $serviceRequest->invId = filter_input(INPUT_POST, 'invId',FILTER_SANITIZE_NUMBER_INT);
    $serviceRequest->requestEstimate = 0;
    $serviceRequest->requestStatus = "Submitted";
    
    // Check for missing data
    if ($serviceRequest->isInvalid()) {
      $_SESSION['message'] = '<p class="errorMessage">Please enter information for all fields.</p>';
      
      $serviceRequest->requestStatus = "Creating";

      $vehicles = getVehicles();
      $prodSelect = buildVehiclesSelect($vehicles, $serviceRequest->invId);

      $pageTitle = $createRequestTitle;
      $contentPath = $createRequestPath;

      break;
    }    
    
    // Send the data to the model
    $createResult = createServiceRequest($serviceRequest);   

    // Check and report the result
    if ($createResult === 1) {
      $vehicle = getInvItemInfo($serviceRequest->invId);
      $_SESSION['message'] = "<p class='successMessage'>Your request for service on the $vehicle->invMake $vehicle->invModel was successfully created.</p>";

      header('location: /phpmotors/service-request/?action=review');
      exit;
    } else {
      $_SESSION['message'] = "<p class='errorMessage'>Sorry, the service request failed. Please try again.</p>";
    }    

    $pageTitle = $submitRequestTitle;
    $contentPath = $submitRequestPath;
    
    break;

  case 'review':
    $pageTitle = $reviewRequestsTitle;
    $contentPath = $reviewRequestsPath;

    $clientId = $_SESSION['clientData']['clientId'];
    $serviceRequests = getServiceRequestsByClient($clientId);
    $serviceRequestNotes = getServiceRequestNotesByClient($clientId);
    break;

  case 'manage':
    $pageTitle = $manageRequestsTitle;
    $contentPath = $manageRequestsPath;
    
    $serviceRequests = getOpenServiceRequests();

    break;
  
  case 'edit':    
    $pageTitle = $editRequestTitle;
    $contentPath = $editRequestPath;

    $requestId = filter_input(INPUT_GET, 'requestId',FILTER_SANITIZE_NUMBER_INT);

    $serviceRequest = getServiceRequestDetails($requestId);
    $serviceRequestNotes = getServiceRequestNotesByRequest($requestId, false);
    $vehicles = getVehicles();
    $prodSelect = buildVehiclesSelect($vehicles, $serviceRequest->invId);
    $statusSelect = buildRequestStatusSelect($serviceRequest->requestStatus);    
    
    break; 

  case 'edit-apply':
    $pageTitle = $editRequestTitle;
    $contentPath = $editRequestPath;

    $requestId = filter_input(INPUT_GET, 'requestId',FILTER_SANITIZE_NUMBER_INT);
    $serviceRequest = getServiceRequestDetails($requestId);

    $serviceRequest->requestStatus = filter_input(INPUT_POST, 'requestStatus',FILTER_SANITIZE_STRING);
    $serviceRequest->requestScheduledOn = filter_input(INPUT_POST, 'requestScheduledOn',FILTER_SANITIZE_STRING);
    $serviceRequest->requestEstimate = filter_input(INPUT_POST, 'requestEstimate',FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    if ($serviceRequest->isInvalid()) {
      $_SESSION['message'] = '<p class="errorMessage">Please enter information for all fields.</p>';
      $serviceRequestNotes = getServiceRequestNotesByRequest($requestId, false);
      $vehicles = getVehicles();
      $prodSelect = buildVehiclesSelect($vehicles, $serviceRequest->invId);
      $statusSelect = buildRequestStatusSelect($serviceRequest->requestStatus);
      break;
    }

    // Send the data to the model
    $updateResult = updateServiceRequest($serviceRequest);   

    // Check and report the result
    if ($updateResult === 1) {      
      $_SESSION['message'] = "<p class='successMessage'>Your update to the service request was successful.</p>";     
      header('location: /phpmotors/service-request/?action=edit&requestId='.$requestId);
      var_dump($_SESSION['message']);
      exit;
    } 
    
    $_SESSION['message'] = "<p class='errorMessage'>Sorry, the service request failed to update. Please try again.</p>";
        
    $serviceRequest = getServiceRequestDetails($requestId);    
    $serviceRequestNotes = getServiceRequestNotesByRequest($requestId, false);
    $vehicles = getVehicles();
    $prodSelect = buildVehiclesSelect($vehicles, $serviceRequest->invId);
    $statusSelect = buildRequestStatusSelect($serviceRequest->requestStatus);
    
    break;

  case 'note-add':
    $pageTitle = $editRequestTitle;
    $contentPath = $editRequestPath;

    $requestId = filter_input(INPUT_POST, 'requestId',FILTER_SANITIZE_NUMBER_INT);

    $serviceRequestNote = new ServiceRequestNote();
    $serviceRequestNote->clientId = $_SESSION['clientData']['clientId'];
    $serviceRequestNote->requestId = $requestId;
    $serviceRequestNote->requestNoteDetail =  filter_input(INPUT_POST, 'requestNoteDetail',FILTER_SANITIZE_STRING);
    $serviceRequestNote->requestNoteShowCustomer = filter_input(INPUT_POST, 'requestNoteShowCustomer',FILTER_VALIDATE_INT);
    $serviceRequestNote->requestNoteShowCustomer = isset($serviceRequestNote->requestNoteShowCustomer) ? 1 : 0;

    if ($serviceRequestNote->isInvalid()) {
      $_SESSION['message'] = '<p class="errorMessage">Please enter information for all fields.</p>';
      $serviceRequest = getServiceRequestDetails($requestId);
      $serviceRequestNotes = getServiceRequestNotesByRequest($requestId, false);
      $vehicles = getVehicles();
      $prodSelect = buildVehiclesSelect($vehicles, $serviceRequest->invId);
      $statusSelect = buildRequestStatusSelect($serviceRequest->requestStatus);
      break;
    }

    // Send the data to the model
    $addResult = createServiceRequestNote($serviceRequestNote);   

    // Check and report the result
    if ($addResult === 1) {      
      $_SESSION['message'] = "<p class='successMessage'>The note was successfully added to the service request.</p>";     
      header('location: /phpmotors/service-request/?action=edit&requestId='.$requestId);
      exit;
    }
    
    $_SESSION['message'] = "<p class='errorMessage'>Sorry, the note was NOT added to the service request. Please try again.</p>";
    
    $serviceRequest = getServiceRequestDetails($requestId);
    $serviceRequestNotes = getServiceRequestNotesByRequest($requestId, false);
    $vehicles = getVehicles();
    $prodSelect = buildVehiclesSelect($vehicles, $serviceRequest->invId);
    $statusSelect = buildRequestStatusSelect($serviceRequest->requestStatus);
    $serviceRequestNote = new ServiceRequestNote();
    break;

  case 'note-delete':
    $requestId = filter_input(INPUT_GET, 'requestId',FILTER_SANITIZE_NUMBER_INT);
    $requestNoteId = filter_input(INPUT_GET, 'requestNoteId',FILTER_SANITIZE_NUMBER_INT);

    $remove = deleteServiceRequestNote($requestNoteId);    
    if ($remove) {
      $_SESSION['message'] = "<p class='successMessage'>Note was successfully deleted.</p>";
    } else {
      $_SESSION['message'] = "<p class='errorMessage'>Note was NOT deleted.</p>";
    }        

    // Redirect to this controller to prevent second note from being created 
    // in the case that the customer hits the refresh button.
    header('location: /phpmotors/service-request/?action=edit&requestId='.$requestId);
    exit;

  default:  
    $pageTitle = $manageRequestsTitle;
    $contentPath = $manageRequestsPath;

    $requestId = filter_input(INPUT_POST, 'requestId',FILTER_SANITIZE_NUMBER_INT);

    break;
}

include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/template-core.php';
