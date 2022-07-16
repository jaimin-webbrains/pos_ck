<?php

require_once './../../util/initialize.php';
$d1= 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
          $system_settings_value = SystemSettings::find_by_id(1);

  $system_expiry_month = $system_settings_value->expiry_month;
  $expiry_date = date('Y-m-d', strtotime('+' . $system_expiry_month . ' months'));


  
//   echo '<pre>';
// print_r($_POST);
// die;
if(isset($_POST['sales'])){
  $voucher_message = $_POST['voucher_message'];
  $voucher_value = $_POST['voucher_value'];
  $voucher_value_type = $_POST['voucher_value_type'];

  $system_max_voucher_discount = $system_settings_value->max_voucher_discount;
  if($voucher_value_type == 0){
    $sym = '%';
    if($system_max_voucher_discount < $voucher_value){
      $database->rollback();
      $_SESSION["error"] = "Please enter the voucher value under " . $system_max_voucher_discount ." .";
      // echo $system_max_voucher_discount;
      Functions::redirect_to("./../for_staff_voucher.php");
    }
  }else{
    $sym = '$';
  }


  global $database;
  $database->start_transaction();
  try {
      if (isset($_FILES["files_to_upload"]["name"]) && !empty($_FILES["files_to_upload"]["name"])) {
          $image_upload = new ImageUpload();
          $image_name = $image_upload->upload_image($_FILES["files_to_upload"], "./../uploads/users/");
          $voucher_background_image = $image_name;
      } else {
           $voucher_background_image = NULL;
      }
      foreach (Customer::find_all() as $customer_data) {
        $check = 'cus'.$customer_data->id;
        if(isset($_POST[$check])){
          $voucher_data = new Voucher();
          $voucher_data->voucher_message = $voucher_message;
          $voucher_data->voucher_value = $voucher_value;
          $voucher_data->voucher_value_type = $voucher_value_type;
          $voucher_data->voucher_background_image = $voucher_background_image;
          $voucher_data->customer_id = $customer_data->id;
          $voucher_object = Voucher::getVoucherAutoIncrement()+1;
          $vnumber= $voucher_data->voucher_number = 'TksU'.sprintf("%06d", $voucher_object);
          $voucher_data->voucher_type = 1;
          $voucher_data->save();
          // MAIL SECTION
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
    background-image: url("'.$d1.'./../uploads/users/'.$voucher_background_image.'");
  
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
      <h3>-APT VOUCHER-</h3>
    </div>
    <div class="container">
  <h2><b>'.$customer_data->full_name .'</b></h2>
      <h2><b>Msg: '.$voucher_message.'</b></h2>
      <p>Voucher Value: '.$voucher_value.''.$sym.'</p>
	  <p>Voucher Code: '. $vnumber.'</p>
    </div>
    <div class="container">
      <p>* Not Refundable Or Exchange in Cash</p>
      
    </div>
  </div>';
		  

          $to = $customer_data->email;
$subject = "APT system Voucher";

$headers = "From: apt.donotreply@gmail.com" . "\r\n";
$headers .= "Reply-To: aptmarketing66@gmail.com" . "\r\n";
$headers .= "CC: aptmarketing66@gmail.com" . "\r\n";
$headers .= "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";

          $message = $mail_details;
          $mailSendingStatus = mail($to, $subject, $message, $headers);
		  

        }
      }
      $database->commit();
      Activity::log_action("Voucher - saved : ");
      $_SESSION["message"] = "Successfull.";
      Functions::redirect_to("./../sales_wise_voucher.php");
  } catch (Exception $exc) {
      $database->rollback();
      $_SESSION["error"] = "Error..! Failed to save user." . $exc;
      echo $exc;
      Functions::redirect_to("./../sales_wise_voucher.php");
  }
}


