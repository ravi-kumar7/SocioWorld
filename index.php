<?php 
session_start();
if(!isset($_POST['name']))
$_SESSION['secure']=rand(10000,99999);
ob_start();
$title="SocioWorld";
include "includes/header.php";
$msg="";
		  if(isset($_POST['name']))
            {  
		if($_POST['captcha']!= $_SESSION['secure'])
				{
					$msg="Invalid Captcha!";
					echo "<script type=\"text/javascript\">
                         window.location = \"index.php#caccount\"; </script>"; 
				}
				else
				{ $query="SELECT * FROM userdata WHERE email='".$_POST['email']."';";
			 $query_run=@mysqli_query($conn,$query);
	         if(@mysqli_num_rows($query_run)>0)
			 {
				 $msg = "Account with email ".$_POST['email']." already exists !";
				echo "<script type=\"text/javascript\">
                window.location = \"index.php#caccount\";
            </script>";
			 }
			 else{
              $month= $_POST['birthday_month'];
              $day= $_POST['birthday_day'];
              $yr= $_POST['birthday_year'];
              $bday= $day . ' ' . $month . ' ' . $yr  ;
	        $passwd= $_POST['pwd'];
			if(strlen($passwd)<32)
			{
				$passwd=sha1($passwd);
			}
	         $query="INSERT INTO userdata(name,dob,gender,email,password) VALUES('".$_POST['name']."','".$bday."','".$_POST['gender']."','".$_POST['email']."','".$passwd."');";
	         if(@mysqli_query($conn,$query))
			 { 
		       $query1="SELECT * FROM userdata WHERE email='".$_POST['email']."';";
			      $query_run=@mysqli_query($conn,$query1);
	            if(@mysqli_num_rows($query_run))
	            {  $rows=@mysqli_fetch_assoc($query_run);
			    $_SESSION['uid']=$rows['id'];
			    unset($_SESSION['secure']);
		        header('Location: timeline/registration.php');
			    } 
			 }
			 }
				}
				unset($_SESSION['secure']);
				$_SESSION['secure']=rand(10000,99999);
            }
?>
<script>
	function validate()
{
	return;
var reg = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*]).{8,20}$/;
if(!document.frm7.pwd.value.match(reg)) 
		   {
		    $("#passerror").show();
			   frm7.passwd.focus();
			   return false;
		   }
		   else
		   {$("#passerror").hide();
		   }
	   return;
}
function doSubmit()
{
	var temp=document.frm7.pwd.value;
	   document.getElementById("passwd").value= SHA1(temp);
}
   </script>
<!-- ==== HEADERWRAP ==== -->
<div id="headerwrap" name="home">
  <header class="clearfix">
    <h1>Connect, Share and Enjoy.</h1>
    <p>Connect and Share your life best Moments with your Family and Friends,<br>
      Join the best Social Network.</p>
    <a href="#caccount" class="smoothScroll btn btn-lg">Get Started</a> </header>
</div>
<!-- /headerwrap --> 

<!-- ==== ABOUT ==== -->
<div id="about" name="about">
  <div class="container">
    <div class="row white">
      <div class="col-md-6"> <img class="img-responsive" src="assets/img/about/about1.jpg" align=""> </div>
      <div class="col-md-6">
        <h3>About us</h3>
        <p>SocioWorld is a Social Networking website started in March 2017 by a group of Students at UIET, Kurukshetra Univerisity, Kurukshetra.</p>
        <h3>Why SocioWorld?</h3>
        <p>SocialWorld is a fastest, safest and easy to use Social Networking website, all your Private data is Safe. Unlike Facebook/Twitter we do not share your personal information with Third party sites.</p>
      </div>
    </div>
    <!-- row --> 
  </div>
</div>
<!-- container --> 

<!-- ==== FEATURES ==== -->
<div id="services" name="features">
  <div class="container">
    <div class="row">
      <h2 class="centered">Features</h2>
      <hr>
      <div class="col-lg-8 col-lg-offset-2">
        <p class="large">SocioWorld offers a lot of features to our Users.</p>
      </div>
      <div class="col-lg-3 callout"> <i class="fa fa-desktop fa-3x"></i>
        <h3>Responsive Website</h3>
        <p>Our Website is fully responsive much faster than other sites</p>
      </div>
      <div class="col-lg-3 callout"> <i class="fa fa-gears fa-3x"></i>
        <h3>Full Privacy Control</h3>
        <p>User can control all his private information, what information to show, what to hide, all in users hand.</p>
      </div>
      <div class="col-lg-3 callout"> <i class="fa fa-dot-circle-o fa-3x"></i>
        <h3>Social Networking</h3>
        <p>Make new friends, connect with your family, share your daily life activities with your family and friends.</p>
      </div>
      <div class="col-lg-3 callout"> <i class="fa fa-inbox  fa-3x"></i>
        <h3>Messaging</h3>
        <p>Personal Message box for each user, chat with your friends and family.</p>
      </div>
                
    </div>
    <!-- row --> 
  </div>
