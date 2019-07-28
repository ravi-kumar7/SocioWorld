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
              <div>
                <div class="messages-list " style="width:100%" >
                  <div class="panel panel-default" >
                    <ul class="list-group">
                      <?php
					  $mquery = "SELECT * FROM messages WHERE to_user=".$_SESSION['uid']." ORDER BY time DESC;";
					  $queryrun=@mysqli_query($conn,$mquery);
					  if(@mysqli_num_rows($queryrun))
					  { $var=true;
					  while($row=@mysqli_fetch_assoc($queryrun))
					  {  if($var)
						  { echo "<li class=\"list-group-item active\" >";
							$var=false;
						  }
						  else
						  {   echo "<li class=\"list-group-item\" >";
							  $var=true;
						  }
						  $pfetch="SELECT * FROM userdata WHERE id=".$row['from_user'].";";
						  $pqueryexec= @mysqli_query($conn,$pfetch);
						  $prow = @mysqli_fetch_assoc($pqueryexec);
						  echo "<a href=\"messagesmain.php?chatid=".$row['from_user']."\">
                          <div class=\"media\">
                            <div class=\"media-left\">
                              <img src=\"upload/user_profile_pictures/".$prow['profilepic']."\" width=\"50\" alt=\"".$prow['name']."\" class=\"media-object\" />
                            </div>
                            <div class=\"media-body\">
                              <span class=\"date\">".$row['time']."</span>
                              <span class=\"user\">".$prow['name']."</span>
                              <div class=\"message\">".$row['message']."</div>
                            </div>
                          </div>
                        </a>
                      </li>";
					  }
					  }
                     else 
					 echo "<li class=\"list-group-item \" style=\"height:350px\" >
                       <center><h4>No Messages!</h4></center>
                      </li>";
					  ?>
                    </ul>
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

   <?php include "footer.php";?>
<?php ob_end_flush()?>