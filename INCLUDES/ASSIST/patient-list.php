<?php   
include_once("../../CONFIGURATIONS/classes/class.DB.inc.php");
$DB= new DB;
$con=$DB->db_connect();
        $dbh=$con->query("SELECT PATIENT_NAME FROM  patient_details join `patient_transaction`  on patient_details.patient_id=patient_transaction.patient_id WHERE acc_lvl=2 ORDER BY `check_in_time` ASC");
        $dbh->execute();
        if($dbh->rowCount()>0)
          {
            echo "<ol>";
            while($row=$dbh->fetch(PDO::FETCH_ASSOC))
                  {
                  echo "<li>".$row["PATIENT_NAME"]."</li>";
                  }
            echo "</ol>";      
          }
 $DB->db_close($con);
?>