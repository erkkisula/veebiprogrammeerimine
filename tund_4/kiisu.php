<?php
	require("functions.php");
	$notice = null;
	$error = "";

		if (isset($_POST["submitMessage"])){
			if ((empty($_POST["catname"])) and (empty($_POST["catcolor"])) and (empty($_POST["cattaillength"]))){
				$error = "Väljad ei tohi olla tühjad";
				} else {
				$notice = addcat($_POST["catname"], $_POST["catcolor"], $_POST["cattaillength"]);
				$error = '<br>' . $notice;
				
			}
		}
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sõnumi lisamine</title>
</head>
<body>
	<h1>Sõnumi lisamine</h1>
	<p>Siin on minu <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames valminud veebileht. See ei oma mingit sisu ja nende kopeerimine ei oma mõtet.</p>
	<br>
	<hr>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Kiisu andmed:</label>
		<br>
		<input type="text" name="catname" placeholder="Nimi...">
		<br>
		<input type="text" name="catcolor" placeholder="Värvus...">
		<br>
		<input type="text" name="cattaillength" placeholder="Saba pikkus...">
		<br>
		<input name="submitMessage" type="submit" value="Salvesta sõnum">
	</form>
	<br>
	<p>
	<?php
		echo $notice;
	?>
	</p>
	<br>
	<hr>
	
	

</body>
</html>