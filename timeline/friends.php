<?php
 session_start();
$title=" Friends | SocioWorld";
  if(!isset($_SESSION['uid']))
  {
	  header('Location: login.php');
  }
  require "../includes/conn.php";
  $username="";
  $sid=$_SESSION['uid'];
if(isset($_GET['of']))
{
	$sid=$_GET['of'];
	$query="SELECT * FROM userdata WHERE id='".$_GET['of']."';";
			 $query_run=@mysqli_query($conn,$query);
	         if(@mysqli_num_rows($query_run))
			 {$row=@mysqli_fetch_assoc($query_run);
              $username=$row['name'];
			 }
}
?>
<!DOCTYPE html>
<html class="st-layout ls-top-navbar ls-bottom-footer show-sidebar sidebar-l2" lang="en">

<?php include "header.php";
include "bodyhead.php";
?>
<script type="text/javascript">
function deleterequest(msg1)
{
	var result = confirm("Cancel friend Request?");
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
			window.location="friends.php";
	}
	
	xmlhttp.open('GET','friendrequest.php?type=del&f='+msg1,true);
	xmlhttp.send();
	}
}
function ar(msg)
{  
	if(window.XMLHttpRequest)
	{
		xmlhttp =  new XMLHttpRequest();
	}
	else
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			var temp = xmlhttp.responseText;
			alert("Friend Request Accepted!");
			window.location="friends.php";
		}			
	}
	
	xmlhttp.open('GET','friendrequest_handle.php?type=add&fa='+msg,true);
	xmlhttp.send();
}
</script>
    <!-- content push wrapper -->
    <div class="st-pusher" id="content">

      <!-- sidebar effects INSIDE of st-pusher: -->
      <!-- st-effect-3, st-effect-6, st-effect-7, st-effect-8, st-effect-14 -->

      <!-- this is the wrapper for the content -->
      <div class="st-content">

        <!-- extra div for emulating position:fixed of the menu -->
        <div class="st-content-inner">

          <div class="container-fluid">
<div class="page-section">
              
                    <!-- Progress table -->
                    
							<?php 
							if(!isset($_GET['of']))
							{
								 echo "<div class=\"row\" >
                  <h4 class=\"page-section-heading\">Friend Requests</h4>
				  <center>
                  <div class=\"panel panel-default\" style=\"width:450px\" >";
							  $query_frfetch="SELECT from_user FROM friendrequest WHERE to_user=".$_SESSION['uid']." ORDER BY id;";
		                        $queryexec=@mysqli_query($conn,$query_frfetch);
								 if(@mysqli_num_rows($queryexec))
								 {  
                                     echo "<div class=\"table-responsive\">
                      <table class=\"table v-middle\" >
                        
                        <tbody id=\"responsive-table-body\">";							 
							       while(($friendrequest=@mysqli_fetch_assoc($queryexec)))
									 {
								       $query="SELECT * FROM userdata WHERE id=".$friendrequest['from_user'].";";
		                               $query_run=@mysqli_query($conn,$query);
								       if(@mysqli_num_rows($query_run)>0)
								       {
										 $row=@mysqli_fetch_assoc($query_run);
										 
										  echo "<tr >
													<td>
											  <img src=\"upload/user_profile_pictures/".$row['profilepic']."\" width=\"40\" class=\"img-circle\" /> <a href=\"profile.php?profileid=".$row['id']."\">".$row['name']."</a>
											</td><td><button class=\"btn btn-success\" onclick=\"ar(".$row['id'].");\">Accept <i class=\"fa fa-check\"></i></button> <button class=\"btn btn-danger\" onclick=\"deleterequest(".$row['id'].")\">Delete <i class=\"fa fa-remove\"></i></button></td></tr> 
                    ";
										
									   }
								    }
									echo "</tbody>
                      </table></div></div>";
									
								 }
								else
									echo "<Center>No Friend Requests</center></div>
              </div>
			  </center>
            </div>";
								}
	 ?>
                       
                          
               
                 
                

           

        
            <div id="filter">
                <center><h4><label>Friends <?php if(isset($_GET['of']))echo "of <a href=\"profile.php?profileid=".$_GET['of']."\">".$username."</a>"?></label></h4></center>
            </div>

            <div class="row" data-toggle="isotope" >
			<?php
			  $query="SELECT * FROM userdata WHERE id='".$sid."';";
			 $query_run=@mysqli_query($conn,$query);
	         if(@mysqli_num_rows($query_run))
			 {$row=@mysqli_fetch_assoc($query_run);
              $variable=explode(',',$row['friendarray']);
			  foreach($variable as $friend)
              {  $query1="SELECT * FROM userdata WHERE id='".$friend."';";
			     $query_run1=@mysqli_query($conn,$query1);
	             if(@mysqli_num_rows($query_run1))
			    {$rows=@mysqli_fetch_assoc($query_run1);
			     echo "<div class=\"col-md-6 col-lg-4 item\">
                <div class=\"panel panel-default\">
                  <div class=\"panel-heading\">
                    <div class=\"media\">
                      <div class=\"pull-left\">
                        <img src=\"upload/user_profile_pictures/".$rows['profilepic']."\" alt=\"".$rows["name"]."\" class=\"media-object img-circle\" width=\"80\" height=\"80\" />
                      </div>
                      <div class=\"media-body\">
                        <h4 class=\"media-heading margin-v-5\"><a href=\"profile.php?profileid=".$friend."\">".$rows['name']."</a></h4>
                        <div class=\"profile-icons\">
                          <span><i class=\"fa fa-users\"></i> ".count(explode(",",$rows['friendarray']))."</span>
                          <span><i class=\"fa fa-birthday-cake\"></i> ".$rows['dob']."</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </div>";
			  }
			 }
			 }
              ?>
          </div>

        </div>
        <!-- /st-content-inner -->

      </div>
      <!-- /st-content -->

    </div>
    <!-- /st-pusher -->

  <?php include "footer.php";
	  ?>