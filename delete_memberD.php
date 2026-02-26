<?php
require_once 'dbconfig.php';
$PID = $_POST[ "del_idD" ];
$applicationStatus = "DISAPPROVE";
$sqld = "UPDATE personalinformation set applicationStatus=:applicationStatus  WHERE PID=:PID";
$stmtd = $DB_con->prepare( $sqld );
$stmtd->bindParam( ':PID', $PID );
$stmtd->bindParam( ':applicationStatus', $applicationStatus );
if ( $stmtd->execute() ) {
   $MSG = "Are you sure want to remove this data?";
} else {
   $MSG = "error while updated....";
}
?>