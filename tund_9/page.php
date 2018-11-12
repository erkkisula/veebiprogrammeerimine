<?php
	$name = "Tundmatu";
	$surname = "Isik";
	$fullName = $name ." " .$surname;
	$monthNow = date("m");
	$birthMonth = date("m");
	$monthNamesET = ["Jaanuar", "Veebruar", "Märts", "Aprill", "Mai", "Juuni", "Juuli", "August", "September", "Oktoober", "November", "Detsember"];
	
	//var_dump($_POST); //Tähtis array $_POST
	if (isset($_POST["firstName"])){
		//$name=$_POST["firstName"];
		$name=test_input($_POST["firstName"]);
	}
	
	if (isset($_POST["lastName"])){
		//$surname=$_POST["lastName"];
		$surname=test_input($_POST["lastName"]);
	}
	
	function test_input($data) {
		echo "Koristan!\n";
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	function fullname(){
		$GLOBALS["fullName"] = $GLOBALS["name"] ." " .$GLOBALS["surname"];
	}
	//echo $monthNamesET[$monthNow -1];
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
		echo " 4. tunni töö";
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
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<lable>Eesnimi:</lable>
		<input name="firstName" type="text" value="">
		<lable>Perekonnanimi:</lable>
		<input name="lastName" type="text" value"">
		<lable>Sünniaasta:</lable>
		<input name="birtYear" type="number" min="1924" max="2003" value="1998">
		<label>Sünnikuu: </label>
		<?php
			echo '<select name="birthMonth">' ."\n";
			for ($i = 1; $i < 13; $i ++){
				echo '<option value="' .$i .'"';
				if ($i == $birthMonth){
					echo " selected ";
				}
				echo ">" .$monthNamesET[$i - 1] ."</option> \n";
			}
			echo "</select> \n";
		?>
		</select>
		<br>
		<input name="submitUserData" type="submit" value="Saada andmed">
	</form>
	
	<?php
		if(isset($_POST["submitUserData"])){							//tehakse list aastatest
			//demo funktsioon, suhteliselt jama
			fullName();
			
			echo "<br><p>" .$fullName .". Olete elanud järgnevatel aastatel:</p>";
			echo "<ul> \n";	
			for($i = $_POST["birtYear"]; $i <= date("Y"); $i ++){
				echo "<li>" .$i ."</li> \n";
			}
			echo "</ul> \n";
		}
	?>
	
</body>
</html>