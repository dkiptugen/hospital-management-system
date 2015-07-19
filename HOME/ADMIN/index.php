<?php
session_start();
include("../../INCLUDES/definitions.php");
function __autoload($class_name)
     {
        include_once '../../CONFIGURATIONS/classes/class.' . $class_name . '.inc.php';
        #var_dump($class_name);
     }
     include("../../INCLUDES/MODULES/monitor.php");
     session_monitor($_SESSION["USERTYPE"],"../","ADMIN");
     $msg="";
     if((isset($_REQUEST["id"])==true) &&($_REQUEST["id"]==='logout')&& ($_REQUEST["auth"]===$_SESSION["un_id"]))
       {
         security::logout();
       }
       $con=DB::db_connect();
       $security=new security;
       $msg="";
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
<script type="text/javascript" src="../../JS/invalid_login.js"></script>
<script type="text/javascript">
  function reloadNames() {
    var url = "../../INCLUDES/MODULES/accounts.php?t=" + (new Date()).getTime(); //kills browser cache
    // This will make a request to names.php (code above) and put the resulting
    // text (which happens to be valid html) into the names div.
    jQuery("#invalid_log").load(url);
}
jQuery(function() {
    // Schedule the reloadNames function to run every 5 seconds.
    // So, the list of names will be updated every 5 seconds.
    setInterval(reloadNames, 3000);
});


</script>
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
       <li class="dropdown">
       <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">USER MANAGEMENT<span class="caret"></span></a>
         <ul class="dropdown-menu">
          <li><a href="index.php?id=add_user&&auth=<?php echo $_SESSION["un_id"]; ?>">ADD USERS</a></li>
          <li><a href="index.php?id=view_user&&auth=<?php echo $_SESSION["un_id"]; ?>">VIEW USERS</a></li>
          <li><a href="index.php?id=psw_mgt&&auth=<?php echo $_SESSION["un_id"]; ?>">PASSWORD MGT</a></li>
        </ul>
        </li>
        <li><a href="index.php?id=invalid_login&&auth=<?php echo $_SESSION["un_id"]; ?>">INVALID LOGINS&nbsp;<span class="badge"><b id="invalid_log"></b></span></a></li>
        <!--li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li-->
        
      </ul>
    <span class="navbar-text navbar-right">
    <b class="glyphicon glyphicon-user"></b>Welcome <a href="index.php?act=mgt&&auth=<?php echo $_SESSION["un_id"];  ?>" class="navbar-link"><?php echo $_SESSION["emp_name"]; ?></a>
     <i>&nbsp;</i><i>&nbsp;</i>
     <a href="index.php?id=logout&&auth=<?php echo $_SESSION["un_id"];  ?>"><b class="glyphicon glyphicon-log-out">Logout</b> </a>
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
            <div class="panel-body" style="padding:0 !important;">
            <?php
              $dbh=$con->prepare("select * from userdetails where id=?");
              $dbh->bindParam(1,$_SESSION["emp_id"]);
              $dbh->execute();
              $R=$dbh->fetch(PDO::FETCH_ASSOC);

              ?>
              <div class="thumbnail" style="margin:0 !important;">
                <img src="<?php echo $R["image"];  ?>" class="img-rounded" />
                <center><a href="index.php?act=mgt&&auth=<?php echo $_SESSION["un_id"];  ?>" class="navbar-link"><?php echo $_SESSION["emp_name"]; ?></a></center>
              </div>
           </div>
        </div>
       <div class="panel panel-primary">
              <ul class="nav nav-pills nav-stacked">
             <center><li class="nav-header active" style="background:rgba(75,75,75,0.4); font-weight:bold;padding:5px;color:white;border-bottom:1px solid blue;">PROFILE CHANGE</li></center>
                <li><a href="index.php?act=mgt&&auth=<?php echo $_SESSION["un_id"];  ?>">ACCOUNT INFO</a></li>
                <li><a href="index.php?act=pass&&auth=<?php echo $_SESSION["un_id"];  ?>">PASSWORD</a></li>
              </ul>
        </div>   
    </div>
    <!-- END OF LEFT CONTENT -->

    <!-- MAIN CONTENT -->
    <div class="col-md-8">
          <p>&nbsp;</p>
          <?php
          if(isset($_REQUEST["id"])||isset($_REQUEST["act"]))
            {
          echo '<div class="panel panel-default " style="background:rgba(255,255,255,0.6);">
         <!--div class="panel-heading"><h3 class="panel-title">CONTENT</h3></div-->
         <div class="panel-body">';
           if((isset($_REQUEST["id"])==true)&&($_REQUEST["auth"]==$_SESSION["un_id"]))
              {                
                include_once("../../INCLUDES/MODULES/admin.php");
                if($_REQUEST["id"]=="add_user")
                   {
                      add_user($con,$msg,$security);
                   }
                elseif($_REQUEST["id"]=="view_user")
                   {
                      view_user($con);
                   }
                elseif($_REQUEST["id"]=="psw_mgt")
                   {
                      pass_mgt($con);
                   }
                elseif($_REQUEST["id"]=="invalid_login")
                   {
                      invalid_logins($con);
                   }   
                elseif($_REQUEST["id"]=="invalid_logins")
                   {
                      user_login($con);
                   }                      
              }
            if((isset($_REQUEST["act"])==true)&&($_REQUEST["auth"]==$_SESSION["un_id"]))
              {  
                include_once("../../INCLUDES/MODULES/profile.php");
                if($_REQUEST["act"]=="mgt")
                   {
                      profile_mgt($con);
                   }
                elseif($_REQUEST["act"]=="pass")
                   {
                      pass_mgt($con,$_SESSION["username"],$msg);
                   }
              }
              echo ' </div><!--div class="panel-footer">Panel footer</div--></div>';
              }
               DB::db_close($con);
          ?>
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
      <div class="panel panel-info">
          <div class="panel-heading"><h3 class="panel-title"><center>MEMO</center></h3></div>
          <div class="panel-body">
            dsdsdfds
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

