<?php
session_start();
function __autoload($class_name)
  {
   include_once '../CONFIGURATIONS/classes/class.' . $class_name . '.inc.php';
  }
include("../INCLUDES/definitions.php");
$msg="";


if(isset($_SESSION["USERTYPE"]))
  {
     users::det_user($_SESSION["USERTYPE"]);
  }
if(isset($_POST["chngpass"]))
  { 
    if($_POST["pass1"]!=$_POST["pass2"])
       {
         $msg="PASSWORD MISSMATCH";
       }
    else
       {
          $chngpass=new chngpass;
          $chngpass->username=$_SESSION["username"];
          $chngpass->password=$_POST["pass1"];
          $chngpass->usertype=$_SESSION["usertype"];
          $chngpass->id=$_SESSION["emp_id"];
          $msg=$chngpass->chngpass();
       }
  }
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<head>
<link rel="stylesheet" type="text/css" href="../CSS/login.css">
<link rel="stylesheet" type="text/css" href="../CSS/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../CSS/normalize.css">
<link rel="stylesheet" type="text/css" href="../CSS/bootstrap-theme.css">
<script type="text/javascript" src="../JS/jquery.min.js"></script>
<script type="text/javascript" src="../JS/bootstrap.min.js"></script>
</head>
<body class="container-fluid">
<div class="row" style="font-weight:bold;color:white;text-shadow:1px 1px 1px 3px black;background:rgba(85,85,85,.7);">
<div class="col-sm-3"></div>
<div class="col-sm-6 col-xs-12 "><center><h2>HOSPITAL MANAGEMENT SYSTEM</h2></center></div>
<div class="col-sm-3"></div>
</div>
<div class="row">
  <div class="col-sm-3"></div>
   <div class="col-sm-6 col-xs-12 ">
    <fieldset style="background:rgba(85,85,85,.4); margin:22% 19%; border-radius:5px; box-shadow:0px 0px 2px rgba(255,255,255,0.1);padding:20px 15px;">
    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post" role="form" class="form-horizontal" >
        <center><label class="control-label"><?php echo $msg; ?></label></center>
       <div class="form-group has-feedback">
        <label class="control-label col-sm-3">ENTER PASSWORD</label>
        <div class="col-sm-8">
         <input type="password"  autofocus="autofocus" autocomplete="off" name="pass1" class="form-control input-sm"/>
        </div>
      </div>
      <div class="form-group has-feedback">
       <label class="control-label col-sm-3">CONFIRM PASSWORD</label>
        <div class="col-sm-8">
         <input type="password"  autofocus="autofocus" autocomplete="off" name="pass2" class="form-control input-sm"/>
        </div>
     </div>
     <div class="form-group">
      <div class="col-sm-3"></div>
        <div class="col-sm-8">
        <button name="chngpass" class="btn btn-primary btn-block btn-xs">CHANGE PASSWORD</button>
        </div>
      </div>
     </div>
   </form>
   </fieldset>
  </div>
 <div class="col-sm-3"></div>
</div>
</body>
</html>

