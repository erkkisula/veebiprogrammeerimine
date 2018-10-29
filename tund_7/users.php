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
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>Kasutajad</title>
  </head>
  <body>
    <h1>Kasutajad</h1>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
    <p>Olete sisse loginud nimega : <?php echo $_SESSION["userFirstName"] ." " .$_SESSION["userLastName"]; ?>. <b><a href="?logout=1">Logi välja! </a></b></p>
    <br>
    <ul>
    <?php echo listUsers();?>
    </ul>
	
  </body>
</html>