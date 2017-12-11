<?php
session_start();
require_once("Elements.php");
require_once("classes/userinfo.class.php");

if(!isset($_SESSION["user_id"])){
    header("Location: index.php");
    exit();
}


//if not logged in, redirect to index page



createHeader("Profile");
createNavbar();
$profilePictureSource = "img/profile_thumb/";
$profilePictureName = "";
?>


<div class="container">
<div class="row">
<div class="col col-md-6">
<?php
//Get and print user object

$currentUser = $_SESSION["user_id"];

if(isset($_GET['username'])){
$Username = $_GET['username'];  //Get user ID from URL
}
if(!isset($_GET['username'])){
	$pdo = new PDO('mysql:host=localhost;dbname=if17_kellrasm;charset=utf8', 'if17', 'if17');
	$usr = new UserInfo($currentUser, $pdo);
	$Username = $usr->getUsername($currentUser);
	header("Location: profile.php?username=$Username");
}

$pdo = new PDO('mysql:host=localhost;dbname=if17_kellrasm;charset=utf8', 'if17', 'if17');
$info = new UserInfo($currentUser, $pdo);
$userInfo = $info->getByUsername($Username);
$userId = $info->getIdByUsername($Username);
$userPhotos = $info->getUserPhotos($userId);
if (!empty((array) $userInfo)) {
echo '<h3>Kasutaja '.$Username.' andmed</h3>';
echo '<p>Email: '.$userInfo[0]->email.' </p>';
echo '<p>Username: '.$userInfo[0]->username.' </p>';
echo '<p>Eesnimi: '.$userInfo[0]->firstname.' </p>';
echo '<p>Perekonnanimi: '.$userInfo[0]->lastname.' </p>';
echo '<p>Sugu: '.$userInfo[0]->gender.' </p>';
echo '<p>Biograafia: '.$userInfo[0]->bio.' </p>';
echo '<p>Kasutaja loodud: '.$userInfo[0]->created.' </p>';
$profilePictureName = $userInfo[0]->profile_pic;
    $imgDir = "img/";
	$picFileTypes = ["jpg", "jpeg", "png", "gif"];
	$picFiles = [];
	
	$allFiles = array_slice(scandir($imgDir), 2);
	foreach ($allFiles as $file){
		$fileType = pathinfo($file, PATHINFO_EXTENSION);
		if (in_array($fileType, $picFileTypes) == true){
			array_push($picFiles, $file);
		}
	}
	echo '<h3>Kasutaja galerii</h3>';
	foreach ($userPhotos as $row){
		echo '<a href=photo.php?photo='.$row["thumbnail"].'><img src="img/thumbs/'.$row["thumbnail"].'" class="img-thumbnail" alt="Pilt"></a>';
	}

}else{
	echo 'Ei leia selle nimega kasutajat';
}
?>
</div>


<div class="col col-md-6 text-center">
<img src="<?php 
if (!empty((array) $userInfo)){echo $profilePictureSource.$profilePictureName;}?>">
</div>
</div>
</div>

<?php
createFooter();
?>