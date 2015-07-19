<?php
function passd($username,$password)
  {
  	include("config.php");
  	$username=htmlspecialchars($username);
  	$password=htmlspecialchars($password);
    return security::password_hash($password,$salt);
  }
function changepassword($con)
  { 
  	$form='<form action="" method="post" class="form" role="form">';
  	$form.='<div class="form-group">NEW PASSWORD<label class="control-label col-md-2"></label><div class="col-md-3"><input type="password" name="pass1" class="form-control"/></div></div>';
  	$form.='<div class="form-group">CONFIRM PASSWORD<label class="control-label col-md-2"></label><div class="col-md-3"><input type="password" name="pass2" class="form-control"/></div></div>';
  	$form.='<div class=""><button name="changepass" class="btn-primary">LOGIN</button></div></form>';
  	if(isset($_POST["changepass"]))
  	   {
  	   	 if($_POST["pass1"]===$_POST["pass2"])
  	   	    {
              $password=passd($_SESSION["username"],$_POST["pass1"]);
              $dbh=$con->prepare("update users set password=? where staff_no=?");
              $dbh->bindParam(1,$password);
              $dbh->bindParam(2,$_SESSION["id"]);
              $dbh->execute();
              $_SESSION["USERTYPE"]=$_SESSION["usertype"];
  	   	    }
  	   	if(isset($_REQUEST["id"]))
  	   	   {
  	   	   	if($_REQUEST["id"]=="change")
  	   	   	  {
  	   	   	  	echo $form;
  	   	   	  }
  	   	   }
  	   }
  }	

function log_in($con,$username,$password)
  {
   $password=passd($username,$password);
   $dbh=$con->prepare("select * from users where username=? and password=?");
   $dbh->bindParam(1,$username);
   $dbh->bindParam(2,$password);
   $dbh->execute();
   if($dbh->rowCount()>0)
     {
     	$_ROW=$dbh->fetch(PDO::FETCH_ASSOC);
     	$_SESSION["id"]=$_ROW["staff_no"];
     	if($_ROW["passwordstatus"]==1)
     	  {
            $_SESSION["USERTYPE"]=$_ROW["usertype"];
     	  }
        else if($_ROW["passwordstatus"]==0)
          {
          	$_SESSION["usertype"]=$_ROW["usertype"];
            changepassword($con);
          }
     }
   else
     {
       $msg="Invalid Login details";
     }
  }

?>