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
        if($_REQUEST["type"]=="new")
          {
          	if(isset($_POST["reg_bk"]))                          ###############
      	      { 
      	      	#echo "string";
      	   
      	   	 $patient_id=security::id_gen(15);
      	   	 $dbh=$con->prepare("
      	   	 	                 INSERT INTO `patient_details`(`PATIENT_NAME`, `Tel_no`, `address`, `patient_id`, `date_of_reg`,National_id) 
      	   	 	                 VALUES 
      	   	 	                (?,?,?,?,now(),?)
      	   	 	                ");
      	   	 $dbh->bindParam(1,$_POST["patientsname"]);
      	   	 $dbh->bindParam(2,$_POST["telno"]);
      	   	 $dbh->bindParam(3,$_POST["address"]);
      	   	 $dbh->bindParam(4,$patient_id);
      	   	 $dbh->bindParam(5,$_POST["natid"]);
      	   	 $dbh->execute();
      	   	 $dbh=null;
      	   	 $transid=security::id_gen(14);
      	   	 if($_POST["patient_status"]=="normal")
      	   	   {
                 $acc=access_level::grant_access("observation_room");
      	   	   }
      	   	 else
      	   	   {
                 $acc=access_level::grant_access("emergency");
      	   	   }
      	   	 $dbh=$con->prepare("INSERT INTO `patient_transaction`(`trans_id`, `patient_id`, `payment_method`, `check_in_time`, `patient_status`, `acc_lvl`)
      	   	                     VALUES 
      	   	                   (?,?,?,now(),?,?)");
             $dbh->bindParam(1,$transid);
             $dbh->bindParam(2,$patient_id);
             $dbh->bindParam(3,$_POST["paymethod"]);
             $dbh->bindParam(4,$_POST["patient_status"]);
             $dbh->bindParam(5,$acc);
      	   	 $dbh->execute();
 
      	     }
             echo '
                    <p>&nbsp;</p>
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
                    <div class="form-group ">
                     <label class="control-label col-md-3 col-md-offset-1" >PAYMENT METHOD</label>
                      <div class="col-md-5">
                       <input type="text" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="paymethod"/>
                      </div>
                    </div>
                    <div class="form-group ">
                     <label class="control-label col-md-3 col-md-offset-1" >National Id</label>
                      <div class="col-md-5">
                       <input type="text" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="natid" placeholder="for under 18,<national id>-<1-10>"/>
                      </div>
                    </div>
                    <div class="form-group ">
                     <label class="control-label col-md-3 col-md-offset-1" >PATIENTS CONDITION</label>
                      <div class="col-md-5">
                       <select class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="patient_status">
                          <option value="" selected>SELECT PATIENT CONDITION</option>
                          <option value="normal">NORMAL</option>
                          <option value="critical">CRITICAL</option>
                       </select>
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
   	 	     echo '<p>&nbsp;</p><center>
   	 	            <form class=" form form-inline" action="'.$_SERVER["PHP_SELF"].'?id=book&&auth='.$_SESSION["un_id"].'&&type=old" method="post">
   	 	               <div class="form-group">
   	 	                 <input type="text" class="form-control" name="search" required >
   	 	                 <button name="sach" class="btn btn-success">search</button>
   	 	               </div>
   	 	            </form>
   	 	           </center><p>&nbsp;</p>';
   	 	     
   	 	     if(isset($_POST["sach"]))
   	 	       { #echo $_POST["search"];
                  $dbh=$con->prepare("select * from hospital.patient_details where `PATIENT_NAME` like concat('%' :search '%')|| `National_id` like concat('%' :search '%') ");
                  $dbh->bindParam(':search',$_POST["search"]);
                  $dbh->execute();
                  if($dbh->rowCount()>0)
	                {
	                  $x=1;
	                  echo "
	                         <table class='table table-condensed' style='background:ghostwhite;'><tr>
		                     <th>NAME</th>
		                     <th>TEL_NO</th>
		                     <th>ADDRESS</th>
		                     <th>DATE_OF_REG</th>
		                     <th>ACTION</th>
                             </tr>
                           ";
                     while($ROW=$dbh->fetch(PDO::FETCH_ASSOC))
                        { 
                          if($x%2==0)
                       	    {
                       	  	  $y="danger";
                       	    }
                       	  else
                       	    {
                       	  	 $y="info";
                       	    }
                          echo"
                                 <tr class='".$y."'>
                                 <td>".$ROW["PATIENT_NAME"]."</td>
                                 <td>".$ROW["Tel_no"]."</td>
                                 <td>".$ROW["address"]."</td>
                                 <td>".$ROW["date_of_reg"]."</td>
                                 <td>
                                  <a href='index.php?id=view&&auth=".$_SESSION["un_id"]."&&patient_id=".$ROW["patient_id"]."'>BOOK PATIENT</a>
                                  <a href='index.php?id=update&&auth=".$_SESSION["un_id"]."&&patient_id=".$ROW["patient_id"]."'>UPDATE PATIENT</a>
                                 </td>
                                 </tr>
                                 ";
                          $x++;
                        }
                     echo "</table>";
                    }
              }
              
   	     }

   	   }	
  }
