<?php 
function view($con)
{
$dbh=$con->query("select * from hospital.patient_details");
$dbh->execute();
if($dbh->rowCount()>0)
   {
	 $x=1;
	 echo "
	    <table class='table table-condensed'>
	    <tr style='background:ghostwhite; font-weight:bold;'>
	    <th>&nbsp;</th>
		<th>PATIENT_NAME</th>
		<th>TEL_NO</th>
		<th>ADDRESS</th>
		<th>PATIENT_ID</th>
		<th>DATE_OF_REG</th>
		<th>NATIONAL_ID</th>
         </tr>";
     while($ROW=$dbh->fetch(PDO::FETCH_ASSOC))
           {
           	 if($x%2!=0)
           	   {
                 $y="info";
           	   }
           	 else 
           	   {
                 $y="warning";
           	   }
             echo"<tr class='".$y."'>
             <td>".$x."</td>
             <td>".$ROW["PATIENT_NAME"]."</td>
             <td>".$ROW["Tel_no"]."</td>
             <td>".$ROW["address"]."</td>
             <td>".$ROW["patient_id"]."</td>
             <td>".$ROW["date_of_reg"]."</td>
             <td>".$ROW["National_id"]."</td>
             </tr>";
             $x++;
            }
     echo "</table>";
    }
}
?>