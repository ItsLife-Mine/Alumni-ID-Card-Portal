<?php
ob_start();
require __DIR__ . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "config.php";
// HTML
require PATH_LIB . "page-top.php"; 
if(isset($_POST['submit']))
{
echo  $oldpass=hash('sha256', $_POST['opwd']);
 $adEmail=$_POST['adEmail'];
 $newpassword=hash('sha256', $_POST['npwd']);
$sql=mysqli_query($connection,"SELECT adPassword FROM adminlogin where adPassword='$oldpass' && adEmail='$adEmail'");
$num=mysqli_fetch_array($sql);
if($num>0)
{
 $connection=mysqli_query($connection,"update adminlogin set adPassword='$newpassword' where adEmail='$adEmail'");
$successMSG="Password Changed Successfully !!";
}
else
{
$errMSG ="Old Password not match !!";
}
}

?>
<script type="text/javascript">
function valid()
{
if(document.chngpwd.opwd.value=="")
{
alert("Old Password Filed is Empty !!");
document.chngpwd.opwd.focus();
return false;
}
else if(document.chngpwd.npwd.value=="")
{
alert("New Password Filed is Empty !!");
document.chngpwd.npwd.focus();
return false;
}
else if(document.chngpwd.cpwd.value=="")
{
alert("Confirm Password Filed is Empty !!");
document.chngpwd.cpwd.focus();
return false;
}
else if(document.chngpwd.npwd.value!= document.chngpwd.cpwd.value)
{
alert("Password and Confirm Password Field do not match  !!");
document.chngpwd.cpwd.focus();
return false;
}
return true;
}
</script>
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
 <form name="chngpwd" action="changePassword.php?authToken=<?php echo $tokenAuth;?>" method="post" onSubmit="return valid();">
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Change Password</h3>
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
                <label>Email Id</label>
                 <input type="text" name="adEmail" value="<?php echo $row['adEmail'];?>" class="form-control" readonly>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Old Password</label>
                 <input type="password" name="opwd" class="form-control" placeholder="Old Password ...">
              </div>
              <!-- /.form-group -->
              
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              
              <!-- /.form-group -->
              <div class="form-group">
                <label>New Password</label>
                 <input type="password" name="npwd" class="form-control" placeholder="New Password ...">
              </div>
              <!-- /.form-group -->
				<div class="form-group">
                <label>Confirm Password</label>
                
				  <input type="password"  name="cpwd" class="form-control" placeholder="Confirm Password ...">
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
         <div class="box-footer">
                <button type="submit" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-info" name="submit" id="submit" value="Change Password" >Update</button>
              </div>
      </div>
      <!-- /.box -->
		</form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    <?php ob_end_flush(); require PATH_LIB . "page-bottom.php"; ?>