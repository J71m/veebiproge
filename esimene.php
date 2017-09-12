<?php
	//kommentaar
	$myName = "Tim";
	$myFamilyName = "Jaanson";
	//kellaaeg
	$hourNow = date("H");
	$partOfDay = "";
	
	if ($hourNow < 8) {
		$partOfDay = "Varajane hommik";
	}elseif ($hourNow >= 8 and $hourNow < 16) {
		$partOfDay = "Koolipäev";
	}else{
		$partOfDay = "vaba aeg";
	}
	
	$timeNow = strtotime(date("d.m.Y H:i:s"));
	//echo $timeNow;
	$schoolDayEnd = strtotime(date("d.m.Y" . " " ."15:45"));
	$toTheEnd = $schoolDayEnd - $timeNow;
	echo (round($toTheEnd / 60));
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title> ­</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<style media="screen">
		p {
			color:black;
		}

	</style>
</head>
<body style="background:#f7f7f7">
	<div class="container" style="background:white;">

		<div class="text-center">
			<h1>Veebiprogrammeerimine</h1>
		</div>

		<div>
			<br><br><br>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce non posuere libero, et sollicitudin diam. Nullam accumsan nisi porta diam fermentum, vel pretium velit eleifend. Vivamus tempor justo nec massa bibendum rhoncus.</p>
			<p>Quisque gravida, tellus eget volutpat venenatis, sapien ligula dignissim massa, molestie iaculis nibh arcu id libero. Curabitur eu turpis ligula. Quisque ac gravida est, non maximus lorem. Nunc dapibus bibendum tellus, in porttitor leo tincidunt et. Vestibulum semper malesuada nibh, ut fermentum leo tempor sed. Vivamus justo felis, lacinia nec fringilla nec, congue sit amet nunc. Sed nisi magna, tempor at lobortis tincidunt, aliquet vitae nibh.</p>
			
		</div>
		
		
		
		<?php
		echo "<br><br>";
		echo "<p>Täna on ".date("d.m.Y").", kell lehe avamisel oli " .date("H:i:s");
		echo "</p>";
		print $myName." ".$myFamilyName;
		echo "<br>Käes on ". $partOfDay ."</p>";
		
		?>






		<footer>
			<p class="text-center" style="margin-top:600px; font-size:8px">Lehel olevat materjali ei ole mõtet tõsiselt võtta</p>
		</footer>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
