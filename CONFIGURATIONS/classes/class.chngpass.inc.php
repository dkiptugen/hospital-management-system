<?php
class chngpass
     {
       public $username;
       public $password;
       public $usertype;
       public $id;
      function __construct()
        {
          $this->username;
          $this->password;
          $this->usertype;
          $this->id;
        }
      function __destruct()
        {
           unset($this->password);
           unset($this->username);
           unset($this->usertype);
           unset($this->id);
        }
      function chngpass()
         {
             #return security::password_hash($this->password,$this->username);
             #exit;
          
             $DB= new DB;
             $con=$DB->db_connect();
             $dbh=$con->prepare("update users set password=:password , passwordstatus=1 where username=:username && id=:id");
             $dbh->bindParam(":username",validate::test_input($this->username));
             $dbh->bindParam(":password",security::password_hash(validate::test_input($this->password),validate::test_input($this->username)));
             $dbh->bindParam(":id",$this->id);
             $success=$dbh->execute();
             if($success)
               {
                 $_SESSION["USERTYPE"]=$this->usertype;
                return users::det_user($_SESSION["USERTYPE"]);
               }
            $DB->db_close($con);
            
            return $this->usertype;
         }
     }
?>