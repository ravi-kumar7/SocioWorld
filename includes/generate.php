<?php
session_start();
header('Content-type: image/jpeg');
$db_name="crypt";
$db_username="root";
$db_password="";
$db_server="localhost";
$conn=@mysqli_connect($db_server,$db_username,$db_password,$db_name) or die("Could not Connect");
$query="SELECT number FROM tampernumber;";
$query_run=@mysqli_query($conn,$query);
if(@mysqli_num_rows($query_run))
{  
$rows=@mysqli_fetch_assoc($query_run);
$test=$rows['number']+1;
$query1="UPDATE tampernumber SET number=".$test." WHERE pkey=1;";
@mysqli_query($conn,$query1);
}
else
	$test=123456789;
$numbers=array('0','0','0','0','0','0','0','0','0','0');
$font_size=array(20,22,24,26,28,30,32,34,36,38);
$pos=array(15,28,41,56,72,89,108,128,150,173);
$width = 500 ;
$height= 100;


$temp_num=$test;
$count=9;

while ($test>0)
{
	$num = $test%10;
	$numbers[$count]=strval($num);
	$count-=1;
	$test=$test/10;
}


$image = imagecreate($width,$height);
imagecolorallocate($image,255,255,255);

$text_color = imagecolorallocate($image,0,0,0);
for($count=0;$count<10;$count++){
imagettftext($image,$font_size[$count],0,$pos[$count],60,$text_color,'font.ttf',$numbers[$count]);
}

imagejpeg($image);

?>
<img src="includes/generate.php"/>