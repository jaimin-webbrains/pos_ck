<?php
$d1= 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
//echo $d1;
//exit();

//print_r($_POST);
require_once './../util/initialize.php';
require_once 'common/pos_header.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
$user = User::find_by_id($_SESSION["user"]["id"]);
if(isset($_POST['b11']))
{

$cus_id = Customer::find_by_id($_POST['file1']);
  $value = $_POST['file11'];
  $rand = rand(10,100000);

  // RETRIVE THE DIRECT_COMISSION VALUE

  $system_settings_value = SystemSettings::find_by_id(1);

  $system_expiry_month = $system_settings_value->expiry_month;
  $expiry_date = date('Y-m-d', strtotime('+' . $system_expiry_month . ' months'));

  $voucher_value = $value/$system_settings_value->point_voucher;

 $data = Voucher::find_by_id($_POST['voucher']);
 
 
 

	$email=$cus_id->email;
	//$image = base64_encode(file_get_contents("uploads/users/".$data->voucher_background_image ));   background-image: url("'. $data->voucher_background_image .'");
	
	  
  $to = $email;
$mail_details='<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
 <style media="screen">
  .coupon {
    border: 5px dotted #bbb; /* Dotted border */
    width: 80%;
    border-radius: 15px; /* Rounded border */
    margin: 0 auto; /* Center the coupon */
    max-width: 600px;
    background-image: url("'.$d1.'/uploads/users/'. $data->voucher_background_image.'");
  
    background-repeat: no-repeat;
    background-size: cover;
    color:red;
  }
  

  .container {
    padding: 2px 16px;
    
  }
 
  .promo {
    background: #ccc;
    padding: 3px;
  }

  .expire {
    color: red;
  }
</style>
</head>
<body>



  <div class="coupon">
    <div class="container">
      <h3>-ATC VOUCHER-</h3>
    </div>
    <div class="container">
	<h2>Congratulation you get voucher</b></h2>
      <h2><b>Customer Name: '.$cus_id->full_name .'</b></h2>
      <p>Voucher Value: '.$value.'$</p>
    </div>
    <div class="container">
      <p>Voucher Code: <span class="promo">VOU '. $rand .'</span></p>
      <p class="expire">Expires: '. $expiry_date .' </p>
    </div>
  </div>';

  

$subject = "APT system Voucher";

$headers = "From: webacreinfoway.it@gmail.com" . "\r\n";
$headers .= "Reply-To: webacreinfoway.it@gmail.com" . "\r\n";
$headers .= "CC: webacreinfoway.it@gmail.com" . "\r\n";
$headers .= "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";

$message = $mail_details;

$mailSendingStatus = mail($to, $subject, $message, $headers);

  if($mailSendingStatus)
  {
	  ?>
	   <script>
			window.onload=function()
			{
				alert("Email send Succesfully");
				window.location="index.php";
			}
		</script>
	  <?php
  }
  else
  {
	 ?>
	   <script>
			window.onload=function()
			{
				alert("Email Not Send");
				window.location="index.php";
			}
		</script>
	  <?php  
  }
  
}
?>