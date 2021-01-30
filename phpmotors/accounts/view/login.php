<h1>Sign in</h1>

<form action="/phpmotors/accounts/index.php" method="post" class="forms">
  <input class="hide-me" hidden name="action" value="login-post">

  <label for="clientEmail">Email</label>
  <input type="email" id="clientEmail" name="clientEmail" required>
  <label for="clientPassword">Password</label>
  <input type="password" id="clientPassword" name="clientPassword" required>
  
  <input type="submit" value="Sign-in">
  <a href="/phpmotors/accounts/index.php?action=register">Not a member yet?</a>
  
</form>

<div>  
  <?php 
    if(isset($clientEmail)){
      echo "Temporary display to show capture of posted data is working. <br>";
      echo "Email: ".$clientEmail."<br>";
      echo "Password: ".$clientPassword."<br>";
    } 
  ?>
</div>