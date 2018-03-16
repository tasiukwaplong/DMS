<?php
require '../../style/connection/dashboard.php'; 
if (isset($_GET['s']) && !empty($_GET['s'])) {
  $sheetName = test_input($_GET['s']);
  $msgCode = 3;
}else{
    $sheetName = '';
  $msgCode = 0;
  $msgbody = 'Sheet name not selected. Click <a data-toggle="modal" href="#myModal">here to select</a>';
}
?>
<!DOCTYPE html>
<!-- saved from url=(0054)# -->
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../../style/myjs.js"></script>
    <link rel="icon" href="https://getbootstrap.com/docs/3.3/favicon.ico">

    <title>Debt Management System</title>

    <!-- Bootstrap core CSS -->
    <link href="../../style/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../style/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../style/dashboard.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="../"><span class="glyphicon glyphicon-home"></span> HOMEPAGE</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="../manage/"><span class="glyphicon glyphicon-briefcase"></span> Manage Debt</a></li>
            <li><a href="../Settings/"><span class="glyphicon glyphicon-edit"></span> Settings</a></li>
            <li><a href="../profile/"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
            <li><a href="../logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="../"><span class="glyphicon glyphicon-check"></span> Overview <span class="sr-only">(current)</span></a></li>
            <li><a href="../create/">Create Debt Sheet</a></li>
            <li class="active"><a href="../manage/">Manage Debt</a></li>
            <li><a href="addadmin/">Add Debt Admin</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li class="active"><a href=""><span class="glyphicon glyphicon-edit"></span> Settings</a></li>
            <li><a href="">Profile Settings</a></li>
            <li><a href="">Change password</a></li>
            <li><a href="">Notifiction <span class="label label-danger">0</span></a></li>
            <li><a href="">Generate API <span class="glyphicon glyphicon-duplicate"></span> </a></li>
          </ul>


          <ul class="nav nav-sidebar">
            <li class="active"><a href=""><span class="glyphicon glyphicon-king"></span> Upgrade to pro</a></li>
          
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <div class="nav navbar-nav ">
            <div class="well well-lg">
              <center><h3 style="  text-transform: uppercase"><?php echo @test_input($_GET['s']);?></h3></center>
              <table class="table table-striped">
              <thead>
                <tr>
                  <th>
                   <span class='glyphicon glyphicon-pencil'></span>Id
                 </th>
                  <th>Name</th>
                  <th>Item</th>
                  <th>Phone</th>
                  <th>Cost</th>
                  <th>Date Collected</th>
                  <th>Return date</th>
                  <th>Additional Info</th>
                  <th></th>
                </tr>
              </thead>

              <?php
              $myFlag = itExistCheck('all_sheets', 'sheet', $sheetName);
              if ($myFlag >= 1) {
              //if it exist
                global $db;
                $query2 = "SELECT * FROM debt_sheets WHERE `sheet_name` = '$sheetName' LIMIT 10";
                $result2=$db->query($query2);
 
               $debt_sheets = $result2->num_rows;
              for($j=0; $j<$debt_sheets; $j++){
                $sheet_details = $result2->fetch_assoc();
                
                echo 
                "<tbody>
                <tr id='tr$j'>
                <td>$sheet_details[debt_id]</td>\n
                <td>$sheet_details[debtor_name]</td>\n
                <td>$sheet_details[item_collected]</td>\n
                <td>$sheet_details[debtor_phone]</td>\n
                <td>$sheet_details[item_cost]</td>\n
                <td>$sheet_details[date_collected]</td>\n
                <td>$sheet_details[date_return]</td>\n
                <td>$sheet_details[additional_info]</td>\n
                <td>
                <a href='#editForm' onclick='getTr(\"tr$j\")' title='edit'><span class='glyphicon glyphicon-pencil'></span></a>
                <a href='#myModal2' onclick='delTr(\"tr$j\")' data-toggle='modal'  title='delete entry'><span class='glyphicon glyphicon-trash' style='color:red'></span></a>
                </td>
                </tr>\n";
              }if ($debt_sheets < 1) {
                echo "
                <tbody>
                <tr>
                <td colspan='6'>No data yet for :". @test_input($_GET['s'])."
                </td>
                </tr>";
              } 

              }else{
                echo "
                <tbody>
                <tr>
                <td colspan='9'>
                <div class='alert alert-warning alert-dismissable fade in'>
                Sheet not selected:". @test_input($_GET['s'])." <br>
                <a href='../create/?s=$sheetName'>Click here </a>to create sheet
                </div
                </td>
                </tr>
                ";
              }

              
              ?>

            </tbody>
          </table>
               

            </div>
          </div>

          <div class="row">
            <div class="col-sm-8">
          <form style="margin-bottom: 10em;margin-top: 3em" method="post" action="create.php" id="editForm">
                <div class="input-group col-xs-7">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>   
      <input id="names" type="text" class="form-control" name="names" placeholder="Debtor's Name" required="">
    </div>
    <br>

    <div class="input-group col-xs-7">
      <span class="input-group-addon"><i class="  glyphicon glyphicon-briefcase"></i></span>   
      <input id="email" type="text" class="form-control" name="item" placeholder="Item Collected" required="">
    </div>
    <br>
        <div class="input-group col-xs-7">
      <span class="input-group-addon"><i class="glyphicon  glyphicon-phone"></i></span>
      <input id="phone" type="number" class="form-control" minlength="11" maxlength="11" name="phonesNumber"  placeholder="Debtor's phone" required="true">
    </div>
    <br>
    <div class="input-group col-xs-7">
      <span class="input-group-addon"><i class="  glyphicon glyphicon-piggy-bank"></i></span>
      <input id="phone" type="text" class="form-control" name="itemPrice"  placeholder="Item Cost" required="true" >
    </div>
    <br>
    <div class="input-group col-xs-7">
      <span class="input-group-addon"><i class="glyphicon glyphicon-arrow-left"></i> &nbsp;<i class="glyphicon glyphicon-calendar"></i></span>   
      <input id="names" type="text" class="form-control" name="dateCollected" placeholder="Date Collected" required="">
    </div>
    <br>
    <div class="input-group col-xs-7">
      <span class="input-group-addon"><i class="glyphicon glyphicon-arrow-right"></i> &nbsp;<i class="glyphicon glyphicon-calendar"></i></span>   
      <input id="names" type="text" class="form-control" name="returnDate" placeholder="Agreed return date" required="">
    </div>
    <br>
    <div class="input-group col-xs-7">
      <span class="input-group-addon"><i class="glyphicon glyphicon-exclamation-sign"></i></span>   
      <textarea id="names" class="form-control" name="addInfo" placeholder="Additional Info" ></textarea>
    </div>

    <div class="input-group col-xs-7" style="margin-left: 50px">
      <br>
      <?php if($msgCode == 0){?>
      <div class="alert alert-danger alert-dismissable fade in fa fa-times-circle notpaidicon">
    <a href="../create/" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error: </strong> <?php echo $msgbody;?><br>
  </div>
        <?php } else if($msgCode == 1 || isset($_GET['success'])){?>
        <input type="hidden" name="sheeetName" value="<?php echo $sheetName;?>">
      <input type="submit" class="btn btn-primary" value="Add +" />
      <br>
      <br>
      <div class="alert alert-success alert-dismissable fade in">
    <a href="../create/" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!</strong> Added to sheet successfully
   <a data-toggle="modal" href="#myModal">Click here</a> to change sheet.
  </div>  

          <?php }else if($msgCode == 3){?>
          <input type="hidden" name="sheeetName" value="<?php echo $sheetName;?>">
      <input type="submit" class="btn btn-primary" value="Update" />
      <?php }?>
  </div>

  </form>
