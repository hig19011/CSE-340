<?php 

class inventory
{
  public $invId;
  public $invColor;
  public $invDescription;
  public $invImage;
  public $invMake;
  public $invModel;
  public $invPrice;
  public $invStock;
  public $invThumbnail;
  public $classificationId;

  function isInvalid()
  {
    if (
      empty($this->invColor)
      || empty($this->invDescription)
      || empty($this->invImage)
      || empty($this->invThumbnail)
      || empty($this->invMake)
      || empty($this->invModel)
      || empty($this->invPrice)
      || empty($this->invStock)
      || empty($this->invThumbnail)
      || empty($this->classificationId)
    ) {
      return true;
    }
    return false;
  }
}

?>