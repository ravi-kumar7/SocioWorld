<?php
session_start();
$data = $_POST['image'];

list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);

$data = base64_decode($data);
$imageName = $_SESSION['uid'].'.jpg';
file_put_contents('upload/user_profile_pictures/'.$imageName, $data);
  require "../includes/conn.php";
  $query = "UPDATE userdata SET profilepic='".$imageName."' WHERE id=".$_SESSION['uid'].";";
   @mysqli_query($conn,$query);
			echo "success";
?>