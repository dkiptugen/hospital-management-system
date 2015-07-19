<?php
function prof_change($con,$security,$username)
   {
   	 $dbh=$con->prepare("select from users where username=?");
   	 $dbh->bindParam(1,$username);
   	 $dbh->execute();
   	 $ro=$dbh->fetch(PDO::FETCH_ASSOC);
     echo'form action="'.$_SERVER["PHP_SELF"].'" method="post" role="form" class="form">
<div class="form-group"><label class="control-label col-md-3" >ENTER OLD PASSWORD</label><div class="col-md-5"><input type="text" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="enteroldpassword"/></div></div>
<div class="form-group"><label class="control-label col-md-3" > ENTER NEW PASSWORD</label><div class="col-md-5"><input type="text" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="enternewpassword"/></div></div>
<div class="form-group"><label class="control-label col-md-3" >CONFIRM NEW PASSWORD</label><div class="col-md-5"><input type="text" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="confirmnew password"/></div></div>
<div class="col-md-3"></div><div class="col-md-5"><button class="btn btn-primary btn-block" name="">CHANGE PASSWORD</button></div>
</form>';
   }


?>