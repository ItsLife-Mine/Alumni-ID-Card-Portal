<?php
session_start();
require_once 'dbconfig.php'; 
require_once 'class.admin.php';

$admin_login = new ADMIN();

if($admin_login->is_adlogged_in()!="")
{
  $admin_login->redirect('adminDashboard.php');
}

if(isset($_POST['btn-login']))
{
  $email = trim($_POST['txtemail']);
  $upass = trim($_POST['txtupass']);
  $authtokenid = md5(uniqid(rand()));

  if($admin_login->adminLogin($email,$upass,$authtokenid))
  {
    $admin_login->redirect("adminDashboard.php?authToken=$authtokenid");
  }
  else
  {
    $error = "Wrong Details!";
  }
}
if (isset($_SESSION['adminSession'])) {
    header("Location: adminDashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Alumni ID Card Portal | Admin Login</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700">

<!-- ===============================
     🎨 BACKGROUND PHOTO + GLASS UI
     (NO PHP / LOGIC CHANGED)
================================ -->
<style>
html, body {
    height: 100%;
}

/* FULL PAGE PHOTO */
body.login-page {
    background: url("../dist/img/iiit-bg.jpg.webp") no-repeat center center fixed;
    background-size: cover;
}

/* DARK OVERLAY FOR READABILITY */
body.login-page::before {
    content: "";
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.35);
    z-index: 0;
}

/* LOGIN BOX ABOVE OVERLAY */
.login-box {
    position: relative;
    z-index: 1;
}

/* GLASS EFFECT CARD */
.login-box-body {
    background: rgba(255,255,255,0.92);
    border-radius: 12px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.35);
}

/* HEADING */
.login-logo a {
    color: #ffffff !important;
    font-weight: 700;
    font-size: 34px;
    letter-spacing: 1px;
    text-transform: uppercase;
    text-shadow: 0 4px 15px rgba(0,0,0,0.6);
}
</style>
</head>

<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>IIIT-DELHI ADMIN</b></a>
  </div>

  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <?php if(isset($error)){ ?>
      <div class="alert alert-danger">
        <strong><?php echo $error; ?></strong>
      </div>
    <?php } ?>

    <form method="post">
      <div class="form-group has-feedback">
        <input type="email" name="txtemail" class="form-control" placeholder="Email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="password" name="txtupass" class="form-control" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <button type="submit" name="btn-login" class="btn btn-primary btn-block btn-flat">
            Sign In
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
