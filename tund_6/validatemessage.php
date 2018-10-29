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

 //kui on sees
 if(isset($_GET["id"])){
     $msg = readmsgforvalidation($_GET["id"]);
 }

 //kinnitamine algab
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["submitValidation"])){
		if (isset($_POST["validation"])){
			if (isset($_POST["id"])){
				validateMSG($_SESSION["userId"], $_POST["validation"], $_POST["id"]);
			} 
		}
	}
}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Anonüümsed sõnumid</title>
</head>
<body>
  <h1>Sõnumid</h1>
  <p>Siin on minu <a href="http://www.tlu.ee">TLÜ</a> õppetöö raames valminud veebilehed. Need ei oma mingit sügavat sisu ja nende kopeerimine ei oma mõtet.</p>
  <hr>
  <ul>

	<li><a href="validatemsg.php">Tagasi</a> sõnumite lehele!</li>
  </ul>
  <hr>
  <h2>Valideeri see sõnum:</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input name="id" type="hidden" value="<?php echo $_GET["id"]; ?>">
    <input type="radio" name="validation" value="0" checked><label>Keela näitamine</label><br>
    <input type="radio" name="validation" value="1"><label>Luba näitamine</label><br>
    <input type="submit" value="Kinnita" name="submitValidation">
  </form>
  <hr>


</body>
</html>