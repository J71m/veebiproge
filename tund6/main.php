<?php
	require("functions.php");
	require ('../../../config.php');
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}

	if (isset($_GET["logout"])) {
		session_destroy();

	}

	$picsDir = "../../pics/";
	$picFileTypes = ["jpg", "jpeg", "png", "gif"];
	$picFiles = [];

	$allFiles = array_slice(scandir($picsDir), 2);
	//var_dump($allFiles);
	foreach ($allFiles as $file) {
		$fileType = pathinfo($file, PATHINFO_EXTENSION);
		if (in_array($fileType, $picFileTypes) == true) {
			array_push($picFiles, $file);
		}
	}

	//$picFiles = array_slice($allFiles, 2);


	$picCount = count($picFiles);

	$picNum = mt_rand(0,($picCount - 1));
	$picFile = $picFiles[$picNum];

	$mysqli = new mysqli($serverHost,$serverUsername, $serverPassword, $database);
	$kasutajaId = $_SESSION['userId'];
	$sql = ("SELECT * FROM vpusers WHERE id=$kasutajaId");
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
			<h1><?php
			while ($row = mysqli_fetch_array($query))
			{
				echo $row["firstname"] ." " .$row["lastname"];
			}
			 ?></h1>
		</div>
		<p><a href="?logout=1">logout</a></p>
		<p><a href="usersinfo.php">Users info</a></p>
		<p><a href="usersideas.php">mõtted</a></p>

		<img src="<?php echo $picsDir .$picFile; ?>" alt="TLÜ">
		<footer>
			<p class="text-center" style="margin-top:600px; font-size:8px">Lehel olevat materjali ei ole mõtet tõsiselt võtta</p>

		</footer>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
