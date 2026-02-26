<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

/* ===============================
   ADMIN AUTH
================================ */
require_once __DIR__ . '/../admin/dbconfig.php';
require_once __DIR__ . '/../admin/class.admin.php';

$admin_home = new ADMIN();

if (!$admin_home->is_adlogged_in()) {
    header("Location: ../admin/index.php");
    exit;
}

/* ===============================
   TOKEN CHECK
================================ */
$authtokenid = $_GET['authToken'] ?? '';
if ($authtokenid === '') {
    header("Location: ../admin/logout.php");
    exit;
}

/* ===============================
   FETCH ADMIN
================================ */
$stmt = $admin_home->runQuery("
    SELECT ad.*, ads.*
    FROM adminlogin ad
    JOIN authsession ads ON ad.adID = ads.studentID
    WHERE ad.adID = :adID
      AND ads.authtokenid = :token
");
$stmt->execute([
    ':adID'  => $_SESSION['adminSession'],
    ':token' => $authtokenid
]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    header("Location: ../admin/logout.php");
    exit;
}
$tokenAuth = $row['authtokenid'];

/* ===============================
   LAYOUT
================================ */
require_once '../lib/page-top.php';
?>

<section class="content-header">
  <h1>Registered Alumni</h1>
</section>

<section class="content">
<div class="box box-primary">
<div class="box-body">

<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
  <th>Photo</th>
  <th>Name</th>
  <th>Email</th>
  <th>Mobile</th>
  <th>Degree</th>
  <th>Status</th>
  <th>Change Status</th>
  <th>View Details</th>
</tr>
</thead>

<tbody>
<?php
$stmt = $DB_con->prepare("SELECT * FROM studentregistration ORDER BY regDate DESC");
$stmt->execute();

while ($stu = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
<tr>

<!-- PHOTO -->
<td>
<?php
$photo = "../uploadDoc/" . $stu['photograph'];
if (!empty($stu['photograph']) && file_exists($photo)) {
?>
<img src="<?= $photo ?>" width="50" height="50" style="border-radius:50%;">
<?php } else { ?>
<img src="../dist/img/user2-160x160.jpg" width="50" height="50" style="border-radius:50%;">
<?php } ?>
</td>

<td><?= htmlspecialchars($stu['studentName']); ?></td>
<td><?= htmlspecialchars($stu['studentEmail']); ?></td>
<td><?= htmlspecialchars($stu['studentMobile']); ?></td>

<!-- DEGREE -->
<td>
<?php
$degreeFile = "../uploadDoc/" . $stu['graduationdegree'];
if (!empty($stu['graduationdegree']) && file_exists($degreeFile)) {
?>
<a href="<?= $degreeFile ?>" target="_blank">Click here</a>
<?php } else { ?>
<span class="text-danger">Not Uploaded</span>
<?php } ?>
</td>

<!-- STATUS -->
<td>
<?php
if ($stu['status'] === 'APPROVED') {
  echo "<span class='label label-success'>Approved</span>";
} elseif ($stu['status'] === 'REJECTED') {
  echo "<span class='label label-danger'>Rejected</span>";
} else {
  echo "<span class='label label-warning'>Pending</span>";
}
?>
</td>

<!-- CHANGE STATUS -->
<td>
<?php if ($stu['status'] === 'PENDING') { ?>

<a href="approveStudent.php?id=<?= $stu['studentID']; ?>&authToken=<?= urlencode($tokenAuth); ?>"
   class="btn btn-success btn-xs"
   onclick="return confirm('Approve this alumni?');">
Approve
</a>

<button class="btn btn-danger btn-xs"
        onclick="openRejectModal(<?= $stu['studentID']; ?>)">
Reject
</button>

<?php } elseif ($stu['status'] === 'APPROVED') { ?>

<button class="btn btn-danger btn-xs"
        onclick="openRejectModal(<?= $stu['studentID']; ?>)">
Reject
</button>

<?php } else { ?>

<a href="approveStudent.php?id=<?= $stu['studentID']; ?>&authToken=<?= urlencode($tokenAuth); ?>"
   class="btn btn-success btn-xs"
   onclick="return confirm('Re-approve this alumni?');">
Approve
</a>

<?php } ?>
</td>

<!-- VIEW DETAILS -->
<td>
<a href="viewStudentDetails.php?in=<?= base64_encode($stu['studentID']); ?>&authToken=<?= urlencode($tokenAuth); ?>"
   class="btn btn-info btn-xs">
<i class="fa fa-eye"></i> View Details
</a>

<?php if ($stu['status'] === 'APPROVED') { ?>
<a href="generateIdCard.php?in=<?= base64_encode($stu['studentID']); ?>&adminView=1&authToken=<?= urlencode($tokenAuth); ?>"
   class="btn btn-success btn-xs">
<i class="fa fa-id-card"></i> View ID Card
</a>
<?php } ?>
</td>
<!-- <td>
<?php if($row['userStatus']=='Y'){ ?>
  <span class="label label-success">Active</span>
<?php } else { ?>
  <span class="label label-danger">Inactive</span>
<?php } ?>
</td> -->

</tr>
<?php } ?>
</tbody>
</table>

</div>
</div>
</section>

<!-- ================= REJECT MODAL ================= -->
<div class="modal fade" id="rejectModal">
<div class="modal-dialog">
<form method="post" action="rejectStudent.php">
  <div class="modal-content">
    <div class="modal-header bg-red">
      <h4 class="modal-title">Reject Alumni</h4>
    </div>
    <div class="modal-body">
      <input type="hidden" name="id" id="rejectStudentID">
      <input type="hidden" name="authToken" value="<?= htmlspecialchars($tokenAuth); ?>">
      <textarea name="remark" class="form-control"
        placeholder="Enter rejection reason" required></textarea>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-danger">Reject</button>
      <button type="button" class="abtn btn-default" data-dismiss="modal">Cancel</button>
    </div>
  </div>
</form>
</div>
</div>

<?php require_once '../lib/page-bottom.php'; ?>

<script>
function openRejectModal(id) {
  document.getElementById('rejectStudentID').value = id;
  $('#rejectModal').modal('show');
}

$(function () {
  $('#example1').DataTable();
});
</script>
