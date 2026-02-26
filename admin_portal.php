<?php
require_once 'class.user.php';
$admin = new USER();

if(isset($_POST['update'])) {
    $sid = $_POST['sid'];
    $stat = $_POST['status'];
    $rem = $_POST['remarks'];
    $stmt = $admin->runQuery("UPDATE studentregistration SET idCardStatus=:s, adminRemarks=:r WHERE studentID=:id");
    $stmt->execute(array(":s"=>$stat, ":r"=>$rem, ":id"=>$sid));
    echo "<script>alert('Status Updated Successfully');</script>";
}
$stmt = $admin->runQuery("SELECT * FROM studentregistration");
$stmt->execute();
?>
<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
<body class="container">
    <h2>Admin Approval Portal</h2>
    <table class="table table-bordered">
        <tr><th>Name</th><th>Status</th><th>Action</th></tr>
        <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td><?php echo $row['studentName']; ?></td>
            <td><?php echo $row['idCardStatus']; ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="sid" value="<?php echo $row['studentID']; ?>">
                    <select name="status"><option value="Approved">Approve</option><option value="Rejected">Reject</option></select>
                    <input type="text" name="remarks" placeholder="Message if rejected">
                    <button type="submit" name="update" class="btn btn-success btn-sm">Save</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>