</div>
<!-- container --> 

<!-- ==== caccount ==== -->
<div id="portfolio" name="caccount">
  <div class="container"><a name="caccount"/>
    <div class="row">
      <h2 class="centered">Create an Account</h2>
      <hr>
	  
      <div class="col-lg-8 col-lg-offset-2 centered">
        <p class="large">It's free and always will be. SocioWorld helps you connect and share with the people in your life.</p>
		<img class="img" src="assets/img/social.png" alt="" width="300" height="109">
      </div>
    </div>
    <!-- /row -->
    <div class="container">
      <div class="row"> 
	 <div class="col-lg-8 col-lg-offset-2 centered">
	 <p style="color:red;" > <b>
	 <?php echo $msg;?>
	 </b></p>
       
        <form id="contact" method="post" class="form" role="form" name="frm7" onsubmit="doSubmit()">
		All fields are Mandatory.<br/><br/>
          <div class="row">
            <div class="col-xs-6 col-md-6 form-group">
              <input class="form-control" id="name" name="name" placeholder="Name" type="text" required />
            </div>
            <div class="col-xs-6 col-md-6 form-group">
              <input class="form-control" id="email" name="email" placeholder="Email" type="email" required />
            </div>
          </div>
          
		   <div class="row">
            <div class="col-xs-12 col-md-12">
              <input type="password" class="form-control" id="passwd" name="pwd" placeholder="Password" required />
			  <p id="passerror" style="color:red; display:none">Invalid Password. Password must contain atleast 8 and maximum 20 characters including one Digit and both uppercase and lowercase letters and one special character </p>
            </div>
          </div>
		  <br/>
		  <div class="row">
		  Birthday&nbsp;&nbsp;&nbsp;&nbsp;
		   <span><select aria-label="Day" name="birthday_day" id="day" title="Day" class="_5dba" required="">
		   <option value="1">1</option>
		   <option value="2">2</option>
		   <option value="3">3</option>
		   <option value="4">4</option>
		   <option value="5">5</option>
		   <option value="6">6</option>
		   <option value="7">7</option>
		   <option value="8">8</option>
		   <option value="9">9</option>
		   <option value="10">10</option>
		   <option value="11">11</option>
		   <option value="12">12</option>
		   <option value="13">13</option>
		   <option value="14">14</option>
		   <option value="15">15</option>
		   <option value="16">16</option>
		   <option value="17">17</option>
		   <option value="18">18</option>
		   <option value="19">19</option>
		   <option value="20">20</option>
		   <option value="21">21</option>
		   <option value="22">22</option>
		   <option value="23">23</option>
		   <option value="24">24</option>
		   <option value="25">25</option>
		   <option value="26">26</option>
		   <option value="27">27</option>
		   <option value="28">28</option>
		   <option value="29">29</option>
		   <option value="30">30</option>
		   <option value="31">31</option>
		   </select>
		   &nbsp;&nbsp;&nbsp;&nbsp;
		   <select aria-label="Month" name="birthday_month" id="month" title="Month" class="_5dba" required="">
		   <option value="January">Jan</option>
		   <option value="February">Feb</option>
		   <option value="March">Mar</option>
		   <option value="April">Apr</option>
		   <option value="May">May</option>
		   <option value="June">Jun</option>
		   <option value="July">Jul</option>
		   <option value="August">Aug</option>
		   <option value="September">Sept</option>
		   <option value="October">Oct</option>
		   <option value="November">Nov</option>
		   <option value="December">Dec</option>
		   </select>&nbsp;&nbsp;&nbsp;&nbsp;
		   <select aria-label="Year" name="birthday_year" id="year" title="Year" class="_5dba" required=""><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option><option value="1910">1910</option><option value="1909">1909</option><option value="1908">1908</option><option value="1907">1907</option><option value="1906">1906</option><option value="1905">1905</option></select></span> 
          </div>
		  <br/>
		  
		  <div class="row">
              Gender: &nbsp;&nbsp;<input type="radio"  id="cnfpasswd" name="gender" value="f"  required />Female &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio"  id="cnfpasswd" name="gender" value="m"  required /> Male<br/><br/>
			
          </div>
		<div class="row">
            <div class="col-xs-2 col-md-5 form-group">
              <img src="includes/generate.php"/>
            </div>
            <div class="col-xs-1 col-md-3 form-group">
              <input class="form-control" id="captcha" name="captcha" placeholder="Captcha" type="text" required />
            </div>
				
          </div>
          <div class="row">
            <div class="col-xs-12 col-md-12">
			
              <button class="btn btn btn-lg" type="submit" onClick="javascript:return validate();" >Register</button>
            </div>
          </div>
        </form>
        <!-- form --> 
      </div>
      </div>
      <!-- /row --> 
    </div>
    <!-- /row --> 
  </div>
</div>
<!-- /container --> 

<!-- container --> 
<?php 
include "includes/footer.php";
ob_end_flush()?>
