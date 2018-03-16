<?php session_start(); ?>
<?php
        $msg = 1;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //when user submits the form
          if (empty($_POST["names"]) || $_POST["names"] == ' ') {
            $msg = "Your Fullname is required";
          }
          else if (empty($_POST["emails"]) || $_POST["emails"] == ' ') {
            $msg = "Your Email is required";
          } 
          else if (empty($_POST["phones"])  || $_POST["phones"] == ' ') {
            $msg = "Your phone Number is required";
          }

          //RegEx is performed here using a function test_input()
          $names = test_input($_POST["names"]);

          if (!preg_match("/^[a-zA-Z ]*$/", $names)) {
            $msg = "Only letters and white space allowed in Name<br>";
          }

      $emails = test_input($_POST["emails"]);
      if (!filter_var($emails, FILTER_VALIDATE_EMAIL)) {
        $msg = "Invalid Email format";
      }

      $phones = test_input($_POST["phoneNumber"]);
      if ($phones == '') {
        $msg = "An error occured, try again";
      }else{
        toDB($names, $emails, $phones); 
      }
    }

    function toDB($names, $emails, $phones){
      global $msg;
      require_once '../style/connection/connection.php';
      @ $db = new mysqli("$db_ghostname","$db_username","$db_password","$db_database");

      if(mysqli_Connect_errno()){
        $msg = 'Error: Could not connect to database';
      }

      $names = $db->real_escape_string(htmlspecialchars ($names));
      $emailAddr =$db->real_escape_string(htmlspecialchars ($emails));
      $phoneNumber =$db->real_escape_string(htmlspecialchars ($phones));

      if (!is_numeric($phoneNumber)) {
        $msg = "An error occured";
      }else{
        //when everything is fine
        @ $query1  = "INSERT INTO `debt_users` (`names`, `tmp_mail`, `phones`) VALUES ('$names', '$emails', '$phones')";

        $result=$db->query($query1);

        if($result){
          $msg = 2;
        }else{
        unset($phones);
        unset($emails);
          $msg = 'Phone number already registered<br>';
        }
        $db-> close();  
      }

    }

    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Debt Management System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="http://www.w3schools.com/appml/2.0.3/appml.js"></script>
</head>
<body>

<div class="well well-lg">DMS 
  <p class="pull-right">
    <a href="api-documentation/"> Api Documentation</a> | <a href="more/">More </a>| 
  </p>
</div>
<div class="container-fluid">

  <div class="row">
    <div class="col-sm-12">
      <center>
        <?php if ($msg == 1) { ?>
      <form style="margin-bottom: 10em;margin-top: 3em" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

    <div class="input-group col-xs-4">
      <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>   
      <input id="email" type="email" class="form-control" name="emails" placeholder="Email" required="">
    </div>
    <br>
    <div class="input-group col-xs-4">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>   
      <input id="names" type="text" class="form-control" name="names" placeholder="Full Name" required="">
    </div>
    <br>
    <div class="input-group col-xs-4">
      <span class="input-group-addon"><i class="glyphicon  glyphicon-phone"></i></span>
      <input id="phone" type="number" class="form-control" minlength="11" maxlength="11" name="phoneNumber"  placeholder="Phone Number" required="true" min="0">
    </div>

    <div class="input-group col-xs-4">
      <br>
    <input type="submit" class="btn btn-primary" value="Register" />
  </div>

  <a href="../">Login here</a>
  </form>
  <?php }else if($msg == 2){ ?>
     <div style="margin-bottom: 10em;margin-top: 3em" class="btn" onclick="window.location = '../'">

    <div class="input-group col-xs-4">   
      <div class="alert alert-success alert-dismissable fade in">
    <a href="../dashboard" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!</strong> Registration successful<br>An OTP(One Time Password) has been sent to: <?php echo $phones; unset($phones); unset($emails);?>
    <a href="../">Click here</a><br> to login.
  </div>  
    </div>
     
  <?php }else{
        unset($phones);
        unset($emails);
    ?>

    <div class="input-group col-xs-4 btn" onclick="window.location = '../register/'">
  <div class="alert alert-danger alert-dismissable fade in fa fa-times-circle notpaidicon">
    <a href="../register/" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error: </strong> Registration not successful: <br><?php echo $msg;?>
  </div>
</div>
<?php }?>

</center>

    </div>
  </div>
</div>

<div class="well well-sm">
    <div appml-include-html="../style/footer.html"></div>
</div>

    
</body>

</html>
