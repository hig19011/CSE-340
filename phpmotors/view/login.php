<h1>Sign in</h1>
<?php 
  displayGlobalMessage();
?>
<form method="post" action="/phpmotors/accounts/">

  <label for="clientEmail">Email</label>
  <input type="email" id="clientEmail" name="clientEmail" 
    <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?>
    required>
  <label for="clientPassword">Password</label>
  <p class="subtext">Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</p>
  <input type="password" id="clientPassword" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
  <button id="passwordButton" type="button">Show Password</button>
  <input type="submit" value="Sign-in">
  <input type="hidden" name="action" value="login">
  <a href="/phpmotors/accounts/index.php?action=register-page">Not a member yet?</a>  
</form>