
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> <?=$pageTitle?> | PHP Motors</title>
    <base href="/phpmotors/"/>
    <link rel="stylesheet" media="screen" href="css/style.css" />    
  </head>
  <body>  
      <header>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/modules/header.php' ?>
      </header>
      <nav>
        <?php 
        // require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/modules/nav.php' 
        ?>
        <?php $nav = buildNav($classifications); echo $nav; ?>
      </nav>
      <main>        
        <?php require $_SERVER['DOCUMENT_ROOT'].$contentPath ?>
      </main>
      <footer>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/modules/footer.php'?>
      </footer> 
      <script src="/phpmotors/js/library.js"></script>
  </body>
</html>
