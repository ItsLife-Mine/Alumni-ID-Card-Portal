<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . "/lib/config.php";
require PATH_LIB . "page-top-user.php";
require_once 'common.php';

/* =========================
   USER SESSION CHECK
========================= */
if (!isset($row) || empty($row['studentEmail'])) {
    header("Location: index.php");
    exit;
}

$email = $row['studentEmail'];

/* =========================
   FETCH STUDENT DATA
========================= */
$data = null;

$stmt = $DB_con->prepare(
    "SELECT * FROM studentregistration WHERE studentEmail = :email LIMIT 1"
);
$stmt->execute([':email' => $email]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

/* =========================
   ✅ CORRECT STATUS LOGIC (FIXED)
========================= */
$status = 'PENDING';

if ($data && isset($data['status'])) {
    $status = strtoupper(trim($data['status']));
}
?>

<!-- ================= HEADER ================= -->
<section class="content-header text-center">
  <h1>Alumni ID Card Portal</h1>
</section>

<!-- ================= MAIN CONTENT ================= -->
<section class="content">
<div class="container">

<!-- ================= WELCOME BOX ================= -->
<div class="row">
  <div class="col-md-12">
    <div class="alert alert-danger text-center">
      <div class="box-body text-center">
        <h3>Welcome, <?= htmlspecialchars($row['studentName']); ?> 👋</h3>
        <p>Thank you for registering on the Alumni ID Card Portal.</p>
      </div>
    </div>
  </div>

<!-- ================= STATUS MESSAGE ================= -->
<div class="row">
  <div class="col-md-12">

<?php if (!$data) { ?>

  <div class="alert alert-warning text-center">
    <strong>You have not submitted your registration form yet.</strong>
  </div>

<?php } elseif ($status === 'PENDING') { ?>

  <div class="alert alert-warning text-center">
    <i class="fa fa-clock-o"></i><br>
    <strong>Your application is under review.</strong><br>
    Please wait for admin approval.
  </div>

<?php } elseif ($status === 'REJECTED') { ?>

  <div class="alert alert-danger text-center">
    <i class="fa fa-times-circle"></i><br>
    <strong>Your application has been rejected.</strong><br><br>
    <strong>Reason:</strong><br>
    <?= !empty($data['adminRemark']) 
        ? nl2br(htmlspecialchars($data['adminRemark'])) 
        : 'No remark provided by admin.'; ?>
  </div>

<?php } elseif ($status === 'APPROVED') { ?>

  <div class="alert alert-success text-center">
    <i class="fa fa-check-circle"></i><br>
    <strong>Your Alumni ID Card has been approved!</strong>
  </div>

<?php } ?>

  </div>
</div>

<!-- ================= ACTION CARDS ================= -->
<div class="row">

  <!-- Edit Details -->
   <!-- Edit Details -->
<div class="col-md-6">
  <div class="box box-warning text-center">
    <div class="box-body">
      <i class="fa fa-edit fa-3x"></i>
      <h4>Edit Details</h4>

<?php if ($status === 'APPROVED') { ?>
        <p>Editing is disabled after approval.</p>
        <button class="btn btn-warning btn-sm" disabled>
          Not Available
        </button>
<?php } else { ?>
        <p>Edit limited registration information.</p>
        <a href="editRegisteredDetails.php" class="btn btn-warning btn-sm">
          Edit Details
        </a>
<?php } ?>

    </div>
  </div>
</div>

  <!-- <?php if ($status !== 'APPROVED') { ?>
  <div class="col-md-6">
    <div class="box box-warning text-center">
      <div class="box-body">
        <i class="fa fa-edit fa-3x"></i>
        <h4>Edit Details</h4>
        <p>Edit limited registration information.</p>
        <a href="editRegisteredDetails.php" class="btn btn-warning btn-sm">
          Edit Details
        </a>
      </div>
    </div>
  </div>
  <?php } ?> -->

  <!-- Registered Details -->
  <div class="col-md-6">
    <div class="box box-info text-center">
      <div class="box-body">
        <i class="fa fa-user fa-3x"></i>
        <h4>Registered Details</h4>
        <p>View your submitted registration information.</p>
        <a href="registeredDetails.php" class="btn btn-info btn-sm">
          View Details
        </a>
      </div>
    </div>
  </div>

</div>

<div class="row">

  <!-- Generate ID Card -->
  <div class="col-md-6">
    <div class="box box-success text-center">
      <div class="box-body">
        <i class="fa fa-id-card fa-3x"></i>
        <h4>Generate ID Card</h4>

<?php if ($status === 'APPROVED') { ?>
        <p>Your ID Card is ready.</p>
        <a href="generateIdCard.php" class="btn btn-success btn-sm">
          View ID Card
        </a>
<?php } else { ?>
        <p>ID Card will be available after approval.</p>
        <button class="btn btn-success btn-sm" disabled>
          Not Available
        </button>
<?php } ?>

      </div>
    </div>
  </div>

  <!-- Change Password -->
  <div class="col-md-6">
    <div class="box box-danger text-center">
      <div class="box-body">
        <i class="fa fa-lock fa-3x"></i>
        <h4>Change Password</h4>
        <p>Update your account password.</p>
        <a href="changePassword.php" class="btn btn-danger btn-sm">
          Change Password
        </a>
      </div>
    </div>
  </div>

</div>

</div>
</section>
</div>

<?php
require PATH_LIB . "page-bottom-user.php";
ob_end_flush();
?>