function view($con)
  { 
  	if(isset($_POST["book"]))
  	   {
  	   	     $transid=security::id_gen(14);
      	   	 if($_POST["patient_status"]=="normal")
      	   	   {
                 $acc=access_level::grant_access("observation_room");
      	   	   }
      	   	 else
      	   	   {
                 $acc=access_level::grant_access("emergency");
      	   	   }
      	   	 $dbh=$con->prepare("INSERT INTO `patient_transaction`(`trans_id`, `patient_id`, `payment_method`, `check_in_time`, `patient_status`, `acc_lvl`)
      	   	                     VALUES 
      	   	                   (?,?,?,now(),?,?)");
             $dbh->bindParam(1,$transid);
             $dbh->bindParam(2,$_POST["pid"]);
             $dbh->bindParam(3,$_POST["paymethod"]);
             $dbh->bindParam(4,$_POST["patient_status"]);
             $dbh->bindParam(5,$acc);
      	   	 $d=$dbh->execute();
      	   	 if($d)
      	   	   {
                 echo ucfirst($_POST["patientsname"])." booked successfully";
      	   	   }
  	   }
  	if(isset($_REQUEST["patient_id"]))
  	   {
  	   	 $dbh=$con->prepare("select PATIENT_NAME from patient_details where patient_id=?");
  	   	 $dbh->bindParam(1,$_REQUEST["patient_id"]);
  	   	 $dbh->execute();
  	   	 $fetched_data=$dbh->fetch(PDO::FETCH_ASSOC);
         echo '<form action="'.$_SERVER["PHP_SELF"].'?id=view&&auth='.$_SESSION["un_id"].'" method="post" role="form" class="form form-horizontal">
                <input hidden name="pid" value="'.$_REQUEST["patient_id"].'" />
                <div class="form-group">
                 <label class="control-label col-md-3 col-md-offset-1" >PATIENTS NAME</label>
                 <div class="col-md-5">
                  <input type="text" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="patientsname" readonly value="'.$fetched_data["PATIENT_NAME"].'"/>
                 </div>
                </div>
                <div class="form-group">
                 <label class="control-label col-md-3 col-md-offset-1" >PAYMENT METHOD</label>
                 <div class="col-md-5">
                  <input type="text" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="paymethod"/>
                 </div>
                </div>
                <div class="form-group ">
                 <label class="control-label col-md-3 col-md-offset-1" >PATIENTS CONDITION</label>
                 <div class="col-md-5">
                  <select class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="patient_status">
                   <option value="" selected>SELECT PATIENT CONDITION</option>
                   <option value="normal">NORMAL</option>
                   <option value="critical">CRITICAL</option>
                  </select>
                 </div>
                </div>
                <div class="col-md-5 col-md-offset-4">
                 <button class="btn btn-primary btn-block" name="book">BOOK PATIENT</button>
                </div>
               </form>';
        }
  }
function update_patient($con)
  {
    if(isset($_POST["updt"]))
     {
        $dbh=$con->prepare("UPDATE `patient_details` SET `PATIENT_NAME`=?,`Tel_no`=?,`address`=?,`National_id`=? WHERE `patient_id`=?");
        $dbh->bindParam(1,$_POST["patientname"]);
        $dbh->bindParam(2,$_POST["telno"]);
        $dbh->bindParam(3,$_POST["address"]);
        $dbh->bindParam(4,$_POST["nationalid"]);
        $dbh->bindParam(5,$_POST["pid"]);
        $d=$dbh->execute();
        if($d)
           {
           	 echo $_POST["patientname"]."'s account updated successfully" ;
           }
     }
    if(isset($_REQUEST["patient_id"]))
       {
       	 $dbh=$con->prepare("select * from patient_details where patient_id =?");
       	 $dbh->bindParam(1,$_REQUEST["patient_id"]);
       	 $dbh->execute();
       	 $R=$dbh->fetch(PDO::FETCH_ASSOC);
         echo '
            <form action="'.$_SERVER["PHP_SELF"].'?id=update&&auth='.$_SESSION["un_id"].'" method="post" role="form" class="form form-horizontal">
            <input name="pid" value="'.$_REQUEST["patient_id"].'" hidden />
            <div class="form-group">
             <label class="control-label col-md-3 col-md-offset-1" >PATIENT NAME</label>
             <div class="col-md-5">
              <input type="text" value="'.$R["PATIENT_NAME"].'" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="patientname" />
             </div>
            </div>
            <div class="form-group">
             <label class="control-label col-md-3 col-md-offset-1" >NATIONAL ID</label>
             <div class="col-md-5">
              <input type="text" value="'.$R["National_id"].'" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="nationalid"/>
             </div>
            </div>
            <div class="form-group">
             <label class="control-label col-md-3 col-md-offset-1" >TEL NO</label>
             <div class="col-md-5">
              <input type="text" value="'.$R["Tel_no"].'" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="telno"/>
             </div>
            </div>
            <div class="form-group">
             <label class="control-label col-md-3 col-md-offset-1" >ADDRESS</label>
             <div class="col-md-5">
              <input type="text" value="'.$R["address"].'" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="address"/>
             </div>
            </div>
            <div class="col-md-5 col-md-offset-4">
             <button class="btn btn-primary btn-block" name="updt">UPDATE PATIENT INFO</button>
            </div>
            </form>
           ';
       }
    
  }

?>