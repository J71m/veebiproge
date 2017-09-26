<?php
  $usrEmail = "";
  $signupEmail = "";
  $usrName = "";
  $usrLastName = "";
  $gender = "";
  $signupBirthDay = null;
  $signupBirthMonth = null;
  $signupBirthYear = null;
  $signupBirthDate = null;


  if(isset($_POST["loginEmail"])) {
    $usrEmail = $_POST["loginEmail"];
  }
  if(isset($_POST["signupFirstName"])) {
    $usrName = $_POST["signupFirstName"];
  }
  if(isset($_POST["signupFamilyName"])) {
    $usrLastName = $_POST["signupFamilyName"];
  }
  if(isset($_POST["signupEmail"])) {
    $signupEmail = $_POST["signupEmail"];
  }
  if (isset($_POST["signupBirthMonth"])) {
    $signupBirthMonth = intval($_POST["signupBirthMonth"]);

  }
  //sünnikuu valik
  $monthNamesEt = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  $signupMonthSelectHTML = "";
  $signupMonthSelectHTML .= '<select name="signupBirthMonth">' ."\n";
  $signupMonthSelectHTML .= '<option value="" selected disabled>kuu</option>' ."\n";
  foreach ($monthNamesEt as $key => $month) {
    if ($key + 1 === $signupBirthMonth) {
      $signupMonthSelectHTML .= '<option value="'.($key + 1) .'" selected>' .$month ."</option> \n";
    } else {
      $signupMonthSelectHTML .= '<option value="'.($key + 1) .'">' .$month ."</option> \n";
    }

  }
  $signupMonthSelectHTML .= "</select> \n";


 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Login</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

     <!-- Optional theme -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
     <style media="screen">
       p {
         font-weight: normal;
       }

     </style>
   </head>
   <body>
    <div class="container">

      <div class="col-md-6">
       <h2>Login</h2>
       <form method="POST">
         <input style="margin:20px 0px 10px 0px" size="30" type="email" name="loginEmail" placeholder="email" value="<?php echo $usrEmail; ?>"><br>
         <input style="margin:20px 0px 10px 0px" size="30" type="password" name="loginPassword" placeholder="salasõna"><br>
         <input style="margin:20px 0px 10px 0px" type="submit" name="submitLogin" value="Sisene">
       </form>
      </div>

      <div class="col-md-6">
        <h2>Registreerimine</h2>
        <form method="POST">
          <input style="margin:20px 0px 25px 0px" size="30" type="text" name="signupFirstName" placeholder="eesnimi" value="<?php echo $usrName; ?>"><br>
          <input size="30" type="text" name="signupFamilyName" placeholder="perekonnanimi" value="<?php echo $usrLastName; ?>">
          <div class="col-sm-12; text-left">
            <br><label>sünnikuupäev</label>
            <?php
              echo $signupMonthSelectHTML;
             ?>
            <label style="margin-top:20px; margin-right:10px">Sugu:</label><br>
            <label><p>Mees</p></label><input style="margin:2px 10px 0px 5px" type="radio" name="gender" value="1">
            <label><p>Naine</p></label><input style="margin:2px 10px 0px 5px" type="radio" name="gender" value="2">
          </div>
          <div class="col-sm-12; text-left">
            <input style="margin:20px 0px 10px 0px" type="email" name="signupEmail" placeholder="email" value="<?php echo $signupEmail; ?>"><br>
            <input style="margin:20px 0px 10px 0px" type="password" name="signupPassword" placeholder="salasõna"><br>
            <input style="margin:20px 0px 10px 0px" type="submit" name="submitReg" value="Saada"><br>
          </div>
        </form>
      </div>
    </div>


     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     		<!-- Latest compiled and minified JavaScript -->
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
   </body>
 </html>
