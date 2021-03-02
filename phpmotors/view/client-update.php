<?php 
  if($_SESSION['clientData']['clientLevel'] <= 1){
    header('Location: /phpmotors/');
    exit;
  }  
?>

<h1>Update Account Information</h1>

<?php 
  displayGlobalMessage();
?>

<h2>Update Account Info</h2>
<form method="post" class="validatedForm">
  <label for="clientFirstName">First Name</label>
  <input type="text" id="clientFirstName" name="clientFirstName" 
    <?php if(isset($clientFirstName)){echo "value='$clientFirstName'";}  ?>
    required>
  <label for="clientLastName">Last Name</label>
  <input type="text" id="clientLastName" name="clientLastName" 
    <?php if(isset($clientLastName)){echo "value='$clientLastName'";}  ?>
    required>
  <label for="clientEmail">Email</label> 
  <input type="email" id="clientEmail" name="clientEmail" 
    <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?>
    required>
  <input type="submit" name="submit" id="updateBtn" value="Update Info">
  <input type="hidden" name="action" value="update-account">
  <input type="hidden" name="clientId" value="<?=$clientId?>">
</form>

<h2>Update Password</h2>
<?php  
  if(isset($_SESSION['passwordMessage'])) {
    echo $_SESSION['passwordMessage'];
  }
  unset($_SESSION['passwordMessage']); 
?>
<form method="post" class="validatedForm"> 
  <label for="clientPassword">Password</label>
  <span class="subtext">Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span>
  <p>* note your original password will be changed</p>
  <input type="password" id="clientPassword" name="clientPassword" required
    pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
  <button id="passwordButton" type="button">Show Password</button>
  <input type="submit" name="submit" id="updatePasswordBtn" value="Update Password">
  <input type="hidden" name="action" value="update-password">
  <input type="hidden" name="clientId" value="<?=$clientId?>">
</form>

