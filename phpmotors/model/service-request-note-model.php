<?php

/* 
 *  This model is used for handling Service Request Notes
 */

require_once '../library/service-request-note.php';

// Create a new Service Request Note
function createServiceRequestNote($note)
{
  $db = phpmotorsConnect();
  $sql = 'INSERT INTO servicerequestnote(requestId, requestNoteDetail, requestNoteShowCustomer, clientId)
      VALUES (:requestId, :requestNoteDetail, :requestNoteShowCustomer, :clientId)';
  $stmt = $db->prepare($sql);
 
  $stmt->bindValue(':requestId', $note->requestId, PDO::PARAM_INT);
  $stmt->bindValue(':requestNoteDetail', $note->requestNoteDetail, PDO::PARAM_STR);
  $stmt->bindValue(':requestNoteShowCustomer', $note->requestNoteShowCustomer, PDO::PARAM_INT);
  $stmt->bindValue(':clientId', $note->clientId, PDO::PARAM_INT);
  
  $stmt->execute();
  
  $rowsChanged = $stmt->rowCount();
  
  $stmt->closeCursor();
  
  // Return the indication of success (rows changed)
  return $rowsChanged;
}

// Update an existing Service Request Note
function updateServiceRequestNote($note)
{
  $db = phpmotorsConnect();
  $sql = 'UPDATE servicerequestnote 
          SET requestId = :requestId, 
              requestNoteDetail = :requestNoteDetail,
              requestNoteShowCustomer = :requestNoteShowCustomer,
              clientId = :clientId                            
          WHERE requestNoteId = :requestNoteId';
  
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':requestNoteId', $note->requestNoteId, PDO::PARAM_INT);
  $stmt->bindValue(':requestId', $note->requestId, PDO::PARAM_INT);
  $stmt->bindValue(':requestNoteDetail', $note->requestNoteDetail, PDO::PARAM_STR);
  $stmt->bindValue(':requestNoteShowCustomer', $note->requestNoteShowCustomer, PDO::PARAM_INT);
  $stmt->bindValue(':clientId', $note->clientId, PDO::PARAM_INT);
  
  $stmt->execute();
  
  $rowsChanged = $stmt->rowCount();
  
  $stmt->closeCursor();
  
  return $rowsChanged;
}

// remove a service request note
function deleteServiceRequestNote($requestNoteId) {
  $db = phpmotorsConnect();
  $sql = 'DELETE FROM serviceRequestNote WHERE requestNoteId = :requestNoteId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':requestNoteId', $requestNoteId, PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// get all service request notes by requestId
function getServiceRequestNotesByRequest($requestId, $onlyShowCustomer){
  $db = phpmotorsConnect();
  $sql = 'SELECT r.requestNoteId, r.requestId, r.requestNoteDetail, 
          r.requestNoteShowCustomer, r.requestNoteEnteredOn,
          r.clientId, c.clientFirstName, c.clientLastName              
        FROM servicerequestNote r 
          INNER JOIN clients c on r.clientId = c.clientId             
        WHERE r.requestId = :requestId';    
  if($onlyShowCustomer) {
    $sql .= " AND r.requestNoteShowCustomer = :requestNoteShowCustomer";
  }

  $stmt = $db->prepare($sql);
  $stmt->bindValue(':requestId', $requestId, PDO::PARAM_INT);
  if($onlyShowCustomer) {
    $stmt->bindValue(':requestNoteShowCustomer', $onlyShowCustomer, PDO::PARAM_INT);
  }
  $stmt->execute();

  //$stmt->setFetchMode(PDO::FETCH_CLASS, 'ServiceRequest');
  $serviceRequestNote = $stmt->fetchAll(PDO::FETCH_CLASS, 'ServiceRequest');

  $stmt->closeCursor();
  return $serviceRequestNote;
}

function getServiceRequestNotesByClient($clientId){
  $db = phpmotorsConnect();
  $sql = 'SELECT n.requestNoteId, n.requestId, n.requestNoteDetail, 
          n.requestNoteShowCustomer, n.requestNoteEnteredOn,
          n.clientId, c.clientFirstName, c.clientLastName              
        FROM serviceRequestNote n
          INNER JOIN clients c on n.clientId = c.clientId     
          INNER JOIN serviceRequest r on r.requestId = n.requestId    
        WHERE r.clientId = :clientId
          AND n.requestNoteShowCustomer = :requestNoteShowCustomer
        order by n.requestId, n.requestNoteId';    
  
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT); 
  $stmt->bindValue(':requestNoteShowCustomer', true, PDO::PARAM_INT); 
  $stmt->execute();

  //$stmt->setFetchMode(PDO::FETCH_CLASS, 'ServiceRequest');
  $serviceRequestNote = $stmt->fetchAll(PDO::FETCH_CLASS, 'ServiceRequestNote');

  $stmt->closeCursor();
  return $serviceRequestNote;
}
?>