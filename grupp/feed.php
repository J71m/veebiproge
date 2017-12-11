<style>body {background-image: url("img/backgroundpic.jpg"); }
body p, body h1, body h2, body h3, body h4, body h5{
    color: white;
}
 </style>
<?php
    session_start();
    if(!isset($_SESSION["user_id"])){
		header("Location: index.php");
		exit();
    }
    require_once("Elements.php");
    require_once("classes/userinfo.class.php");
    require_once("classes/useractions.class.php");
    createHeader("Feed");
    createNavbar();
?>
<div class="container">
<h1>Feed</h1>
<?php
$currentUser = $_SESSION["user_id"];
$pdo = new PDO('mysql:host=localhost;dbname=if17_kellrasm;charset=utf8', 'if17', 'if17');
$usernameFetch = new UserInfo($currentUser,$pdo);
$stmt = $pdo->prepare("SELECT * FROM pic_group WHERE deleted IS null AND visibility<>3 ORDER BY created DESC LIMIT 20"); 
if ( false===$stmt ){
    die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$stmt->execute();
if ( false===$stmt ){
    die('execute() failed: ' . htmlspecialchars($mysqli->error));
}
$result = $stmt->fetchAll();
foreach ($result as $row){
    $userId = $row["userid"];
    $userName = $usernameFetch->getUsernameById($userId);
    echo '
    <div class="row">
    <div class="col-md-4 feedelementanim">
    <p>Kasutaja '.$userName.' lisas '.$row["created"].' pildi</p>
    <a href=photo.php?photo='.$row["filename"].'><img src="img/thumbs/'.$row["filename"].'" class="img-thumbnail" alt="Pilt"></a>
    <hr>
    </div>
    </div>
    ';
}

?>
</div>
<?php
    createFooter();
?>

<script>
var columns = document.getElementsByClassName("feedelementanim");
TweenMax.staggerFrom(columns, 0.5, {
    opacity: 0,
    scale: 0,
    delay: 0
}, 0.2);
</script>