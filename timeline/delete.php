<?php
session_start();
$query = "DELETE FROM userdata WHERE id=".$_SESSION['uid'].";";
				@mysqli_query($conn,$query);
				
				?>