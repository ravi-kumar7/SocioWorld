<?php
 session_start();
$title="SocioWorld";
$username="N/A";
$msg="";
$profilepic="upload/user_profile_pictures/";
  if(!isset($_SESSION['uid']))
  {
	  header('Location: login.php');
  }
  require "../includes/conn.php";
  if(isset($_POST['status']))
  {    
	   $date = date("d F Y H:i a");	
	  if(isset($_FILES['picupload']) AND basename($_FILES['picupload']['name'])!="")
	  { $type="photo";
        $target_path1 = "upload/post_pics/";
		$target_path1 = $target_path1.basename( $_FILES['picupload']['name']);
		move_uploaded_file($_FILES['picupload']['tmp_name'], $target_path1);
		$variable= explode(".",basename( $_FILES['picupload']['name']));	  
		$query = "INSERT INTO posts(post_content,addedby,time,ptype,photourl) VALUES('".$_POST['status']."','".$_SESSION['uid']."','".$date."','".$type."','".basename($_FILES['picupload']['name'])."');";
		@mysqli_query($conn,$query);
	  }
      else
	  {$type="text";
		$query = "INSERT INTO posts(post_content,addedby,time,ptype) VALUES('".$_POST['status']."','".$_SESSION['uid']."','".$date."','".$type."');";
		@mysqli_query($conn,$query);
	  }
  
  }
?>
<!DOCTYPE html>
<html class="st-layout ls-top-navbar ls-bottom-footer show-sidebar sidebar-l2" lang="en">

