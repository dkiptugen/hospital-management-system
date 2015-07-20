<?php 
function patients($con)
{
$dbh=$con->query("select * from hospital.patient_details");
$dbh->execute();
if($dbh->rowCount()>0)
	{
	$x=1;
	 echo "<table><tr>
		<th>NAME</th>
		<th>TEL_NO</th>
		<th>ADDRESS</th>
		<th>PATIENT_ID</th>
		<th>DATE_OF_REG</th>
</tr>";
while($ROW=$dbh->fetch(PDO::FETCH_ASSOC))
{
echo"<tr>
<td>".$ROW["NAME"]."</td>
<td>".$ROW["Tel_no"]."</td>
<td>".$ROW["address"]."</td>
<td>".$ROW["patient_id"]."</td>
<td>".$ROW["date_of_reg"]."</td>
</tr>";
}
echo "</table>";
}
?>