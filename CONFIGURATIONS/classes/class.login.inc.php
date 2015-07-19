<?php
/*
  function __autoload($class_name)
     {
        include_once 'class.' . $class_name . '.inc.php';
        #var_dump($class_name);
     }
*/

class login
 {
   public $username;
   public $password;

   function __construct()
     {
     	$this->username;
        $this->password;
     }
   function __destruct()
     {
        unset($this->username);
        unset($this->password);
     }
  function login()
    {
    	  $security= new security;
        $DB= new DB;
        $users= new users;
        $Validate= new validate;
        $username=validate::test_input($this->username);
        $password=validate::test_input($this->password);
        $PASS=$password;
        $password=$security::password_hash($password,$username);
        #echo $password;
        $con=DB::db_connect();
        $dbh=$con->prepare("select * from users join userdetails on userdetails.id=users.id where username=? and password=?");
        $dbh->bindParam(1,$username);
        $dbh->bindParam(2,$password);
        $dbh->execute();
        if($dbh->rowCount()>0)
          { 
     	    $_ROW=$dbh->fetch(PDO::FETCH_ASSOC);
     	    $_SESSION["id"]=$_ROW["id"];
          $_SESSION["username"]=$_ROW["username"];
     	    if($_ROW["perm"]==1)
     	       {
               $_SESSION["emp_id"]=$_ROW["id"];
               $_SESSION["emp_name"]=$_ROW["employee_name"];
               $_SESSION["un_id"]=$security::id_gen(20);
                if($_ROW["passwordstatus"]==1)
     	            { 
                      $_SESSION["USERTYPE"]=$_ROW["usertype"];                      
                      $users->det_user($_ROW["usertype"]);
                      #echo $_ROW["usertype"];
     	            }
                 else if($_ROW["passwordstatus"]==0)
                    {                      
          	          $_SESSION["usertype"]=$_ROW["usertype"];
                      header("location:changepassword.php");
                      exit;
                    }
                }
            elseif ($_ROW["perm"]===0) 
                {
                  $msg="ACCESS DENIED, CONTACT ADMIN";
                  return $msg;
                  header("location:index.php");
                  exit;	
                }
          }
        else
          {
            
            $invalid = new invalid_logins;
            $invalid->username=$username;
            $invalid->password=$PASS;
            $invalid::wrong_login($con);  
            $msg="Invalid Login details";
            return $msg;          
            header("location:index.php");
            exit;
          }
          exit();
        DB::db_close($con);
    }
 }


?>