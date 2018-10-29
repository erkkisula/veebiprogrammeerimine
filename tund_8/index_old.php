<?php
	//echo "Siin on minu esimene PHP";
	$name = "Erkki";
	$surname = "Sula";
	$weekDay = date("N");
	$hourNow = date("H");
	$monthNow = date("m");
	//echo $hourNow;
	$partOfDay = "";
	$weekDayNamesET = ["Esmaspäev", "Teisipäev", "Kolmapäev", "Neljapäev", "Reede", "Laupäev", "Pühapäev"];
	//var_dump($weekDayNamesET);
	//echo $weekDayNamesET[0];
	$monthNamesET = ["Jaanuar", "Veebruar", "Märts", "Aprill", "Mai", "Juuni", "Juuli", "August", "September", "Oktoober", "November", "Detsember"]; //array mis sätib paika kuud
	$todayDate = date("d. ") .$monthNamesET[$monthNow -1] .date(" Y"); //näiteks 09. September 2018
	if ($hourNow < 8){
		$partOfDay = "Varajane Hommik";
	}
	if ($hourNow >= 8 and $hourNow < 16){
		$partOfDay = "Kooliaeg";
	}
	if ($hourNow >= 16){
		$partOfDay = "Vabaaeg";
	}	
	
	//loosime juhusliku pildi
	$picNum = mt_rand(2, 43);//random
	//echo $picNum
	$picURL = "http://www.cs.tlu.ee/~rinde/media/fotod/TLU_600x400/tlu_";
	$picEXT = ".jpg";
	$picFName = $picURL .$picNum .$picEXT;
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
			echo $name ." " .$surname . " " ."lehekülg";
		?>
	</h1>
	<p>Siin on minu <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames valminud veebilehed. See ei oma mingit sisu ja nende kopeerimine ei oma mõtet.</p>
	<p>Kes elab metsa sees? 
	Kes elab paksu metsa sees?
	Kes elab metsa sees? </p>
	<!--<img src="http://greeny.cs.tlu.ee/~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_1.jpg" alt="TLÜ Terra õppehoone">-->
	<img src="../../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_1.jpg" alt="TLÜ Terra õppehoone">
	<p>Mul on sõber, kes ka teeb <a href="../../../~maksjel" target="_blank">veebi</a>.</p>
	
	<img src="<?php echo $picFName; ?>" alt="Suvaline pilt Tallinna Ülikoolist">
	
	<?php
		echo "<p>Täna on " .$weekDayNamesET[$weekDay -1] .", " .$todayDate ."</p> \n";
		//echo $monthNamesET[$monthNow -1] ."\n";
		echo "<p>Lehe avamise hetkel oli kell " .date("H:i:s") .", käes on " .$partOfDay .".</p> \n";
	?>
</body>
</html>