<?php
class invalid_logins
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
	public static function get_user_ip_address($force_string=NULL)
       {
	      $ip_addresses = array();
	      $ip_elements = array(
		                       'HTTP_X_FORWARDED_FOR', 'HTTP_FORWARDED_FOR',
		                       'HTTP_X_FORWARDED', 'HTTP_FORWARDED',
		                       'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_CLUSTER_CLIENT_IP',
		                       'HTTP_X_CLIENT_IP', 'HTTP_CLIENT_IP',
		                       'REMOTE_ADDR'
	                           );
	      foreach ( $ip_elements as $element )
		     {
		       if(isset($_SERVER[$element]))
		          {
			        if( !is_string($_SERVER[$element]) )
				       {
				          continue;
			           }
			        $address_list = explode(',', $_SERVER[$element]);
			        $address_list = array_map('trim', $address_list);
			        foreach ( $address_list as $x )
			           {
				         $ip_addresses[] = $x;
			           }
		          }
	        }
	      if ( count($ip_addresses)==0 )
	          {
		        return FALSE;
	          } 
     else if ($force_string===TRUE || ( $force_string===NULL && count($ip_addresses)==1 ) ) 
              {
		        return $ip_addresses[0];
	          }
	    else 
	          {
		        return $ip_addresses;
	          }
     }
	 
       
	 public static function get_public_ip_address()
        {
	      $url="simplesniff.com/ip";
	      $ch = curl_init();
	      curl_setopt($ch, CURLOPT_URL, $url);
	      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	      $data = curl_exec($ch);
	      curl_close($ch);
	      return $data;
        }
     public static function table_trans($con)
        {
        	$dbh=$con->query("show tables like 'invalid_logins'");
        	$dbh->execute();
        	if($dbh->rowCount()==0)
        	  {
        	  	$db=$con->query("create table invalid_logins(id Int NOT NULL AUTO_INCREMENT,employee_name varchar(30),username varchar(20),password varchar(32),local_ip varchar(18),public_ip varchar(18),date DATETIME,primary key(id))");
        	  	$db->execute();
        	  }


        }
	 public  function wrong_login($con)
	   {   $invalid= new invalid_logins;
	   	   $security= new security;
		   $local_ip=invalid_logins::get_user_ip_address();
		   $public_ip=invalid_logins::get_public_ip_address();
		   
		   $dbh=$con->prepare("select * from users join userdetails on userdetails.id=users.id where username=:user");
		   $dbh->bindParam(":user",$this->username);
		   $dbh->execute();
		   if($dbh->rowCount()>0)
		      { 
			     $data=$dbh->fetch(PDO::FETCH_ASSOC);
				 $name=$data["employee_name"]; 
				 $tel=$data["tel_no"];
				 $password=$security->password_hash($this->password,$this->username);
				 
			  }
		   else
		      {
				$name="INVALID USER"; 
				 $tel="00000001";
				 $password=$this->password;
			  }
		    $dbh=$con->query("show tables like 'invalid_logins'");
        	$dbh->execute();
        	if($dbh->rowCount()<1)
        	  {
        	  	$db=$con->query("create table invalid_logins(id Int NOT NULL AUTO_INCREMENT,employee_name varchar(30),tel_no varchar(15),username varchar(20),password varchar(32),local_ip varchar(18),public_ip varchar(18),date DATETIME,status int,primary key(id))");
        	  	$db->execute();
        	  }
		   $dbh1=$con->prepare("insert into invalid_logins(id,employee_name,tel_no,username,password,local_ip,public_ip,date,status)
		                       values(null,:name,:tel_no,:uname,:pass,:local,:public,now(),0)");
		   $username=$this->username;
		   $dbh1->bindParam(":name",$name);
		   $dbh1->bindParam(":tel_no",$tel);
		   $dbh1->bindParam(":uname",$username);
		   $dbh1->bindParam(":pass",$password);
		   $dbh1->bindParam(":local",$local_ip);
		   $dbh1->bindParam(":public",$public_ip);
		   $dbh1->execute(); 
		   
	   }
}
?>