<?php 
if($_SESSION['loggedIn'] == false || $_SESSION['clientData']['clientLevel'] < 2){
  header('Location: /phpmotors/');
  exit;
}
?>

<h1><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
	echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
elseif(isset($invMake) && isset($invModel)) { 
	echo "Modify$invMake $invModel"; }?></h1>

<?php
  displayGlobalMessage();
?>

<p>* Note all Fields are Required</p>
<form class="forms" method="post">
  <label for="classificationId">Classification</label>
  <select id="classificationId" name="classificationId">      
    <?php foreach ($classifications as $classification) { ?>
      <option 
        <?php if(isset($vehicle) && $vehicle->classificationId == $classification->classificationId) {echo "selected ";}
              elseif(isset($invInfo['classificationId']) && $invInfo['classificationId'] == $classification->classificationId) {echo "selected ";}?>
      value="<?= $classification->classificationId ?>"><?= $classification->classificationName ?></option>
    <?php } ?>
  </select>
  <label for="invMake">Make</label>
  <input id="invMake" name="invMake" list="makes" 
    <?php if(isset($vehicle->invMake)){echo "value='$vehicle->invMake'";} 
          elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; } ?>
    required>
  <datalist id="makes">      
  <?php foreach ($carMakes as $make) { ?>
      <option value="<?= $make?>"></option>
    <?php } ?>    
  </datalist>
  <label for="invModel">Model</label>
  <input id="invModel" name="invModel" type="text" 
    <?php if(isset($vehicle->invModel)){echo "value='$vehicle->invModel'";} 
      elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; } ?>
    required>
  <label for="invDescription">Description</label>
  <textarea id="invDescription" name="invDescription" rows="3" required><?php 
    if(isset($vehicle->invDescription)){echo $vehicle->invDescription;}
    elseif(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; } 
    ?></textarea>
  <label for="invImage">Image Path</label>
  <input id="invImage" name="invImage" type="text" value="/phpmotors/images/no-image.jpg" 
    <?php if(isset($vehicle->invImage)){echo "value='$vehicle->invImage'";}  
          elseif(isset($invInfo['invImage'])) {echo "value='$invInfo[invImage]'"; } ?>
    required>
  <label for="invThumbnail">Thumbnail Path</label>
  <input id="invThumbnail" name="invThumbnail" type="text" value="/phpmotors/images/no-image.jpg" 
    <?php if(isset($vehicle->invThumbnail)){echo "value='$vehicle->invThumbnail'";} 
          elseif(isset($invInfo['invThumbnail'])) {echo "value='$invInfo[invThumbnail]'"; } ?>
    required>
  <label for="invPrice">Price</label>
  <input id="invPrice" name="invPrice" type="text"
    <?php if(isset($vehicle->invPrice)){echo "value='$vehicle->invPrice'";}  
          elseif(isset($invInfo['invPrice'])) {echo "value='$invInfo[invPrice]'"; } ?> 
  required>
  <label for="invStock"># In Stock</label>
  <input id="invStock" name="invStock" type="text" 
    <?php if(isset($vehicle->invStock)){echo "value='$vehicle->invStock'";}  
          elseif(isset($invInfo['invStock'])) {echo "value='$invInfo[invStock]'"; } ?>
    required>
  <label for="invColor">Color</label>
  <input id="invColor" name="invColor" type="text" 
    <?php if(isset($vehicle->invThumbnail)){echo "value='$vehicle->invColor'";} 
          elseif(isset($invInfo['invColor'])) {echo "value='$invInfo[invColor]'"; }?>
    required>
  
  <input type="submit" value="Update Vehicle">
  <input type="hidden" name="action" value="update-vehicle">
  <input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])){
    echo $invInfo['invId'];} elseif(isset($invId)) {echo $invId;}?>">
</form>