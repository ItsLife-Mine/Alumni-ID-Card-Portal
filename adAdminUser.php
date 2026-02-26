<?php
ob_start();
require __DIR__ . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "config.php";
// HTML
require PATH_LIB . "page-top.php"; 
$reg_user = new ADMIN();

if(isset($_POST['btn-signup']))
{
	$adName = trim($_POST['adName']);
	$adEmail = trim($_POST['adEmail']);
	$adMobile = trim($_POST['adMobile']);
	$password = trim($_POST['password']);
	$tokenCode = md5(uniqid(rand()));
	
	$stmt = $reg_user->runQuery("SELECT * FROM adminlogin WHERE adEmail=:adEmail");
	$stmt->execute(array(":adEmail"=>$adEmail));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if($stmt->rowCount() > 0)
	{
		$msg = "
		      <div class='alert alert-error'>
				<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Sorry !</strong>  email already exists , Please Try another one
			  </div>
			  ";
	}
	else
	{
		if($reg_user->register($adName,$adEmail,$adMobile,$password,$tokenCode))
		{			
			$adID = $reg_user->lasdID();		
			$key = base64_encode($adID);
			$adID = $key;
			
			$message = "					
						Hello $adEmail,
						<br /><br />
						Welcome to Coding Cage!<br/>
						To complete your registration  please , just click following link<br/>
						<br /><br />
						<a href='http://localhost/x/verify.php?id=$adID&code=$tokenCode'>Click HERE to Activate :)</a>
						<br /><br />
						Thanks,";
						
			$subject = "Confirm Registration";
						
			$reg_user->send_mail($adEmail,$message,$subject);	
			$msg = "
					<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Success!</strong>  We've sent an email to $adEmail.
                    Please click on the confirmation link in the email to create your account. 
			  		</div>
					";
		}
		else
		{
			echo "sorry , Query could no execute...";
		}		
	}
}
?>
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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Admin Dashboard
        <!--<small>Control panel</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Admin Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
 <form name="adduser" action="adAdminUser.php?authToken=<?php echo $tokenAuth;?>" method="post" >
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Add New User</h3>
        </div>
		   <div class="box-body">  
<?php
	if(isset($errMSG)){
			?>
		  <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Alert! &nbsp; &nbsp; <?php echo $errMSG; ?></h4>
               
              </div>
            <?php
	}
	else if(isset($successMSG)){
		?>
		    <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert! &nbsp; &nbsp;  <?php echo $successMSG; ?></h4>
               
              </div>
        <?php
	}
	?> 
				  </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
				<div class="form-group">
                <label>Full Name</label>
                 <input type="text" name="adName" class="form-control" placeholder="Full name" required>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Email Id (User Name)</label>
                 <input type="email" class="form-control" name="adEmail" placeholder="Email" required autocomplete="off">
              </div>
              <!-- /.form-group -->
              
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              
              <!-- /.form-group -->
              <div class="form-group">
                <label>Mobile No.</label>
                 <input type="text" name="adMobile" class="form-control" placeholder="Mobile No." required>
              </div>
              <!-- /.form-group -->
				<div class="form-group">
                <label>Password</label>
                
				 <input type="password" id="password" name="password" class="form-control" placeholder="Password" required autocomplete="off">
              </div>
              <!-- /.form-group -->
				<div class="form-group">
                <label>Confirm Password</label>
                 <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Retype password" required autocomplete="off">
              </div>
              <!-- /.form-group -->
				<div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
             <span id='message'></span>
            </label>
          </div>
        </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
         <div class="box-footer">
                <button type="submit" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-info" name="btn-signup">Add User</button>
              </div>
      </div>
      <!-- /.box -->
		</form>
    </section>
    <!-- /.content -->
	  <section class="content">
      <div class="row">
        <div class="col-xs-12" style="padding-left: 0px;  padding-right: 0px;">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><strong>Admin Details</strong></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
					<th>Name</th>
					<th>Email ID (User ID)</th>
                    <th>Mobile Number</th>
					<th>User Status (Active/Disable)</th>
					<th>Registration Date</th>
                </tr>
                </thead>
                <tbody>
					<?php
						
								$result = $DB_con->prepare("SELECT * FROM 	adminlogin" );
								$result->execute();
								for($i=0; $row = $result->fetch(); $i++){
									
							?>
                <tr>
					<td><?php echo $row ['adName']; ?></td>
                  <td><?php echo $row ['adEmail']; ?></td>
                  <td><?php echo $row ['adMobile']; ?></td>
					<td><?php echo $row ['userStatus']; ?></td>
                  <td><?php echo $row ['adDate']; ?></td>
                </tr>
					 <?php } ?>
              
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
  </div>
  <!-- /.content-wrapper -->
    <?php ob_end_flush(); require PATH_LIB . "page-bottom.php"; ?>