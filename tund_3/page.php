<?php
	$name = "Tundmatu";
	$surname = "Isik";
	
	//var_dump($_POST); //Tähtis array $_POST
	if (isset($_POST["firstName"])){
		$name=$_POST["firstName"];
	}
	if (isset($_POST["lastName"])){
		$surname=$_POST["lastName"];
	}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
	<?php
		echo $name;
		echo " ";
		echo $surname;
		echo " 3. tunni töö";
	?>
	</title>
</head>
<body>
	<h1>
		<?php
			echo $name ." " .$surname . " " ."asjade lehekülg";
		?>
	</h1>
	<p>Siin on minu <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames valminud veebilehed. See ei oma mingit sisu ja nende kopeerimine ei oma mõtet.</p>
	<br>
	<hr>
	
	<form method="POST">
		<lable>Eesnimi:</lable>
		<input name="firstName" type="text" value="">
		<lable>Perekonnanimi:</lable>
		<input name="lastName" type="text" value"">
		<label>Sünniaasta:</lable>
		<input name="birtYear" type="number" min="1924" max="2003" value="1998">
		<br>
		<input name="submitUserData" type="submit" value="Saada andmed">
	</form>
	
	<?php
		if(isset($_POST["submitUserData"])){
			echo "<br><p>Olete elanud järgnevatel aastatel:</p>";
			echo "<ul> \n";	
			for($i = $_POST["birtYear"]; $i <= date("Y"); $i ++){
				echo "<li>" .$i ."</li> \n";
			}
			echo "</ul> \n";
		}
	?>
	
</body>
</html>