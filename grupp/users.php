<style>body {background-image: url("img/backgroundpic.jpg"); }
body p, body h1, body h2, body h3, body h4, body h5, body td, body th{
    color: white;
}
.table tbody tr:hover td, .table tbody tr:hover th {
    background-color: #000000;
}
 </style>
<?php
session_start();
if(!isset($_SESSION["user_id"])){
    header("Location: index.php");
    exit();
}
require_once("classes/userinfo.class.php");
require_once("Elements.php");
//if not logged in, redirect to index page

createHeader("Users");
require("functions.php");
createNavbar();
?>

<div class="container">
<h2>Users</h2>
<table class="table table-hover">
<thead>
    <tr>
        <th>Kasutaja</th>
        <th>Eesnimi</th>
        <th>Perekonnanimi</th>
        <th>Sugu</th>
        <th>Profiil</th>
    </tr>
</thead>
<tbody>

<?php
$userId = $_SESSION["user_id"];
$pdo = new PDO('mysql:host=localhost;dbname=if17_kellrasm;charset=utf8', 'if17', 'if17');
$info = new UserInfo($userId, $pdo);
$list = $info->getUserList();
foreach ($list as $row){
	if ($row["gender"] == 1){
		$row["gender"] = "mees";
	}else if ($row["gender"] == 2){
		$row["gender"] = "naine";
	}else{
		$row["gender"] = "salajane";
	}
    echo '<tr class="anim">';
    echo '<td> '.$row["username"].' </td>';
    echo '<td> '.$row["firstname"].' </td>';
    echo '<td> '.$row["lastname"].' </td>';
    echo '<td> '.$row["gender"].' </td>';
    echo '<td> <a href="profile.php?username='.$row["username"].'"><button type="button" class="btn btn-sm btn-default">Vaata profiili</button></a> </td>';
    echo '</tr>';
}
?>

</tbody>
</table>
</div>

<?php
createFooter();
?>
<script>
var columns = document.getElementsByClassName("anim");
TweenMax.staggerFrom(columns, 0.3, {
    opacity: 0,
    delay: 0
}, 0.1);
</script>