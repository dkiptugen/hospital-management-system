<?php
class security
   { 
    
     function encrypt($value)
	   {
		 $value=md5($value);
		 return $value;
	   }
     function password_hash($password,$salt)
	   {
		 $salt=sha1($salt);
		 $password=md5($password);
		 return md5($password.$salt);
	   }
	
    function logout()                                        
	     {
	       if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
               $_SESSION[]=array();
	       unset($_SESSION);
	       session_destroy();
	       $host  = $_SERVER['HTTP_HOST'];
               $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
               $extra = '../../HOME/index.php';               
	       $homeurl="http://".$host.$uri.'/'.$extra;
		   
	       header('location:'.$homeurl); 
	       exit;
		}
     public static function id_gen($sat)
              {
                $seed = str_split('abcdefghijklmnopqrstuvwxyz'
        			.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
        			.'0123456789');
                 shuffle($seed);
                 $rand = '';
                 foreach (array_rand($seed,$sat) as $k){ $rand .= $seed[$k]; }       	
                  return $rand;
               }
     function sanitize($name,$value)
	        {
		  $value=htmlspecialchars(strip_tags($value));
		  $magic_quotes_active = get_magic_quotes_gpc();
                  $new_enough_php = function_exists( "mysql_real_escape_string" ); 
                  if( $new_enough_php )
  		     {
                      if( $magic_quotes_active )
			 {  
			   $value = stripslashes( $value ); 
			  }
                       $value = mysql_real_escape_string( $value );
                     } 
		  else 
		    { 
           if( !$magic_quotes_active ) 
			    {
			     $value = addslashes( $value ); 
			    }
            
           }
		 $I=array($name=>$value);
		 
		 return $I;
	    }
     		
   }   
?>