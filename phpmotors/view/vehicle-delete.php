<?php 
if($_SESSION['loggedIn'] == false || $_SESSION['clientData']['clientLevel'] < 2){
  header('Location: /phpmotors/');
  exit;
}
?>

<h1><?php if(isset($vehicle->invMake) && isset($vehicle->invModel)){ 
	echo "Delete $vehicle->invMake $vehicle->invModel";} ?> 
</h1>
<?php
  displayGlobalMessage();
?>

<form class="forms" method="post">
<label for="invMake">Make</label>
  <input id="invMake" name="invMake" type="text" 
    <?php if(isset($vehicle->invMake)){echo "value='$vehicle->invMake'";} ?>
  readonly>
  <label for="invModel">Model</label>
  <input id="invModel" name="invModel" type="text" 
    <?php if(isset($vehicle->invModel)){echo "value='$vehicle->invModel'";} ?>
  readonly>
  <label for="invDescription">Description</label>
  <textarea id="invDescription" name="invDescription" rows="3" readonly><?php 
    if(isset($vehicle->invDescription)){echo $vehicle->invDescription;} ?></textarea>  
  <input type="submit" value="Delete Vehicle">
  <input type="hidden" name="action" value="delete-vehicle">
  <input type="hidden" name="invId" value="<?php if(isset($vehicle->invId)){echo $vehicle->invId;}?>">
</form>