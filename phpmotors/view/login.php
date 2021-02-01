<h1>Sign in</h1>

<?php 
  if(isset($message)) {
    echo $message;
  }
?>

<form action="/phpmotors/accounts/index.php" method="post" class="forms">

  <label for="clientEmail">Email</label>
  <input type="email" id="clientEmail" name="clientEmail" required>
  <label for="clientPassword">Password</label>
  <input type="password" id="clientPassword" name="clientPassword" required>
  
  <input type="submit" value="Sign-in">
  <a href="/phpmotors/accounts/index.php?action=register-page">Not a member yet?</a>
  <input type="hidden" name="action" value="login">
</form>