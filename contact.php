
<?php
$title="Contact Us | SocioWorld"; 
include "./includes/header.php";
$msg="";
		  if(isset($_POST['name']))
            {
	         require "./includes/conn.php";
	         $query="INSERT INTO enquiry(name, email, message) VALUES('".$_POST['name']."','".$_POST['email']."','".$_POST['message']."');";
	         if(@mysqli_query($conn,$query))
				 $msg='<h4><b>Message Sent! The Developers will contact you within 24 Hours.</b></h4>';
			
		}
?>
<!-- ==== CONTACT ==== -->
<div id="contact" name="contact">
  <div class="container">
    <div class="row">
      <h2 class="centered">Contact Us</h2>
      <hr>
      <div class="col-md-4 centered"> <i class="fa fa-map-marker fa-2x"></i>
        <p>#76, Mahesh Nagar Ambala Cantt<br>
          Haryana, HR 133001</p>
      </div>
      <div class="col-md-4"> <i class="fa fa-envelope-o fa-2x"></i>
        <p>info@SocialWorld.com</p>
      </div>
      <div class="col-md-4"> <i class="fa fa-phone fa-2x"></i>
        <p> +91-9416121130</p>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2 centered">
 <div class="row" id="message" style="color: darkblue;">
             <?php echo $msg;?>
		  </div>
        <form id="contact" method="post" class="form" role="form">
		 
          <div class="row">
            <div class="col-xs-6 col-md-6 form-group">
              <input class="form-control" id="name" name="name" placeholder="Name" type="text" required />
            </div>
            <div class="col-xs-6 col-md-6 form-group">
              <input class="form-control" id="email" name="email" placeholder="Email" type="email" required />
            </div>
          </div>
          <textarea class="form-control" id="message" name="message" placeholder="Message" rows="5"></textarea>
          <div class="row">
            <div class="col-xs-12 col-md-12">
              <button class="btn btn btn-lg" type="submit">Send Message</button>
            </div>
          </div>
        </form>
        <!-- form --> 
      </div>
    </div>
    <!-- row --> 
    
  </div>
</div>
<!-- container -->
<?php 
include "./includes/footer.php";
?>