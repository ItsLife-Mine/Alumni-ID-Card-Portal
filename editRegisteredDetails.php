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
$stmt = $DB_con->prepare("
    SELECT * FROM studentregistration 
    WHERE studentEmail = :email 
    LIMIT 1
");
$stmt->execute([':email' => $email]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    header("Location: dashboard.php");
    exit;
}

/* =========================
   BLOCK IF APPROVED
========================= */
if (strtoupper($data['status']) === 'APPROVED') {
    header("Location: dashboard.php");
    exit;
}

/* =========================
   UPDATE DATA
========================= */
if (isset($_POST['update'])) {

    $studentName      = trim($_POST['studentName']);
    $rollnumber       = trim($_POST['rollnumber']);
    $studentpEmail    = trim($_POST['studentpEmail']);
    $studentMobile    = trim($_POST['studentMobile']);
    $vtype            = trim($_POST['vtype']);
    $role             = trim($_POST['role']);
    $yearofenroll     = trim($_POST['yearofenroll']);
    $yearofgraduation = trim($_POST['yearofgraduation']);

    /* OPTIONAL FILES */
    $photograph = $data['photograph'];
    if (!empty($_FILES['photograph']['name'])) {
        $photoName = $studentMobile . '-' . $_FILES['photograph']['name'];
        move_uploaded_file($_FILES['photograph']['tmp_name'], "uploadDoc/" . $photoName);
        $photograph = $photoName;
    }

    $graduationdegree = $data['graduationdegree'];
    if (!empty($_FILES['graduationdegree']['name'])) {
        $degreeName = $studentMobile . '-' . $_FILES['graduationdegree']['name'];
        move_uploaded_file($_FILES['graduationdegree']['tmp_name'], "uploadDoc/" . $degreeName);
        $graduationdegree = $degreeName;
    }

    $update = $DB_con->prepare("
        UPDATE studentregistration SET
            studentName = :studentName,
            rollnumber = :rollnumber,
            studentpEmail = :studentpEmail,
            studentMobile = :studentMobile,
            vtype = :vtype,
            role = :role,
            yearofenroll = :yearofenroll,
            yearofgraduation = :yearofgraduation,
            photograph = :photograph,
            graduationdegree = :graduationdegree,
            status = 'PENDING',
            adminRemark = NULL
        WHERE studentEmail = :email
    ");

    $update->execute([
        ':studentName'      => $studentName,
        ':rollnumber'       => $rollnumber,
        ':studentpEmail'    => $studentpEmail,
        ':studentMobile'    => $studentMobile,
        ':vtype'            => $vtype,
        ':role'             => $role,
        ':yearofenroll'     => $yearofenroll,
        ':yearofgraduation' => $yearofgraduation,
        ':photograph'       => $photograph,
        ':graduationdegree' => $graduationdegree,
        ':email'            => $email
    ]);

    header("Location: dashboard.php?updated=1");
    exit;
}
?>

<div class="content-wrapper">
<section class="content-header text-center">
  <h1>Edit Registered Details</h1>
</section>

<section class="content">
<div class="row">
<div class="col-md-8 col-md-offset-2">

<div class="box box-warning">
<div class="box-body">

<form method="post" enctype="multipart/form-data">

<div class="form-group">
<label>Name</label>
<input type="text" name="studentName" class="form-control"
value="<?= htmlspecialchars($data['studentName']); ?>" required>
</div>

<div class="form-group">
<label>Roll Number</label>
<input type="text" name="rollnumber" class="form-control"
value="<?= htmlspecialchars($data['rollnumber']); ?>" required>
</div>

<div class="form-group">
<label>IIITD Email (cannot be changed)</label>
<input type="email" class="form-control"
value="<?= htmlspecialchars($data['studentEmail']); ?>" readonly>
</div>

<div class="form-group">
<label>Personal Email</label>
<input type="email" name="studentpEmail" class="form-control"
value="<?= htmlspecialchars($data['studentpEmail']); ?>" required>
</div>

<div class="form-group">
<label>Mobile</label>
<input type="text" name="studentMobile" class="form-control"
value="<?= htmlspecialchars($data['studentMobile']); ?>" required>
</div>

<div class="form-group">
<label>Program</label>
<select name="vtype" id="vtype" class="form-control" required>
<option value="">Select Program</option>
</select>
</div>

<div class="form-group">
<label>Specialization</label>
<select name="role" id="role" class="form-control" required>
<option value="">Select Specialization</option>
</select>
</div>

<div class="form-group">
<label>Enrollment Year</label>
<select name="yearofenroll" id="yearofenroll" class="form-control" required>
<?php for ($y=2008;$y<=date('Y');$y++): ?>
<option value="<?= $y ?>" <?= ($data['yearofenroll']==$y?'selected':'') ?>><?= $y ?></option>
<?php endfor; ?>
</select>
</div>

<div class="form-group">
<label>Graduation Year</label>
<select name="yearofgraduation" id="yearofgraduation" class="form-control" required></select>
</div>

<div class="form-group">
<label>Upload Graduation Degree (optional)</label>
<input type="file" name="graduationdegree" class="form-control">
</div>

<div class="form-group">
<label>Upload Photograph (optional)</label>
<input type="file" name="photograph" class="form-control">
</div>

<div class="form-group">
<label>
<input type="checkbox" name="notify_admin" value="1">
Notify admin about these changes via email
</label>
</div>

<div class="text-center">
<button type="submit" name="update" class="btn btn-warning">
<i class="fa fa-save"></i> Update Details
</button>
<a href="dashboard.php" class="btn btn-default">Cancel</a>
</div>

</form>

</div>
</div>
</div>
</div>
</section>
</div>

<script>
/* =========================
   PROGRAM → SPECIALIZATION
========================= */
var subjectObject = {
  "B.Tech.": {"CSE":1,"ECE":1,"CSAM":1,"CSD":1,"CSSS":1,"CSB":1,"CSAI":1,"EVE":1,"CSEcon":1},
  "M.Tech.": {"CSE":1,"CSE-Research":1,"ECE":1,"CB":1},
  "Dual Degree": {"CSE":1,"ECE":1,"CSAM":1,"CSD":1,"CSSS":1,"CSB":1,"CSAI":1,"EVE":1,"CSEcon":1},
  "Ph.D.": {"CSE":1,"ECE":1,"CB":1,"SSH":1,"HCD":1,"Maths":1},
  "PG Diploma": {"DSAI":1,"CSAI":1,"DSHCS":1}
};

var programSel = document.getElementById("vtype");
var roleSel    = document.getElementById("role");
var enrollSel  = document.getElementById("yearofenroll");
var gradSel    = document.getElementById("yearofgraduation");

/* LOAD PROGRAMS */
for (var p in subjectObject) {
  programSel.options[programSel.options.length] = new Option(p, p);
}
programSel.value = "<?= $data['vtype']; ?>";

/* LOAD ROLES */
function loadRoles() {
  roleSel.length = 1;
  if (!programSel.value) return;
  for (var r in subjectObject[programSel.value]) {
    roleSel.options[roleSel.options.length] = new Option(r, r);
  }
  roleSel.value = "<?= $data['role']; ?>";
}

/* ✅ FIXED GRADUATION LOGIC */
function loadGraduationYears() {

  gradSel.length = 0;
  const enrollYear = parseInt(enrollSel.value);
  const program = programSel.value;
  if (!enrollYear || !program) return;

  let offsets = [];

  switch (program) {
    case "B.Tech.":
      offsets = [4,5,6];
      break;
    case "M.Tech.":
      offsets = [2,3,4];
      break;
    case "Dual Degree":
      offsets = [5,6,7];
      break;
    case "Ph.D.":
      offsets = [4,5,6,7,8,9];
      break;
    case "PG Diploma":
      offsets = [1,2,3];
      break;
  }

  offsets.forEach(o => {
    gradSel.options[gradSel.options.length] =
      new Option(enrollYear + o, enrollYear + o);
  });

  gradSel.value = "<?= $data['yearofgraduation']; ?>";
}

programSel.onchange = function () {
  loadRoles();
  loadGraduationYears();
};
enrollSel.onchange = loadGraduationYears;

loadRoles();
loadGraduationYears();
</script>

<?php
require PATH_LIB . "page-bottom-user.php";
ob_end_flush();
?>
