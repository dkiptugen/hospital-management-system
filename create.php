<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
</head>
<?php
$msg='';
if(isset($_POST['cr'])==true)
{
if(empty($_POST['f-name']))
   {
	$msg='enter valid file name';    
   }
else
   { 
    $name=$_POST['f-name'].'.php';
    $handle=fopen($name,'w');
    fwrite($handle,'<!Doctype html>'."\n".'<html>'."\n".'<head>'."\n".'<meta charset="utf-8">'."\n".'<title></title>'.     "\n".'</head>'."\n".'<body>'."\n".'<form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">'."\n");
   $y=explode(',',$_POST['varibles'],1000);	
   foreach( $y as $x )
          {
     fwrite($handle,'<p><label>'.strtoupper(str_replace('-',' ',$x)).'</label><input type="text" required="required" autofocus="autofocus" autocomplete="off" name="'.trim(strtolower(str_replace('-','',$x))).'"/></p>'."\n");
          }
    fwrite($handle,'<p><input type="submit" name="" value="SUBMIT" /></p>'."\n".'</form>'."\n".'</body>'."\n".'</html>'."\n");
    fclose($handle);
   }
}
?>
<body>
<form action="<?php $_SERVER['PHP_SELF'];  ?>" method="post">
<p><label>File Name</label><input type="text" name="f-name" /></p>
<p><label>VARIABLES</label><br/><textarea name="varibles" placeholder="put the input variables separated by a comma (,) and two words separated by a hyphen (-)" cols="50" rows="5" ></textarea></p>
<p><input type="submit" name="cr" value="CREATE" /></p>
<p><?php echo $msg; ?></p>
</form>
</body>
</html>