if(isset($_POST['birthday'])){
  $voucher_message = $_POST['voucher_message'];
  $voucher_value = $_POST['voucher_value'];
  $voucher_value_type = $_POST['voucher_value_type'];


  $system_max_voucher_discount = $system_settings_value->max_voucher_discount;
  if($voucher_value_type == 0){
    $sym = '%';
    if($system_max_voucher_discount < $voucher_value){
      $database->rollback();
      $_SESSION["error"] = "Please enter the voucher value under " . $system_max_voucher_discount ." .";
      // echo $system_max_voucher_discount;
      Functions::redirect_to("./../birthday_voucher.php");
    }
  }else{
    $sym = '$';
  }
  
  global $database;
  $database->start_transaction();
  try {
      if (isset($_FILES["files_to_upload"]["name"]) && !empty($_FILES["files_to_upload"]["name"])) {
          $image_upload = new ImageUpload();
          $image_name = $image_upload->upload_image($_FILES["files_to_upload"], "./../uploads/users/");
          $voucher_background_image = $image_name;
      } else {
           $voucher_background_image = NULL;
      }
      foreach (Customer::find_all() as $customer_data) {
        $check = 'cus'.$customer_data->id;
        if(isset($_POST[$check])){
          $voucher_data = new Voucher();
          $voucher_data->voucher_message = $voucher_message;
          $voucher_data->voucher_value = $voucher_value;
          $voucher_data->voucher_value_type = $voucher_value_type;
          $voucher_data->voucher_background_image = $voucher_background_image;
          $voucher_data->customer_id = $customer_data->id;
          $voucher_object = Voucher::getVoucherAutoIncrement() + 1;
           $vnumber=$voucher_data->voucher_number = 'Dob'.sprintf("%06d", $voucher_object);
          $voucher_data->voucher_type = 2;
          $voucher_data->save();

          // MAIL SECTION 
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
    background-image: url("'.$d1.'./../uploads/users/'.$voucher_background_image.'");
  
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
      <h3>-APT VOUCHER-</h3>
    </div>
    <div class="container">
  <h2><b>'.$customer_data->full_name .'</b></h2>
      <h2><b>Msg: '.$voucher_message.'</b></h2>
      <p>Voucher Value: '.$voucher_value.''.$sym.'</p>
	  <p>Voucher Code: '. $vnumber.'</p>
	  
    </div>
    <div class="container">
      <p>* Not Refundable Or Exchange in Cash</p>
    
    </div>
  </div>';
		  

          $to = $customer_data->email;
$subject = "APT system Voucher";

$headers = "From: apt.donotreply@gmail.com" . "\r\n";
$headers .= "Reply-To: aptmarketing66@gmail.com" . "\r\n";
$headers .= "CC: aptmarketing66@gmail.com" . "\r\n";
$headers .= "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";

          $message = $mail_details;
          $mailSendingStatus = mail($to, $subject, $message, $headers);


        }
      }
      $database->commit();
      Activity::log_action("Voucher - saved : ");
      $_SESSION["message"] = "Successfull.";
      Functions::redirect_to("./../birthday_voucher.php");
  } catch (Exception $exc) {
      $database->rollback();
      $_SESSION["error"] = "Error..! Failed to save user." . $exc;
      echo $exc;
      Functions::redirect_to("./../birthday_voucher.php");
  }
}



if(isset($_POST['joined'])){
  $voucher_message = $_POST['voucher_message'];
  $voucher_value = $_POST['voucher_value'];
  $voucher_value_type = $_POST['voucher_value_type'];

  $system_max_voucher_discount = $system_settings_value->max_voucher_discount;
  if($voucher_value_type == 0){
    $sym = '%';
    if($system_max_voucher_discount < $voucher_value){
      $database->rollback();
      $_SESSION["error"] = "Please enter the voucher value under " . $system_max_voucher_discount ." .";
      // echo $system_max_voucher_discount;
      Functions::redirect_to("./../for_staff_voucher.php");
    }
  }else{
    $sym = '$';
  }

  global $database;
  $database->start_transaction();
  try {
      if (isset($_FILES["files_to_upload"]["name"]) && !empty($_FILES["files_to_upload"]["name"])) {
          $image_upload = new ImageUpload();
          $image_name = $image_upload->upload_image($_FILES["files_to_upload"], "./../uploads/users/");
          $voucher_background_image = $image_name;
      } else {
           $voucher_background_image = NULL;
      }
      foreach (Customer::find_all() as $customer_data) {
        $check = 'cus'.$customer_data->id;
        if(isset($_POST[$check])){
          $voucher_data = new Voucher();
          $voucher_data->voucher_message = $voucher_message;
          $voucher_data->voucher_value = $voucher_value;
          $voucher_data->voucher_value_type = $voucher_value_type;
          $voucher_data->voucher_background_image = $voucher_background_image;
          $voucher_data->customer_id = $customer_data->id;
          $voucher_object = Voucher::getVoucherAutoIncrement()+1;
          $vnumber= $voucher_data->voucher_number = 'Anv'.sprintf("%06d", $voucher_object);
          $voucher_data->voucher_type = 3;
          $voucher_data->save();

          // MAIL SECTION 
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
                background-image: url("'.$d1.'./../uploads/users/'.$voucher_background_image.'");
              
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
                <h3>-APT VOUCHER-</h3>
              </div>
              <div class="container">
                <h2><b>'.$customer_data->full_name .'</b></h2>
                <h2><b>Msg: '.$voucher_message.'</b></h2>
                <p>Voucher Value: '.$voucher_value.''.$sym.'</p>
                <p>Voucher Code: '. $vnumber.'</p>
              </div>
              <div class="container">
                <p>* Not Refundable Or Exchange in Cash</p>
              </div>
            </div>';

  


  // include('./../../smtp/PHPMailerAutoload.php');
  // $mail= new PHPMailer(true);
  // $mail->isSMTP();
  // $mail->Host="smtp.gmail.com";
  // $mail->Port=587;
  // $mail->SMTPSecure="tls";
  // $mail->SMTPAuth=true;
  // $mail->Username="viralode95745@gmail.com";
  // $mail->Password="9574535297";
  // $mail->SetFrom("viralode95745@gmail.com");
  // $mail->addAddress($customer_data->email);
  // $mail->IsHTML(true);
  // $mail->Subject="APT system Voucher";
  // $mail->Body=$mail_details;
  // $mail->SMTPOptions=array('ssl'=>array(
  //     'verify_peer'=>false,
  //     'verify_peer_name'=>false,
  //     'allow_self_signed'=>false
  // ));
  // $mail->send();




          $to = $customer_data->email;
          $subject = "APT system Voucher";

          $headers = "From: apt.donotreply@gmail.com" . "\r\n";
          $headers .= "Reply-To: aptmarketing66@gmail.com" . "\r\n";
          $headers .= "CC: aptmarketing66@gmail.com" . "\r\n";
          $headers .= "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
          $message = $mail_details;
          $mailSendingStatus = mail($to, $subject, $message, $headers);

        }
      }
      $database->commit();
      Activity::log_action("Voucher - saved : ");
      $_SESSION["message"] = "Successfull.";
      Functions::redirect_to("./../joined_voucher.php");
  } catch (Exception $exc) {
      $database->rollback();
      $_SESSION["error"] = "Error..! Failed to save user." . $exc;
      echo $exc;
      Functions::redirect_to("./../joined_voucher.php");
  }
}

