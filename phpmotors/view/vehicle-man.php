<?php 
if($_SESSION['loggedIn'] == false || $_SESSION['clientData']['clientLevel'] < 2){
  header('Location: /phpmotors/');
  exit;
}
?>

<h1>Vehicle Management</h1>

<div>
  <a href="/phpmotors/vehicles/?action=add-classification-page">Add Classification</a>
</div>
<div>
  <a href="/phpmotors/vehicles/?action=add-vehicle-page">Add Vehicle</a>
</div>