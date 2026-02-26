<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>ID CARD @IIIT-DELHI</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="plugins/iCheck/square/blue.css">
<!-- TODO: Missing CoffeeScript 2 --> 
<script
    type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.js"></script> 
<script type="text/javascript">//<![CDATA[
    $(window).load(function(){  
$('#password, #confirm_password').on('keyup', function () {
    if ($('#password').val() == $('#confirm_password').val()) {
        $('#message').html('Password matching..').css('color', 'green');
    } else 
        $('#message').html('Password not matching..').css('color', 'red');
});

    });

	
	
	
  //]]></script> 
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries --> 
<!-- WARNING: Respond.js doesn't work if you view the page via file:// --> 
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]--> 

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	
	<style>
	@media print {
  .noPrint{
    display:none;
  }
}
	
		
	</style>
	
</head>
<body class="hold-transition register-page">
<div class="register-box" style="width: 700px">
  <div class="register-logo"> <a href="index.php" style="color:#FFFFFF;"><img src="https://www.iiitd.ac.in/sites/default/files/images/logo/style3singlecolorsmall.png" /></a> </div>
  <div class="register-box-body">
    <!--<h3 class="login-box-msg noPrint" style="color: #000;"><strong>IIIT-DELHI Temporary ID Card</strong></h3>-->
	  <center><p><button onclick="window.print()" class="noPrint">Print</button></p></center>
    <div id="print"><img src="https://iiitd.ac.in/idcardsform/1.png" style="width:99%"/> <br/><hr/><br/><img src="https://iiitd.ac.in/idcardsform/2.png" style="width:99%" /></div>
	  
  </div>
  <!-- /.form-box --> 
</div>
<!-- /.register-box --> 

<!-- jQuery 3 --> 
<script src="bower_components/jquery/dist/jquery.min.js"></script> 
<!-- Bootstrap 3.3.7 --> 
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 
<!-- iCheck --> 
<script src="plugins/iCheck/icheck.min.js"></script> 
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
