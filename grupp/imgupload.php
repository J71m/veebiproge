<style>body {background-image: url("img/backgroundpic.jpg"); }
body p, body h1, body h2, body h3, body h4, body h5, body td, body th{
    color: white;
}
 </style>
<?php
	session_start();
	if(!isset($_SESSION["user_id"])){
		header("Location: index.php");
		exit();
	}
	require ('conn.php');
	require_once("Elements.php");
    createHeader("Piltide üleslaadimine");
    createNavbar();
	require_once ('classes/Photoupload.class.php');
	$notice = "";
	

	
	//kui logib välja
	if (isset($_GET["logout"])){
		//lõpetame sessiooni
		session_destroy();
		header("Location: index.php");
	}

	
	//Algab foto laadimise osa
	
	$target_dir = "img/pics/";
	//thumb target dir
	$thumb_dir = "img/thumbs/";
	$target_file = "";
	$uploadOk = 1;
	$imageFileType = "";
	$maxWidth = 600;
	$maxHeight = 400;
	$marginRight = 10;
	$marginBottom = 10;
	
	//Kas vajutati üleslaadimise nuppu
	if(isset($_POST["submit"]) && isset($_POST["visibility"])) {
		
		if(!empty($_FILES["fileToUpload"]["name"])){
			
			//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]))["extension"]);
			$timeStamp = microtime(1) *10000;
			$target_file = "photo_" .$timeStamp ."." .$imageFileType;

			//thumb target file
			$target_thumb = "photo_" .$timeStamp ."." .$imageFileType;
		
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				$notice .= "Fail on pilt - " . $check["mime"] . ". ";
				$uploadOk = 1;
			} else {
				$notice .= "See pole pildifail. ";
				$uploadOk = 0;
			}
		
			//Kas selline pilt on juba üles laetud
			if (file_exists($target_file)) {
				$notice .= "Kahjuks on selle nimega pilt juba olemas. ";
				$uploadOk = 0;
			}
			
			//Piirame failitüüpe
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$notice .= "Vabandust, vaid jpg, jpeg, png ja gif failid on lubatud! ";
				$uploadOk = 0;
			}
			
			//Kas saab laadida?
			if ($uploadOk == 0) {
				$notice .= "Vabandust, pilti ei laetud üles! ";
			//Kui saab üles laadida
			} else {
				
				//initialize class
				$myPhoto = new Photoupload($_FILES["fileToUpload"]["tmp_name"], $imageFileType);
				//Upload image with watermarks
				$myPhoto->resizePhoto($maxWidth, $maxHeight);
				//$myPhoto->addWatermark("graphics/watermark.png", $marginRight, $marginBottom);
				//$myPhoto->addTextWatermark("Heade mõtete veeb");
				$myPhoto->savePhoto($target_dir, $target_file);
				$myPhoto->clearImages();

				//Upload thumbnail
				$myPhoto->resizePhoto(100, 100);
				$myPhoto->savePhoto($thumb_dir, $target_thumb);
				$myPhoto->clearImages();

				unset($myPhoto);

				//salvestame andmebaasi
				$mysqli = new mysqli('localhost', 'if17', 'if17', 'if17_kellrasm');
				$stmt = $mysqli->prepare("INSERT INTO pic_group (userid, filename, thumbnail, caption, visibility) VALUES (?, ?, ?, ?, ?)");		
				echo $mysqli->error;
				$user =  $_SESSION["user_id"];
				$visibility = $_POST["visibility"];
				$caption = 'caption';
				$filenamedb =  "photo_" .$timeStamp ."." .$imageFileType;
				$thumbnamedb = "photo_" .$timeStamp ."." .$imageFileType;
				$stmt->bind_param("isssi", $user, $filenamedb, $thumbnamedb, $caption, $visibility);
				
				if ($stmt->execute()){
					echo "\n Õnnestus!";
				} else {
					echo "\n Tekkis viga : " .$stmt->error;
				}
				$stmt->close();
				$mysqli->close();
			}
		
		} else {
			$notice = "Palun valige kõigepealt pildifail!";
		}
	}
	
	/*
	function resize_image($image, $origW, $origH, $w, $h){
		$dst = imagecreatetruecolor($w, $h);
		imagecopyresampled($dst, $image, 0, 0, 0, 0, $w, $h, $origW, $origH);
		return $dst;
	}
	*/
	
	
?>
<body>
	<div class="container">
	<form action="imgupload.php" method="post" class="col-md-5" enctype="multipart/form-data">
	<div class="form-group anim">
	<h3>Piltide galeriisse üleslaadimine</h3>
		<label>Valige pildifail:</label>
		<div class="input-group">
		<span class="input-group-btn">
		<span class="btn btn-default btn-file">
		Browse... <input type="file" name="fileToUpload" id="fileToUpload">
		</span>
		</span>
		<input type="text" class="form-control" readonly>
		</div>
		<img id='img-upload'/>
		</div>
		<div class="form-group anim">
  			<label for="visibility">Nähtavus:</label>
  			<select class="form-control" id="visibility" name="visibility">
				<option value="1">Avalik</option>
				<option value="2">Ainult kasutajad</option>
				<option value="3">Ainult sina</option>
			</select>
		</div> 
		<input type="submit" value="Lae üles" class="btn btn-default anim" name="submit" id="submit"><span id="fileSizeError"></span>
	</form>
	<span><?php echo $notice; ?></span>


<?php
$images = glob("img/profile_pics*.{jpg,jpeg,png,gif}", GLOB_BRACE);
foreach($images as $image)
{
echo '<div class="col-md-2">';
echo '<img style="height:120px;" alt="" class="thumbnail img-responsive anim" src="'.$image.'">';
echo '</div>';
}
?>


</div>

<?php
createFooter();
?>
<script>
var columns = document.getElementsByClassName("anim");
TweenMax.staggerFrom(columns, 1.5, {
    opacity: 0,
	x: -200,
    delay: 0
}, 0.2);
</script>