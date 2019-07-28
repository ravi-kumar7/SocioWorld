<?php 
 session_start();
 $msg="";
 $id=0;
	         require "../includes/conn.php";
 $title="Login | SocioWorld";
  if(isset($_SESSION['uid']))
  {
	  header('Location: index.php');
  }
  if(isset($_POST['username']))
            {
				$passwd= $_POST['passwd'];
				if(strlen($passwd)<32)
			{
				$passwd=sha1($passwd);
			}
	         $query="SELECT * FROM userdata WHERE email='".$_POST['username']."' and password='".$passwd."';";
			 $query_run=@mysqli_query($conn,$query);
	         if(@mysqli_num_rows($query_run))
	         {$row=@mysqli_fetch_assoc($query_run);
		       $_SESSION['uid']=$row['id'];
			   header('Location: index.php');		   
			 }
			 else
				 $msg="<p style=\"color:red;\" > <b>Invalid UserName/Password </b></p>";
			}
?>
<!DOCTYPE html>
<html class="hide-sidebar ls-bottom-footer" lang="en">

<?php include "header.php";?>
<body class="login">
<script type="text/javascript" src="../includes/sha1.js"></script>  
<script>
function doSubmit()
{
	var temp=document.login.passwd.value;
	document.getElementById("pwd").value= SHA1(temp);
}
function changeform(value)
{
	if(value==1)
	{
		document.getElementById("default").style.display='block';
		document.getElementById("forget").style.display='none';
		
	}
	else{
		document.getElementById("forget").style.display='block';
		document.getElementById("default").style.display='none';
	}
}
	
   </script>
  <div id="content">
    <div class="container-fluid">

      <div class="lock-container">
        <h1>Account Login</h1>
        <div class="panel panel-default text-center" id="default">
          <img src="images/login.png" class="img-circle">
          <div class="panel-body">
		    <form method="post" name="login" onsubmit="doSubmit()"  >
			 <?php echo $msg;
		  ?>
			
            <input class="form-control" type="text" name="username" placeholder="Email" required>
            <input class="form-control" type="password" name="passwd" placeholder="Enter Password" id="pwd" required> 

            <input type="submit" class="btn btn-primary" value="Login"/> 
            <!--a href="#" class="forgot-password" onclick="changeform(2)">Forgot password?</a-->
			</form>
          </div>
        </div>
		<div class="panel panel-default text-center" id="forget" style="display:none">
          <img src="images/reset.png" class="img-circle" width="110px" height="110px">
          <div class="panel-body">
		    <form method="post" name="forgetpass" onsubmit="doSubmit()"  >
			
			
            
			<?php 
			 if(isset($_POST['femail']))
			 {
				 $rquery="SELECT * FROM userdata WHERE email='".$_POST['femail']."';";
				 $rqueryexec=@mysqli_query($conn,$rquery);
				 if($rrow=@mysqli_fetch_assoc($rqueryexec))
				 {
					 echo "OTP is Sent to the Registered Mobile Number\n";
					 echo "<input class=\"form-control\" type=\"text\" name=\"OTP\" placeholder=\"Enter OTP\" required><input type=\"submit\" class=\"btn btn-primary\" value=\"Verify\"/> ";
					 include('way2sms-api.php');
					 $temp=rand(100000,999999)."I".$rrow['id'];
					 $_SESSION['OTP']=$temp;
					 sendWay2SMS('USERNAME' , 'PASSWORD' ,$rrow['mobile'], 'Your OTP for SocioWorld is '.$temp); 
                     echo "<script>changeform(2);</script>";					 
				 }
				 else
				 {
					 echo "<script>alert(\"Invalid Email\");</script>";
				 }
				 
			 }
			 if (!isset($_SESSION['OTP']))
			 echo "<input class=\"form-control\" type=\"text\" name=\"femail\" placeholder=\"Enter your Email\" required><input type=\"submit\" class=\"btn btn-primary\" value=\"Reset Password\"/> ";
		     if(isset($_POST['OTP']) && $_POST['OTP']==$_SESSION['OTP'])
			 {
				 $variable= explode("I",$_POST['OTP']);				 
				 unset($_SESSION['OTP']);
				 $_SESSION['uid']=$variable[1];
				echo "<script> window.location=\"settings.php\"</script>";
				
			 }
			?>
            
            <a  class="forgot-password" onclick="changeform(1)">Back to Login</a>
			</form>
          </div>
        </div>
      </div>

    </div>
  </div>

<?php include "footer.php"?>