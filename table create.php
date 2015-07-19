<!doctype html>
<html>
<head>
<meta charset="utf-8" name="viewport" content="width=device-width">
<link rel="stylesheet" type="text/css" href="CSS/main.css">
<link rel="stylesheet" type="text/css" href="CSS/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../CSS/normalize.css">
<link rel="stylesheet" type="text/css" href="CSS/bootstrap-theme.css">
<script type="text/javascript" src="JS/jquery.min.js"></script>
<script type="text/javascript" src="JS/timer.js"></script>
<script type="text/javascript" src="JS/bootstrap.min.js"></script>
<title></title>
</head>
<?php
$msg='';
/*
if(isset($_POST['cr'])==true)
{
if(empty($_POST['f-name']))
   {
	$msg='enter valid file name';    
   }
else
   { 
    $name=$_POST['f-name'].'.php';
    $handle=fopen($name,'a');
    fwrite($handle,'<!Doctype html>'."\n".'<html>'."\n".'<head>'."\n".'<meta charset="utf-8">'."\n".'<title></title>'.     "\n".'</head>'."\n".'<body>'."\n".'<form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">'."\n");
   $y=explode(',',$_POST['varibles'],1000);	
   foreach( $y as $x )
          {
     fwrite($handle,'<p><label>'.strtoupper(str_replace('-',' ',$x)).'</label><input type="text" required="required" autofocus="autofocus" autocomplete="off" name="'.trim(strtolower(str_replace('-','',$x))).'"/></p>'."\n");
          }
    fwrite($handle,'<p><input type="submit" name="" value="SUBMIT" /></p>'."\n".'</form>'."\n".'</body>'."\n".'</html>'."\n");
    fclose($handle);
   }
}*/
?>
<body>
<div class="col-sm-4">
<form action="<?php $_SERVER['PHP_SELF'];  ?>" method="post" class="form" role="form-horizontal">
<div class="form-group"><label class="control-label col-md-5">FILE NAME</label><div class="col-md-7"><input type="text" name="file-name" class="form-control" /></div></div>
<div class="form-group"><label class="control-label col-md-5">FUNCTION NAME</label><div class="col-md-7"><input type="text" name="f-name" class="form-control" /></div></div>
<div class="form-group"><label class="control-label col-md-5">TABLE NAME</label><div class="col-md-7"><input type="text" name="table-name" placeholder="{database}.{table}" class="form-control" /></div></div>
<p><div class="form-group"><div class="col-md-5"></div><div class="col-md-7"><button name="cr-table" class="btn btn-primary btn-block">CREATE TABLE</button></div></div></p>
<p><?php echo $msg; ?></p>
</form>
<?php
if(isset($_POST["cr-table"]))
{
echo "<div class='panel ' style='max-height:300px; overflow:auto;'><form method='post' action='".$_SERVER["PHP_SELF"]."' enctype='multipart/form-data' >";
include("CONFIGURATIONS/classes/class.DB.inc.php");
$DB= new DB;
$con=$DB->db_connect();
$dbh=$con->query("DESCRIBE ".$_POST["table-name"]);
//$dbh->bindParam(":table",$_POST["table-name"]);
echo'<input type="text" hidden name="f-name" value="'.$_POST["f-name"].'" />';
echo'<input type="text" hidden name="file-name" value="'.$_POST["file-name"].'" />';
echo'<input type="text" hidden name="table-name" value="'.$_POST["table-name"].'" />';
$dbh->execute();
if($dbh->columnCount()>0)
   {
    while($COL=$dbh->fetch(PDO::FETCH_ASSOC))
      {
        echo "<label>".$COL["Field"]."</label><input type='checkbox' name='val[]' value='".$COL["Field"]."' />";
      }
   }
echo"<button name='xx'>CREATE</button></form>";
$DB->db_close($con);
}
if(isset($_POST["xx"]))
{
  $name="INCLUDES/MODULES/".$_POST['file-name'].'.php';
  $handle=fopen($name,'a');
  #chmod($name, 0775);
  #print_r($_POST["val"]);
  fwrite($handle,'<?php '."\n".'function '.$_POST['f-name'].'($con)'."\n".'{'."\n".'$dbh=$con->query("select * from '.$_POST["table-name"].'");'."\n".'$dbh->execute();'."\n".'if($dbh->rowCount()>0)'."\n\t".'{'."\n\t".'$x=1;'."\n\t".' echo "<table><tr>'."\n");
foreach($_POST["val"] as $y)
  {
    fwrite($handle,"\t\t".'<th>'.strtoupper($y).'</th>'."\n");
  }
  fwrite($handle,'</tr>";'."\n".'while($ROW=$dbh->fetch(PDO::FETCH_ASSOC))'."\n".'{'."\n".'echo"<tr>'."\n");

  foreach($_POST["val"] as $y)
  {
    fwrite($handle,'<td>".$ROW["'.$y.'"]."</td>'."\n");
  }

  fwrite($handle,'</tr>";'."\n".'}'."\n".'echo "</table>";'."\n".'}'."\n".'?>');
  
}
?>
</div>
<div class="col-sm-4">
<?php
$msg='';
if(isset($_POST['crform'])==true)
{
if(empty($_POST['f-name']))
   {
  $msg='enter valid file name';    
   }
else
   { 
    $name=$_POST['f-name'].'.php';
    $handle=fopen($name,'w');
    fwrite($handle,'<form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post" role="form" class="form">'."\n");
   $y=explode(',',$_POST['varibles'],1000); 
   foreach( $y as $x )
          {
     fwrite($handle,'<div class="form-group"><label class="control-label col-md-3" >'.strtoupper(str_replace('-',' ',$x)).'</label><div class="col-md-5"><input type="text" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="'.trim(strtolower(str_replace('-','',$x))).'"/></div></div>'."\n");
          }
    fwrite($handle,'<div class="col-md-3"></div><div class="col-md-5"><button class="btn btn-primary btn-block" name="">SUBMIT</button></div>'."\n".'</form>'."\n");
    fclose($handle);
   }
}
?>
<form action="<?php $_SERVER['PHP_SELF'];  ?>" method="post" class="form" role="form" enctype="multipart/form_data">
<p><div class="form-group"><label class="control-label col-md-4">File Name</label><div class="col-md-8"><input type="text" name="f-name" class="form-control" /></div></div></p>
<p><div class="form-group"><label class="control-label col-md-4">VARIABLES</label><div class="col-md-8"><textarea name="varibles" placeholder="put the input variables separated by a comma (,) and two words separated by a hyphen (-)" cols="50" rows="5" class="form-control" ></textarea></div></div></p>
<p><div class="col-md-4"></div><div class="col-md-8"><input type="submit" name="crform" value="CREATE" class="btn btn-primary btn-block" /></div></p>
<p><?php echo $msg; ?></p>
</form>
</div>
</body>
</html>