<?php 
	session_start();
	if (isset($_SESSION["userId"])) {
		header("Location: main.php");
		exit();
	}
	require("functions.php");
	require("conn.php");
	require("config.php");
	$a = hash("sha512", "asdf1234");
	//echo $a;
	$loginFirstName = "";
	$loginFamilyName = "";
	$gender = "";
	$loginEmail = "";
	$loginBirthDay = null;
	$loginBirthMonth = null;
	$loginBirthYear = null;
	$loginBirthDate = "";

	$notice = "";

	$loginFirstNameError = "";
	$loginFamilyNameError = "";
	$loginBirthDayError = "";
	$loginGenderError = "";
	$loginEmailError = "";
	$loginPasswordError = "";

	if (isset($_POST["signinButton"])) {
		# code...

	//kas on kasutajanimi sisestatud
		if (isset ($_POST["loginEmail"])){
			if (empty ($_POST["loginEmail"])){
				$loginEmailError ="NB! Sisselogimiseks on vajalik kasutajatunnus (e-posti aadress)!";
			} else {
				$loginEmail = $_POST["loginEmail"];
			}
		}
	}
	if (!empty($loginEmail) and !empty($_POST["loginPassword"])) {
		//echo "sisse logimine";
		$notice = signIn($loginEmail, $_POST["loginPassword"]);
	}



?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form method="POST" action="">
		<label>Kasutajanimi (E-post): </label>
		<input name="loginEmail" type="email" value="<?php echo $loginEmail; ?>">
		<br><br>
		<input name="loginPassword" placeholder="Salasõna" type="password"><span></span>
		<br><br>
		<input name="signinButton" type="submit" value="Logi sisse"><span><?php echo $notice; ?></span>
	</form>
</body>
</html>