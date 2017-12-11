<style>
body {
    background-image: url("img/backgroundprof.jpg"); 
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    height:100%;
    width:100%;
}
body p, body h1, body h2, body h3, body h4, body h5{
    color: white;
}
</style>
<?php
session_start();
require_once("Elements.php");
require_once("classes/userinfo.class.php");
require_once("classes/useractions.class.php");

if(!isset($_SESSION["user_id"])){
    header("Location: index.php");
    exit();
}

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
//if not logged in, redirect to index page



createHeader("Profile");
createNavbar();
$profilePictureSource = "img/profile_thumb/";
$profilePictureName = "";

if (isset($_POST["changeButton"])){
        echo '<script>console.log("Change button pressed")</script>';
    if (isset ($_POST["changeFirstname"]) && isset ($_POST["changeLastname"]) && isset ($_POST["changeGender"]) && isset ($_POST["changeBio"])){
        echo '<script>console.log("All field values present")</script>';
        $pdo = new PDO('mysql:host=localhost;dbname=if17_kellrasm;charset=utf8', 'if17', 'if17');
        $changeUser = new UserActions($pdo);
        $changeUser->changeProfile($_SESSION["user_id"], $_POST["changeFirstname"], $_POST["changeLastname"], $_POST["changeGender"], $_POST["changeBio"]);
		header("Location: profile.php?$currentUser");
    }
}
?>
<div class="container">
<div id="profileModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Uuenda kasutaja andmeid</h4>
      </div>
      <div class="modal-body">
            <form class="form-horizontal" role="form" action="" method="POST">
                <div class="form-group">
                    <label for="changeFirstName" class="col-sm-3 control-label">Eesnimi</label>
                    <div class="col-sm-9">
                        <input type="text" id="changeFirstname" name="changeFirstname" class="form-control" value=<?php echo $userInfo[0]->firstname ?>  required>
                    </div>
                </div>
                <div class="form-group">
                <label for="changeLastname" class="col-sm-3 control-label">Perekonnanimi</label>
                <div class="col-sm-9">
                    <input type="text" id="changeLastname" name="changeLastname" class="form-control" value=<?php echo $userInfo[0]->lastname ?>  required>
                </div>
                </div>
                <div class="form-group">
                    <label for="changeGender" class="col-sm-3 control-label">Sugu</label>
                    <div class="col-sm-9">
                    <select class="form-control" name="changeGender" id="changeGender" required>
                        <option value=1>Mees</option>
                        <option value=2>Naine</option>
                        <option value=3>Ei avalda</option>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="changeBio" class="col-sm-3 control-label">Biograafia</label>
                    <div class="col-sm-9">
                        <textarea id="changeBio" name="changeBio" class="form-control" required><?php echo $userInfo[0]->bio ?></textarea>
                    </div>
                </div>
          </div>
      <div class="modal-footer">
        <button type="submit" name="changeButton" id="changeButton" class="btn btn-primary">Uuenda</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Sulge</button>
        </form>
      </div>
       <!-- /form -->
    </div>

  </div>
</div>
<div class="row">
<div class="col col-md-6">
<?php
//Get and print user object


if (!empty((array) $userInfo)) {

if ($userInfo[0]->gender == 1){
	$userInfo[0]->gender = "mees";
}else if ($userInfo[0]->gender == 2){
	$userInfo[0]->gender = "naine";
}else{
	$userInfo[0]->gender = "salajane";
}


$pdo2 = new PDO('mysql:host=localhost;dbname=if17_kellrasm;charset=utf8', 'if17', 'if17');
$currentUsernameFetch = new UserInfo($currentUser,$pdo2);
$currentUsername = $currentUsernameFetch->getUsernameById($currentUser);


if($currentUsername == $_GET["username"]){
echo '<button type="button" class="btn btn-primary navanim" data-toggle="modal" data-target="#profileModal">Redigeeri Profiili</button>';
}
echo '<h3>'.$Username.'</h3>';
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
        echo '
        <div class="col-md-4">
        <a href=photo.php?photo='.$row["thumbnail"].'><img src="img/thumbs/'.$row["thumbnail"].'" class="img-thumbnail" alt="Pilt"></a>
        </div>
        ';
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
