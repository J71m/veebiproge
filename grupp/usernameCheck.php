<?Php
//Get Username
@$user=$_GET['user'];
//Require PDO connection
require "conn.php";
//Select all diameters categorized under selected wood ID
$sql="SELECT username FROM user_group WHERE username='$user'";
$row=$bdd->prepare($sql);
$row->execute();
$result=$row->fetchAll(PDO::FETCH_ASSOC);

$main = array('data'=>$result);
echo json_encode($main);
?>