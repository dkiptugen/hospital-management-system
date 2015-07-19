<?php
class fileMgt
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