if(isset($_POST['staff'])){
  // echo '<pre>';
  // print_r($_POST);
  // die;
  $voucher_message = $_POST['voucher_message'];
  $voucher_value = $_POST['voucher_value'];
  $voucher_value_type = $_POST['voucher_value_type'];
  $voucher_qty = $_POST['voucher_qty'];

  $system_max_voucher_discount = $system_settings_value->max_voucher_discount;
  // print_r($system_max_voucher_discount);
  if($voucher_value_type == 0){
    $sym = '%';
    if($system_max_voucher_discount < $voucher_value){
      $database->rollback();
      $_SESSION["error"] = "Please enter the voucher value under " . $system_max_voucher_discount ." .";
      // echo $system_max_voucher_discount;
      Functions::redirect_to("./../for_staff_voucher.php");
    }
  }else{
    $sym = '$';
  }

  global $database;
  $database->start_transaction();
  try {
      if (isset($_FILES["files_to_upload"]["name"]) && !empty($_FILES["files_to_upload"]["name"])) {
          $image_upload = new ImageUpload();
          $image_name = $image_upload->upload_image($_FILES["files_to_upload"], "./../uploads/users/");
          $voucher_background_image = $image_name;
      } else {
           $voucher_background_image = NULL;
      }
  
      foreach (User::find_all() as $staff_data) {
        $check = 'staff'.$staff_data->id;
        if(isset($_POST[$check])){
          
          for($i = 1; $i<= $voucher_qty; $i++){
            
            $Max_V = Voucher::STAF_MAX_NUMBER();
            
            if(count($Max_V) > 0){
              $CURRENT_MAX_NO = str_replace('STAFF','',$Max_V[0]->voucher_number) + 1;  
            }else{
              $CURRENT_MAX_NO = 1;  
            }

            $MAX_CODE = 'STAFF'.str_pad($CURRENT_MAX_NO,10,'0',STR_PAD_LEFT);
            $voucher_data = new Voucher();
            $voucher_data->voucher_message = $voucher_message;
            $voucher_data->voucher_value = $voucher_value;
            $voucher_data->voucher_value_type = $voucher_value_type;
            $voucher_data->voucher_background_image = $voucher_background_image;
            $voucher_data->staff_id = $staff_data->id;
            $voucher_object = Voucher::getVoucherAutoIncrement()+1;
            $vnumber=$voucher_data->voucher_number = $MAX_CODE;
            $voucher_data->voucher_type = 10;
            $voucher_data->voucher_qty = $voucher_qty;
            $voucher_data->save();

            // MAIL SECTION 
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
                background-image: url("'.$d1.'./../uploads/users/'.$voucher_background_image.'");
              
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
                  <h3>-APT VOUCHER-</h3>
                </div>
                <div class="container">
              <h2><b>'.$staff_data->name .'</b></h2>
                  <h2><b>Msg: '.$voucher_message.'</b></h2>
                  <p>Voucher Value: '.$voucher_value.''.$sym.'</p>
                <p>Voucher Code: '. $vnumber.'</p>
                
                </div>
                <div class="container">
                  <p>* Not Refundable Or Exchange in Cash</p>
                
                </div>
              </div>';

            $to = $staff_data->email;
            $subject = "APT system Voucher";

            $headers = "From: apt.donotreply@gmail.com" . "\r\n";
            $headers .= "Reply-To: aptmarketing66@gmail.com" . "\r\n";
            $headers .= "CC: aptmarketing66@gmail.com" . "\r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";

            $message = $mail_details;
            $mailSendingStatus = mail($to, $subject, $message, $headers);
          }
        }
        
        
      
      }
       
      $database->commit();
      Activity::log_action("Voucher - saved : ");
      $_SESSION["message"] = "Successfull.";
      Functions::redirect_to("./../for_staff_voucher.php");
  } catch (Exception $exc) {
      $database->rollback();
      $_SESSION["error"] = "Error..! Failed to save user." . $exc;
      echo $exc;
      Functions::redirect_to("./../for_staff_voucher.php");
  }
}



