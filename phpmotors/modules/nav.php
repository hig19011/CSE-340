<div>
  <ul>
    <li><a href="/phpmotors" title="View the PHP Motors home page">Home</a></li>    
    <?php foreach($navList as $navItem) { ?>
        <li><a href='/phpmotors/index.php?action=<?=urldecode($navItem); ?>' title='View our <?=$navItem?> product line'><?=$navItem?></a></li>
    <?php } ?>
  </ul>  
</div>