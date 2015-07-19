<?php 
function test($con)
{
$dbh=$con->query("select * from hospital.users");
$dbh->execute();
if($dbh->rowCount()>0)
	{
	$x=1;
	 echo "<table><tr>
		<th>ID</th>
		<th>USERNAME</th>
		<th>PASSWORD</th>
</tr>";
while($ROW=$dbh->fetch(PDO::FETCH_ASSOC))
{
echo"<tr>
<td>".$ROW["id"]."</td>
<td>".$ROW["username"]."</td>
<td>".$ROW["password"]."</td>
</tr>";
}
echo "</table>";
}
?>