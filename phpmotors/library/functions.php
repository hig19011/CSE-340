<?php

// Validate that the email has the correct format
function checkEmail($clientEmail){
  $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
  return $valEmail;
}

// Check the password for a minimum of 8 characters,
// at least one 1 capital letter, at least 1 number and
// at least 1 special character
function checkPassword($clientPassword){
  $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])(?=.*[A-Z])(?=.*[a-z])([^\s]){8,}$/';
  return preg_match($pattern, $clientPassword);
}


// This is a way to build up the nav menu for reuse.  It is less than ideal to bury code in a string
// because it prevents the developer from using the tools built into most IDEs from validating 
// the syntax at design time.
function buildNav($classifications) {
  $nav = '<div>';
  $nav .= '<ul>';
  $nav .= '<li><a href="/phpmotors" title="View the PHP Motors home page">Home</a></li>';
  foreach($classifications as $navItem) { 
    $nav .= '<li><a href="/phpmotors/index.php?action='.urldecode($navItem->classificationName).'" title="View our '.$navItem->classificationName.' product line">'.$navItem->classificationName.'</a></li>';
  }
  $nav .= '</ul>';
  $nav .= '</div>';
  return $nav;
}

// Build the classifications select list 
function buildClassificationList($classifications){ 
  $classificationList = '<select name="classificationId" id="classificationList">'; 
  $classificationList .= "<option>Choose a Classification</option>"; 
  foreach ($classifications as $classification) { 
   $classificationList .= "<option value='$classification->classificationId'>$classification->classificationName</option>"; 
  } 
  $classificationList .= '</select>'; 
  return $classificationList; 
 }


function displayGlobalMessage(){ 
  if(isset($_SESSION['message'])) {
    echo $_SESSION['message'];
  }
  unset($_SESSION['message']); 
}