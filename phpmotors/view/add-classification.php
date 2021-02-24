<?php 
if($_SESSION['loggedIn'] == false || $_SESSION['clientData']['clientLevel'] < 2){
  header('Location: /phpmotors/');
  exit;
}
?>

<h1>Add Classification</h1>

<?php 
  if(isset($message)) {
    echo $message;
  }
?>

<form method="post" class="forms">

  <label for="carClassification">Name:</label>
  <input type="text" id="carClassification" name="classificationName" 
    <?php if(isset($classificationName)){echo "value='$classificationName'";} ?>
    required>

  <input type="submit" name="submit" id="addBtn" value="Add Classification">
  <input type="hidden" name="action" value="add-classification">
</form>