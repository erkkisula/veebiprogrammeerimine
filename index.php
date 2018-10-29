<?php
	//echo "Siin on minu esimene PHP";
	$name = "Erkki";
	$surname = "Sula";
	$todayDate = date("d.m.Y");
	$hourNow = date("H");
	//echo $hourNow;
	$partOfDay = "";
	if ($hourNow < 8){
		$partOfDay = "Varajane Hommik";
	}
	if ($hourNow >= 8 and $hourNow < 16){
		$partOfDay = "Kooliaeg";
	}
	if ($hourNow >= 16){
		$partOfDay = "Vabaaeg";
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
	?>
	lehekülg</title>
</head>
<body>
	<h1>
		<?php
			echo $name ." " .$surname . " " ."lehekülg";
		?>
	</h1>
	<p>Siin on minu <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames valminud veebilehed. See ei oma mingit sisu ja nende kopeerimine ei oma mõtet.</p>
	<p>Kes elab metsa sees? 
	Kes elab paksu metsa sees?
	Kes elab metsa sees? </p>
	<!--<img src="http://greeny.cs.tlu.ee/~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_1.jpg" alt="TLÜ Terra õppehoone">-->
	<img src="../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_1.jpg" alt="TLÜ Terra õppehoone">
	<p>Mul on sõber, kes ka teeb <a href="../../~maksjel" target="_blank">veebi</a>.</p>
	<?php
		echo "<p>Tänane kuupäev on: " .$todayDate ."</p> \n";
		echo "<p>Lehe avamise hetkel oli kell " .date("H:i:s") .", käes on " .$partOfDay .".</p> \n";
	?>
</body>
</html>