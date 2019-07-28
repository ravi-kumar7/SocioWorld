<?php 
session_start();
require "../includes/conn.php";
$date=date("d F Y H:i a");
$testquery="SELECT * FROM lastlogin WHERE uid=".$_SESSION['uid'].";";
$queryExec = @mysqli_query($conn,$testquery);
if($row=@mysqli_fetch_assoc($queryExec))
{ 
$query="UPDATE lastlogin SET lastlogin='".$date."' WHERE uid='".$_SESSION['uid']."');";
@mysqli_query($conn,$query);
}
else
{$query="INSERT INTO lastlogin(lastlogin,uid) VALUES('".$date."','".$_SESSION['uid']."');";
@mysqli_query($conn,$query);
}
session_destroy();
	  header('Location: login.php');
?>