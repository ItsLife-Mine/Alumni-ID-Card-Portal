<?php
require __DIR__ . "/lib/config.php";
require_once 'common.php';   // <-- IMPORTANT (ye DB connection deta hai)

if (!isset($DB_con)) {
    die("Database connection failed.");
}

if (!isset($_GET['email'])) {
    die("<h2 style='color:red;text-align:center;'>Invalid QR Code</h2>");
}

$email = $_GET['email'];

$stmt = $DB_con->prepare("
    SELECT * FROM studentregistration
    WHERE studentEmail = :email
    AND status = 'APPROVED'
    LIMIT 1
");
$stmt->execute([':email' => $email]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("<h2 style='color:red;text-align:center;'>INVALID ALUMNI ID</h2>");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Alumni Verification</title>
    <style>
        body{
            font-family: Arial;
            background:#f4f6f9;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }
        .card{
            background:white;
            padding:25px;
            width:350px;
            border-radius:10px;
            box-shadow:0 5px 20px rgba(0,0,0,0.15);
            text-align:center;
        }
        img{
            width:90px;
            border-radius:6px;
            margin-bottom:10px;
        }
        .valid{
            color:green;
            font-weight:bold;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="valid">✔ Alumni Verified</div>
    <img src="uploadDoc/<?php echo $data['photograph']; ?>">
    <p><strong>Name:</strong> <?php echo $data['studentName']; ?></p>
    <p><strong>Program:</strong> <?php echo $data['vtype']; ?></p>
    <p><strong>Batch:</strong> <?php echo $data['yearofgraduation']; ?></p>
    <p><strong>Email:</strong> <?php echo $data['studentEmail']; ?></p>
</div>

</body>
</html>