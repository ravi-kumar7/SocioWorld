<?php
 session_start();
$title="Edit Profile | SocioWorld";
  if(!isset($_SESSION['uid']))
  {
	  header('Location: login.php');
  }
   require "../includes/conn.php";
?>
<!DOCTYPE html>
<html class="st-layout ls-top-navbar ls-bottom-footer show-sidebar sidebar-l2" lang="en">

<?php include "header.php";
include "bodyhead.php";
?>
<script>
   function validate2()
   {
	      var file= upload.pic.value;
   var reg = /(.*?)\.(jpg|bmp|jpeg|png|JPG|JPEG|PNG|BMP)$/;
   if(!file.match(reg))
   {  $("#fileerror").show();
			   document.getElementById('InputFile').value="";
			   return false;
		   }
		   else
		   {$("#fileerror").hide();
		   }
   }
</script>


        <!-- extra div for emulating position:fixed of the menu -->
        <div class="st-content-inner">

          <div class="container-fluid">

            <div class="jumbotron bg-transparent text-center margin-none">
              <h1>Update Profile Picture </h1>
            </div>

            <div class="page-section">
              <div class="row">
                <div class="col-md-10 col-lg-8 col-md-offset-1 col-lg-offset-2">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <form class="form-horizontal" role="form" name="upload" method="post">
                        <div class="form-group form-control-default required">
						  
						  	<div class="row">
	  		<div class="col-md-4 text-center">
				<div id="upload-demo" style="width:350px"></div>
	  		</div>
			
	  		<div class="col-md-4" style="padding-top:30px;">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" class="form-control" id="InputFile" placeholder="Choose" name="pic" required>
				<br/>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-success upload-result" onClick="javascript: return validate2();" >Upload Image</button><p id="fileerror" style="color:red; display:none"> Invalid Image File </p>
	  		</div>
	  	</div>
<script src="jquery.js"></script>
<script src="croppie.js"></script>
<link rel="stylesheet" href="croppie.css">
<script type="text/javascript">
$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 210,
        height: 210,
        type: 'square'
    },
    boundary: {
        width: 210,
        height: 210
    }
});

$('#InputFile').on('change', function () { 
	var reader = new FileReader();
    reader.onload = function (e) {
    	$uploadCrop.croppie('bind', {
    		url: e.target.result
    	}).then(function(){
    		console.log('jQuery bind complete');
    	});
    	
    }
    reader.readAsDataURL(this.files[0]);
});

$('.upload-result').on('click', function (ev) {
	$uploadCrop.croppie('result', {
		type: 'canvas',
		size: 'viewport'
	}).then(function (resp) {

		$.ajax({
			url: "ajaxpro.php",
			type: "POST",
			data: {"image":resp},
			success: function (data) {
				window.location = "index.php";
			}
		});
	});
});

</script>
                        </div>
                      </form>
                    </div>
                  </div>
                

				 </div>
				 </div>
        </div>
        <!-- /st-content-inner -->

      </div>
      <!-- /st-content -->

    </div>
    <!-- /st-pusher -->

       <?php include "footer.php";
	  ?>
   
    