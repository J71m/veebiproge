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
require_once("classes/comments.class.php");
require_once("classes/userinfo.class.php");
require_once("classes/useractions.class.php");
createHeader("Viewing photo");
createNavbar();

$pdo = new PDO('mysql:host=localhost;dbname=if17_kellrasm;charset=utf8', 'if17', 'if17');
$comment = new Comments($pdo);
$photo = $_GET['photo'];
$stmt = $pdo->prepare("SELECT id, userid FROM pic_group WHERE thumbnail=?");
if ( false===$stmt ){
    die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$stmt->execute(array($photo));
if ( false===$stmt ){
    die('execute() failed: ' . htmlspecialchars($mysqli->error));
}
$result = $stmt->fetch();
$photo_id = $result["id"];
$photo_userid = $result["userid"];

$currentUser = $_SESSION["user_id"];

if (isset($_POST["deleteButton"])){
        echo '<script>console.log("Delete button pressed")</script>';
        $pdo = new PDO('mysql:host=localhost;dbname=if17_kellrasm;charset=utf8', 'if17', 'if17');
        $changeUser = new UserActions($pdo);
        $changeUser->deletePhoto($_SESSION["user_id"], $photo_id);
		header("Location: profile.php?$currentUser");
}

?>

<div class="container">
<div id="deleteModal" class="modal fade" role="dialog">
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
                    <label for="deletePhoto" class="col-sm-3 control-label">Kustuta pilt?</label>
                    
                </div>
      <div class="modal-footer">
        <button type="submit" name="deleteButton" id="deleteButton" class="btn btn-primary">JAH</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Sulge</button>
        </form>
      </div>
       <!-- /form -->
    </div>
	</div>
  </div>
</div>

<?php
if(isset($_GET['photo'])){
    echo '<img class="img-rounded centered" src="img/pics/'.$photo.'"></img>';
    }

if(isset($_POST['commentButton'])){
    if(isset($_POST['comment'])){
        $comment->addComment($photo_id ,$_SESSION["user_id"], $_POST['comment']);
        }
    }
	if($_SESSION['user_id'] == $photo_userid){
	echo '<br><button type="button" class="btn btn-danger navanim centered" data-toggle="modal" data-target="#deleteModal" style="margin-top:10px;">KUSTUTA</button>';
	}
?>

<h2 style="text-align:center;">Comments</h2>
<form class="form-horizontal" role="form" action="" method="POST">
<div class="form-group">
                    <div class="col-md-12">
                        <textarea id="comment" name="comment" class="form-control centered col-md-12" required></textarea>
                    </div>
                </div>
<button type="submit" name="commentButton" id="commentButton" class="btn btn-primary centered">Lisa kommentaar</button>
</form>

<?php
    $info = new UserInfo($_SESSION["user_id"], $pdo);
    $comments = $comment->loadComments($photo_id);
    foreach ($comments as $row){
        $commentuser = $info->getUsernameById($row["user_id"]);

        echo '<div style="border:5px double #eeeeee">';
        echo '<p style="margin-bottom: 10px; text-align:center;">user: '.$commentuser.' </p>';
        echo '<p style="padding-left: 25px;text-align:center;">comment: '.$row["comment"].' </p>';
        echo '<p style="padding-left: 25px;text-align:center;">time: '.$row["comment_time"].' </p>';
        echo '</div>';
    }

?>

</div>

<?php
createFooter();
?>