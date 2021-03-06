<?php

/* 
 *  This model is used for handling the Inventory
 */

require_once '../library/vehicle.php';

// Create a new vehicle type
function createVehicle($vehicle)
{
  // Create a connection object using the phpmotors connection function
  $db = phpmotorsConnect();
  // The SQL statement
  $sql = 'INSERT INTO inventory(invMake, invModel, invDescription, invImage, invThumbnail, 
        invPrice, invStock, invColor, classificationId)
      VALUES (:invMake, :invModel, :invDescription, :invImage, :invThumbnail, :invPrice, 
        :invStock, :invColor, :classificationId)';
  // Create the prepared statement using the phpmotors connection
  $stmt = $db->prepare($sql);
  // The next nine lines replace the placeholders in the SQL
  // statement with the actual values in the variables
  // and tells the database the type of data it is
  //$stmt->bindValue(':invId', $vehicle->invId, PDO::PARAM_STR);
  $stmt->bindValue(':invMake', $vehicle->invMake, PDO::PARAM_STR);
  $stmt->bindValue(':invModel', $vehicle->invModel, PDO::PARAM_STR);
  $stmt->bindValue(':invDescription', $vehicle->invDescription, PDO::PARAM_STR);
  $stmt->bindValue(':invImage', $vehicle->invImage, PDO::PARAM_STR);
  $stmt->bindValue(':invThumbnail', $vehicle->invThumbnail, PDO::PARAM_STR);
  $stmt->bindValue(':invPrice', $vehicle->invPrice, PDO::PARAM_STR);
  $stmt->bindValue(':invStock', $vehicle->invStock, PDO::PARAM_INT);
  $stmt->bindValue(':invColor', $vehicle->invColor, PDO::PARAM_STR);
  $stmt->bindValue(':classificationId', $vehicle->classificationId, PDO::PARAM_INT);
  // Insert the data
  $stmt->execute();
  // Ask how many rows changed as a result of our insert
  $rowsChanged = $stmt->rowCount();
  // Close the database interaction
  $stmt->closeCursor();
  // Return the indication of success (rows changed)
  return $rowsChanged;
}


// Create a new vehicle type
function updateVehicle($vehicle)
{
  // Create a connection object using the phpmotors connection function
  $db = phpmotorsConnect();
  // The SQL statement
  $sql = 'UPDATE inventory 
          SET invMake = :invMake, invModel = :invModel, 
              invDescription = :invDescription, invImage = :invImage, 
              invThumbnail = :invThumbnail, invPrice = :invPrice, 
              invStock = :invStock, invColor = :invColor, 
              classificationId = :classificationId 
          WHERE invId = :invId';
  // Create the prepared statement using the phpmotors connection
  $stmt = $db->prepare($sql);
  // The next nine lines replace the placeholders in the SQL
  // statement with the actual values in the variables
  // and tells the database the type of data it is
  $stmt->bindValue(':invId', $vehicle->invId, PDO::PARAM_INT);
  $stmt->bindValue(':invMake', $vehicle->invMake, PDO::PARAM_STR);
  $stmt->bindValue(':invModel', $vehicle->invModel, PDO::PARAM_STR);
  $stmt->bindValue(':invDescription', $vehicle->invDescription, PDO::PARAM_STR);
  $stmt->bindValue(':invImage', $vehicle->invImage, PDO::PARAM_STR);
  $stmt->bindValue(':invThumbnail', $vehicle->invThumbnail, PDO::PARAM_STR);
  $stmt->bindValue(':invPrice', $vehicle->invPrice, PDO::PARAM_STR);
  $stmt->bindValue(':invStock', $vehicle->invStock, PDO::PARAM_INT);
  $stmt->bindValue(':invColor', $vehicle->invColor, PDO::PARAM_STR);
  $stmt->bindValue(':classificationId', $vehicle->classificationId, PDO::PARAM_INT);
  // Insert the data
  $stmt->execute();
  // Ask how many rows changed as a result of our insert
  $rowsChanged = $stmt->rowCount();
  // Close the database interaction
  $stmt->closeCursor();
  // Return the indication of success (rows changed)
  return $rowsChanged;
}

