
<?php
      if((isset($_REQUEST["id"])==true)&&($_REQUEST["id"]=="reg")&&($_REQUEST["auth"]==$_SESSION["un_id"]))
         {
    ?>
      <div class="panel panel-default " >
         <!--div class="panel-heading"><h3 class="panel-title">CONTENT</h3></div-->
        <script type="text/javascript">
        $(document).ready(function(){
         
           $('#x').click(function(){
             
             $("#new-users").hide();
             $('#olduser').show();
               });
            $("#new").click(function(){
             $('#olduser').hide();
             $("#new-users").show();
           });
        }); 
         </script>
         <div class="panel-body">
          <!--div class="panel"-->
          <div class="panel-body">
          <form class="form-inline">
          <div class="col-sm-6">
          <input type="radio" name="customer-type"  id="new"  class="form-control" />   <label class="control-label">NEW PATIENT</label>
          </div>
          <div class="col-sm-6">
          <input type="radio" name="customer-type" id="x"  class="form-control" />   <label class="control-label">OLD PATIENT</label>
          </div>
          </form>
          </div>
          <!--/div-->
          <div id="new-users" style="display:none;">
          <div class="col-sm-6">
          <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post" role="form" class="form form-horizontal" id="c-reg">
           <div class="form-group x"><label class="control-label col-md-5" >PATIENTS NAME</label><div class="col-md-7"><input type="text" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="patientsname"/></div></div>
           <div class="form-group x"><label class="control-label col-md-5" >TELEPHONE NO</label><div class="col-md-7"><input type="text" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="telephoneno"/></div></div>
           <div class="form-group x"><label class="control-label col-md-5" >ADDRESS</label><div class="col-md-7"><input type="text" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="address"/></div></div>
           <div class="x"><div class="col-md-4"></div><div class="col-md-8"><button class="btn btn-primary btn-block" name="reg_bk" >REGISTER AND BOOK </button></div></div>
          </form>
          </div>
          </div>
         </div>
         <div id="olduser" style="display:none;" >
           <center> <form class=" form form-inline"><div class="form-group"><input type="text" class="form-control" name="search" required><button name="sach" class="btn btn-success">search</button></div></form></center>

         </div>
         <!--div class="panel-footer">Panel footer</div-->
      </div>
      <?php 
          }
          if((isset($_REQUEST["id"])==true)&&($_REQUEST["id"]=="billing")&&($_REQUEST["auth"]==$_SESSION["un_id"]))
         {
      ?>
      <div class="panel panel-default">
         <div class="panel-body">
            <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post" role="form" class="form form-horizontal">
              <div class="form-group"><label class="control-label col-md-3" >PATIENT NAME</label><div class="col-md-5"><input type="text" class="form-control" readonly required="required" autofocus="autofocus" autocomplete="off" name="patientname"/></div></div>
              <div class="form-group"><label class="control-label col-md-3" >CONSULTATION FEE</label><div class="col-md-5"><input type="text" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="consultationfee"/></div></div>
              <div class="form-group"><label class="control-label col-md-3" >PHARMACY FEE</label><div class="col-md-5"><input type="text" class="form-control" required="required" autofocus="autofocus" autocomplete="off" name="pharmacyfee"/></div></div>
              <div class="col-md-3"></div><div class="col-md-5"><button class="btn btn-primary btn-block" name="">SUBMIT</button></div>
            </form>
         </div>
      </div>
      <?php
        }
      ?>