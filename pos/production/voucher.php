
<script>
alert("Congratulation your voucher is created");
</script>

<?php
require_once './../util/initialize.php';
require_once 'common/pos_header.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
$user = User::find_by_id($_SESSION["user"]["id"]);
?>
<?php
  $idd=$cus_id = Customer::find_by_id($_POST['cusid']);
  $value = $_POST['value'];
  $rand = rand(10,100000);

  // RETRIVE THE DIRECT_COMISSION VALUE

  $system_settings_value = SystemSettings::find_by_id(1);

  $system_expiry_month = $system_settings_value->expiry_month;
  $expiry_date = date('Y-m-d', strtotime('+' . $system_expiry_month . ' months'));

  $voucher_value = $value/$system_settings_value->point_voucher;

?>
<?php


if (isset($_FILES["file1"]["name"]) && !empty($_FILES["file1"]["name"])) {
	
          $image_upload = new ImageUpload();
          $image_name = $image_upload->upload_image($_FILES["file1"], "uploads/users/");
          $voucher_background_image = $image_name;
      } else {
           $voucher_background_image = NULL;
      }
	  
	  if(isset($_POST)) {

  $data = new Voucher;

  $data->voucher_date = $expiry_date;
  $data->voucher_message = "Congretulation your voucher is created";
  $data->voucher_value = $voucher_value;
  $data->voucher_background_image = $voucher_background_image;
  $data->customer_id = $cus_id;
  $data->voucher_number = $rand;
  $data->voucher_type = 0;

  //print_r($data);

  try {
      $data->save();
	  $temp_voucher_value=$value;
	  foreach(RewardPoint::find_all_by_customer_id($cus_id->id) as $reward_data){
		  $reward_id=$reward_data->id;
        if($reward_data->reward_points==$temp_voucher_value)
		{
			$delete="delete from reward_point where id='$reward_id'";
			$query=mysqli_query($con,$delete);
			break;
		}else if($reward_data->reward_points>$temp_voucher_value){
			$temp_voucher_value=$reward_data->reward_points-$temp_voucher_value;
			$update="Update reward_point set reward_points='$temp_voucher_value' where id='$reward_id'";
			$query=mysqli_query($con,$update);
			break;
			
		}
		else if($reward_data->reward_points<$temp_voucher_value){
			$temp_voucher_value=$temp_voucher_value-$reward_data->reward_points;
			$delete="delete from reward_point where id='$reward_id'";
			$query=mysqli_query($con,$delete);
		}
        //$points = $points + $reward_data->reward_points;
      }
      Activity::log_action("Voucher Data - Inserted");
      $_SESSION["message"] = "Voucher Data - Inserted:.";
  } catch (Exception $exc) {
      $_SESSION["error"] = "Error..! Failed to save.";
  }

}

$voucher11 = mysqli_query($con,"SELECT id FROM `voucher` ORDER BY `voucher`.`id` DESC LIMIT 1");
$voucher12=mysqli_fetch_array($voucher11);
$voucher=$voucher12['id'];
$data = Voucher::find_by_id($voucher);

?>





<!DOCTYPE html>
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
    background-image: url("uploads/users/<?php echo $data->voucher_background_image; ?>");
    background-repeat: no-repeat;
    background-size: cover;
    color:white;
  }

  .container {
    padding: 2px 16px;
    /* background-color: #f1f1f1; */
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



  <div class="coupon" style="margin-top:5%">
    <div class="container">
	<h4>Congratulation your voucher is generated</b></h4>
      <h3>-ATC VOUCHER-</h3>
    </div>
    <div class="container" style="background-image:<?php echo ""?>">
	
      <h2><b>Customer Name: <?php echo $cus_id->full_name; ?></b></h2>
      <p>Voucher Value: <?php echo $voucher_value; ?>$</p>
    </div>
    <div class="container">
      <p>Voucher Code: <span class="promo">VOU<?php echo $rand; ?></span></p>
      <p class="expire">Expires: <?php echo $expiry_date; ?> </p>
    </div>
  </div>

  
  
  <form method="post" enctype="multipart/form-data" style="float: right; padding-right: 43%;" action="sendmail.php">
<div class="form-group" >	
<?php /**/?>
					<input type="hidden"  name="file1" class="form-control"  value="<?php echo $cus_id->id ?>"/>
					
					<input type="hidden"  name="file11" class="form-control" required value="<?php echo $value; ?>"/>
					 
					<input type="hidden"  name="voucher" class="form-control" required value="<?php echo $voucher; ?>"/>
				
                
                  <button type="submit" class="btn btn-warning btn-lg" name="b11">Send Voucher to Mail</button>
				   </div>
                </form>



</body>
</html>

<?php

?>


