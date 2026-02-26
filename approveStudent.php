<?php
session_start();
require_once 'dbconfig.php';

/* ===============================
   ADMIN SESSION CHECK
================================ */
if (!isset($_SESSION['adminSession'])) {
    header("Location: index.php");
    exit;
}

/* ===============================
   VALIDATE INPUT
================================ */
if (!isset($_GET['id'], $_GET['authToken'])) {
    header("Location: adminDashboard.php");
    exit;
}

$id        = intval($_GET['id']);
$authToken = $_GET['authToken'];

/* ===============================
   UPDATE STATUS (APPROVE)
================================ */
$stmt = $DB_con->prepare("
    UPDATE studentregistration SET
        status = 'APPROVED',
        idCardStatus = 'APPROVED'
    WHERE studentID = :id
");
$stmt->execute([':id' => $id]);

/* ===============================
   REDIRECT
================================ */
header("Location: adminDashboard.php?authToken=" . urlencode($authToken));
exit;
