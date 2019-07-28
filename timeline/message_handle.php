<?php
session_start();
if(isset($_SESSION['uid']))
{
	$date=date("d F Y H:i:s a");
	require "../includes/conn.php";
    $query = "INSERT INTO messages(from_user,to_user,time,message) VALUES('".$_SESSION['uid']."','".$_GET['t']."','".$date."','".$_GET['msg']."');";
	@mysqli_query($conn,$query);
}
?>