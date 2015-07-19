<?php
function session_monitor($user,$red,$type)
  {
    if(isset($user))
        {
          if($user!=$type)
            {
              users::det_user($user,$red);
            }
        }
    else
       {
          header("location:../index.php"); exit;
       }
  }

?>