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
             
                       <div class="panel panel-default">
                    <div class="panel-body">
                      <form class="form-horizontal" role="form" method="post">
           
                        <div class="form-group">
                          <div class="col-sm-9">
                            <div class="input-group">
                              <input type="text" class="form-control" name="searchtext" placeholder="Search ..." required>
                              <span class="input-group-btn">
                                        <button class="btn btn-inverse" type="submit">Search <i class="fa fa-search"></i></button>
                                    </span>
                            </div>
                            <!-- /input-group -->
                          </div>
                        </div>
                       
                      </form>
                    </div>
                  </div>
		<?php
		if(isset($_POST['searchtext']))
		{$query1="SELECT * FROM userdata WHERE name LIKE '".$_POST['searchtext']."%' ORDER BY name;";
			     $query_run1=@mysqli_query($conn,$query1);
	             if(@mysqli_num_rows($query_run1))
			    {
					while ($rows=@mysqli_fetch_assoc($query_run1))
					{echo "<div class=\"col-md-6 col-lg-4 item\">
                <div class=\"panel panel-default\">
                  <div class=\"panel-heading\">
                    <div class=\"media\">
                      <div class=\"pull-left\">
                        <img src=\"upload/user_profile_pictures/".$rows['profilepic']."\" alt=\"".$rows["name"]."\" class=\"media-object img-circle\" width=\"80\" height=\"80\" />
                      </div>
                      <div class=\"media-body\">
                        <h4 class=\"media-heading margin-v-5\"><a href=\"profile.php?profileid=".$rows['id']."\">".$rows['name']."</a></h4>
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
        <!-- /st-content-inner -->

      </div>
      <!-- /st-content -->

    </div>
    <!-- /st-pusher -->

  <?php include "footer.php";
	  ?>