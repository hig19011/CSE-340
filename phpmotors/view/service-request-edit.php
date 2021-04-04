<?php 
if($_SESSION['loggedIn'] == false || $_SESSION['clientData']['clientLevel'] < 2){
  header('Location: /phpmotors/');
  exit;
}
?>
<section class="request-intro">
  <h1>Service Request</h1>
  <div>
    <a href="/phpmotors/service-request/?action=manage">Manage Service Requests</a>
  </div>
  <?php 
    displayGlobalMessage();
  ?>
  <p>Clients request for service on their vehicle.</p>
</section>

<div id="request-details">
  <section class="request-info">
    <h2>Service Request</h2><span></span>
    <span class="label">Client Name</span>
    <span class="details"><?=$serviceRequest->clientFirstName ?> <?=$serviceRequest->clientLastName?></span>
    <span class="label">Submitted On </span>
    <span class="details"><?=date_format(new DateTime($serviceRequest->requestSubmittedOn),"n/j/y")?></span>
    <span class="label">Vehicle</span>  
    <span class="details"><?=$serviceRequest->invMake?> <?=$serviceRequest->invModel?></span>
    <span class="label">Description </span>
    <span class="details"><?=$serviceRequest->requestDescription?></span>
    <span class="label">Status </span>
    <span class="details"><?=$serviceRequest->requestStatus?></span>
    <span class="label">Scheduled On </span>
    <span class="details"><?php
      if($serviceRequest->requestScheduledOn == "0000-00-00"){
        echo "";
      } else {
        echo date_format(new DateTime($serviceRequest->requestScheduledOn),"n/j/y");
      }?>
    </span>
    <span class="label">Estimate </span>
    <span class="details"><?php 
      if($serviceRequest->requestEstimate >=0){ //set to zero if negative to avoid looking like it saved
        echo "$".number_format(round($serviceRequest->requestEstimate,0)); 
      } else { 
        echo "$0.00"; 
      } ?></span>
  </section>


  <section class="request-notes">  
  <h2>Notes</h2><span></span>
    <?php 
      if(count($serviceRequestNotes) == 0) {
        echo "<p>No notes have been entered.";
      }
      
      foreach($serviceRequestNotes as $note) { ?>      
        <span class="label">Details</span>
        <span class="detail"><?=$note->requestNoteDetail?></span>
        <span class="label">Entered By</span>
        <span class="detail"><?=$note->clientFirstName ?> <?=$note->clientLastName?></span>
        <span class="label">Entered On</span>
        <span class="detail"><?=date_format(new DateTime($note->requestNoteEnteredOn),"n/j/y h:i A")?></span>
        <span class="label">Visibility</span>
        <span class="detail"><?php
          if($note->requestNoteShowCustomer){
            echo "Show Customer";
          }
          else {
            echo "Internal Only";
          }
        ?></span> 
        <a href="/phpmotors/service-request/?action=note-delete&requestNoteId=<?=$note->requestNoteId?>&requestId=<?=$note->requestId?>" class="last-detail">Delete Note</a>  
        <span></span>
    <?php } ?>
  </section>

  <form method="post" class="validatedForm">
  <hr class="mobile-only">
    <h3>Update Request</h3>
    <label for="requestStatus">Status</label>
    <?php echo $statusSelect; ?>
    
    <label for="requestScheduledOn">Scheduled On</label>
    <input type="date" id="requestScheduledOn" name="requestScheduledOn"
      <?php if(isset($serviceRequest->requestScheduledOn)){echo "value='$serviceRequest->requestScheduledOn'";}?> 
    />
    <label for="requestEstimate">Estimate</label>
    <input type="number" id="requestEstimate" name="requestEstimate" min="0"
      <?php if(isset($serviceRequest->requestEstimate)){echo "value='$serviceRequest->requestEstimate'";}?> 
    />

    <input type="submit" name="submit" id="updateBtn" value="Update Request">
    <input type="hidden" name="action" value="edit-apply">
    <input type="hidden" name="requestId" value="<?=$serviceRequest->requestId?>">
  </form>


  <form method="post" class="validatedForm">
  <hr class="mobile-only">
  <h3>Add a new Note</h3>
    <label for="requestNoteDetail">Enter Notes</label>
    <textarea id="requestNoteDetail" name="requestNoteDetail" rows="3" required><?php if(isset($serviceRequestNote->requestNoteDetail)){echo $serviceRequestNote->requestNoteDetail;}?></textarea>
  
    <input id="requestNoteShowCustomer" name="requestNoteShowCustomer" type="checkbox" value="showCustomer" class="side-details"
      <?php if(isset($serviceRequestNote->requestNoteShowCustomer) && $serviceRequestNote->requestNoteShowCustomer == 1) {
        echo "checked='$serviceRequestNote->requestNoteShowCustomer'";
      } ?>
    />
    <label for="requestNoteShowCustomer" class="side-label">Show Customer</label>

    <input type="submit" name="submit" id="addNoteBtn" value="Add Note">
    <input type="hidden" name="action" value="note-add">
    <input type="hidden" name="requestId" value="<?=$serviceRequest->requestId?>">
  </form>

</div>