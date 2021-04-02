<?php 
if($_SESSION['loggedIn'] == false){
  header('Location: /phpmotors/');
  exit;
}
?>
<section class="clientInfo">
  <h1><?=$_SESSION['clientData']['clientFirstName']?></h1>
  <?php 
    displayGlobalMessage();

    if($_SESSION['loggedIn']){
      echo "<p>You are logged in.</p>";
    }
?>
  <ul>
    <li><span>Identifier</span><span><?=$_SESSION['clientData']['clientId']?></span></li>    
    <li><span>First Name</span><span><?=$_SESSION['clientData']['clientFirstName']?></span></li>
    <li><span>Last Name</span><span><?=$_SESSION['clientData']['clientLastName']?></span></li>
    <li><span>Email Address</span><span><?=$_SESSION['clientData']['clientEmail']?></span></li>   
  </ul>
 
  <h2>Account Management</h2>
  <p>Use this link to update account information.</p>
  <div><a href="/phpmotors/accounts/?action=update-client-page">Update Account Information</a></div>
  <h2>Service Requests</h2>
  <p>Use this link to create and review requests for service on your vehicle.</p>
  <?php    
      echo "<div><a href='/phpmotors/service-request/?action=review'>Service Requests</a></div>";  
  ?>

  <?php 
    if($_SESSION['clientData']['clientLevel'] > 1) { ?>

  <h2>Service Request Management</h2>
  <p>Use this link to manage clients requests for service.</p>
  <?php    
      echo "<div><a href='/phpmotors/service-request?action=manage'>Service Request Management</a></div>";
    }
  ?>

  <?php 
    if($_SESSION['clientData']['clientLevel'] > 1) { ?>

  <h2>Vehicle Management</h2>
  <p>Use this link to manage the inventory.</p>
  <?php    
      echo "<div><a href='/phpmotors/vehicles'>Vehicle Management</a></div>";
    }
  ?>
</section>