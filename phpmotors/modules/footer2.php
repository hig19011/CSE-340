<?php        
    $lastModified = filemtime($_SERVER['DOCUMENT_ROOT'].$contentPath);  
    date_default_timezone_set('America/Phoenix');
    $date = date('d F, Y', $lastModified);
?> 

<div>
  <p>&copy; PHP Motors, All rights reserved.</p>
  <p>All images used are believed to be in "Fair Use". Please notify the author if any are not and they will be removed.</p>
  <p>Last Updated: <?php echo $date?></p>
</div>