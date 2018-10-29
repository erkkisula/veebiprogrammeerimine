 <?php
require ("../../../config.php");
//echo $GLOBALS["serverHost"];
//echo $GLOBALS["serverUsername"];
//echo $GLOBALS["serverPassword"];
$database = "if18_erkki_su_1";

//alustan sessiooni
session_start();

function listUsers(){

	$notice = "<ul> \n";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT firstname, lastname, email FROM vpusers");
	echo $mysqli->error;
	$stmt->bind_result($fname, $lname, $eMail);
	$stmt->execute();
	while($stmt->fetch()){
		$notice .= "<li>" .$fname ." " .$lname ." " .$eMail ."</li>";
	}

	$stmt->close();
	$mysqli->close();
	return $notice;
	
}

function allvalidmessages(){
	$notice = "<ul> \n";
	$valid = 1;
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE valid=1 ORDER BY validated");
	echo $mysqli->error;
	$stmt->bind_result($msg);
	$stmt->execute();

	while($stmt->fetch()){
		$notice .= "<li>" .$msg ."</li> \n";
	}

	$stmt->close();
	$mysqli->close();
	return $notice;
}

function validateMSG($userID, $messageValidation, $messageID){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("UPDATE vpamsg SET validator=?, valid=?, validated=now() WHERE id=?");
	echo $mysqli->error;
	$stmt->bind_param("iii", $userID, $messageValidation, $messageID);
	if($stmt->execute()){
		$notice = "Ok!";
	}else{
		$notice = "Error" .$stmt->error;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
}

function readallunvalidatedmessages(){
	$notice = "<ul> \n";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, message FROM vpamsg WHERE valid IS NULL ORDER BY id DESC");
	echo $mysqli->error;
	$stmt->bind_result($id, $msg);
	$stmt->execute();
	
	while($stmt->fetch()){
		$notice .= "<li>" .$msg .'<br><a href="validatemessage.php?id=' .$id .'">Valideeri</a>' ."</li> \n";
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
}

function readmsgforvalidation($editId){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE id = ?");
	$stmt->bind_param("i", $editId);
	$stmt->bind_result($msg);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = $msg;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
  }

function signin($email, $password){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, firstname, lastname, password FROM vpusers WHERE email=?");
	echo $mysqli->error;
	$stmt->bind_param("s", $email);
	$stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb, $passwordFromDb);
	if($stmt->execute()){
		//kui päring õnnestus
		if($stmt->fetch()){
			//kasutaja on olemas
			if(password_verify($password, $passwordFromDb)){
				//kui salasõna klapib
				$notice = "Logisite sisse!";
				//määran sessioonimuutujad
				$_SESSION["userId"] = $idFromDb;
				$_SESSION["userFirstName"] = $firstnameFromDb;
				$_SESSION["userLastName"] = $lastnameFromDb;
				$_SESSION["userEmail"] = $email;
				//liigume kohe main.php
				$stmt->close();
				$mysqli->close();
				header("Location: main.php");
				exit();
			}else{
				$notice = "Vale salasõna!";
			} 
		}else{
			$notice = "Kasutaja (". $email. ") ei ole olemas!" .$stmt->error;
		}
	}else{
		$notice = "Sisse logimisel tekkis viga!" .$stmt->error;
	}

	$stmt->close();
	$mysqli->close();
	return $notice;
}//sisselogimine lõppeb

function signup($name, $surname, $email, $gender, $birthDate, $password){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
	echo $mysqli->error;
	//krüpteerin parooli, kasutades juhuslikku soolamisfraasi (salting_string)
	$options = [
		"cost" => 12,
		"salt" => substr(sha1(rand()), 0, 22),
		];
	$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
	$stmt->bind_param("sssiss", $name, $surname, $birthDate, $gender, $email, $pwdhash);
	if($stmt->execute()){
		$notice = "Ok!";
	}else{
		$notice = "Error" .$stmt->error;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
}

function test_input($data) {
	//echo "Koristan!\n";
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function saveAMsg ($msg){
	//echo "Töötab";
	$notice = ""; //see on teade mis antakse salvestamise kohta
	//loome ühenduse serveriga
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//valmistame ette sql päringu
	$stmt = $mysqli->prepare("INSERT INTO vpamsg (message) VALUES(?)");
	echo $mysqli->error;
	$stmt->bind_param("s", $msg);//s-string, i-integer, d-decimal,
	if ($stmt->execute()){
		$notice = 'Sõnum: "' .$msg . '" on salvestatud!';
	}else{
		$notice = "Sõnumi salvestamisel tekkis tõrge: " . $stmt->error;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
}

function addcat ($catname, $catcolor, $cattaillength){
	//echo "Töötab";
	$notice = ""; //see on teade mis antakse salvestamise kohta
	//loome ühenduse serveriga
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//valmistame ette sql päringu
	$stmt = $mysqli->prepare("INSERT INTO kiisu (nimi, v2rvus, saba) VALUES(?, ?, ?)");
	echo $mysqli->error;
	$stmt->bind_param("ssi", $catname, $catcolor, $cattaillength);//s-string, i-integer, d-decimal,
	if ($stmt->execute()){
		$notice = 'Kiisu: "' .$catname . '" andmed on salvestatud!';
	}else{
		$notice = "Sõnumi salvestamisel tekkis tõrge: " . $stmt->error;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
}

function readallmessages(){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT message FROM vpamsg");
	echo $mysqli->error;
	$stmt->bind_result($msg);
	$stmt->execute();
	while($stmt->fetch()){
		$notice = "<p>" .$msg ."</p> \n";
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
	
}
?>