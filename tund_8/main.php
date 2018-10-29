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

  $stylestuff = userpageload($_SESSION["userId"]);
  $mydescription = $stylestuff[0];
  $mybgcolor = $stylestuff[1];
  $mytxtcolor = $stylestuff[2];
  $pageTitle = "Pealeht";

  require("header.php");
?>


	  <p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	  <hr>
    <p>Olete sisse loginud nimega : <?php echo $_SESSION["userFirstName"] ." " .$_SESSION["userLastName"]; ?>. <b><a href="?logout=1">Logi välja! </a></b></p>
	  <ul>
        <li>Valideeri anonüümseid <a href="validatemsg.php">sõnumeid</a></li>
        <li><a href="users.php">Kasutajate list</a></li>
        <li>Fotode <a href="photoupload.php">üleslaadimine </a></li>
	  </ul>
	
  </body>
</html>