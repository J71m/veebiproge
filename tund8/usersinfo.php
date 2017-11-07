<?php
	require("functions.php");
	require("../../../config.php");

	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}

	if (isset($_GET["logout"])) {
		session_destroy();
	}
	$mysqli = new mysqli($serverHost,$serverUsername, $serverPassword, $database);
	$sql = ('SELECT * FROM vpusers');
	$query = mysqli_query($mysqli,$sql);
	$mysqli->close();

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
		<p><a href="?logout=1">logout</a></p>
		<table border="1" style="border-collapse: collapse;">
			<tr>
				<th>Eesnimi</th>
				<th>Perekonnanimi</th>
				<th>email</th>
				<th>sünnikuupäev</th>
				<th>sugu</th>
			</tr>
			<tr>
				<?php
				while ($row = mysqli_fetch_array($query))
				{
					if ($row["gender"]==1) {
						$sugu = "mees";
					}else {
						$sugu = "naine";
					}
					echo '' .'<tr>
						<td>'.$row['firstname'].'</td>
						<td>'.$row['lastname'].'</td>
						<td>'.$row['email'].'</td>
						<td>'.$row['birthday'].'</td>
						<td>'.$sugu.'</td>';


				}

				?>
			</tr>
		</table>


		<footer>
			<p class="text-center" style="margin-top:600px; font-size:8px">Lehel olevat materjali ei ole mõtet tõsiselt võtta</p>

		</footer>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
