<?php
session_start();
if(isset($_SESSION['uid'])&& isset($_GET['type']))
{
	require "../includes/conn.php";
	switch($_GET['type'])
	{ case "add":
	$query = "INSERT INTO friendrequest(from_user,to_user) VALUES('".$_SESSION['uid']."','".$_GET['t']."') ;";
	if(@mysqli_query($conn,$query))
		echo $_SESSION['uid'];
	break;
	case "del":
	$query1 = "DELETE FROM friendrequest WHERE from_user=".$_GET['f']." AND to_user=".$_SESSION['uid'].";";
	if(@mysqli_query($conn,$query1))
		echo $_SESSION['uid'];
	break;
	case "fetch":
			  $query_friendrequest_fetch="SELECT * FROM friendrequest WHERE to_user='".$_SESSION['uid']."';";
			 $query_run2=@mysqli_query($conn,$query_friendrequest_fetch);
	         if(@mysqli_num_rows($query_run2))
			 {
				 while(($row=@mysqli_fetch_assoc($query_run2)))
				 {
				$query_fdata="SELECT * FROM userdata WHERE id='".$row['from_user']."';";
				$queryexec=@mysqli_query($conn,$query_fdata);
				if(@mysqli_num_rows($queryexec))
				{    $row_data=@mysqli_fetch_assoc($queryexec);
						echo "<li class=\"media\">
                  <div class=\"media-left\">
                    <a href=\"#\">
                      <img class=\"media-object thumb\" src=\"upload/user_profile_pictures/".$row_data['profilepic']."\" alt=\"people\">
                    </a>
                  </div>
                  <div class=\"media-body\">
                    <div class=\"pull-right\">
                      <span class=\"label label-default\" onclick=\"accept(".$row_data['id'].")\" id=\"accept".$row_data['id']."\"\">Accept</span>
                    </div><div class=\"pull-right\">
                    </div>
                    <p class=\"margin-none\" id=\"message".$row_data['id']."\">You have a friend Request from ".$row_data['name']."</p>
                  </div>
                </li>";
				}
				 }
	    }
		else
			echo "<li class=\"media\">
                  <div class=\"media-body\">
                    <Center><p class=\"margin-none\">No Friend Requests</p></center>
                  </div>
                </li>
                
              ";
	break;
	}
	
}
?>