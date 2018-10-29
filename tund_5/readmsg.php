<?php
	require("functions.php");
	$notice = readallmessages();
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
	<p>
	<?php
		echo $notice;
	?>
	</p>
</body>
</html>