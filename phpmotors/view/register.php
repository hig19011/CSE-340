<h1>Register</h1>

<?php 
  displayGlobalMessage();
?>

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
  <label for="clientPassword">Password</label>
  <p class="subtext">Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</p>
  <input type="password" id="clientPassword" name="clientPassword" required
    pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
  <button id="passwordButton" type="button">Show Password</button>
  <input type="submit" name="submit" id="regBtn" value="Register">
  <input type="hidden" name="action" value="register">
</form>

