<?php 
// if(isset($_COOKIE['firstName'])){
//   $cookieFirstName = filter_input(INPUT_COOKIE, 'firstName', FILTER_SANITIZE_STRING);
// }
  if(isset($_SESSION['loggedIn'])){
    $sessionFirstName = $_SESSION['clientData']['clientFirstName'];    
  }
?>

<div>
  <a href="/phpmotors" title="PHP Motors Home page"><img src="images/site/logo.png" alt="php motors logo"></a>
  <?php 
  if(isset($sessionFirstName)){
    echo "<a href='/phpmotors/accounts/'><span class='welcome'>Welcome $sessionFirstName</span></a>";
    echo "<a href='/phpmotors/accounts/index.php?action=logout' title='Log out of PHP Motors'>Logout</a>";
  }   
  else {
    echo "<a href='/phpmotors/accounts/index.php?action=login-page' title='View My Account'>My Account</a>";
  }
  ?>
</div>