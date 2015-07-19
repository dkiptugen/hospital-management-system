<?php
class validate
   {
   	function __constructor()
   	   {

    	}
    function __destructor()
        {

        }
	function test_input($data) 
	  {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
	 function test_empty($name,$value)
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
	 function validate_string_val($value,$maxsize,$minsize)
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
	    }

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
?>