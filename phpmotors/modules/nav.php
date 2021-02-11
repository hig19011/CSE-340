<div>
  <ul>
    <li><a href="/phpmotors" title="View the PHP Motors home page">Home</a></li>    
    <?php foreach($navList as $navItem) { ?>
        <li><a href='/phpmotors/index.php?action=<?=urldecode($navItem->classificationName); ?>' title='View our <?=$navItem->classificationName?> product line'><?=$navItem->classificationName?></a></li>
    <?php } ?>
  </ul>  
</div>