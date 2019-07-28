<?php
 session_start();
$title="Registration";
$msg="Step 2: Complete Registration";
  if(!isset($_SESSION['uid']))
  {
	 header('Location: ../index.php');
  }

  if(isset($_POST['phone']))
	  {
        require "../includes/conn.php";
        $uid= $_SESSION['uid'];
			 $query = "UPDATE userdata SET about='".$_POST['about']."', highedu='".$_POST['education']."', location='".$_POST['location']."', website='".$_POST['website']."', mobile='".$_POST['phone']."', job='".$_POST['job']."' WHERE id=".$uid.";";
	         if(@mysqli_query($conn,$query))
			 {
				 header('Location: uploadpic.php');
			 }
else
	$msg="<p id=\"phoneerror\" style=\"color:red; display:none\"> Invalid Phone Number. </p>";	
			
	  }
?>
<!DOCTYPE html>
<html class="st-layout ls-top-navbar ls-bottom-footer show-sidebar sidebar-l2" lang="en">

<?php include "header.php";?>
<body>
<script>
function validate()
{ 
           var phone=registration.phone.value;
           var digit = /^[0-9]+$/;
           if(!phone.match(digit)) 
      {
		    $("#phoneerror").show();
			   registration.phone.focus();
			   return false;
		   }
		   else
		   {$("#phoneerror").hide();
		   }
       

  if(!document.registration.checkbox.checked)
  {  $("#checkerror").show();
			   registration.checkbox.focus();
			   return false;
		   }
		   else
		   {$("#checkerror").hide();
		   }

	   
   }
</script>
  <div class="st-container">

    <!-- Fixed navbar -->
    <div class="navbar navbar-main navbar-primary navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">SocioWorld</a>
        </div>
      </div>
    </div>


        <!-- extra div for emulating position:fixed of the menu -->
        <div class="st-content-inner">

          <div class="container-fluid">

            <div class="jumbotron bg-transparent text-center margin-none">
              <h1><?php echo $msg;?></h1>
              <p>Complete the registration form to get started.</p>
			  
            </div>

            <div class="page-section">
              <div class="row">
                <div class="col-md-10 col-lg-8 col-md-offset-1 col-lg-offset-2">
                  <h4 class="page-section-heading">Basic Details</h4>
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <form name="registration" id="registration" method="post">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group form-control-default required">
                              <label for="InputNumber">Phone Number</label>
                              <input type="text" class="form-control" id="InputNumber" placeholder="Phone Number" name="phone" required>
							  <p id="phoneerror" style="color:red; display:none"> Invalid Phone Number. </p>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group form-control-default required">
                              <label for="InputLocation">Location</label>
                              <input type="text" class="form-control" id="InputLocation" placeholder="Your Location" name="location" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group form-control-default ">
                          <label for="InputWebsite">Website</label>
                          <input type="text" class="form-control" id="InputWebsite" placeholder="Your Website " name="website">
                        </div>
                        <div class="form-group form-control-default required">
                          <label for="InputEducation">Education</label>
                          <input type="text" class="form-control" id="InputEducation" placeholder="Education" name="education" required>
                        </div>
						<div class="form-group form-control-default required">
                          <label for="InputEducation">Job</label>
                          <input type="text" class="form-control" id="InputJob" placeholder="Your Job" name="job" required>
                        </div>
						 <div class="form-group">
                          <label class="col-sm-3 control-label">Describe About Yourself </label>
                          <div class="col-sm-9">
                            <textarea class="form-control" rows="5" name="about"></textarea>
                          </div>
                        </div>
						<br/>
						<br/>
						
						<div class="checkbox checkbox-success">
                            
							<input id="checkbox3" type="checkbox" name="checkbox" checked>
                            <label for="checkbox3">I agree to the Terms and Conditions</label>
							<p id="checkerror" style="color:red; display:none"> Please Agree to our Terms and Conditions. </p>
                          </div>
						  <br/>
                        <button type="submit" class="btn btn-primary" onClick="javascript:return validate();">Submit</button>
                      </form>
                    </div>
                  </div>

				 </div>
				 </div>
        </div>
        <!-- /st-content-inner -->

      </div>
      <!-- /st-content -->

    </div>
    <!-- /st-pusher -->

       <?php include "footer.php";
	  ?>
    