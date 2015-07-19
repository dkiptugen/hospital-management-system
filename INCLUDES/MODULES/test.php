<?php 
function view_users($con)
{
$dbh=$con->query("select * from hospital.users");
$dbh->execute();
if($dbh->rowCount()>0)
	{
	$x=1;
	 echo "<table><tr>
		<th>USERNAME</th>
		<th>PASSWORD</th>
		<th>PASSWORDSTATUS</th>
		<th>USERTYPE</th>
		<th>PERM</th>
</tr>";
while($ROW=$dbh->fetch(PDO::FETCH_ASSOC))
{
echo"<tr>
<td>".$ROW["username"]."</td>
<td>".$ROW["password"]."</td>
<td>".$ROW["passwordstatus"]."</td>
<td>".$ROW["usertype"]."</td>
<td>".$ROW["perm"]."</td>
</tr>";
}
echo "</table>";
}
?>