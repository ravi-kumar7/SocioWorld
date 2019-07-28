<?php
session_start();
$title="Messages | SocioWorld";
$username="N/A";
$msg="";
  require "../includes/conn.php";
  if(!isset($_SESSION['uid']))
  {
	  header('Location: login.php');
  }
?>
<!DOCTYPE html>
<html class="st-layout ls-top-navbar ls-bottom-footer show-sidebar sidebar-l2" lang="en">
<?php include "header.php";
include "bodyhead.php";
?>
<script type="text/javascript">
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
			window.location=<?php if(isset($_GET['chatid'])) echo "\"messagesmain.php?chatid=". $_GET['chatid']."\""?>;
		}			
	}
	xmlhttp.open('GET','message_handle.php?msg='+temp+'&t='+<?php if(isset($_GET['chatid'])) echo $_GET['chatid']?>,true);
	xmlhttp.send();
	}
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
    <center><h2>Messages</h2></center>
            <div class="media messages-container media-clearfix-xs-min media-grid" style="width:100%">
              <div class="media-body">
                <div class="panel panel-default share">
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button class="btn btn-primary" onclick="sendmsg();"><i class="fa fa-envelope"></i> Send</button>
                    </div>
					
                    <!-- /btn-group -->
                    <input type="text" class="form-control share-text" placeholder="Write message..." name="msgtext" id="msgtext" required />
                  </div>
				  
                  <!-- /input-group -->
                </div>
                      <?php
					  if(isset($_GET['chatid']))
					  {
					  $mquery = "SELECT * FROM messages WHERE (to_user=".$_SESSION['uid']." AND from_user=".$_GET['chatid'].") OR (to_user=".$_GET['chatid']." AND from_user=".$_SESSION['uid'].") ORDER BY time DESC;";
					  $queryrun=@mysqli_query($conn,$mquery);
					  if(@mysqli_num_rows($queryrun))
					  { $var=true;
					  while($row=@mysqli_fetch_assoc($queryrun))
					  {  
				        $pfetch="SELECT * FROM userdata WHERE id=".$row['from_user'].";";
						  $pqueryexec= @mysqli_query($conn,$pfetch);
						  $prow = @mysqli_fetch_assoc($pqueryexec);
				   if($row['from_user']==$_GET['chatid'])
				  echo "<div class=\"media\" style=\"margin:10px 10px 0px 0px\">
                  <div class=\"media-left\">
                    <a href=\"#\">
                      <img src=\"upload/user_profile_pictures/".$prow['profilepic']."\" width=\"60\" alt=\"".$prow['name']."\" class=\"media-object\" />
                    </a>
                  </div>
                  <div class=\"media-body message\">
                    <div class=\"panel panel-default\">
                      <div class=\"panel-heading panel-heading-white\">
                        <div class=\"pull-right\">
                          <small class=\"text-muted\">".$row['time']."</small>
                        </div>
                        <a href=\"profile.php?profileid=".$_GET['chatid']."\">".$prow['name']."</a>
                      </div>
                      <div class=\"panel-body\">
                        ".$row['message']."

                      </div>
                    </div>
                  </div>
                </div>";
				else
                echo "<div class=\"media\" style=\"margin:10px 10px 0px 0px\">
                  <div class=\"media-body message\">
                    <div class=\"panel panel-default\">
                      <div class=\"panel-heading panel-heading-white\">
                        <div class=\"pull-right\">
                          <small class=\"text-muted\">".$row['time']."</small>
                        </div>
                        <a href=\"profile.php\">Me</a>
                      </div>
                      <div class=\"panel-body\">
                        ".$row['message']."
                      </div>
                    </div>
                  </div>
				  <div class=\"media-right\">
                    <img src=\"upload/user_profile_pictures/".$prow['profilepic']."\" width=\"60\" alt=\"me\" class=\"media-object\" />
                  </div>
				  ";
					  }
					  }
                     else 
					 echo "<li class=\"list-group-item \" style=\"height:350px\" >
                       <center><h4>No Messages!</h4></center>
                      </li>";
					  }
					  else
					  {
						  echo "<script type=\"text/javascript\">window.location=\"index.php\"</script>";
					  }
					  ?>
              </div>
            </div>

          </div>

        </div>
        <!-- /st-content-inner -->

      </div>
      <!-- /st-content -->

    </div>
    <!-- /st-pusher -->

   <?php include "footer.php";?>
<?php ob_end_flush()?>