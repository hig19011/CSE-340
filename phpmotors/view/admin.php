<?php 
if($_SESSION['loggedIn'] == false){
  header('Location: /phpmotors/');
  exit;
}
?>
<section class="clientInfo">
  <h1><?=$_SESSION['clientData']['clientFirstName']?></h1>
  <ul>
    <li><span>Identifier</span><span><?=$_SESSION['clientData']['clientId']?></span></li>    
    <li><span>First Name</span><span><?=$_SESSION['clientData']['clientFirstName']?></span></li>
    <li><span>Last Name</span><span><?=$_SESSION['clientData']['clientLastName']?></span></li>
    <li><span>Email Address</span><span><?=$_SESSION['clientData']['clientEmail']?></span></li>
    <li><span>User Level</span><span><?=$_SESSION['clientData']['clientLevel']?></span></li>
  </ul>
  <?php 
    if($_SESSION['clientData']['clientLevel'] > 1) {
      echo "<p><a href='/phpmotors/vehicles'>Vehicle Management</a></p>";
    }
  ?>
</section>