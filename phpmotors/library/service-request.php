<?php 

class ServiceRequest {

  public $requestId;
  public $clientId;           // foreign key to client table
  public $clientFirstName;    // read only from client table, no validation
  public $clientLastName;     // read only from client table, no validation
  public $invId;              // foreign key to inventory table
  public $invMake;            // read only from inventory table, no validation
  public $invModel;           // read only from inventory table, no validation
  public $requestDescription;
  public $requestStatus;
  public $requestSubmittedOn; // set by database, no validation
  public $requestScheduledOn; // may be null
  public $requestEstimate;      

  // public function __construct() {
  //   $this->requestId = intval($this->requestId);
  //   $this->clientId = intval($this->clientId);
  // }


  function isInvalid()
  {
    $submittedOn = date_parse($this->requestSubmittedOn);
    if (
      empty($this->clientId)
      || empty($this->invId)      
      || empty($this->requestDescription)
      || empty($this->requestStatus)
      || $this->requestEstimate < 0
      || ($this->requestEstimate != null && !checkdate($submittedOn['month'],$submittedOn['day'],$submittedOn['year']))
    ) {
      return true;
    }
    return false;
  }
}


?>