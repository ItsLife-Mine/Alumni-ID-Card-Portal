<?php
require_once 'dbconfig.php';
$program = $_POST['program'];
$result1 = $DB_con->prepare("SELECT * FROM batchupdate where programId='$program'");
$result1->execute();
echo '<option value="">-- Select Btach--</option>';
 for($i=0; $row = $result1->fetch(); $i++){
echo '<option value="'.$row['batchID'].'">'.$row['batch'].'</option>';
	
}
?>