<?php
	require("functions.php");
	$name = "";
	$surname = "";
	$fullName = $name ." " .$surname;
	$email = "";
	$gender = "";
	$monthNow = date("m");
	$birthMonth = null;
	$birthYear = null;
	$birthDay = null;
	$birthDate = null;
	$monthNamesET = ["Jaanuar", "Veebruar", "Märts", "Aprill", "Mai", "Juuni", "Juuli", "August", "September", "Oktoober", "November", "Detsember"];
	
	//muutujad võimalike veateadetega
	$nameError = "";
	$surnameError = "";
	$birthMonthError = "";
	$birthYearError = "";
	$birthDayError = "";
	$genderError = "";
	$emailError = "";
	$passwordError = "";
	
	//kui on uue kasutaja loomise nuppu vajutatud
	if(isset($_POST["submitUserData"])){
	
	//var_dump($_POST); //Tähtis array $_POST
	if (isset($_POST["firstName"]) and !empty($_POST["firstName"])){
		//$name=$_POST["firstName"];
		$name = test_input($_POST["firstName"]);
	}else{
		$nameError="Palun sisesta eesnimi!";
	}
	
	if (isset($_POST["lastName"]) and !empty($_POST["lastName"])){
		//$surname=$_POST["lastName"];
		$surname = test_input($_POST["lastName"]);
	}else{
		$surnameError="Palun sisesta perenimi";
	}
	
	if(isset($_POST["gender"])){
		$gender = intval($_POST["gender"]);
	}else{
		$genderError = "Palun märgi sugu!";
	}
	
	//kontrollime kas sünniaeg sisestati ja kas on korrektne
	if(isset($_POST["birthDay"])){
		$birthDay = $_POST["birthDay"];
	}
	
	if(isset($_POST["birthMonth"])){
		$birthMonth = $_POST["birthMonth"];
	}
	
	if(isset($_POST["birthYear"])){
		$birthYear = $_POST["birthYear"];
	}
	
	//kontrollin kuupäeva
	
	if(isset($_POST["birthDay"]) and isset($_POST["birthMonth"]) and isset($_POST["birthYear"])){
		//checkdate(päev, kuu, aasta)
		if(checkdate(intval($_POST["birthMonth"]), intval($_POST["birthDay"]), intval($_POST["birthYear"]))){
			$birthDate = date_create($_POST["birthMonth"] ."/" .$_POST["birthDay"] ."/" .$_POST["birthYear"]);
			$birthDate = date_format($birthDate, "Y-m-d");
			//echo $birthDate;
		}else{
			$birthYearError = "Kuupäev on vigane!";
		}
	}
	
	//kui kõik on korras, siis salvestame kasutaja
	
	if(empty($nameError) and empty($surnameError) and empty($birthMonthError) and empty($birthYearError) and empty($birthDayError) and empty($genderError) and empty($emailError) and empty($passwordErrorError)){
		$notice = signup($name, $surname, $email, $gender, $birthDate, $_POST["password"]);
		echo $notice;
	}
	
	}//kui on nuppu vajutatud lõppeb ära

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Katselise veebi kasutaja loomine</title>
</head>
<body>
	<h1>Loo endale konto</h1>
	<p>Siin on minu <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames valminud veebilehed. See ei oma mingit sisu ja nende kopeerimine ei oma mõtet.</p>
	<br>
	<hr>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Eesnimi:</label><br>
		<input name="firstName" type="text" value="<?php echo $name; ?>"><span><?php echo $nameError; ?></span><br>
		<label>Perekonnanimi:</label><br>
		<input name="lastName" type="text" value""><span><?php echo $surnameError; ?></span><br>
		
		<input type="radio" name="gender" value="2" 
		<?php
			if($gender == "2"){
				echo " checked";
			}
		?>>
		<label>Naine</label>
		
		<input type="radio" name="gender" value="1"
		<?php
			if($gender == "1"){
				echo " checked";
			}
		?>><label>Mees</label><br>		
		<span><?php echo $genderError; ?></span><br>
		
		<label>Sünnipäev: </label>
		<?php
			echo '<select name="birthDay">' ."\n";
			echo '<option value="" selected disabled>Päev</option>' ."\n";
			for ($i = 1; $i < 32; $i ++){
				echo '<option value="' .$i .'"';
				if ($i == $birthDay){
					echo " selected ";
				}
				echo ">" .$i ."</option> \n";
			}
			echo "</select> \n";
		?>
		
		<label>Sünnikuu: </label>
		<?php
			echo '<select name="birthMonth">' ."\n";
			echo '<option value="" selected disabled>Kuu</option>' ."\n";
			for ($i = 1; $i < 13; $i ++){
				echo '<option value="' .$i .'"';
				if ($i == $birthMonth){
					echo " selected ";
				}
				echo ">" .$monthNamesET[$i - 1] ."</option> \n";
			}
			echo "</select> \n";
		?>

		<label>Sünniaasta: </label>
		<?php
			echo '<select name="birthYear">' ."\n";
			echo '<option value="" selected disabled>Aasta</option>' ."\n";
			for ($i = date("Y") - 15; $i >= date("Y") - 100; $i --){
				echo '<option value="' .$i .'"';
				if ($i == $birthYear){
					echo " selected ";
				}
				echo ">" .$i ."</option> \n";
			}
			echo "</select> \n";
		?>
		<br>
		
		<label>Salasõna:</label><br>
		<input name="password" type="text"><span><?php echo $passwordError; ?></span><br>
		
		<label>E-mail (kasutajatunnus):</label>
		<input type="email" name="email"><br><span><?php echo $emailError; ?></span><br>
		<br>
		<input name="submitUserData" type="submit" value="Loo kasutaja">
	</form>
</body>
</html>