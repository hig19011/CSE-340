<h1>Register</h1>

<?php 
  if(isset($message)) {
    echo $message;
  }
?>

<form method="post" class="forms">
  <label for="clientFirstName">First Name</label>
  <input type="text" id="clientFirstName" name="clientFirstName" required>
  <label for="clientLastName">Last Name</label>
  <input type="text" id="clientLastName" name="clientLastName" required>

  <label for="clientEmail">Email</label>
  <input type="email" id="clientEmail" name="clientEmail" required>
  <label for="clientPassword">Password</label>
  <input type="password" id="clientPassword" name="clientPassword" required>
  
  <input type="submit" name="submit" id="regBtn" value="Register">
  <input type="hidden" name="action" value="register">
</form>

