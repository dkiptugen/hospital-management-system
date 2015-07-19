<?php
function profile_mgt($con)
   {
  	echo "profile online";
   }
 function pass_mgt($con,$username,$msg)
   {
     if (isset($_POST["pass-change"]))
   	   { 
   	   	 if($_POST["newpass1"]==$_POST["newpass2"])
   	   	   {
             $password=security::password_hash($_POST["oldpass"],$_POST["username"]);
             if($password==$_POST["db-pass"])
               {
                 $password=security::password_hash($_POST["newpass1"],$_POST["username"]);
                 $dbh=$con->prepare("update users set password=? where username=?");
                 $dbh->bindParam(1,$password);
                 $dbh->bindParam(2,$_POST["username"]);
                 $success=$dbh->execute();
                 if($success)
                   {
                     echo "password modified succesfully";
                   	 #header("location:index.php");
                     exit;
                   }
               }
             else
               {
                  $msg="PLEASE RETYPE YOUR CORRECT PASSWORD";
               }
   	   	   } 
   	   	else
   	   	    {
   	   	    	$msg="PLEASE ENTER MATCHING PASSWORDS";
   	   	    }  	     
       }
   	 $dbh=$con->prepare("select password from users where username=?");
   	 $dbh->bindParam(1,$username);
   	 $dbh->execute();
   	 $ro=$dbh->fetch(PDO::FETCH_ASSOC);
     echo'
     <form action="'.$_SERVER["PHP_SELF"].'?act=pass&&auth='.$_SESSION["un_id"].'" method="post" role="form" class="form form-horizontal">
     <p><center class="danger">'.$msg.'</center></p>
     <input hidden value="'.$ro["password"].'" name="db-pass" />
     <input hidden value="'.$username.'" name="username" />
     <div class="form-group"><label class="control-label col-md-4 col-md-offset-1" >ENTER OLD PASSWORD</label><div class="col-md-5"><input type="password" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="oldpass"/></div></div>
     <div class="form-group"><label class="control-label col-md-4 col-md-offset-1" > ENTER NEW PASSWORD</label><div class="col-md-5"><input type="password" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="newpass1"/></div></div>
     <div class="form-group"><label class="control-label col-md-4 col-md-offset-1" >CONFIRM NEW PASSWORD</label><div class="col-md-5"><input type="password" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="newpass2"/></div></div>
     <div class="col-md-5 col-md-offset-5" style="padding:0;"><button class="btn btn-primary btn-block" name="pass-change"><strong>CHANGE PASSWORD</strong></button></div>
     </form>';
   }
?>