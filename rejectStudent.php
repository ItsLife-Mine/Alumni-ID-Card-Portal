<?php
session_start();
require_once 'dbconfig.php';

/* =========================
   ADMIN SESSION CHECK
========================= */
if (!isset($_SESSION['adminSession'])) {
    header("Location: index.php");
    exit;
}

/* =========================
   VALIDATE INPUT
========================= */
if (
    !isset($_POST['id']) ||
    !isset($_POST['remark']) ||
    !isset($_POST['authToken'])
) {
    header("Location: adminDashboard.php");
    exit;
}

$id     = intval($_POST['id']);
$remark = trim($_POST['remark']);

/* =========================
   UPDATE STUDENT (REJECT)
========================= */
$stmt = $DB_con->prepare("
    UPDATE studentregistration SET
        status = 'REJECTED',
        idCardStatus = 'NOT_GENERATED',
        adminRemark = :remark
    WHERE studentID = :id
");

$stmt->execute([
    ':remark' => $remark,
    ':id'     => $id
]);

/* =========================
   REDIRECT BACK
========================= */
header("Location: adminDashboard.php?authToken=" . urlencode($_POST['authToken']));
exit;
