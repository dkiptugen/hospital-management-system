<?php
######################################################################################
########################### USER CONFIGS #############################################
######################################################################################
class users
   {
	   
	 function access_level($user)
	   {
		switch($user)
		      {
				 case "ADMIN":
				                   $access=1;
							       break;  
				 case "DIRECTOR":
				                   $access=2;
							       break;
				case "MANAGER":
				                   $access=3;
							       break;
				case "ACCOUNTANT":
				                   $access=4;
							       break ;
				case "SUPERVISOR":
				                   $access=5;
							       break; 
			  }
		   return $access;
	   }
	/*
	      START OF USER REDIRECT
	*/ 
	 function det_user($group,$test="")
	   { 
             $x[0]=array('GROUP'=>'ADMIN','LOCATION'=>'ADMIN'); 
             $x[1]=array('GROUP'=>'DIRECTOR','LOCATION'=>'DIRECTOR');
             $x[2]=array('GROUP'=>'MANAGER','LOCATION'=>'MANAGER');
			 $x[3]=array('GROUP'=>'ACCOUNTANT','LOCATION'=>'ACCOUNTANT');
			 $x[4]=array('GROUP'=>'SUPERVISOR','LOCATION'=>'SUPERVISOR');
			 $x[5]=array('GROUP'=>'INVALID','LOCATION'=>'../HOME');
             $xx=0;		 
             foreach($x as $y)
                {
	                if(strtoupper($group) == strtoupper($y['GROUP']))
			           {
			             $xx=0;
			             header('location:'.$test.$y['LOCATION']);
			             exit;
			           }
		           else
			           { 
			              $xx++;				 
			           }					 
	            }
	        if($xx!=0)
		       { 
	              echo 'Invalid user';
		       }
           } 
		#---------------------------------END OF USER REDIRECT----------------------------------------#
     function user_check($user,$usertype)
		{
			#session_start();
            if(!empty($user))
			  {
			    if($user!=$usertype)
				   {
					$this->det_user($user,"../");   
				   }
			  }
			else
			   {
				header("location:../index.php");exit; 
			   }
		}
   } 
