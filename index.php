<?php
//script by Tasiu Kwaplong (T.K) 09031514346 Nov, 2017
session_start();
// wrote a test
if(isset($_SESSION['dms_user_login'])){
header("location: dashboard/");
}

//script by Tasiu Kwaplong (T.K) 09031514346 Feb, 2018
 require 'style/connection/connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty($_POST["useremail"]) || $_POST["useremail"] == ' ') {
     $_SESSION['my_dms_error_msg']  = "Please provide a valid Email";

  } else if (empty($_POST["userpsw"]) || $_POST["userpsw"] == ' ') {
     $_SESSION['my_dms_error_msg'] = "Password is required to sign in";
   
  }else {

    $mail = test_input2($_POST["useremail"]);

    $pass = test_input2($_POST["userpsw"]);

      
   toDB($mail, $pass); 
    
}

}


function toDB( $email, $password){
  //when this function 
global $db;

  if(mysqli_Connect_errno()){
  $_SESSION['my_dms_error_msg'] = 'Error: Could not connect to database';
 
  }

  $uname = $db->real_escape_string(htmlspecialchars ($email));
  $pword = $db->real_escape_string(htmlspecialchars($password));

   if (!$uname || !$pword){
      $_SESSION['my_dms_error_msg'] = 'Error Signing In';
      
   }else{
    //script by Tasiu Kwaplong (T.K) 09031514346
  
    @ $query1 = "select emails, psw from debt_users where emails = '$uname' and psw = '$pword' and acct_type != 'blocked' limit 1";

    $result=$db->query($query1);
    
    if ($result->num_rows == 1) {
    $_SESSION['dms_user_login']=$uname; // Initializing Session
    return @header("location: dashboard/");
  } else {
    
    $_SESSION['my_dms_error_msg'] = "Username or Password is invalid";
    $db-> close();   // Closing Connection
   return @header("location: http://localhost/debt/");
     
  }
  
}
}

function test_input2($data) {
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

          <?php if(isset($_SESSION['my_dms_error_msg'])){?>
        
         <div class="alert alert-danger alert-dismissable fade in fa fa-times-circle notpaidicon">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Error: </strong> <?php echo $_SESSION['my_dms_error_msg']; session_unset('my_dms_error_msg');?><br>
        </div>

        <?php } ?>

      <form style="margin-bottom: 10em;margin-top: 3em" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

    <div class="input-group col-xs-4">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>   
      <input id="email" type="text" class="form-control" name="useremail" placeholder="Email">
    </div>
    <br>
    <div class="input-group col-xs-4">
      <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
      <input id="password" type="password" class="form-control" name="userpsw" placeholder="Password">
    </div>

    <div class="input-group col-xs-4">
      <br>
    <input type="submit" class="btn btn-primary" value="Login" />
  </div>

  <a href="register/">Register here</a>
  </form>
</center>

    </div>
  </div>
</div>
<div class="well well-sm">
    <div appml-include-html="style/footer.html"></div>
</div>

    
</body>

</html>
