<?php
require_once("classes/userinfo.class.php");

function createHeader($siteTitle){
echo'
<!DOCTYPE html>
<html lang="et-EE">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>'.$siteTitle.'</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/swiper.min.css">
        <link href="https://fonts.googleapis.com/css?family=Old+Standard+TT" rel="stylesheet"> 
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    </head>
    <body>
';
}

function createFooter(){
echo'
    <script src="js/script.js"></script>
    <script src="js/swiper.min.js"></script>
    </body>
</html>
    ';
}

function createNavbar(){
    if (isset($_SESSION["user_id"])) {
        //Get logged in user's email
        $pdo = new PDO('mysql:host=localhost;dbname=if17_kellrasm;charset=utf8', 'if17', 'if17');
        $info = new UserInfo($_SESSION["user_id"], $pdo);
        $userEmail = $info->getEmail();
		$userName = $info->getUsername();
    echo'
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand navanim" href="#">Grupitöö</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="navanim"><a href="feed.php">Avaleht</a></li>
            <li class="navanim"><a href="profile.php">Profiil</a></li>
            <li class="navanim"><a href="users.php">Kasutajad</a></li>
            <li class="navanim"><a href="imgupload.php">Lisa pilte</a></li>
        </ul>
        <p class="navbar-text" style="float: right">Sisse logitud : <a href="profile.php">'.$userName.'</a></p>
        <form id="signout" class="navbar-form navbar-right" role="form" method="POST" action="">
        <button type="submit" class="btn btn-primary navanim" name="signoutButton">Log out</button>
        </form>
        </div>
    </nav>
        ';
        }else{
        echo'
        <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand navanim" href="#">Grupitöö</a>
          </div>
          <ul class="nav navbar-nav">
              <li class="navanim"><a href="index.php">Sisse logimine</a></li>
          </ul>
        <form id="signin" class="navbar-form navbar-right" role="form" method="POST" action="">
        <div class="input-group navanim">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input id="loginEmail" type="email" class="form-control" name="loginEmail" value="" placeholder="Email Address" required>                                        
        </div>

        <div class="input-group navanim">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input id="loginPassword" type="password" class="form-control" name="loginPassword" value="" placeholder="Password" required>                                        
        </div>

        <button type="submit" class="btn btn-primary navanim" name="signinButton">Login</button>
        <button type="button" class="btn btn-default navanim" data-toggle="modal" data-target="#registerModal">Registreeri</button>
    </form>
    </div>
    </nav> 
    ';
    }
    if (isset($_POST["signoutButton"])){
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
?>