##########################################################################################################
################################ SECURITY ################################################################
##########################################################################################################
class security
   { 
    function get_user_ip_address($force_string=NULL)
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
	 
       
	  function get_public_ip_address()
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
	 function wrong_login($con,$username,$password)
	   {
		   $local_ip=$this->get_user_ip_address();
		   $public_ip=$this->get_public_ip_address();
		   $dbh=$con->prepare("select * from users join userdetails on userdetails.staff_no=users.id where username=:user");
		   $dbh->bindParam(":user",$username);
		   $dbh->execute();
		   if($dbh->rowCount()>0)
		      { 
			     $data=$dbh->fetch(PDO::FETCH_ASSOC);
				 $name=$data["firstname"]." ".$data["lastname"]." ".$data["surname"]; 
				 $tel=$data["mobile_no"];
				 $password=$this->password_hash($password,$username);
				 
			  }
		   else
		      {
				$name="INVALID USER"; 
				 $tel="00000001";
			  }
		   $dbh1=$con->prepare("insert into insecurity(id,employee_name,tel_no,username,password,local_ip,public_ip,date)
		                       values(null,:name,:tel_no,:uname,:pass,:local,:public,now())");
		   $dbh1->bindParam(":name",$name);
		   $dbh1->bindParam(":tel_no",$tel);
		   $dbh1->bindParam(":uname",$username);
		   $dbh1->bindParam(":pass",$password);
		   $dbh1->bindParam(":local",$local_ip);
		   $dbh1->bindParam(":public",$public_ip);
		   $dbh1->execute(); 
	   }
	 
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
     function id_gen($sat)
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
   #############################################################################################
   ############################### DATABASE CONNECTION #########################################
   #############################################################################################
   class DB
   {
     function db_connect()
	    {
		 include('details.php');
		 try
		   {
                $dbh = new PDO('mysql:host='.HOST.';dbname='.DBase, DB_USER,DB_PASS, array(PDO::ATTR_PERSISTENT => true));
		        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                return $dbh;
            } 
		 catch(PDOException $e) 
		   {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
           }
	    }
     function db_close($dbh)
	        {
		  $dbh = null;		
		}
   }
##########################################################################################
############################## Validation ################################################
##########################################################################################   
 class validate
   {
	function test_input($data) 
	  {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
	 /*function check_empty($name,$value)
	    {
		  if(!empty($value))
		    { 
		      $msg="";
			  return array($name=>$value,$error=>0,$err_message=>$msg);
		    }
		 else
		    {
			  $value="";
			  $msg=$name.'field is empty';
			  return array($name=>$value,$error=>1,$err_message=>$msg);
			}
		}
	 function validate_email($value)
	    {
		  $value=test_input($value);
          if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{ 
		      $msg='Invalid Email';
              return array($val=>$value,$error=>1,$err_message=>$msg);
            }
          else
		   {
			  $msg='';
              return array($val=>$value,$error=>0,$err_message=>$msg);
		   }			  
		}
	 function validate_strings($value,$maxsize,$minsize)
	    {
		 if(strlen($value)>$maxsize)
		    {
			 $msg='input data is very long';
             return array($val=>$value,$error=>1,$err_message=>$msg);
		    }
		 else if(strlen($value)<$minsize)
		    {
			 $msg='input data is too short';
             return array($val=>$value,$error=>1,$err_message=>$msg);
		    }
		 else
		    {
			  if(preg_match('/[^a-z\s-\']/i',$value))
			    {
				 $msg='';
                 return array($val=>$value,$error=>0,$err_message=>$msg); 
			    }
			  else
			    {
				 $msg='The string should only contain letters';
                 return array($val=>$value,$error=>1,$err_message=>$msg);
				}
			}
	    }
	 function validate_numbers($value)
	    {
		   if(preg_match('/[0-9]+/'))
		    {
			  $msg='';
              return array($val=>$value,$error=>0,$err_message=>$msg);  
		    }
		 else
		    {
			 $msg='Invalid input,only numbers required';
             return array($val=>$value,$error=>1,$err_message=>$msg); 	
			}
	    }*/

  private function build_error($key, $value, $message) 
     {
       return array($key => $value, $error => 1, $err_message => $message);
     }

  private function build_success($key, $value)
     {
       return array($key => $value, $error => 0, $err_message => '');
     }
   function check_empty($name, $value)
      {
        if(empty($value)) 
          { 
           return build_error($name, $value, $name . ' field is empty');
          } 
          else
           {
            return build_success($name, $value);
           }
      }
     function validate_strings($value,$maxsize,$minsize) 
     {
        if(strlen($value) > $maxsize) 
           {
             return build_error($val, $value, 'input data is very long');
           }
        if(strlen($value) < $minsize)
           {
             return build_error($val, $value, 'input data is too short');
           }

        if(!preg_match('/[^a-z\s-\']/i',$value)) 
          {
            return build_error($val, $value, 'The string should only contain letters (and some other stuff)');
          }

        return build_success($val, $value);
      }
   } 
class file_up
   {
    function upload($name,$target_dir,$maxsize=500000,$allowed_type=array("jpg","png","jpeg","gif","pdf","docx","doc"))
       {
         $mime = "application/pdf; charset=binary";	  
         if(!file_exists($target_dir))
            {
	          mkdir($target_dir,$mode=0777);   
	        }
	     $target_dir=$target_dir."/";
	     $uploadOk = 1;
	     $target_file = $target_dir . basename($_FILES[$name]["name"]);
	     $FileType = pathinfo($target_file,PATHINFO_EXTENSION);
	     ###############################################################
	     ####################  FILE TYPE CHECK #########################
	     ############################################################### 
	     $fl=0;
         foreach($allowed_type as $FILETP)
           {
             if($imageFileType == $FILETP )
	            {
		          $fl++;	
		         }
	       }
          if($fl==0)
		    {		   
              $uploadOk = 0;
            }
	    ################################################################
	    ##########################  FILE EXISTENCE    ##################
	    ################################################################
	     if (file_exists($target_file))
	         {
               echo "Sorry, file already exists.";
               $uploadOk = 0;
             }
	    ################################################################
        ##################### Check file size ##########################
	    ################################################################
         if ($_FILES[$name]["size"] >$maxsize)
            {
              echo "Sorry, your file is too large.";
              $uploadOk = 0;
            }	
		################################################################
		################## CHECK IF CONDITIONS MET #####################
		################################################################
		 if ($uploadOk == 0)
	        {
              echo "Sorry, your file was not uploaded.";
            } 
	    else 
	        {
               if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file))
	               {
                      echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				      echo "Upload: " . $_FILES[$name]["name"] . "<br />";
                      echo "Type: " . $_FILES[$name]["type"] . "<br />";
                      echo "Size: " . ($_FILES[$name]["size"] / 1024) . " Kb<br />";
                      echo "Stored in: " . $_FILES[$name]["tmp_name"];
		           } 
	          else 
	               {
                      echo "Sorry, there was an error uploading your file.";
                   }
          }
	  }
	 function download($file_name,$file_path)
	    {
		  if (file_exists($file_name))
		     {
				// Close sessions to prevent user from waiting until
                // download will finish (uncomment if needed)
                //session_write_close();
                set_time_limit(0);
                ignore_user_abort(false);
                ini_set('output_buffering', 0);
                ini_set('zlib.output_compression', 0);
                $chunk = 10 * 1024 * 1024; // bytes per chunk (10 MB)
                $fh = fopen($filepath, "rb");
                if ($fh === false)  
				   {
                     echo "Unable open file";
                   }
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.basename($file_name));
                header('Expires: 0');
				header('Content-Transfer-Encoding: binary');
                header('Cache-Control: must-revalidate');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file_name));
			    while (!feof($fh)) 
				      {
                        echo fread($handle, $chunk);
                        ob_flush();  // flush output
                        flush();
                      }
                readfile($file_name);
                exit;
             }		
		}
	 function gzCompressFile($source, $level = 9)
	   { 
         $dest = $source . '.gz'; 
         $mode = 'wb' . $level; 
         $error = false; 
         if ($fp_out = gzopen($dest, $mode))
		    { 
             if ($fp_in = fopen($source,'rb'))
			    { 
                  while (!feof($fp_in)) 
                  gzwrite($fp_out, fread($fp_in, 1024 * 512)); 
                  fclose($fp_in); 
                }
			 else 
			    {
                  $error = true; 
                }
           gzclose($fp_out); 
          }
	   else 
	      {
           $error = true; 
          }
      if ($error)
         return false; 
       else
        return $dest; 
     } 
   }
   
 ?>
