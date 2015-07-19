<?php
session_start();
include("../../INCLUDES/definitions.php");
function __autoload($class_name)
     {
        include_once '../../CONFIGURATIONS/classes/class.' . $class_name . '.inc.php';
        #var_dump($class_name);
     }
     include("../../INCLUDES/MODULES/monitor.php");
     session_monitor($_SESSION["USERTYPE"],"../","DOCTOR");
     if((isset($_REQUEST["id"])==true) &&($_REQUEST["id"]==='logout')&& ($_REQUEST["auth"]===$_SESSION["un_id"]))
       {
         security::logout();
       }
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<head>
<link rel="stylesheet" type="text/css" href="../../CSS/main.css">
<link rel="stylesheet" type="text/css" href="../../CSS/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../../CSS/normalize.css">
<link rel="stylesheet" type="text/css" href="../../CSS/bootstrap-theme.css">
<script type="text/javascript" src="../../JS/jquery.min.js"></script>
<script type="text/javascript" src="../../JS/timer.js"></script>
<script type="text/javascript" src="../../JS/bootstrap.min.js"></script>
<title></title>
</head>
<body>
<!--$TART OF NAVIGATION  -->
<div class="row">
 <nav class="navbar navbar-default navbar-static-top navbar-collapse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
        <img alt="" src="...">HOSPITAL MANAGEMENT SYSTEM
      </a>
    </div>
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
     <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
     <li><a href="#">Link</a></li>
     <li class="dropdown">
       <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
         <ul class="dropdown-menu">
          <li><a href="#">Action</a></li>
          <li><a href="#">Another action</a></li>
          <li><a href="#">Something else here</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="#">Separated link</a></li>  
          <li role="separator" class="divider"></li>
          <li><a href="#">One more separated link</a></li>
         </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav">
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
        
      </ul>
    <span class="navbar-text navbar-right">
    <b class="glyphicon glyphicon-user"></b> Welcome <a href="#" class="navbar-link"><?php echo $_SESSION["emp_name"]; ?></a>
     <i>&nbsp;</i><i>&nbsp;</i>
     <a href="index.php?id=logout&&auth=<?php echo $_SESSION["un_id"]; ?>"><b class="glyphicon glyphicon-log-out"> Logout</b> </a>
     <i>&nbsp;</i><i>&nbsp;</i>
    </span>
    
    </div>
  </div>
</nav>
</div>
<!-- END OF NAVIGATION  -->
<div class="clearfix"></div>
<!-- START OF CONTENT-->
<div class="row">
  <div class="container-fluid">
  <!--LEFT CONTENT -->
    <div class="col-sm-2">
       <div class="panel panel-primary ">
           <div class="panel-heading"><h4 class="panel-title">SUB MENU</h4></div>
           <div class="panel-body">
              Basic panel example
           </div>
           <!--div class="panel-footer">Panel footer</div-->
       </div>
    </div>
    <!-- END OF LEFT CONTENT -->

    <!-- MAIN CONTENT -->
    <div class="col-md-8">
      <div class="panel panel-default ">
         <!--div class="panel-heading"><h3 class="panel-title">CONTENT</h3></div-->
         <div class="panel-body">
           Basic panel example
         </div>
         <!--div class="panel-footer">Panel footer</div-->
      </div>
    </div>
    <!-- END OF MAIN CONTENT -->

    <!-- RIGHT CONTENT -->
    <div class="col-sm-2">
       <div class="panel panel-primary">
          <div class="panel-heading"><h3 class="panel-title"><center>TIME</center></h3></div>
          <div class="panel-body" style="background:rgba(75,75,75,.3);">
            <center><p id="timer" style="font-weight:bold; color:gold; text-shadow:black 1px 1px 1px,black 1px 1px 1px,black 1px 1px 1px,white 1px 1px 1px; font-size:18pt;"></p></center>
          </div>
      </div>
    </div>
    <!-- END OF LEFT CONTENT -->

   
  </div>
 </div>
<div class="row">
 <hr /> 
  <div class="container-fluid" style="background:rgba(255,255,255,.5); padding:10px 100px; font-weight:bold;">
       
         &copy;CopyRight 2015 HOSPITAL MANAGEMENT SYSTEM. ALL RIGHTS RESERVED
      
  </div>
</div>
</body>
</html>

