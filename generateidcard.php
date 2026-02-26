<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../lib/page-top.php';

/* ===== VALIDATION ===== */
if (!isset($_GET['in'])) {
    header("Location: adminDashboard.php");
    exit;
}

$studentID = base64_decode($_GET['in']);

$stmt = $DB_con->prepare("
    SELECT studentName, studentEmail, photograph,
           vtype, role, yearofgraduation
    FROM studentregistration
    WHERE studentID = :id AND status='APPROVED'
    LIMIT 1
");
$stmt->execute([':id' => $studentID]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Invalid or unapproved record");
}

$name  = htmlspecialchars($data['studentName']);
$email = htmlspecialchars($data['studentEmail']);
$batch = htmlspecialchars($data['yearofgraduation']);
$program = htmlspecialchars($data['vtype'])." (".htmlspecialchars($data['role']).")";

$photoPath = "../uploadDoc/".$data['photograph'];
$photo = (!empty($data['photograph']) && file_exists($photoPath))
    ? $photoPath
    : "../dist/img/user2-160x160.jpg";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Alumni ID Card</title>

<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../dist/css/AdminLTE.min.css">

<style>
/* ===== ID CARD ===== */
#idCard{
    width:440px;
    min-height:260px;
    background:#e6f7f6;
    border-radius:14px;
    border:2px solid #0aa;
    box-shadow:0 10px 25px rgba(0,0,0,.12);
    font-family:'Segoe UI',Tahoma,sans-serif;
    overflow:hidden;
    margin:30px auto;
}

/* ===== HEADER ===== */
/* ===== HEADER ===== */
.logo-strip{
    height:60px;
    background-color:#f2fefe;
    background-image:url("../dist/img/iiit-logo.jpg");
    background-repeat:no-repeat;
    background-position:center;
    background-size:100% auto;   /* 🔥 FULL WIDTH */
    border-bottom:1.5px solid #0aa;
}

.title-strip{
    text-align:center;
    font-size:15px;
    font-weight:700;
    color:#009688;
    padding:6px 0;
    border-bottom:none;   /* ✅ neeche wali line removed */
}

/* ===== BODY ===== */
.id-body{
    display:flex;
    padding:14px;
    gap:14px;
}

.id-photo{
    width:95px;
    text-align:center;
}
.id-photo img{
    width:82px;
    height:100px;
    border-radius:8px;
    border:1px solid #ddd;
    background:#fff;
    padding:3px;
}

.id-info{
    flex:1;
    font-size:13px;
}
.id-info p{ margin:6px 0; }
.id-info strong{ font-weight:600; }
.id-qr {
    width: 90px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.id-qr img {
    border: 1px solid #ccc;
    padding: 4px;
    border-radius: 6px;
    background: #fff;
}

/* ===== PRINT SAFE ===== */
@media print{
    .main-header,.main-sidebar,.navbar,.btn{display:none!important;}
}
</style>
</head>

<body class="hold-transition skin-blue-light sidebar-mini">
<div class="wrapper">
<div class="content-wrapper">
<section class="content">

<div id="idCard">
    <div class="logo-strip"></div>
    <div class="title-strip">Alumni ID Card</div>

    <div class="id-body">
        <div class="id-photo">
            <img src="<?= $photo ?>">
        </div>
        <div class="id-info">
            <p><strong>Name:</strong> <?= $name ?></p>
            <p><strong>Program:</strong> <?= $program ?></p>
            <p><strong>Batch:</strong> <?= $batch ?></p>
            <p><strong>Email:</strong>
                <span style=><?= $email ?></span>
            </p>
        </div>
        <!-- QR -->
<div class="id-qr">
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?php echo urlencode('http://192.168.20.157/connected/alumni-verify.php?email='.$data['studentEmail']); ?>" width="85">
</div>
    </div>
</div>
<div class="text-center" style="margin-bottom:30px">
    <button onclick="downloadPDF()" class="btn btn-success">
        <i class="fa fa-download"></i> Download as PDF
    </button>
</div>

</section>
</div>
</div>

<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
async function downloadPDF(){
    const { jsPDF } = window.jspdf;
    const card = document.getElementById("idCard");

    const canvas = await html2canvas(card,{
        scale:4,
        useCORS:true,
        backgroundColor:"#ffffff"
    });

    const pdf = new jsPDF({
        orientation:"landscape",
        unit:"mm",
        format:[85.6,54]   // 💳 EXACT ID CARD SIZE
    });

    pdf.addImage(canvas.toDataURL("image/png"),
        "PNG",0,0,85.6,54);
    pdf.save("Alumni_ID_Card.pdf");
}
</script>

</body>
</html>
