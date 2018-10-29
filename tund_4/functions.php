 <?php
require ("../../../config.php");
//echo $GLOBALS["serverHost"];
//echo $GLOBALS["serverUsername"];
//echo $GLOBALS["serverPassword"];
$database = "if18_erkki_su_1";

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