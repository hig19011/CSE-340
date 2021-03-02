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


<?php
  displayGlobalMessage(); 
  if (isset($classificationList)) { 
    echo '<h2>Vehicles By Classification</h2>'; 
    echo '<p>Choose a classification to see those vehicles</p>'; 
    echo $classificationList; 
  }
?>
<noscript>
<p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
</noscript>
<table id="inventoryDisplay"></table>

<script src="/phpmotors/js/inventory.js"></script>