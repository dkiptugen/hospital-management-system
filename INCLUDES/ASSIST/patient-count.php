<?php   
include_once("../../CONFIGURATIONS/classes/class.DB.inc.php");
$DB= new DB;
$con=$DB->db_connect();
        $dbh=$con->query("SELECT count(PATIENT_NAME) as xx FROM  patient_details join `patient_transaction`  on patient_details.patient_id=patient_transaction.patient_id WHERE acc_lvl=2 ORDER BY `check_in_time` ASC");
        $dbh->execute();
        if($dbh->rowCount()>0)
          {
            $row=$dbh->fetch(PDO::FETCH_ASSOC);
                
                  echo "<li>".$row["xx"]."</li>";
           
          }
      $DB->db_close($con);
?>