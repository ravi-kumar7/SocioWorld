<?php
session_start();
if(isset($_SESSION['uid']) && isset($_GET['type']))
{
	require "../includes/conn.php";

	switch($_GET['type'])
	{ case "add":
		$query = "SELECT friendarray FROM userdata WHERE id=".$_SESSION['uid'].";";
		if($query_run=@mysqli_query($conn,$query))
			{
				$row = mysqli_fetch_assoc($query_run);
				$temp= $row['friendarray'];
				if($temp=="")
				$temp= $temp.$_GET['fa'];
				else
				$temp= $temp.",".$_GET['fa'];
			    echo $temp;
				$query = "UPDATE userdata SET friendarray='".$temp."' WHERE id=".$_SESSION['uid'].";";
				@mysqli_query($conn,$query);
			}
			$query = "SELECT friendarray FROM userdata WHERE id=".$_GET['fa'].";";
		if($query_run=@mysqli_query($conn,$query))
			{
				$row = mysqli_fetch_assoc($query_run);
				$temp= $row['friendarray'];
				if($temp=="")
				$temp= $temp.$_SESSION['uid'];
				else
				$temp= $temp.",".$_SESSION['uid'];
			    echo $temp;
				$query = "UPDATE userdata SET friendarray='".$temp."' WHERE id=".$_GET['fa'].";";
				@mysqli_query($conn,$query);
			}
			$query1 = "DELETE FROM friendrequest WHERE from_user=".$_GET['fa']." AND to_user=".$_SESSION['uid'].";";
	if(@mysqli_query($conn,$query1));
		echo $_GET['fa'];
		break;
	case "del":
		$query1 = "DELETE FROM friendrequest WHERE from_user=".$_GET['fa']." AND to_user=".$_SESSION['uid'].";";
	if(@mysqli_query($conn,$query1));
		echo $_GET['fa'];
		break;
		
	case "rf":
	$query = "SELECT friendarray FROM userdata WHERE id=".$_SESSION['uid'].";";
		if($query_run=@mysqli_query($conn,$query))
			{
				$row = mysqli_fetch_assoc($query_run);
				$var= explode(",",$row['friendarray']);
				$temp="";
				foreach($var as $friend)
				{ 
				if($friend!=$_GET['fa'])
					{if($temp=="")
				  $temp= $temp.$friend;
				 else
				  $temp= $temp.",".$friend;
					}
				}
				$query = "UPDATE userdata SET friendarray='".$temp."' WHERE id=".$_SESSION['uid'].";";
				@mysqli_query($conn,$query);
			}
		$query = "SELECT friendarray FROM userdata WHERE id=".$_GET['fa'].";";
		if($query_run=@mysqli_query($conn,$query))
			{
				$row = mysqli_fetch_assoc($query_run);
				$var= explode(",",$row['friendarray']);
				$temp="";
				foreach($var as $friend)
				{ 
				echo $friend."\n";
				if($friend!=$_SESSION['uid'])
					{if($temp=="")
				  $temp= $temp.$friend;
				 else
				  $temp= $temp.",".$friend;
					}
				}
				$query = "UPDATE userdata SET friendarray='".$temp."' WHERE id=".$_GET['fa'].";";
				@mysqli_query($conn,$query);
			}
	break;
	}
	
}
?>