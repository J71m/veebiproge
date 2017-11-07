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
 	$notice = "";
	$success = "";

	$picsDir = "../../pics/";
	$picFileTypes = ["jpg", "jpeg", "png", "gif", "PNG", "JPG", "JPEG", "GIF"];
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

	function resizeImage($image, $origW, $origH, $w, $h){
		$newImage = imagecreatetruecolor($w, $h);
		imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $origW, $origH);
		return $newImage;
	}

	//pildi laadimine
	$target_dir = "../../pics/";
	$target_file = "";
	$uploadOk = 1;
	$imageFileType = "";

	$maxWidth = 600;
	$maxHeight = 400;
	$marginBottom = 10;
	$marginRight = 10;
if (isset($_POST["submit"])) {
	if (!empty($_FILES["fileToUpload"]["name"])) {
		
		$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));

		$timeStamp = microtime(1) * 10000;

		$target_file = $target_dir . pathinfo(basename($_FILES["fileToUpload"]["name"]))["filename"] ."_" .$timeStamp ."." .$imageFileType;	



		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	    if($check !== false) {
	        $notice .= "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        $notice .= "File is not an image.";
	        $uploadOk = 0;
	    }

			//check if exists
		if (file_exists($target_file)) {
		$notice .= "Pilt on juba olemas. ";
		$uploadOk = 0;
		}

			 // Check file size
		if ($_FILES["fileToUpload"]["size"] > 2000000) {
				$notice .= "Pilt on liiga suur. ";
				$uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "GIF") {
				$notice .= "Ainult JPG, JPEG, PNG & GIF on lubatud. ";
				$uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
				$notice .= "Pilti ei laetud üles. ";
		// if everything is ok, try to upload file
		} else {
				/*if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
						$notice = "Pilt ". basename( $_FILES["fileToUp[load"]["name"]). " on üles laetud.";
				} else {
						$notice .= "Pildi üleslaadimisel tekkis probleem";
				}*/

				if ($imageFileType=="jpg" or $imageFileType == "jpeg") {
					$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
				}
				if ($imageFileType=="png") {
					$myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
				}
				if ($imageFileType=="gif") {
					$myTempImage = imagecreatefromgif($_FILES["fileToUpload"]["tmp_name"]);
				}

				$imageWidth = imagesx($myTempImage);
				$imageHeight = imagesy($myTempImage);
				if ($imageWidth>$imageHeight) {
					$sizeRatio = $imageWidth / $maxWidth;
				} else{
					$sizeRatio = $imageHeight / $maxHeight;
				}
				$myImage = resizeImage($myTempImage, $imageWidth, $imageHeight, round($imageWidth / $sizeRatio), round($imageHeight / $sizeRatio));

				//watermark

				$stamp = imagecreatefrompng("hmv_logo.png");
				$stampWidth = imagesx($stamp);
				$stampHeight = imagesy($stamp);
				$stampPosX = round($imageWidth / $sizeRatio) - $stampWidth - $marginRight;
				$stampPosY = round($imageHeight / $sizeRatio) - $stampHeight - $marginBottom;
				imagecopy($myImage, $stamp, $stampPosX, $stampPosY, 0, 0, $stampWidth, $stampHeight);

				//tekst
				$textToImage = "LULUL";
				$textColor = imagecolorallocatealpha($myImage, 255, 255, 255, 100);
				imagettftext($myImage, 20, 0, 10, 25, $textColor, "OpenSans-Regular.ttf", $textToImage);

				//faili salvestamine
				if ($imageFileType=="jpg" or $imageFileType == "jpeg") {
					if (imagejpeg($myImage, $target_file, 91)) {
						$notice = "Fail: ".$_FILES["fileToUpload"]["name"] ." laeti üles";
					}else{
						$notice = "Faili üleslaadimine ebaõnnestus";
					}
				}
				if ($imageFileType=="png") {
					if (imagepng($myImage, $target_file, 6)) {
						$notice = "Fail: ".$_FILES["fileToUpload"]["name"] ." laeti üles";
					}else{
						$notice = "Faili üleslaadimine ebaõnnestus";
					}
				}
				if ($imageFileType=="gif") {
					if (imagegif($myImage, $target_file)) {
						$notice = "Fail: ".$_FILES["fileToUpload"]["name"] ." laeti üles";
					}else{
						$notice = "Faili üleslaadimine ebaõnnestus";
					}
				}

				imagedestroy($myTempImage);
				imagedestroy($myImage);
				imagedestroy($stamp);
		}
	}else{
		$notice .= "Vali pildifail!";
	}
	

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

		<form action="main.php" method="post" enctype="multipart/form-data">
				<label for="fileToUpload">Vali uus pilt üleslaadimiseks:</label>
				<div class="form-group">
				<input type="file" name="fileToUpload" id="fileToUpload">
				</div>
				<input type="submit" value="Lae üles" name="submit">
		</form>

		<p><?php echo $notice; ?></p>

		<img src="<?php echo $picsDir .$picFile; ?>" alt="pilt">
		<footer>
			<p class="text-center" style="margin-top:400px; font-size:8px">Lehel olevat materjali ei ole mõtet tõsiselt võtta</p>

		</footer>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
