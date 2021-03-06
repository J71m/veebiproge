<?php
	require("editideafunctions.php");
	require("functions.php");
	require("../../../config.php");
	$notice = "";

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

	if (isset($_POST["ideaButton"])) {
		updateIdea($_POST["id"], test_input($_POST["idea"]), $_POST["ideaColor"]);
		header("Location: ?id=" .$_POST["id"]);
	}
	if (isset($_GET["id"])) {
		$currentIdea = getSingleIdea($_GET["id"]);
	}
	if (isset($_GET["delete"])) {
		deleteIdea($_GET["id"]);
		header("Location: usersideas.php");
		exit();
	}
	
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


	</style>
</head>
<body style="background:#f7f7f7">
	<div class="container" style="background:white;">

		<div class="text-center">
			<h1>Mõtete leht</h1>

		</div>
		<p><a href="usersideas.php">mõtete leht</a></p>
		<p><a href="?logout=1">logout</a></p>


		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
			<input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>">
			<label>mõte: </label>
			<textarea name="idea"><?php echo $currentIdea->text; ?></textarea><br>
			<label>Mõttega seotud värv</label>
			<input type="color" name="ideaColor" value="<?php echo $currentIdea->color; ?>">
			<input type="submit" name="ideaButton" value="Saada">
			<span><?php echo $notice; ?></span>
		</form>
		<p><a href="?id=<?php echo $_GET["id"] ?>&delete=true">kustuta</a></p>

		<footer>
			<p class="text-center" style="margin-top:400px; font-size:8px">Lehel olevat materjali ei ole mõtet tõsiselt võtta</p>

		</footer>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
