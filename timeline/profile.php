<?php
 session_start();
$title="SocioWorld";
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
if(isset($_GET['profileid']) && $uid!=$_GET['profileid'])
{
	$uid = $_GET['profileid'];
}
$query="SELECT * FROM userdata WHERE id='".$uid."';";
			 $query_run=@mysqli_query($conn,$query);
	         if(@mysqli_num_rows($query_run))
			 {$row=@mysqli_fetch_assoc($query_run);
              $username=$row['name'];
			  $title=$username." | SocioWorld";
              $gender=$row['gender'];
			  $about=$row['about'];
			  $dob=$row['dob'];
			  $mobile=$row['mobile'];
			  $location=$row['location'];
			  $website=$row['website'];
			  $highedu=$row['highedu'];
			  $email=$row['email'];
			  $job=$row['job'];
			  if($row['profilepic']!="")
			  { $profilepic="upload/user_profile_pictures/";
		      $profilepic.=$row['profilepic'];				   
			 }
			 }
			 else
			 header('Location: index.php');
?>
<!DOCTYPE html>
<html class="st-layout ls-top-navbar ls-bottom-footer show-sidebar sidebar-l2" lang="en">

<?php include "header.php";
include "bodyhead.php";
?>

<script>
function ca()
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
			document.getElementById('addfriend').innerHTML="<a href=\"#\" class=\"btn btn-fail\" >Request Sent <i class=\"fa fa-check\"></i></a><button class=\"btn btn-danger\" onclick=\"cancel();\">Cancel Request</button>";
	}
	
	xmlhttp.open('GET',<?php if(isset($_GET['profileid']))echo "'friendrequest.php?type=add&t=".$_GET['profileid']."'"?>,true);
	xmlhttp.send();
	
}
function cancel()
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
			document.getElementById('addfriend').innerHTML="<a onclick=\"ca()\" href=\"#\" class=\"btn btn-success\" >Add Friend <i class=\"fa fa-plus-circle\"></i></a>";
	}
	
	xmlhttp.open('GET',<?php if(isset($_GET['profileid']))echo "'friendrequest.php?type=del&f=".$_SESSION['uid']."&t=".$_GET['profileid']."'"?>,true);
	xmlhttp.send();
	}
}
function rf(msg)
{  var result = confirm("Remove Friend?");
	if(result)
	{	if(window.XMLHttpRequest)
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
			document.getElementById('removefriend').innerHTML="<a onclick=\"ca()\" href=\"#\" class=\"btn btn-success\" >Add Friend <i class=\"fa fa-plus-circle\"></i></a>";
		}			
	}
	xmlhttp.open('GET','friendrequest_handle.php?type=rf&fa='+msg,true);
	xmlhttp.send();
	}
}
function sendmsg()
{   var temp=document.getElementById('msgtext').value; 
    if(temp!="")
	{if(window.XMLHttpRequest)
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
			document.getElementById('msgtext').value="";
			document.getElementById('mresponse').style.display="block";
			setTimeout(hide,1000);
		}			
	}
	xmlhttp.open('GET','message_handle.php?msg='+temp+'&t='+<?php if(isset($_GET['profileid'])) echo $_GET['profileid']?>,true);
	xmlhttp.send();
	}
}
function hide()
{
	document.getElementById('mresponse').style.display="none";
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

            <div class="media media-grid media-clearfix-xs">
              <div class="media-left">

                <div class="width-250 width-auto-xs">
                  <div class="panel panel-default widget-user-1 text-center">
                    <div class="avatar">
                      <a href="<?php if($uid==$_SESSION['uid'])echo "editpic.php?pid=".$_SESSION['uid']; else echo "#";?>"><img src="<?php echo $profilepic;?>" alt="" class="img-circle"></a>
                      
					  <h3><?php echo $username;?></h3>
                      <?php 
			if(isset($_GET['profileid']))
				{ $var=false;	  
			      $query = "SELECT friendarray FROM userdata WHERE id=".$_SESSION['uid'].";";
		             if($query_run=@mysqli_query($conn,$query))
						{
							$row = @mysqli_fetch_assoc($query_run);
							$temp= $row['friendarray'];
							$variable= explode(",",$row['friendarray']);
							foreach($variable as $friend)
							{
								if($friend==$_GET['profileid'])
								{
									 echo "<div id=\"removefriend\"><a onclick=\"rf(".$_GET['profileid'].")\" href=\"#\" class=\"btn btn-success\" >Remove Friend <i class=\"fa fa-remove\"></i></a></div>";
									 $var=true;
									 break;
								}
							}
				        } 
			           if( $_SESSION['uid']!=$_GET['profileid'] && !$var)
					  {
						  $query1="SELECT * FROM friendrequest WHERE from_user='".$_SESSION['uid']."' AND to_user='".$_GET['profileid']."';";
			              $query_run1=@mysqli_query($conn,$query1);
						  if(@mysqli_num_rows($query_run1)>0)
						  echo "<div id=\"addfriend\"><a href=\"#\" class=\"btn btn-fail\" >Request Sent <i class=\"fa fa-check\"></i></a>
					      <button class=\"btn btn-danger\" onclick=\"cancel();\">Cancel Request</button></div>";
						  else					  
						  echo "<div id=\"addfriend\"><a onclick=\"ca()\" href=\"#\" class=\"btn btn-success\" >Add Friend <i class=\"fa fa-plus-circle\"></i></a></div>";
					  }
				}
					  ?>
					</div>
                    <div class="profile-icons margin-none">
                    </div>
                    <div class="panel-body">
                      <div class="expandable expandable-indicator-white expandable-trigger">
                        <div class="expandable-content">
                          <?php echo $about;?>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Contact -->
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      Contact
                    </div>
                    <ul class="icon-list icon-list-block">
                      <li><i class="fa fa-envelope fa-fw"></i> <?php echo "<a href=\"mailto:".$email."\">".$email."</a>";?></li>
                      <li><i class="fa fa-link fa-fw"></i> <?php echo "<a href=\"http://".$website."\" target=\"_blank\">".$website."</a>";?></li>
                      <li><i class="fa fa-mobile fa-fw"></i> <a href="#"><?php echo $mobile;?></a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="media-body">
			  <?php 
			         
					  if(isset($_GET['profileid']))
					  echo "<center><p style=\"color:blue;display:none;\" id=\"mresponse\" >Message Sent!</p></center>
				  <div class=\"panel panel-default share\">
                  <div class=\"input-group\">
                    <div class=\"input-group-btn\">
                      <button class=\"btn btn-primary\" onclick=\"sendmsg();\"><i class=\"fa fa-envelope\"></i> Send</button>
                    </div>
                    <input type=\"text\" class=\"form-control share-text\" placeholder=\"Write message...\" name=\"msgtext\" id=\"msgtext\" required />
					  
                  </div>
                </div>
				";
				
				?>
                

              
                <div class="row">
                  <div class="col-md-6">
                    <div class="panel panel-default">
                      <div class="panel-heading panel-heading-gray">
					  <?php 
                        if(!isset($_GET['profileid']))
						echo "<a href=\"edit.php\" class=\"btn btn-white btn-xs pull-right\"><i class=\"fa fa-pencil\"></i></a>";  
						
						?>
                        <i class="fa fa-fw fa-info-circle"></i> About
                      </div>
                      <div class="panel-body">
                        <ul class="list-unstyled profile-about margin-none">
                          <li class="padding-v-5">
                            <div class="row">
                              <div class="col-sm-4"><span class="text-muted">Date of Birth</span></div>
                              <div class="col-sm-8"> <?php echo $dob;?></div>
                            </div>
                          </li>
                          <li class="padding-v-5">
                            <div class="row">
                              <div class="col-sm-4"><span class="text-muted">Job</span></div>
                              <div class="col-sm-8"> <?php echo $job;?></div>
                            </div>
                          </li>
                          <li class="padding-v-5">
                            <div class="row">
                              <div class="col-sm-4"><span class="text-muted">Gender</span></div>
                              <div class="col-sm-8"><?php echo $gender;?></div>
                            </div>
                          </li>
                          <li class="padding-v-5">
                            <div class="row">
                              <div class="col-sm-4"><span class="text-muted">Lives in</span></div>
                              <div class="col-sm-8"><?php echo $location;?></div>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="panel panel-default">
                      <div class="panel-heading panel-heading-gray">
                        <div class="pull-right">
                          <a href="friends.php<?php if(isset($_GET['profileid']))echo "?of=".$_GET['profileid'] ?>" class="btn btn-primary btn-xs">View All Friends <i class="fa fa-users"></i></a>
                        </div>
                        <i class="icon-user-1"></i> Friends
                      </div>
                      <div class="panel-body">
                        <ul class="img-grid">
						  <?php 
						    if(isset($_GET['profileid']))
								$fid=$_GET['profileid'];
							else
								$fid=$_SESSION['uid'];
							$query = "SELECT friendarray FROM userdata WHERE id=".$fid.";";
							if($query_run=@mysqli_query($conn,$query))
							{
								$row=@mysqli_fetch_assoc($query_run);
								if($row['friendarray']!="")
								{
								$variable= explode(",",$row['friendarray']);
								$var=0;
								foreach($variable as $friend)
								{ if($var>9)
									break;
								$subquery="SELECT * FROM userdata WHERE id=".$friend.";";
								$query_run1=@mysqli_query($conn,$subquery);
								$rowss=@mysqli_fetch_assoc($query_run1);
								echo "<li><a href=\"profile.php?profileid=".$friend."\"><img src=\"upload/user_profile_pictures/".$rowss['profilepic']."\" width=\"105px\" height=\"105px\" alt=\"".$rowss['name']."\" /></a></li>";
								$var++;
								}
								}
								else
									echo "No Friends";
							}
							
						  ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
  <div class="tabbable">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#home" data-toggle="tab"><i class="fa fa-fw fa-picture-o"></i> Photos</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane fade active in" id="home">
					<?php 
					$fphoto = "SELECT * FROM posts WHERE ptype='photo' AND addedby=".$_SESSION['uid']."";
					$fpqueryexec = @mysqli_query($conn,$fphoto);
					while($prow=@mysqli_fetch_assoc($fpqueryexec))
					{
						echo "<img src=\"upload/post_pics/".$prow['photourl']."\" width=\"120px\" height=\"120px\"/>";
					}
					?>
                    </div>
                    
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
    