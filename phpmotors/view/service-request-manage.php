<?php 
if($_SESSION['loggedIn'] == false || $_SESSION['clientData']['clientLevel'] < 2){
  header('Location: /phpmotors/');
  exit;
}
?>

<h1>Service Requests</h1>

<?php displayGlobalMessage(); ?>

<ul class="service-requests">
<?php foreach($serviceRequests as $request){ ?>
    <li>     
      <span class="label">Submitted On: </span><span class="detail"><?=date_format(new DateTime($request->requestSubmittedOn),"n/j/y")?></span>
      <span class="label">Vehicle: </span><span class="detail"><?=$request->invMake?> <?=$request->invModel?></span>
      <span class="label">Description: </span><span class="detail"><?=$request->requestDescription?></span>
      <span class="label">Status: </span><span class="detail"><?=$request->requestStatus?></span>
      <span class="label">Scheduled On: </span><span class="detail"><?php
        if($request->requestScheduledOn == "0000-00-00"){
          echo "";
        } else {
          echo date_format(new DateTime($request->requestScheduledOn),"n/j/y");
        }?>
      </span>
      <span class="label">Estimate: </span><span class="detail"><?=$request->requestEstimate?></span>
      <a href="/phpmotors/service-request/?action=edit&requestId=<?=$request->requestId?>">Edit Request</a>     
    </li>
  <?php
  }
  ?>
</ul>
