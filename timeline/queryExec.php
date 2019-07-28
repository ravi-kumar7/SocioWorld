<?php
require "../includes/conn.php";
if(isset($_POST["type"]))
{
	$query="SELECT * FROM userdata WHERE email='".$_POST['email']."';";
			 $query_run=@mysqli_query($conn,$query);
	         if(@mysqli_num_rows($query_run)>0)
			 {
				 echo "Account with email ".$_POST['email']." already exists !";
			 }
			 else
			 {$month= $_POST['birthday_month'];
              $day= $_POST['birthday_day'];
              $yr= $_POST['birthday_year'];
              $bday= $day . ' ' . $month . ' ' . $yr  ;
	        $passwd= $_POST['pwd'];
			if(strlen($passwd)<32)
			{
				$passwd=sha1($passwd);
			}
	//$date=date('m/d/y'); 
	$query="INSERT INTO userdata(name,dob,gender,email,password,about,highedu,location,website,mobile,job) VALUES('".$_POST['name']."','".$bday."','".$_POST['gender']."','".$_POST['email']."','".$passwd."','".$_POST['about']."','".$_POST['education']."','".$_POST['location']."','".$_POST['website']."','".$_POST['phone']."','".$_POST['job']."');";
	  if(@mysqli_query($conn,$query))
	  {  $query1="SELECT * FROM userdata WHERE email='".$_POST['email']."';";
			      $query_run=@mysqli_query($conn,$query1);
	            if(@mysqli_num_rows($query_run))
	            {  $rows=@mysqli_fetch_assoc($query_run); 
                   echo $rows['id'];
	  }
	  else
		  echo "ERROR";
	  }
     }
}
else
{ 
$target_path1 = "upload/user_profile_pictures/";
$target_path1 = $target_path1 .basename( $_FILES['uploaded_file']['name']);
      move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $target_path1);
$variable= explode(".",basename( $_FILES['uploaded_file']['name']));	  
$query = "UPDATE userdata SET profilepic='".basename( $_FILES['uploaded_file']['name'])."' WHERE id=".$variable[0].";";
@mysqli_query($conn,$query);
}
?>