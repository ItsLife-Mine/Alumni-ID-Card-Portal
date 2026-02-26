<?php
ob_start();
require "lib/config.php";
require "lib/page-top-user.php";
require_once "common.php";

/* ===== Session check ===== */
if (!isset($row) || empty($row['studentEmail'])) {
    header("Location: index.php");
    exit;
}

$studentID = $row['studentID'];

$stmt = $DB_con->prepare(
    "SELECT * FROM studentregistration WHERE studentID = :id LIMIT 1"
);
$stmt->execute([':id' => $studentID]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
<section class="content-header">
    <h1>Registered Details</h1>
</section>

<section class="content">
<div class="box box-primary">
<div class="box-body">

<?php if (!$data) { ?>

    <div class="alert alert-warning">
        No registration details found.
    </div>

<?php } else { ?>
<div class="text-center" style="margin-bottom:20px;">
<?php
$photoPath = "uploadDoc/" . $data['photograph'];

if (!empty($data['photograph']) && file_exists($photoPath)) {
?>
    <img src="<?= $photoPath ?>" class="img-circle" width="120">
<?php
} else {
?>
    <img src="dist/img/user2-160x160.jpg" class="img-circle" width="120">
<?php
}
?>
</div>

<table class="table table-bordered table-striped">
    <tr><th>Name</th><td><?= htmlspecialchars($data['studentName']) ?></td></tr>
    <tr><th>Roll Number</th><td><?= htmlspecialchars($data['rollnumber']) ?></td></tr>
    <tr><th>IIITD Email</th><td><?= htmlspecialchars($data['studentEmail']) ?></td></tr>
    <tr>
    <th>Personal Email</th>
    <td>
        <?= !empty(trim($data['studentpEmail'])) 
              ? htmlspecialchars($data['studentpEmail']) 
              : 'N/A'; ?>
    </td>
</tr>
    <tr><th>Mobile</th><td><?= htmlspecialchars($data['studentMobile']) ?></td></tr>
    <tr><th>Program</th><td><?= htmlspecialchars($data['vtype']) ?></td></tr>
    <tr><th>Specialization</th><td><?= htmlspecialchars($data['role']) ?></td></tr>
    <tr><th>Enrollment Year</th><td><?= htmlspecialchars($data['yearofenroll']) ?></td></tr>
    <tr><th>Graduation Year</th><td><?= htmlspecialchars($data['yearofgraduation']) ?></td></tr>
    <tr><th>Registration Date</th><td><?= htmlspecialchars($data['regDate']) ?></td></tr>
    <tr>
    <th>Graduation Degree</th>
    <td>
        <?php
        $degreePath = "uploadDoc/" . $data['graduationdegree'];

        if (!empty($data['graduationdegree']) && file_exists($degreePath)) {
        ?>
            <a href="<?= $degreePath ?>" target="_blank" class="btn btn-info btn-xs">
                <i class="fa fa-file-pdf-o"></i> View Degree
            </a>
        <?php
        } else {
            echo "Not Uploaded";
        }
        ?>
    </td>
</tr>
</table>

<?php } ?>

</div>
</div>
</section>
</div>

<?php
include "lib/page-bottom-user.php";
ob_end_flush();
