<?php

/* 
 *  This model is used for handling Service Requests
 */

require_once '../library/service-request.php';

// Create a new Service Request
function createServiceRequest($serviceRequest)
{
  $db = phpmotorsConnect();
  $sql = 'INSERT INTO servicerequest(clientId, invId, requestDescription, requestStatus, requestScheduledOn, requestEstimate)
      VALUES (:clientId, :invId, :requestDescription, :requestStatus, :requestScheduledOn, :requestEstimate)';
  
  $stmt = $db->prepare($sql);
  
  $stmt->bindValue(':clientId', $serviceRequest->clientId, PDO::PARAM_INT);
  $stmt->bindValue(':invId', $serviceRequest->invId, PDO::PARAM_INT);
  $stmt->bindValue(':requestDescription', $serviceRequest->requestDescription, PDO::PARAM_STR);
  $stmt->bindValue(':requestStatus', $serviceRequest->requestStatus, PDO::PARAM_STR);
  $stmt->bindValue(':requestScheduledOn', $serviceRequest->requestScheduledOn, PDO::PARAM_STR);
  $stmt->bindValue(':requestEstimate', strval($serviceRequest->requestEstimate), PDO::PARAM_STR);
  
  $stmt->execute();
  
  $rowsChanged = $stmt->rowCount();
  
  $stmt->closeCursor();
 
  return $rowsChanged;
}

// Update and existing Service Request
function updateServiceRequest($serviceRequest)
{
  $db = phpmotorsConnect();
  $sql = 'UPDATE servicerequest 
          SET clientId = :clientId,
              invId = :invId, 
              requestDescription = :requestDescription, 
              requestStatus = :requestStatus, 
              requestScheduledOn = :requestScheduledOn,
              requestEstimate = :requestEstimate 
          WHERE requestId = :requestId';
  $stmt = $db->prepare($sql);
 
  $stmt->bindValue(':requestId', $serviceRequest->requestId, PDO::PARAM_INT);
  $stmt->bindValue(':clientId', $serviceRequest->clientId, PDO::PARAM_INT);
  $stmt->bindValue(':invId', $serviceRequest->invId, PDO::PARAM_INT);  
  $stmt->bindValue(':requestDescription', $serviceRequest->requestDescription, PDO::PARAM_STR);
  $stmt->bindValue(':requestStatus', $serviceRequest->requestStatus, PDO::PARAM_STR);
  $stmt->bindValue(':requestScheduledOn', $serviceRequest->requestScheduledOn, PDO::PARAM_STR);
  $stmt->bindValue(':requestEstimate', strval($serviceRequest->requestEstimate), PDO::PARAM_STR);  

  $stmt->execute();
 
  $rowsChanged = $stmt->rowCount();
  
  $stmt->closeCursor();
  
  return $rowsChanged;
}

// remove a service request
function deleteServiceRequest($requestId) {
  $db = phpmotorsConnect();
  $sql = 'DELETE FROM servicerequest WHERE requestId = :requestId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':requestId', $requestId, PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
 }
 
 // get a single service request by requestId
 function getServiceRequestDetails($requestId){
  $db = phpmotorsConnect();
  $sql = 'SELECT r.requestId, c.clientId, c.clientFirstName, c.clientLastName, 
            r.invId, i.invMake, i.invModel,
            r.requestDescription, r.requestStatus, r.requestSubmittedOn, r.requestScheduledOn, r.requestEstimate
          FROM servicerequest r 
            INNER JOIN clients c on r.clientId = c.clientId
            INNER JOIN inventory i on r.invId = i.invId
          WHERE r.requestId = :requestId';          

  $stmt = $db->prepare($sql);
  $stmt->bindValue(':requestId', $requestId, PDO::PARAM_INT);
  $stmt->execute();
  
  $stmt->setFetchMode(PDO::FETCH_CLASS, 'ServiceRequest');
  $serviceRequest = $stmt->fetch();
  
  $stmt->closeCursor();
  return $serviceRequest;
 }

  // get all service requests by client Id
  function getServiceRequestsByClient($clientId){
    $db = phpmotorsConnect();
    $sql = 'SELECT r.requestId, r.clientId, c.clientFirstName, c.clientLastName, 
              r.invId, i.invMake, i.invModel, 
              r.requestDescription, r.requestStatus, r.requestSubmittedOn, r.requestScheduledOn, r.requestEstimate
            FROM servicerequest r 
              INNER JOIN clients c on r.clientId = c.clientId
              INNER JOIN inventory i on r.invId = i.invId
            WHERE r.clientId = :clientId
            order by r.requestSubmittedOn, r.requestId';          
  
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();    
    
    $serviceRequest = $stmt->fetchAll(PDO::FETCH_CLASS, 'ServiceRequest');
    
    $stmt->closeCursor();
    return $serviceRequest;
   }

   // get all service requests by that 
  function getOpenServiceRequests(){
    $requestStatusCancelled = 'Cancelled';
    $requestStatusServiced = 'Serviced';

    $db = phpmotorsConnect();
    $sql = 'SELECT r.requestId, r.clientId, c.clientFirstName, c.clientLastName, 
              r.invId, i.invMake, i.invModel, 
              r.requestDescription, r.requestStatus, r.requestSubmittedOn, r.requestScheduledOn, r.requestEstimate
            FROM servicerequest r 
              INNER JOIN clients c on r.clientId = c.clientId
              INNER JOIN inventory i on r.invId = i.invId
            WHERE r.requestStatus <> :requestStatusCancelled
              and r.requestStatus <> :requestStatusServiced
            order by r.requestSubmittedOn, r.requestId';          
  
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':requestStatusCancelled', $requestStatusCancelled, PDO::PARAM_STR);
    $stmt->bindValue(':requestStatusServiced', $requestStatusServiced, PDO::PARAM_STR);
    $stmt->execute();
    
    $serviceRequest = $stmt->fetchAll(PDO::FETCH_CLASS, 'ServiceRequest');
    
    $stmt->closeCursor();
    return $serviceRequest;
   }


 ?>