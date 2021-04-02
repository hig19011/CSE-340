<?php 

class ServiceRequestNote {

  public $requestNoteId;
  public $requestId;         // foreign key to ServiceRequest table
  public $requestNoteDetail;
  public $requestNoteShowCustomer;
  public $clientId;          // foreign key to Client table - represents employee who created the note
  public $clientFirstName;   // read only from client table, no validation
  public $clientSecondName;  // read only from client table, no validation
  public $requestNoteEnteredOn;  //uses database default, no validation

  function isInvalid()
  {
    if (
      empty($this->clientId)
      || empty($this->requestId)      
      || empty($this->requestNoteDetail)
      || $this->requestNoteShowCustomer < 0
      || $this->requestNoteShowCustomer > 1
     ) {
      return true;
    }
    return false;
  }
}


?>