<?php
   class access_level
     {
	   function grant_access($next_user)
	      {
            switch ($next_user)
              {
            	case 'observation_room':
            		$x=2;
            		break;
            	case 'doctor':
            		$x=3;
            		break;
            	case 'lab':
            		$x=4;
            		break;
            	case 'pharmacy':
            		$x=5;
            		break;
            	case 'ward':
            		$x=6;
            		break;
            	case 'emergency':
            		$x=7;
            		break;
            	case 'exit':
            		$x=0;
            		break;	
            	default:
            		$x=1;
            		break;
              }
            return $x;
	      }
	   function get_loc($key)
	      {
	      	switch ($key) 
	      	  {
	      		case 1:
	      			$x="front-desk";
	      			break;
	      		case 2:
	      			$x="observation_room";
	      			break;
	      		case 3:
	      			$x="doctor";
	      			break;
	      		case 4:
	      			$x="lab";
	      			break;
	      		case 5:
	      			$x="pharmacy";
	      			break;
	      		case 6:
	      			$x="ward";
	      			break;
	      		case 7:
	      			$x="emergency";
	      			break;
	      	   }
	      	   return $x;
	      }
     }
?>