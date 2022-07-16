<?php
require_once './../util/initialize.php';
require_once 'common/pos_header.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

$hidden_invoice_id = $_POST['hidden_invoice_id'];
$value = $_POST['value'];

$qry="Update invoice set thumps_status='{$value}' where id='$hidden_invoice_id'";
$query=mysqli_query($con,$qry);
return $query
?>
