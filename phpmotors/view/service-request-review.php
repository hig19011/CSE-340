<?php 
if($_SESSION['loggedIn'] == false){
  header('Location: /phpmotors/');
  exit;
}
?>

<h1>Service Requests</h1>

<?php displayGlobalMessage(); ?>

<h2>Create a service request</h2>
<p>Click the following link to create a new service request</p>
<a href="/phpmotors/service-request/?action=create">Create Service Request</a>

<hr>

<h2>All Service Requests</h2>
<ul class="service-requests">
<?php foreach($serviceRequests as $request){ ?>
    <li>
      <h3>Request</h3><span></span>  
      <span class="label">Submitted On: </span><span class="detail"><?=date_format(new DateTime($request->requestSubmittedOn),"n/j/y")?></span>
      <span class="label">Vehicle: </span><span class="detail"><?=$request->invMake?> <?=$request->invModel?></span>
      <span class="label">Description: </span><span class="detail"><?=$request->requestDescription?></span>
      <span class="label">Status: </span><span class="detail"><?=$request->requestStatus?></span>
      <span class="label">Scheduled On: </span><span class="detail"><?php
        if($request->requestScheduledOn == NULL){
          echo "";
        } else {
          echo date_format(new DateTime($request->requestScheduledOn),"n/j/y");
        }?></span>
      <span class="label">Estimate: </span><span class="detail"><?php echo "$".number_format(round($request->requestEstimate,0));?></span>
      <h4>Notes</h4>
              
      <?php 
        $keys = array_keys(array_column($serviceRequestNotes, 'requestId'), $request->requestId);
        if(count($keys) == 0) {
          echo "<p>No notes have been entered.";
        }
        else {
          echo "<ul>";
          foreach($serviceRequestNotes as $note){ 
            if($note->requestId == $request->requestId) { ?>
            <li>                 
              <span class="label">Entered On</span>
              <span class="detail"><?=date_format(new DateTime($note->requestNoteEnteredOn),"n/j/y h:i A")?></span>
              <span class="label">Details</span>
              <span class="detail"><?=$note->requestNoteDetail?></span>
            </li>
          <?php } ?>          
        <?php } ?>      
      <?php echo "</ul>"; } ?>
    </li>
  <?php
  }
  ?>
</ul>
