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
        	$dbh=$con->query("select 1 from invalid_logins limit 1");
        	$X=$dbh->execute();
        	if(!$X)
        	  {
        	  	$db=$con->query("create table invalid_logins(id Int NOT NULL AUTO_INCREMENT,employee_name varchar(30),username varchar(20),password varchar(32),local_ip varchar(18),public_ip varchar(18),date DATETIME,primary key(id))");
        	  	$db->execute();
        	  }

        }
	 public static function wrong_login()
	   {   
	   	   $con=DB::db_connect();
		   $local_ip=$this->get_user_ip_address();
		   $public_ip=$this->get_public_ip_address();
		   return $local_ip. "  ".$public_ip;
		   $dbh=$con->prepare("select * from users join userdetails on userdetails.staff_no=users.id where username=:user");
		   $dbh->bindParam(":user",$username);
		   $dbh->execute();
		   if($dbh->rowCount()>0)
		      { 
			     $data=$dbh->fetch(PDO::FETCH_ASSOC);
				 $name=$data["firstname"]." ".$data["lastname"]." ".$data["surname"]; 
				 $tel=$data["mobile_no"];
				 $password=$this->password_hash($this->password,$this->username);
				 
			  }
		   else
		      {
				$name="INVALID USER"; 
				 $tel="00000001";
			  }
		   $this->table_trans($con);
		   $dbh1=$con->prepare("insert into invalid_logins(id,employee_name,tel_no,username,password,local_ip,public_ip,date)
		                       values(null,:name,:tel_no,:uname,:pass,:local,:public,now())");
		   $dbh1->bindParam(":name",$name);
		   $dbh1->bindParam(":tel_no",$tel);
		   $dbh1->bindParam(":uname",$this->username);
		   $dbh1->bindParam(":pass",$this->password);
		   $dbh1->bindParam(":local",$local_ip);
		   $dbh1->bindParam(":public",$public_ip);
		   $dbh1->execute(); 
		   DB::db_close($con);
	   }
}
?>