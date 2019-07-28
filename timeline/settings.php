<?php
 session_start();
$title="Settings";
$result="";
$msg="";
  require "../includes/conn.php";
  if(!isset($_SESSION['uid']))
  {
	 header('Location: ../index.php');
  }
if(isset($_POST['passwd']))
{
	$query = "UPDATE userdata SET password='".$_POST['passwd']."' WHERE id=".$_SESSION['uid'].";";
				@mysqli_query($conn,$query);
				$result="Password Updated Successfully";
				header('Location: index.php');
}

?>
<!DOCTYPE html>
<html class="st-layout ls-top-navbar ls-bottom-footer show-sidebar sidebar-l2" lang="en">

<?php include "header.php";?>
<body>
<script type="text/javascript" src="../includes/sha1.js"></script>  
<script>
function doSubmit()
{
	var temp=document.frm7.passwd.value;
	document.getElementById("passwd").value= SHA1(temp);
}
	function validate()
{
var reg = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*]).{8,20}$/;
if(!document.frm7.passwd.value.match(reg)) 
		   {
		    $("#perror").show();
			   frm7.passwd.focus();
			   return false;
		   }
		   else
		   {$("#perror").hide();
		   }
if(document.getElementById('passwd').value!=document.getElementById('cpasswd').value)
{
	$("#cperror").show();
			   frm7.passwd.focus();
	return false;
}
else
	$("#cperror").hide();

return;
}
   
   function accountdel()
   {
	   var result = confirm("Are you sure?");
	if(result)
	{if(window.XMLHttpRequest)
	{
		xmlhttp =  new XMLHttpRequest();
	}
	else
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			window.location="logout.php";
	}
	
	xmlhttp.open('GET','delete.php',true);
	xmlhttp.send();
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

            

            <div class="page-section">
              <div class="row">
			 
                <div class="col-md-10 col-lg-8 col-md-offset-1 col-lg-offset-2">
                   <div class="jumbotron bg-transparent text-center margin-none">
              <h1>User Settings</h1>
			  <a href="index.php">Home</a>
            </div>
                  <div class="panel panel-default">
                    <div class="panel-body">
					<?php echo $result; ?>
					<p id="perror" style="color:red; display:none"> Invalid Password. Password must contain atleast 8 and maximum 20 characters including one Digit and both uppercase and lowercase letters and one special character </p>
					<p id="cperror" style="color:red; display:none">Password and Confirm Password Doesn't Match!. </p>
                      <form name="frm7" id="cpwd" method="post" onsubmit="doSubmit()">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group form-control-default required">
                              <label for="InputNumber">New Password</label>
                              <input type="password" class="form-control" id="passwd" placeholder="New Password" name="passwd" required>
							  
                            </div>
                          </div>
						  <div class="col-md-6">
                            <div class="form-group form-control-default required">
                              <label for="InputNumber">Confrim New Password</label>
                              <input type="password" class="form-control" id="cpasswd" placeholder="Confirm New Password" name="cpasswd" required>
							  
                            </div>
                          </div>
						  <div class="col-md-6">
                             <button type="submit" class="btn btn-primary" onclick="javascript:return validate();"><i class="fa fa-edit"></i> Change Password </button>
                          </div>
						  <div class="col-md-6">
                             <button type="button" class="btn btn-danger" onclick="accountdel();""><i class="fa fa-remove"></i> Delete Account </button>
                          </div>
                        <br/>
                       
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
    