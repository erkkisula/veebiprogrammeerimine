<?php
  require("functions.php");
  //kui pole sisse loginud

  //$mydescription = "Siia tuleb tekst";
  //$mybgcolor = "#FFFFFF";
  //$mytxtcolor = "#000000";

  $stylestuff = userpageload($_SESSION["userId"]);
  $mydescription = $stylestuff[0];
  $mybgcolor = $stylestuff[1];
  $mytxtcolor = $stylestuff[2];

  //echo $stylestuff[1];

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

   //kinnitamine algab
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	  if (isset($_POST["submitUserData"])){
		  if (isset($_POST["description"])){
			  if (isset($_POST["bgcolor"])){
          if (isset($_POST["txtcolor"])){
            userpagesave($_SESSION["userId"], $_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
          }
			  } 
		  }
	  }
  }

  $pageTitle = "Kasutaja leht";
  require("header.php");

  //echo userpageDESC($_SESSION["userId"]);
?>


    <h2>Kasutaja <?php echo $_SESSION["userFirstName"] ." " .$_SESSION["userLastName"]; ?> leht</h2>
	  <hr>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea>
      <br>
      <label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
      <label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mytxtcolor; ?>"><br>
      <input name="submitUserData" type="submit" value="Uuenda andmeid">
    </form>
    <p>Olete sisse loginud nimega : <?php echo $_SESSION["userFirstName"] ." " .$_SESSION["userLastName"]; ?>. <b><a href="?logout=1">Logi välja! </a></b></p>
	
  </body>
</html>