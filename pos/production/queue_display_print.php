<?php
require_once './../util/initialize.php';
  
  if(isset($_GET['id'])){
    $queue = Queue::find_by_id($_GET['id']);

    
  } 
$user = User::find_by_id($_SESSION["user"]["id"]);
?>
<style media="screen">
.b1{
  font-weight: 700;
}
</style> 
    

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Queue Display Print</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<div class="container">
    <div class="row">
        <div class="col-6" style="text-align: center;">
          <div class="border border-primary  bg-dark text-white">
            
              <p class="font-weight-bold mb-1"><h3 style="font-weight:700;">Customer Name: <?php echo $queue->customer_id()->full_name; ?></h3></p>
              <p class="font-weight-bold mb-1"><h3 style="font-weight:700;">Queue Type: <?php echo $queue->queue_type; ?></h3></p>
              <p class="font-weight-bold mb-1"><h3 style="font-weight:700;">Queue Number:  <?php echo $queue->queue_number; ?></h3></p>
              <p class="font-weight-bold mb-1"><h3 style="font-weight:700;">Queue Date:  <?php echo $queue->que_date_time; ?></h3></p>
          </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  window.print();
</script>
</body>
</html>