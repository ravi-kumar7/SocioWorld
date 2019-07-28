<?php
session_start();
if(isset($_SESSION['uid']) && isset($_GET['type']) &&isset($_GET['data']))
{
	require "../includes/conn.php";
$date = date("d F Y H:i a");	
	switch($_GET['type'])
	{ case "add":
		case "add":
	$query = "INSERT INTO comments(comment,pid,time,commentby) VALUES('".$_GET['comment']."','".$_GET['data']."','".$date."','".$_SESSION['uid']."') ;";
	if(@mysqli_query($conn,$query));
	break;
	}
	
}
?>