<?php
require_once 'dbconfig.php';
$PID = $_POST[ "del_id" ];
$applicationStatus = "APPROVE";
$sql = "UPDATE personalinformation set applicationStatus=:applicationStatus  WHERE PID=:PID";
$stmt = $DB_con->prepare( $sql );
$stmt->bindParam( ':PID', $PID );
$stmt->bindParam( ':applicationStatus', $applicationStatus );
if ( $stmt->execute() ) {
   $MSG = "Are you sure want to remove this data?";
} else {
   $MSG = "error while updated....";
}
?>