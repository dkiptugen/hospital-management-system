<?php

         
 class DB
   { 	    
     public static function db_connect()
	    {
		 $dir=$_SERVER["DOCUMENT_ROOT"]."/Hospital management system/CONFIGURATIONS";
         $dir=$dir.'/details.php';
   	      if(file_exists($dir))
             {
               include($dir);
             }
          else
             {
	           echo dir(__FILE__);
             }
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
	    
     public static function db_close($dbh)
	    {
		  $dbh = null;
		  unset($dbh);		
		}
	public function fetch_assist($Object)
	    {
	    	if($Object->rowCount()>0)
	    	   {
	    	   	 $ROW[]=array();
	    	   	 for($no=1; $no<=$Object->rowCount(); $n0++)
	    	   	    {
	    	   	      return $ROW[$no]=$Object->fetch(PDO::FETCH_ASSOC);
	    	        }

	    	   }
	    }
   }


?>