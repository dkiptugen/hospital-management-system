<?php

function booking($con)
  {
  	echo' 
  	<ul class="nav nav-tabs" style="font-weight:bold; color:black;">  
    <li><a href="index.php?id=book&&auth='.$_SESSION["un_id"].'&type=new">NEW PATIENTS</a></li>
    <li><a href="index.php?id=book&&auth='.$_SESSION["un_id"].'&type=old">OLD PATIENTS</a></li>
    </ul>';
    if(isset($_REQUEST["type"]))
      {  

      	####################################################################
       	
        if($_REQUEST["type"]=="new")
          {
          	if(isset($_POST["reg_bk"]))                          ###############
      	      { 
      	      	#echo "string";
      	   
      	   	 $patient_id=security::id_gen(15);
      	   	 $dbh=$con->prepare("
      	   	 	                 INSERT INTO `patient_details`(`NAME`, `Tel_no`, `address`, `patient_id`, `date_of_reg`) 
      	   	 	                 VALUES 
      	   	 	                (?,?,?,?,now())
      	   	 	                ");
      	   	 $dbh->bindParam(1,$_POST["patientsname"]);
      	   	 $dbh->bindParam(2,$_POST["telno"]);
      	   	 $dbh->bindParam(3,$_POST["address"]);
      	   	 $dbh->bindParam(4,$patient_id);
      	   	 $dbh->execute();
      	   	 $dbh=null;
      	   	 $dbh=$con->prepare();
             $dbh->bindParam(,);
      	   	 $dbh->execute();
      	   	
      	     }
             echo '
                   <form action="'.$_SERVER["PHP_SELF"].'?id=book&&auth='.$_SESSION["un_id"].'&type=new" method="post" role="form" class="form form-horizontal">
                    <div class="form-group ">
                     <label class="control-label col-md-2 col-md-offset-2" >PATIENTS NAME</label>
                      <div class="col-md-5">
                       <input type="text" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="patientsname"/>
                      </div>
                    </div>
                    <div class="form-group ">
                     <label class="control-label col-md-2 col-md-offset-2" >TELEPHONE NO</label>
                      <div class="col-md-5">
                       <input type="text" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="telno"/>
                      </div>
                    </div>
                    <div class="form-group ">
                     <label class="control-label col-md-2 col-md-offset-2" >ADDRESS</label>
                      <div class="col-md-5">
                       <input type="text" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="address"/>
                      </div>
                    </div>
                    <div class="col-md-5 col-md-offset-4">
                     <button class="btn btn-primary btn-block" name="reg_bk" >REGISTER AND BOOK </button>
                    </div>
                   </form>
                 ';
          }
       elseif($_REQUEST["type"]=="old")
   	      {
   	 	     echo '<center> <form class=" form form-inline"><div class="form-group"><input type="text" class="form-control" name="search" required><button name="sach" class="btn btn-success">search</button></div></form></center>';
   	      }
   	  }	
  }
function view($con)
  {
    echo "view";
  }
function view_doc_spec($con,$doc_id)
  {
      echo "view specific";
  }

?>