<h1>Add Vehicle</h1>

<?php
if (isset($message)) {
  echo $message;
}
?>

<p>* Note all Fields are Required</p>
<form class="forms" method="post">
  <label for="classificationId">Classification</label>
  <select id="classificationId" name="classificationId">      
    <?php foreach ($classificationList as $classification) { ?>
      <option value="<?= $classification->classificationId ?>"><?= $classification->classificationName ?></option>
    <?php } ?>
  </select>
  <label for="invMake">Make</label>
  <input id="invMake" name="invMake" list="makes" required>
  <datalist id="makes">      
  <?php foreach ($carMakes as $make) { ?>
      <option value="<?= $make?>"></option>
    <?php } ?>    
  </datalist>
  <label for="invModel">Model</label>
  <input id="invModel" name="invModel" type="text" required>
  <label for="invDescription">Description</label>
  <textarea id="invDescription" name="invDescription" rows="3" required></textarea>
  <label for="invImage">Image Path</label>
  <input id="invImage" name="invImage" type="text" value="/phpmotors/images/no-image.jpg" required>
  <label for="invThumbnail">Thumbnail Path</label>
  <input id="invThumbnail" name="invThumbnail" type="text" value="/phpmotors/images/no-image.jpg" required>
  <label for="invPrice">Price</label>
  <input id="invPrice" name="invPrice" type="text" required>
  <label for="invStock"># In Stock</label>
  <input id="invStock" name="invStock" type="text" required>
  <label for="invColor">Color</label>
  <input id="invColor" name="invColor" type="text" >
  
  <input type="submit" value="Add Vehicle">
  <input type="hidden" name="action" value="add-vehicle">
</form>