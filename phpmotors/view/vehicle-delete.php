<?php 
if($_SESSION['loggedIn'] == false || $_SESSION['clientData']['clientLevel'] < 2){
  header('Location: /phpmotors/');
  exit;
}
?>

<h1><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
	echo "Delete $invInfo[invMake] $invInfo[invModel]";} 
elseif(isset($invMake) && isset($invModel)) { 
	echo "Delete$invMake $invModel"; }?></h1>

<?php
  displayGlobalMessage();
?>

<form class="forms" method="post">
<label for="invMake">Model</label>
  <input id="invMake" name="invMake" type="text" 
    <?php if(isset($vehicle->invMake)){echo "value='$vehicle->invModel'";} 
      elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; } ?>
  readonly>
  <label for="invModel">Model</label>
  <input id="invModel" name="invModel" type="text" 
    <?php if(isset($vehicle->invModel)){echo "value='$vehicle->invModel'";} 
      elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; } ?>
  readonly>
  <label for="invDescription">Description</label>
  <textarea id="invDescription" name="invDescription" rows="3" readonly><?php 
    if(isset($vehicle->invDescription)){echo $vehicle->invDescription;}
    elseif(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; } 
    ?></textarea>  
  <input type="submit" value="Delete Vehicle">
  <input type="hidden" name="action" value="delete-vehicle">
  <input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])){echo $invInfo['invId'];}?>">
</form>