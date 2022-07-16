<?php
require_once './../util/initialize.php';
$voucher = $_GET['id'];
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


  <div class="coupon">
    <div class="container">
      <h3>-APT VOUCHER-</h3>
    </div>
    <div class="container">
      <h2><b>Customer Name: <?php echo $data->customer_id()->full_name; ?></b></h2>
      <p><?php echo $data->voucher_message; ?></p>
      <p>Voucher Value: <?php echo $data->voucher_value; ?>$</p>
    </div>
    <div class="container">
      <p>Voucher Code: <span class="promo"><?php echo $data->voucher_number; ?></span></p>
    </div>
  </div>


</body>
</html>
