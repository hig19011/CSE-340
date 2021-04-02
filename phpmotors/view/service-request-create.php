<?php 
if($_SESSION['loggedIn'] == false){
  header('Location: /phpmotors/');
  exit;
}
?>

<h1>New Service Request</h1>

<p>Please fill out the following form to request service on your vehicle.  Note we only service vehicles that we sell.</p>

<h2>Service Request</h2>
<?php 
  displayGlobalMessage();
?>
<form method="post" class="validatedForm">
  <label for="clientFirstName">First Name</label>
  <input type="text" id="clientFirstName" name="clientFirstName" readonly
    <?php if(isset($serviceRequest->clientFirstName)){echo "value='$serviceRequest->clientFirstName'";}  ?>
    required>
  <label for="clientLastName">Last Name</label>
  <input type="text" id="clientLastName" name="clientLastName" readonly
    <?php if(isset($serviceRequest->clientLastName)){echo "value='$serviceRequest->clientLastName'";}  ?>
    required>
  <label for="invId">Vehicle</label>
	<?php echo $prodSelect; ?>
  <label for="requestDescription">Describe the concern with the vehicle.</label>
  <textarea id="requestDescription" name="requestDescription" rows="3" required><?php if(isset($serviceRequest->requestDescription)){echo $serviceRequest->requestDescription;}?></textarea>
  <label for="requestStatus">Status</label>
  <input type="text" id="requestStatus" name="requestStatus" readonly
    <?php if(isset($serviceRequest->requestStatus)){echo "value='$serviceRequest->requestStatus'";}  ?>
    required>
  <input type="submit" name="submit" id="addBtn" value="Submit Service Request">
  <input type="hidden" name="action" value="submit">
</form>