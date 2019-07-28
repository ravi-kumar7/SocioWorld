<?php
 session_start();
 if(!isset($_SESSION['uid']))
  {
	  header('Location: login.php');
  }
$title="SocioWorld";
  
  require "../includes/conn.php";

?>

<!DOCTYPE html>
<html class="st-layout ls-top-navbar ls-bottom-footer show-sidebar sidebar-l2" lang="en">

<?php include "header.php";
include "bodyhead.php";
?>
<script>
function ca(msg1)
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
		{   var temp = xmlhttp.responseText;
			document.getElementById('addfriend'+temp).innerHTML="<a href=\"#\" class=\"btn btn-fail\" onclick=\"cancel("+temp+");\" >Request Sent <i class=\"fa fa-check\"></i></a>";
		}
	}
	
	xmlhttp.open('GET',<?php echo "'friendrequest.php?type=add&f=".$_SESSION['uid']."&t='+msg1"?>,true);
	xmlhttp.send();
	
}
function cancel(msg)
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
		{var temp = xmlhttp.responseText;
			document.getElementById('addfriend'+temp).innerHTML="<span class=\"label label-primary\" onclick=\"ca("+temp+");\">Add Friend <i class=\"fa fa-plus-circle\"></i></span>";
		}
	}
	
	xmlhttp.open('GET',<?php echo "'friendrequest.php?type=del&f=".$_SESSION['uid']."&t='+msg"?>,true);
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
            <div class="page-section">
              <div class="row">
                  <h4 class="page-section-heading">Search Result for <?php echo "\"".$_GET['searchquery']."\"" ?></h4>
                  <div class="panel panel-default" style="width:100%">
                    <!-- Progress table -->
                    <div class="table-responsive">
                      <table class="table v-middle" >
                        <thead>
                          <tr>
                            
                            <th>Name</th>
                            <th>Email</th>
                            <th>Location</th>
                            <th>Work</th>
							<th></th>
                          </tr>
                        </thead>
                        <tbody id="responsive-table-body">
							<?php 
							if(isset($_GET['searchquery']))
							{$query="SELECT * FROM userdata WHERE name LIKE '".$_GET['searchquery']."%' ORDER BY name;";
		 $query_run=@mysqli_query($conn,$query);
	         if(@mysqli_num_rows($query_run))
			 {
				 while(($row=@mysqli_fetch_assoc($query_run)) )
				 {
					 if($row['id']!=$_SESSION['uid'])
					echo "<tr>
                            <td>

                              <img src=\"upload/user_profile_pictures/".$row['profilepic']."\" width=\"40\" class=\"img-circle\" /> <a href=\"profile.php?profileid=".$row['id']."\">".$row['name']."</a>
                            </td>
                            <td>".$row['email']."</td>
                            <td>".$row['location']."<a href=\"#\"><i class=\"fa fa-map-marker fa-fw text-muted\"></i></a></td>
                            <td>
                               ".$row['job']."
                              
                            </td>";
                          $query1="SELECT * FROM friendrequest WHERE from_user='".$_SESSION['uid']."' AND to_user='".$row['id']."';";
			              $query_run1=@mysqli_query($conn,$query1);
						  if(@mysqli_num_rows($query_run1)>0)
						  echo "<td id=\"addfriend".$row['id']."\"><a href=\"#\" class=\"btn btn-fail\" onclick=\"cancel(".$row['id'].");\" >Request Sent <i class=\"fa fa-check\"></i></a></td></tr>";
                          else					  
						  echo "<td id=\"addfriend".$row['id']."\"><span class=\"label label-primary\" onclick=\"ca(".$row['id'].")\">Add Friend <i class=\"fa fa-plus-circle\"></i></span></td></tr>
                          ";
				 }
			 }	 
             }
			 else
				 echo "<script type=\"text/javascript\">
                         window.location = \"index.php\"; </script>"; 
	 ?>
                       
                          
                        </tbody>
                      </table>
                    </div>
                    <!-- // Progress table -->
                 
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