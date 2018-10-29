<?php
	//echo "Siin on minu esimene PHP";
	$name = "Erkki";
	$surname = "Sula";
	$dirToRead = "../../pics/";
	$allFiles = array_slice(scandir($dirToRead), 2);
	//var_dump($allFiles);
	
	$picNum = mt_rand(1,4);
	$picURL = "../../pics/tlu_";
	$picEXT = ".jpg";
	$picNAM = $picURL .$picNum .$picEXT;
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
		echo " kodunetöö";
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
	
	<img src="<?php echo $picNAM; ?>" alt="Suvaline pilt">
	
	<?php
		#for($i = 0; $i < count($allFiles); $i ++){
		#	echo '<img src="' .$dirToRead .$allFiles[$i] .'" alt="pilt"><br>';
		#}
		

	?>
</body>
</html>