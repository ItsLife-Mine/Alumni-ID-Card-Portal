<?php
ob_start();
require __DIR__ . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "config.php";
// HTML
require PATH_LIB . "page-top.php";
session_start();
require_once 'common.php';
$studentID = $row[ 'studentID' ];
//$personalInformation_fee = new STUDENT();
$emailID = $row[ 'studentEmail' ];
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <br/><center><h1>Thank you for registering<br/><br/>The details can be checked at dashboard from the left menu</h1></center>
    <!--<ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">User Dashboard</li>
    </ol>-->
  </section>
  
  
</div>
<!-- /.content-wrapper -->

<?php  ob_end_flush(); require PATH_LIB . "page-bottom.php"; ?>