<?php include "header.php";
include "bodyhead.php";
?>
<script>

   function validate2()
   { 
   var file= post.picupload.value;
   var reg = /(.*?)\.(jpg|bmp|jpeg|png|JPG|JPEG|PNG|BMP)$/;
   if(!file.match(reg))
   {  
	document.getElementById('picupload').value="";
	alert("Invalid Image");
   }
   else
   {    var temp = file.split("\\");
	   document.getElementById('imagename').innerHTML=temp[temp.length-1];
	   document.getElementById('imagename').style.visibility='visible';
   }
   }
   function remove()
   {
	   var temp = confirm("Remove Attachment?");
	   if(temp)
	   {document.getElementById('picupload').value="";
	   document.getElementById('imagename').innerHTML="IMAGE NAME";
	   document.getElementById('imagename').style.visibility='hidden';
       } 
   }
   function ajax(data)
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
			window.location="index.php";
		}			
	}
	
	xmlhttp.open('GET',data,true);
	xmlhttp.send();
   }
   function addcomment(msg)
   {
	 
	 ajax('comments.php?type=add&data='+msg+'&comment='+document.getElementById('commentinput'+msg).value);
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

            <div class="timeline row" data-toggle="isotope">
              <div class="col-xs-12 col-md-15">
                <div class="timeline-block">
                  <div class="panel panel-default share clearfix-xs">
                    <div class="panel-heading panel-heading-gray title">
                      What&acute;s new
                    </div>
                    <div class="panel-body">
					<form name="post" method="post" enctype="multipart/form-data" >
                      <textarea name="status" class="form-control share-text" rows="3" placeholder="Share your status..." required></textarea>
                    </div>
                    <div class="panel-footer share-buttons">
					  
                      <input type="file" style="display:none;" name="picupload" id="picupload" onChange="validate2();" /><a href="#" onclick="document.getElementById('picupload').click();"><i class="fa fa-photo"></i></a><a href="#" style="width:300px;visibility:hidden;" onclick="remove();" id="imagename">IMAGE NAME</a>
                      <button type="submit" class="btn btn-primary btn-xs pull-right" onclick="return val();">Post <i class="fa fa-send"></i></button>
                    </form>
					</div>
                  </div>
                </div>
              </div>
              

          </div>
		  <?php
		          $query = "SELECT * FROM userdata WHERE id=".$_SESSION['uid']."";
				  $queryexec = @mysqli_query($conn,$query);
				  if(@mysqli_num_rows($queryexec))
				  {	 $r = @mysqli_fetch_assoc($queryexec);
			         $friendarray = $r['friendarray'].",".$_SESSION['uid'];
			         $temp = explode(",",$r['friendarray']);
					 $query2= "SELECT * FROM posts ORDER BY time DESC;";
					 $var=false;
					 $q=@mysqli_query($conn,$query2);
					 if(@mysqli_num_rows($q))
					 { 
				       while($post=@mysqli_fetch_assoc($q))
				       {  
				           if($post['addedby']==$_SESSION['uid'])
						   {
							   $var=true;
							   echo "<div class=\"col-xs-12 col-md-15 \">
												<div class=\"timeline-block\">
												  <div class=\"panel panel-default\">

													<div class=\"panel-heading\">
													  <div class=\"media\" >
														<div class=\"media-left\" \">
														  <a href=\"\" >
															<center><img width=\"50px\" height=\"50px\" src=\"upload/user_profile_pictures/".$r['profilepic']."\"  class=\"media-object\">
														  </a>
														</div>
														<div class=\"media-body\">

														  <a href=\"profile.php\">".$r['name']."</a>

														  <span>on ".$post['time']."</span>
														</div>
													  </div>
													</div>
								<p style=\"margin:10px 10px 0px 10px;\">".$post['post_content']."</p>";
								if($post['ptype']=="photo")
										echo "<center><img src=\"upload/post_pics/".$post['photourl']."\" style=\"margin:10px;width:275px;height:180px;\"></center>";
									echo "<ul class=\"comments\">";
                         $cquery="SELECT * FROM comments WHERE pid=".$post['pid']." ORDER BY time DESC;";
                         $cqueryExec = @mysqli_query($conn,$cquery);
						 if(@mysqli_num_rows($cqueryExec))
                          {
                            while($crow=@mysqli_fetch_assoc($cqueryExec))
								{ $cpquery="SELECT * FROM userdata WHERE id=".$crow['commentby'].";";
                                  $cpqueryExec = @mysqli_query($conn,$cpquery);
						          $cprow=@mysqli_fetch_assoc($cpqueryExec);
								  echo"		
													  <li clas=\"media\">
														<div class=\"media-left\">
														  <a href=\"\">
															<img width=\"50px\" height=\"50px\" src=\"upload/user_profile_pictures/".$cprow['profilepic']."\" class=\"media-object\" >
														  </a>
														</div>
														<div class=\"media-body\">
														 
														  <a href=\"profile.php?profileid=".$crow['commentby']."\" class=\"comment-author\">".$cprow['name']."</a>
														  <span>".$crow['comment']."</span>
														  <div class=\"comment-date\">".$crow['time']."</div>
														</div>
													  </li>
													  ";
								}
                          }
						echo "<li class=\"comment-form\">
														<div class=\"input-group\">

														  <input type=\"text\" class=\"form-control\" id=\"commentinput".$post['pid']."\" />

														  <span class=\"input-group-btn\">
												   <a href=\"#\" class=\"btn btn-default\" onclick=\"addcomment(".$post['pid'].")\"><i class=\"fa fa-send\"></i></a>
												</span>

														</div>
													  </li>
													</ul>
												  </div>

												</div>
											  </div>";
						   }
						else
						{	
					       foreach($temp as $f)
			           {  if($post['addedby']==$f)
						   {  
					          $fquery="SELECT * FROM userdata WHERE id=".$f."";
					          $fqueryexec = @mysqli_query($conn,$fquery);
							  if(@mysqli_num_rows($fqueryexec))
							  {	  $frow=@mysqli_fetch_assoc($fqueryexec);
					          echo "<div class=\"col-xs-12 col-md-15 \">
												<div class=\"timeline-block\">
												  <div class=\"panel panel-default\">

													<div class=\"panel-heading\">
													  <div class=\"media\" >
														<div class=\"media-left\" \">
														  <a href=\"#\" >
															<center><img width=\"50px\" height=\"50px\"src=\"upload/user_profile_pictures/".$frow['profilepic']."\" class=\"media-object\">
														  </a>
														</div>
														<div class=\"media-body\">

														  <a href=\"profile.php?profileid=".$f."\">".$frow['name']."</a>

														  <span>on ".$post['time']."</span>
														</div>
													  </div>
													</div>
								<p style=\"margin:10px 10px 0px 10px;\">".$post['post_content']."</p>";
								if($post['ptype']=="photo")
										echo "<center><img  src=\"upload/post_pics/".$post['photourl']."\" style=\"margin:10px;width:275px;height:180px;\"></center>";
									echo "<ul class=\"comments\">";
                         $cquery="SELECT * FROM comments WHERE pid=".$post['pid']." ORDER BY time DESC;";
                         $cqueryExec = @mysqli_query($conn,$cquery);
						 if(@mysqli_num_rows($cqueryExec))
                          {
                            while($crow=@mysqli_fetch_assoc($cqueryExec))
								{ $cpquery="SELECT * FROM userdata WHERE id=".$crow['commentby'].";";
                                  $cpqueryExec = @mysqli_query($conn,$cpquery);
						          $cprow=@mysqli_fetch_assoc($cpqueryExec);
								  echo"		
													  <li clas=\"media\">
														<div class=\"media-left\">
														  <a href=\"\">
															<img width=\"50px\" height=\"50px\" src=\"upload/user_profile_pictures/".$cprow['profilepic']."\" class=\"media-object\" >
														  </a>
														</div>
														<div class=\"media-body\">
														 
														  <a href=\"profile.php?profileid=".$crow['commentby']."\" class=\"comment-author\">".$cprow['name']."</a>
														  <span>".$crow['comment']."</span>
														  <div class=\"comment-date\">".$crow['time']."</div>
														</div>
													  </li>
													  ";
								}
                          }
						echo "<li class=\"comment-form\">
														<div class=\"input-group\">

														  <input type=\"text\" class=\"form-control\" id=\"commentinput".$post['pid']."\" />

														  <span class=\"input-group-btn\">
												   <a href=\"#\" class=\"btn btn-default\" onclick=\"addcomment(".$post['pid'].")\"><i class=\"fa fa-send\"></i></a>
												</span>

														</div>
													  </li>
													</ul>
												  </div>

												</div>
											  </div>";	
							  }
							break;
						   }
					    }
					   }
						
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


<?php include "footer.php";?>
<?php ob_end_flush()?>