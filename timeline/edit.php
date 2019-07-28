<?php
 session_start();
$title="Edit Profile | SocioWorld";
$msg="Update Details";
$username="Not Available";
$dob="1 January 2017";
$about="Not Available";
$mobile="Not Available";
$email="Not Available";
$website="Not Available";
$highedu="Not Available";
$gender="Not Available";
$job="Not Available";
$profilepic="";
  if(!isset($_SESSION['uid']))
  {
	  header('Location: login.php');
  }
  require "../includes/conn.php";
$uid= $_SESSION['uid'];


  if(isset($_POST['phone']))
	  {
        require "../includes/conn.php";
        $uid= $_SESSION['uid'];
			 $query = "UPDATE userdata SET about='".$_POST['about']."', highedu='".$_POST['education']."', location='".$_POST['location']."', website='".$_POST['website']."', mobile='".$_POST['phone']."', job='".$_POST['job']."' WHERE id=".$uid.";";
	         if(@mysqli_query($conn,$query))
			 {
				 header('Location: index.php');
			 }
else
	$msg="<p id=\"phoneerror\" style=\"color:red; display:none\"> Invalid Phone Number. </p>";	
			
	  }
$query="SELECT * FROM userdata WHERE id='".$uid."';";
			 $query_run=@mysqli_query($conn,$query);
	         if(@mysqli_num_rows($query_run))
			 {$row=@mysqli_fetch_assoc($query_run);
              $username=$row['name'];
              $gender=$row['gender'];
			  $about=$row['about'];
			  $dob=$row['dob'];
			  $mobile=$row['mobile'];
			  $location=$row['location'];
			  $website=$row['website'];
			  $highedu=$row['highedu'];
			  $email=$row['email'];
			  $job=$row['job'];
			  if($gender=='m')
				  { $profilepic="images/male.png";
			        $gender="Male";
				  }
				   else
				   {  $profilepic="images/female.png";
			          $gender="Female"; 
				   }
			  if($row['profilepic']!="")
			  { $profilepic="upload/user_profile_pictures/";
		      $profilepic.=$row['profilepic'];				   
			 }
			 }
?>
<!DOCTYPE html>
<html class="st-layout ls-top-navbar ls-bottom-footer show-sidebar sidebar-l2" lang="en">

<?php include "header.php";
include "bodyhead.php";
?>
 <!-- sidebar effects OUTSIDE of st-pusher: -->
    <!-- st-effect-1, st-effect-2, st-effect-4, st-effect-5, st-effect-9, st-effect-10, st-effect-11, st-effect-12, st-effect-13 -->

    <!-- content push wrapper -->
    <div class="st-pusher" id="content">
    <!-- content push wrapper -->
    <div class="st-pusher" id="content">

      <!-- sidebar effects INSIDE of st-pusher: -->
      <!-- st-effect-3, st-effect-6, st-effect-7, st-effect-8, st-effect-14 -->

      <!-- this is the wrapper for the content -->
      <div class="st-content">

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


        <!-- extra div for emulating position:fixed of the menu -->
        <div class="st-content-inner">

          <div class="container-fluid">

            <div class="jumbotron bg-transparent text-center margin-none">
              <h1><?php echo $msg;?></h1>
            </div>
            <div class="page-section">
              <div class="row">
                <div class="col-md-10 col-lg-8 col-md-offset-1 col-lg-offset-2">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <form name="registration" id="registration" method="post">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group form-control-default required">
                              <label for="InputNumber">Phone Number</label>
                              <input type="text" class="form-control" id="InputNumber" placeholder="Phone Number" name="phone" value="<?php echo $mobile;?>" required>
							  <p id="phoneerror" style="color:red; display:none"> Invalid Phone Number. </p>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group form-control-default required">
                              <label for="InputLocation">Location</label>
                              <input type="text" class="form-control" id="InputLocation" placeholder="Your Location" name="location" value="<?php echo $location;?>" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group form-control-default ">
                          <label for="InputWebsite">Website</label>
                          <input type="text" class="form-control" id="InputWebsite" placeholder="Your Website " name="website" value="<?php echo $website;?>">
                        </div>
                        <div class="form-group form-control-default required">
                          <label for="InputEducation">Education</label>
                          <input type="text" class="form-control" id="InputEducation" placeholder="Education" name="education" value="<?php echo $highedu;?>" required>
                        </div>
						<div class="form-group form-control-default required">
                          <label for="InputEducation">Job</label>
                          <input type="text" class="form-control" id="InputJob" placeholder="Your Job" name="job" value="<?php echo $job;?>" >
                        </div>
						 <div class="form-group">
                          <label class="col-sm-3 control-label">Describe About Yourself </label>
                          <div class="col-sm-9">
                            <textarea class="form-control" rows="5" name="about" value=""><?php echo $about;?></textarea>
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
                        <button type="submit" class="btn btn-primary" onClick="javascript:return validate();">Update</button>
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
   
    