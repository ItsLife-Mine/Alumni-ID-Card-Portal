<?php
/* ===============================
   ADMIN AUTH + TOKEN CHECK
================================ */
require_once '../lib/page-top.php';
// ADMIN NAME FROM SESSION (safe)
$adminName = $_SESSION['adminName'] ?? 'Admin';

if (!isset($_GET['in'])) {
    header("Location: adminDashboard.php?authToken=" . urlencode($tokenAuth));
    exit;
}

$studentID = base64_decode($_GET['in']);

$stmt = $DB_con->prepare(
    "SELECT * FROM studentregistration WHERE studentID = :id LIMIT 1"
);
$stmt->execute([':id' => $studentID]);
$stu = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$stu) {
    echo "<h3 style='padding:20px;'>Student not found</h3>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>View Alumni Details</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
<style>
.content-wrapper {
  background: #f4f6f9;
}

.profile-box {
  background: #fff;
  border-radius: 8px;
  padding: 25px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.details-table td {
  padding: 12px;
}
</style>

</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<!-- ================= CONTENT ================= -->
<div class="content-wrapper">
<section class="content-header">
  <h1>Registered Alumni Details</h1>
</section>

<section class="content">

<div class="row">
  <div class="col-md-8 col-md-offset-2">

    <div class="box box-primary">
      <div class="box-body">

        <!-- PHOTO -->
        <div class="text-center">
          <?php
          $photo = "../uploadDoc/" . $stu['photograph'];
          if (!empty($stu['photograph']) && file_exists($photo)) {
          ?>
            <img src="<?= $photo ?>" class="img-circle" width="120">
          <?php } else { ?>
            <img src="../dist/img/user2-160x160.jpg" class="img-circle" width="120">
          <?php } ?>
          <h3 style="margin-top:10px;"><?= htmlspecialchars($stu['studentName']); ?></h3>
          <p><?= htmlspecialchars($stu['studentEmail']); ?></p>
        </div>

        <hr>

        <!-- DETAILS TABLE -->
        <table class="table table-bordered">
          <tr>
            <th>Roll Number</th>
            <td><?= htmlspecialchars($stu['rollnumber']); ?></td>
          </tr>
          <tr>
            <th>Personal Email</th>
           <td>
            <?= !empty(trim($stu['studentpEmail'])) 
            ? htmlspecialchars($stu['studentpEmail']) 
            : 'N/A'; ?>
          </td>
          </tr>
          <tr>
            <th>Mobile</th>
            <td><?= htmlspecialchars($stu['studentMobile']); ?></td>
          </tr>
          <tr>
            <th>Program</th>
            <td><?= htmlspecialchars($stu['vtype']); ?></td>
          </tr>
          <tr>
            <th>Specialization</th>
            <td><?= htmlspecialchars($stu['role']); ?></td>
          </tr>
          <tr>
            <th>Enrollment Year</th>
            <td><?= htmlspecialchars($stu['yearofenroll']); ?></td>
          </tr>
          <tr>
            <th>Graduation Year</th>
            <td><?= htmlspecialchars($stu['yearofgraduation']); ?></td>
          </tr>
          <tr>
            <th>Registration Date</th>
            <td><?= htmlspecialchars($stu['regDate']); ?></td>
          </tr>
          <tr>
            <th>Graduation Degree</th>
            <td>
              <?php
              $degreeFile = "../uploadDoc/" . $stu['graduationdegree'];
              if (!empty($stu['graduationdegree']) && file_exists($degreeFile)) {
              ?>
                <a href="<?= $degreeFile ?>" target="_blank" class="btn btn-info btn-xs">
                  <i class="fa fa-file-pdf-o"></i> View Degree
                </a>
              <?php } else { ?>
                <span class="text-danger">Not Uploaded</span>
              <?php } ?>
            </td>
          </tr>
        </table>
      </div>
    </div>

  </div>
</div>

</section>
</div>

<footer class="main-footer text-center">
<strong>© IIIT-Delhi</strong>
</footer>

</div>

<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>

</body>
</html>
