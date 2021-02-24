<?php

/* 
 *  This model is used for handling the site Accounts
 */


// Register a new client
function regClient($clientFirstName, $clientLastName, $clientEmail, $clientPassword)
{
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO clients (clientFirstName, clientLastName,clientEmail, clientPassword)
      VALUES (:clientFirstName, :clientLastName, :clientEmail, :clientPassword)';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':clientFirstName', $clientFirstName, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastName', $clientLastName, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

/* 
 *  This function will check to see if an existing email already exists
 */

function doesEmailExist($clientEmail)
{
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'SELECT clientEmail FROM clients WHERE clientEmail = :clientEmail';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next line replaces the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    // Run Query
    $stmt->execute();
    //Get query results
    $matchingEmailCount = $stmt->fetch(PDO::FETCH_NUM);
    // Close the database interaction
    $stmt->closeCursor();

    if (empty($matchingEmailCount)) {
        return 0;
    } else {
        return 1;
    }
}

function getClient($clientEmail)
{
    $db = phpmotorsConnect();
    $sql = 'SELECT clientId, clientFirstName, clientLastName, clientEmail, clientLevel, clientPassword 
            FROM clients 
            WHERE clientEmail = :clientEmail';
    $stmt = $db->prepare($sql);  
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientData;
}
