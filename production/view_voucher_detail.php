<?php
include "../util/initialize.php";
//$con=mysqli_connect("localhost","root","","newposdb");
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
$get_voucher=mysqli_query($con,"select * from voucher where id=224");
$fetch_expiry=mysqli_query($con,"select * from system_settings");
$fetch_expiry_row=mysqli_fetch_array($fetch_expiry);
$rows=array();
$current_date=date('Y-m-d');

$count=0;

while($voucher_data_array=mysqli_fetch_array($get_voucher))
{
	// echo '<pre>';
	// print_r($voucher_data_array);
	// die;
	$voucher_date=date('Y-m-d',strtotime(str_replace('-','/',$voucher_data_array['voucher_date'])));
	$expiry_date=date('Y-m-d', strtotime($voucher_date .'+'.$fetch_expiry_row['expiry_month'].' month'));
	//var_dump($expiry_date > $current_date);
	
	//$rows[$count]=$voucher_data_array['voucher_number'];
	//$rows[$count]=$voucher_data_array['voucher_value'];
	if($expiry_date >= $current_date)
	{
		//echo $current_date."   ".$expiry_date."</br>";
		array_push($rows, array("voucher_number" => $voucher_data_array['voucher_number'], "voucher_value" => $voucher_data_array['voucher_value']));
	}
}
echo json_encode($rows);
?>
