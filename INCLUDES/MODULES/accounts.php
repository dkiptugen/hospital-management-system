<?php
include_once("../../CONFIGURATIONS/classes/class.DB.inc.php");
$DB= new DB;
$con=$DB->db_connect();
$dbh=$con->prepare("SELECT count(`employee_name`) as tot FROM `invalid_logins` where date_format(date,'%d-%m-%Y')= date_format(now(),'%d-%m-%Y')&& status=0");
$dbh->execute();
if($dbh->rowCount()>0)
   {
	 $R=$dbh->fetch(PDO::FETCH_ASSOC);  
	  echo $R["tot"]; 
   }
else
   {
	echo "0";   
   }
$DB->db_close($con);
?>