if(isset($_POST['select'])){
  $voucher_message = $_POST['voucher_message'];
  $voucher_value = $_POST['voucher_value'];
  $voucher_value_type = $_POST['voucher_value_type'];

  $system_max_voucher_discount = $system_settings_value->max_voucher_discount;
  if($voucher_value_type == 0){
    $sym = '%';
    if($system_max_voucher_discount < $voucher_value){
      $database->rollback();
      $_SESSION["error"] = "Please enter the voucher value under " . $system_max_voucher_discount ." .";
      // echo $system_max_voucher_discount;
      Functions::redirect_to("./../custom_voucher.php");
    }
  }else{
    $sym = '$';
  }

  
  global $database;
  $database->start_transaction();
  try {
      if (isset($_FILES["files_to_upload"]["name"]) && !empty($_FILES["files_to_upload"]["name"])) {
          $image_upload = new ImageUpload();
          $image_name = $image_upload->upload_image($_FILES["files_to_upload"], "./../uploads/users/");
          $voucher_background_image = $image_name;
      } else {
           $voucher_background_image = NULL;
      }
      foreach (Customer::find_all() as $customer_data) {
        $check = 'cus'.$customer_data->id;
        if(isset($_POST[$check])){
          $voucher_data = new Voucher();
          $voucher_data->voucher_message = $voucher_message;
          $voucher_data->voucher_value = $voucher_value;
          $voucher_data->voucher_value_type = $voucher_value_type;
          $voucher_data->voucher_background_image = $voucher_background_image;
          $voucher_data->customer_id = $customer_data->id;
          $voucher_object = Voucher::getVoucherAutoIncrement()+1;
          $vnumber= $voucher_data->voucher_number = 'Sorry'.sprintf("%06d", $voucher_object);
          $voucher_data->voucher_type = 4;
          $voucher_data->save();

          // MAIL SECTION 
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
    background-image: url("'.$d1.'./../uploads/users/'.$voucher_background_image.'");
  
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
      <h3>-APT VOUCHER-</h3>
    </div>
    <div class="container">
	<h2><b>'.$customer_data->full_name .'</b></h2>
      <h2><b>Msg: '.$voucher_message.'</b></h2>
      <p>Voucher Value: '.$voucher_value.''.$sym.'</p>
	   <p>Voucher Code: '.$vnumber.'</p>
    </div>
    <div class="container">
  <p>* Not Refundable Or Exchange in Cash </p>  
    </div>
  </div>';
          $to = $customer_data->email;
          $subject = "APT system Voucher";
          $headers = "From: apt.donotreply@gmail.com" . "\r\n";
          $headers .= "Reply-To: aptmarketing66@gmail.com" . "\r\n";
          $headers .= "CC: aptmarketing66@gmail.com" . "\r\n";
          $headers .= "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
          $message = $mail_details;
          $mailSendingStatus = mail($to, $subject, $message, $headers);


        }
      }
      $database->commit();
      Activity::log_action("Voucher - saved : ");
      $_SESSION["message"] = "Successfull.";
      Functions::redirect_to("./../custom_voucher.php");
  } catch (Exception $exc) {
      $database->rollback();
      $_SESSION["error"] = "Error..! Failed to save user." . $exc;
      echo $exc;
      Functions::redirect_to("./../custom_voucher.php");
  }
}
