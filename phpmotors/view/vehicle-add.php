<?php 
if($_SESSION['loggedIn'] == false || $_SESSION['clientData']['clientLevel'] < 2){
  header('Location: /phpmotors/');
  exit;
}
?>

<h1>Add Vehicle</h1>

<?php
  displayGlobalMessage();
?>

<p>* Note all Fields are Required</p>
<form class="forms" method="post">
  <label for="classificationId">Classification</label>
  <select id="classificationId" name="classificationId">      
    <?php foreach ($classifications as $classification) { ?>
      <option 
        <?php if(isset($vehicle) && $vehicle->classificationId == $classification->classificationId) echo "selected "?>
      value="<?= $classification->classificationId ?>"><?= $classification->classificationName ?></option>
    <?php } ?>
  </select>
  <label for="invMake">Make</label>
  <input id="invMake" name="invMake" list="makes" 
    <?php if(isset($vehicle->invMake)){echo "value='$vehicle->invMake'";}  ?>
    required>
  <datalist id="makes">      
  <?php foreach ($carMakes as $make) { ?>
      <option value="<?= $make?>"></option>
    <?php } ?>    
  </datalist>
  <label for="invModel">Model</label>
  <input id="invModel" name="invModel" type="text" 
    <?php if(isset($vehicle->invModel)){echo "value='$vehicle->invModel'";}  ?>
    required>
  <label for="invDescription">Description</label>
  <textarea id="invDescription" name="invDescription" rows="3" required><?php if(isset($vehicle->invDescription)){echo $vehicle->invDescription;}?></textarea>
  <label for="invImage">Image Path</label>
  <input id="invImage" name="invImage" type="text" value="/phpmotors/images/no-image.jpg" 
    <?php if(isset($vehicle->invImage)){echo "value='$vehicle->invImage'";}  ?>
    required>
  <label for="invThumbnail">Thumbnail Path</label>
  <input id="invThumbnail" name="invThumbnail" type="text" value="/phpmotors/images/no-image.jpg" 
    <?php if(isset($vehicle->invThumbnail)){echo "value='$vehicle->invThumbnail'";}  ?>
    required>
  <label for="invPrice">Price</label>
  <input id="invPrice" name="invPrice" type="text"
    <?php if(isset($vehicle->invPrice)){echo "value='$vehicle->invPrice'";}  ?> 
  required>
  <label for="invStock"># In Stock</label>
  <input id="invStock" name="invStock" type="text" 
    <?php if(isset($vehicle->invStock)){echo "value='$vehicle->invStock'";}  ?>
    required>
  <label for="invColor">Color</label>
  <input id="invColor" name="invColor" type="text" 
    <?php if(isset($vehicle->invThumbnail)){echo "value='$vehicle->invColor'";}  ?>
    required>
  
  <input type="submit" value="Add Vehicle">
  <input type="hidden" name="action" value="add-vehicle">
</form>