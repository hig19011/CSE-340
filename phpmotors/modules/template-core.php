
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> <?=$_SESSION['contentPath'] ?> | PHP Motors</title>
    <link rel="stylesheet" media="screen" href="css/style.css" />    
  </head>
  <body>
  <? echo $_SESSION['contentPath']?>
    <header>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/modules/header.php' ?>
    </header>
    <nav>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/modules/nav.php' ?>
    </nav>
    <main>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/'.$_SESSION['contentPath'] ?>
    </main>
    <footer>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/modules/footer.php'?>
    </footer>
  </body>
</html>