</div>
<div class="col-sm-4">
 
<form  method="post" action="create.php">
  <h2>Sheet Settings <span class="glyphicon glyphicon-wrench"></span></h2>
  <div class="input-group col-xs-7" title="Add another account to manage this sheet">
      <input id="names" type="text" class="form-control" name="names" placeholder="Co-admin email" required="">
      <button type="submit">
      <span class="input-group-addon"><i class="glyphicon glyphicon-plus"></i>&nbsp;<i class="glyphicon glyphicon-plus glyphicon-user"></i></span>
    </button>
    </div>
   
    </form>

    <form style="margin-bottom: 10em;margin-top: 3em" method="post" action="create.php">
  <div class="input-group col-xs-7" title="Delete co-admin account email from list">
      <select id="names" name="s" class="form-control" name="" required="">
              <option value="">make a selection</option>
            </select>
            <button type="submit">
             <span class="input-group-addon">
             <i class="glyphicon glyphicon-trash"></i>
              <i class="glyphicon glyphicon-user"></i>
            </span>            
            </button>
    </div>
    </form>


</div>
</div>
  <!--modal start here-->

  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Select sheet</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create / Select Sheet</h4>
        </div>
        <div class="modal-body">
    
          <div class="input-group col-xs-12">
            <form  method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <select id="names" name="s" class="form-control" name="" required="">
              <option value="">make a selection</option>
              <?php
              $all_sheets = $result->num_rows;
              $sheet = "<option value='Enter'>Enter Sheet Name</option>";

              for($i=0; $i<$all_sheets; $i++){
                $DisplaySheet = $result->fetch_assoc();            
                $sheet .= "<option value='$DisplaySheet[sheet]'>$DisplaySheet[sheet]</option>";
              
              }
              echo $sheet;
              ?>
            </select>
            <br><br>
            <input type="submit" class="btn btn-primary" value="Proceed" />
          </form>
    </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!--modal stop here-->

  <!-- Modal -->
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirm Action !!</h4>
        </div>
        <div class="modal-body">
    
          <div class="input-group col-xs-12">
            <form  method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            You are about to delete data from sheet??
            <br><br>
            <input type="submit" class="btn btn-primary" value="Proceed" />
          </form>
    </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!--modal stop here-->
  
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./Dashboard Template for Bootstrap_files/jquery.min.js.download">

    </script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="./Dashboard Template for Bootstrap_files/bootstrap.min.js.download"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="./Dashboard Template for Bootstrap_files/holder.min.js.download"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./Dashboard Template for Bootstrap_files/ie10-viewport-bug-workaround.js.download"></script>
  

</body></html>