// Add a new car classification
function createClassification($classificationName)
{
  // Create a connection object using the phpmotors connection function
  $db = phpmotorsConnect();
  // The SQL statement
  $sql = 'INSERT INTO carClassification (classificationName) VALUES (:classificationName)';
  // Create the prepared statement using the phpmotors connection
  $stmt = $db->prepare($sql);
  // The next four lines replace the placeholders in the SQL
  // statement with the actual values in the variables
  // and tells the database the type of data it is
  $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
  // Insert the data
  $stmt->execute();
  // Ask how many rows changed as a result of our insert
  $rowsChanged = $stmt->rowCount();
  // Close the database interaction
  $stmt->closeCursor();
  // Return the indication of success (rows changed)
  return $rowsChanged;
}

// Get car make
function getExistingVehicleMakes()
{
  // Create a connection object using the phpmotors connection function
  $db = phpmotorsConnect();
  // The SQL statement
  $sql = 'SELECT DISTINCT invMake From inventory';
  // Create the prepared statement using the phpmotors connection
  $stmt = $db->prepare($sql);
  // The next line runs the prepared statement 
  $stmt->execute();
  // The next line gets the data from the database and 
  // stores it as an array in the $classifications variable 
  $makes = $stmt->fetchAll(PDO::FETCH_COLUMN);
  // The next line closes the interaction with the database 
  $stmt->closeCursor();
  // The next line sends the array of data back to where the function 
  // was called (this should be the controller) 
  return $makes;
}

// Get vehicles by classificationId 
function getInventoryByClassification($classificationId){ 
  $db = phpmotorsConnect(); 
  $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId'; 
  $stmt = $db->prepare($sql); 
  $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT); 
  $stmt->execute(); 
  $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
  $stmt->closeCursor(); 
  return $inventory; 
 }

 // Get vehicle information by invId
function getInvItemInfo($invId){
  $db = phpmotorsConnect();
  $sql = 'SELECT * FROM inventory WHERE invId = :invId';  
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
  $stmt->execute();
  
  $stmt->setFetchMode(PDO::FETCH_CLASS, 'inventory');
  $invInfo = $stmt->fetch();
  
  //$invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $invInfo;
 }

 function deleteVehicle($invId){
  $db = phpmotorsConnect();
  $sql = 'DELETE FROM inventory WHERE invId = :invId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
 }

 function getVehicleDetails($invId){
  $db = phpmotorsConnect();
  $sql = 'SELECT i.invId, invMake, invModel, invDescription, im.imgPath as invImage, 
            REPLACE(im.imgPath,".","-tn.") as invThumbnail, 
            invPrice, invStock, invColor, classificationId 
          FROM inventory i 
            INNER JOIN images im on i.invId = im.invId 
          WHERE i.invId = :invId 
            AND im.imgPrimary = 1
            and im.imgName not like "%-tn%"';          

  $stmt = $db->prepare($sql);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
  $stmt->execute();
  
  $stmt->setFetchMode(PDO::FETCH_CLASS, 'inventory');
  $invInfo = $stmt->fetch();
  
  //$invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $invInfo;
 }

 function getVehiclesByClassification($classificationName){
  $db = phpmotorsConnect();
  $sql = 'SELECT i.invId, invMake, invModel, invDescription, im.imgPath as invImage, 
            REPLACE(im.imgPath,".","-tn.") as invThumbnail, invPrice, invStock, invColor, classificationId 
          FROM inventory i 
            INNER JOIN images im on i.invId = im.invId             
          WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName)
            and im.imgName not like "%-tn%" 
            AND im.imgPrimary = 1';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
  $stmt->execute();
  $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $vehicles;
}

 // Get information for all vehicles
function getVehicles(){
	$db = phpmotorsConnect();
	$sql = 'SELECT invId, invMake, invModel FROM inventory';
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $invInfo;
}