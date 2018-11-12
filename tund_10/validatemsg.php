<?php
 require("functions.php");
 //kui pole sisse loginud

 if(!isset($_SESSION["userId"])){
     header("Location: index_new.php");
     exit();
 }

 //väljalogimine
 if(isset($_GET["logout"])){
     session_destroy();
     header("Location: index_new.php");
     exit();
 }

 $notice = readallunvalidatedmessages();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Anonüümsed sõnumid</title>
</head>
<body>
  <h1>Sõnumid</h1><br>
  <p><b><a href="main.php">Tagasi</a></b> <p><b><a href="?logout=1">Logi välja! </a></b></p>
  <p>Siin on minu <a href="http://www.tlu.ee">TLÜ</a> õppetöö raames valminud veebilehed. Need ei oma mingit sügavat sisu ja nende kopeerimine ei oma mõtet.</p>
  <hr>
  <ul>

  </ul>
  <hr>
  
  <?php echo $notice; ?>

</body>
</html>