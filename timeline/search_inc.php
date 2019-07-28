 <?php
session_start();
 require "../includes/conn.php";
 if(isset($_GET['q']))
 {
	 if(!empty($_GET['q']) or $_GET['q']!="")
	 { $query="SELECT DISTINCT * FROM userdata WHERE name LIKE '".$_GET['q']."%' ORDER BY name;";
		 $query_run=@mysqli_query($conn,$query);
	         if(@mysqli_num_rows($query_run))
			 {
				 $var = 0;
				 while(($row=@mysqli_fetch_assoc($query_run)) && $var<4 )
				 {
					 if($row['id']!=$_SESSION['uid'])
					 echo "<li class=\"media\" style=\"padding:10px; width:250px;\">
                  
                    <div class=\"media-left\">
                    <a href=\"profile.php?uid=".$row['id']."\">
                      <img class=\"img-circle\" src=\"upload/user_profile_pictures/".$row['profilepic']."\" height=\"50px\" width=\"50px\" alt=\"".$row['name']."\">
                    </a>
                  </div>
                  <div class=\"media-body\">
                   
                    <a href=\"profile.php?profileid=".$row['id']."\"><h5 class=\"media-heading\">".$row['name']."</h5></a>

                    <p class=\"margin-none\">".$row['location']."</p>
                  </div>
                </li>";
				$var = $var +1;
				if($var>=4)
				echo "<li class=\"media\" style=\"padding:10px; width:250px;\">
                  <a href=\"searchresult.php?searchquery=".$_GET['q']."\">See More Results</a>
                </li>";
				 }
				 
             }
			 else
				 echo "<li class=\"media\" style=\"padding:10px; width:250px;\">
                  No Results
                </li>";
	 }
 }
		?>