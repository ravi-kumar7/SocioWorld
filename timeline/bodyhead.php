<body>
<?php
$mainpic="";
$val="";
$mainname="";
$query="SELECT * FROM userdata WHERE id='".$_SESSION['uid']."';";
			 $query_run=@mysqli_query($conn,$query);
	         if(@mysqli_num_rows($query_run))
			 {$row=@mysqli_fetch_assoc($query_run);
              $mainname=$row['name'];
			  $mainpic="upload/user_profile_pictures/";
		      $mainpic.=$row['profilepic'];				   
			 }
?>
<script type="text/javascript">
function match()
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
			if(temp.length <2)
			{document.getElementById('searchresult').innerHTML=temp;
			 document.getElementById('searchresult').style.display='none';
			}
			else	
			{document.getElementById('searchresult').innerHTML=temp;
			 document.getElementById('searchresult').style.display='block';
			}
		}			
	}
	
	xmlhttp.open('GET','search_inc.php?q='+document.search.search_text.value,true);
	xmlhttp.send();
}
function accept(msg)
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
			alert("Friend Request Accepted!");
			
		}			
	}
	
	xmlhttp.open('GET','friendrequest_handle.php?type=add&fa='+msg,true);
	xmlhttp.send();
}
function fetch()
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
			document.getElementById('friend_requests').innerHTML=temp;
		}			
	}
	
	xmlhttp.open('GET','friendrequest.php?type=fetch',true);
	xmlhttp.send();
}
</script>
  <!-- Wrapper required for sidebar transitions -->
  <div class="st-container">

    <!-- Fixed navbar -->
    <div class="navbar navbar-main navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid" >
        <div class="navbar-header" >
		<a href="search.php"  class="toggle pull-right visible-xs "><i class="fa fa-search"></i></a>
		<a href="#sidebar-menu" data-effect="st-effect-1" data-toggle="sidebar-menu" class="toggle pull-left visible-xs"><i class="fa fa-bars"></i></a>
         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand navbar-brand-primary hidden-xs" href="../index.php">SocioWorld</a>
        </div>
        <div class="collapse navbar-collapse" id="main-nav">
          <ul class="nav navbar-nav hidden-xs" <?php if($_SERVER['SCRIPT_NAME']=="/MajorProject/timeline/friends.php") echo "style=\"display:none;\"" ?>>
            <!-- messages -->
            <li class="dropdown notifications hidden-xs hidden-sm">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="fetch()">
                <i class="fa  fa-user"></i><?php $frchkquery= "SELECT * FROM friendrequest WHERE to_user=".$_SESSION['uid'].";";
				$execquery = @mysqli_query($conn,$frchkquery);
				$val= @mysqli_num_rows($execquery);
				if($val!=0)
					echo "+".$val;
				?>
              </a>
              <ul class="dropdown-menu" id="friend_requests">
			
               </ul>
            </li> 
            <!-- // END messages -->
          </ul>

          <ul class="nav navbar-nav navbar-user">
            <!-- User -->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo $mainpic;?>" width="35" alt="Bill" class="img-circle" /> <?php echo $mainname;?> <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="profile.php">Profile</a></li>
                <li><a href="messages.php">Messages</a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </li>
          </ul>

          <form class="navbar-form margin-none navbar-left hidden-xs " id="search" name="search">
            <!-- Search -->
            <div class="search-1">
              <div class="input-group">
                <span class="input-group-addon"><i class="icon-search"></i></span>
                <input type="text" class="form-control" placeholder="Search a friend" onkeyup="match()" id="search_text" name="search_text">
			
              <ul class="dropdown-menu" id="searchresult" style="display:none" >
               
              </ul>
</div>
            </div>
            
          </form>
        </div>
      </div>
    </div>

    <!-- Sidebar component with st-effect-1 (set on the toggle button within the navbar) -->
    <div class="sidebar left sidebar-size-2 sidebar-offset-0 sidebar-visible-desktop sidebar-visible-mobile sidebar-skin-dark" id="sidebar-menu" data-type="collapse" style="width:200px">
      <div data-scrollable>
        <ul class="sidebar-menu">
          <li class="">
            <a href="index.php"><i class="fa fa-newspaper-o"></i> <span>NewsFeed</span></a>
          </li>
          <li class=""><a href="profile.php"><i class="icon-user-1"></i> <span>Profile</span></a></li>
          <li class=""><a href="friends.php"><i class="fa fa-group"></i> <span>Friends <?php if($val!=0) echo '+'.$val;?></span></a></li>
          <li class=""><a href="messages.php"><i class="icon-comment-fill-1"></i> <span>Messages</span></a></li>
          <li><a href="settings.php"><i class="icon-lock-fill"></i> <span>Settings</span></a></li>
          
        <h4 class="category border top">Notifications</h4>
        <div class="sidebar-block">
          <ul class="sidebar-feed"  >
            <?php
               $lquery = "SELECT * FROM lastlogin WHERE uid=".$_SESSION['uid'].";";
				$lqueryExec = @mysqli_query($conn,$lquery);
				if($row=@mysqli_fetch_assoc($lqueryExec))
			{echo "<li  >
              <div >
                <a href=\"#\" class=\"text-white\">Last Login:</a>
                <span class=\"time\">".$row['lastlogin']."</span>
              </div>
            </li>";
}
			?>
          </ul>
        </div>
        <a href="logout.php"><h4 class="category">Logout</h4></a>
      </div>
    </div>

  

    <!-- sidebar effects OUTSIDE of st-pusher: -->
    <!-- st-effect-1, st-effect-2, st-effect-4, st-effect-5, st-effect-9, st-effect-10, st-effect-11, st-effect-12, st-effect-13 -->
	