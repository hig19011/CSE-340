<h1>Register</h1>

<form action="/phpmotors/accounts/?action=register-post" method="post" class="forms">
  <label for="clientFirstName">First Name</label>
  <input type="text" id="clientFirstName" name="clientFirstName" required>
  <label for="clientLastName">Last Name</label>
  <input type="text" id="clientLastName" name="clientLastName" required>

  <label for="clientEmail">Email</label>
  <input type="email" id="clientEmail" name="clientEmail" required>
  <label for="clientPassword">Password</label>
  <input type="password" id="clientPassword" name="clientPassword" required>
  
  <input type="submit" value="Register">
</form>

<div> 
  <?php 
    if(isset($clientEmail)){
      echo "Temporary display to show capture of posted data is working. <br>";
      echo "First Name: ".$clientFirstName."<br>";
      echo "Last Name: ".$clientLastName."<br>";
      echo "Email: ".$clientEmail."<br>";
      echo "Password: ".$clientPassword."<br>";
    } 
  ?> 
</div>

