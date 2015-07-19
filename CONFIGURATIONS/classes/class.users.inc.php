<?php
class users
   {
	   
	 /*
	      START OF USER REDIRECT
	*/ 
	 function det_user($group,$test="")
	   { 
             $x[0]=array('GROUP'=>'ADMIN','LOCATION'=>'ADMIN'); 
             $x[1]=array('GROUP'=>'FRONT-DESK','LOCATION'=>'FRONT-DESK');
             $x[2]=array('GROUP'=>'DOCTOR','LOCATION'=>'DOCTOR');
			 $x[3]=array('GROUP'=>'LAB','LOCATION'=>'LAB');
			 $x[4]=array('GROUP'=>'OBSERVATION','LOCATION'=>'OBSERVATION-ROOM');
			 $x[5]=array('GROUP'=>'PHARMACY','LOCATION'=>'PHARMACY');
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

?>