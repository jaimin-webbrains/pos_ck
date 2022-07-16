<?php
require_once './../util/initialize.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>POS TRANSACTION REPORT</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <script type="text/javascript">
    function exportTableToExcel(tableID, filename = ''){
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

        // Specify file name
        filename = filename?filename+'.xls':'excel_data.xls';
        // Create download link element
        downloadLink = document.createElement("a");
        document.body.appendChild(downloadLink);

        if(navigator.msSaveOrOpenBlob){
          var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
          });
          navigator.msSaveOrOpenBlob( blob, filename);
        }else{
          // Create a link to the file
          downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
          // Setting the file name
          downloadLink.download = filename;
          //triggering the function
          downloadLink.click();
        }
    }
  </script>
</head>
<body>

  <div class="container-fluid">
    <hr/>
    <button class="btn btn-primary" onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button>
    <hr/>

    <table id="tblData" class="table table-bordered" style="font-size:10px;width:100%;">
      <thead>
        <tr>
          <th>S/no</th>
          <th>Inv No.</th>
          <th>Customer No.</th>
          <th>Date</th>
          <th>Time</th>
          <th>Queue No.</th>
          <th>Total Sales</th>
          <th>Payment Type</th>
		      <th>Transaction ID</th>
          <th>Reference ID</th>
          <th>Service Staff 1</th>
          <th>Service Staff 2</th>
          <th>Voucher No</th>
          <th>Branch</th>
          <th>Queue Issue Time</th>
          <th>Birthday Month</th>
          <th>Product Description</th>
        </tr>
      </thead>
      <tbody>
        <?php
		    $checked = 0;
		    foreach (UserRole::find_all_by_user_id($_SESSION["user"]["id"]) as $user_role_data ) {
				 // echo "<h1>$user_role_data->role_id</h1>";
          if($user_role_data->role_id == 3 or $user_role_data->role_id == 7){  
            $q11="SELECT users.branch_id FROM `users`  WHERE users.id = '".$_SESSION["user"]["id"]."'" ;
              $retv22=mysqli_query($con,$q11);
              $res1=mysqli_fetch_array($retv22);
              if($res1[0]=='all')
              {
                  $checked = 0;
              }else
              {
                $checked = 1;
                $ar1 = explode(",",$res1[0]);
              }
          }
        }
		
        if(isset($_POST['from_date']) && isset($_POST['to_date'])){
          $from_date = $_POST['from_date'];
          $to_date = $_POST['to_date'];
          $branch_id = $_POST['branch_id'];
          // start content
          $sn = 1;
          foreach( Invoice::find_all_by_date_range($from_date, $to_date, $branch_id) as $inv_data )
          {
            
            if($checked==1 && array_search($inv_data->invoice_branch()->id,$ar1))
            {
              echo "<tr>";
              echo "<td>".$sn."</td>";
              echo "<td>".$inv_data->invoice_number."</td>";
              echo "<td>".$inv_data->customer_id()->full_name."</td>";
              // get the date time seprately
              $s = strtotime($inv_data->invoice_date);
              $date = date('Y-m-d', $s);
              $time = date('H:i:s', $s);
              echo "<td style='white-space:nowrap'>".$date."</td>";
              echo "<td>".$time."</td>";
              if($inv_data->queue_number > 0){
                $queue = Queue::find_by_id($inv_data->queue_number);
                echo "<td>".$queue->queue_number."</td>";
              }else{
                echo "<td>-</td>";
              }
              echo "<td>".number_format($inv_data->invoice_total,2)."</td>";
              if($inv_data->invoice_payment_type==1)
              {
                echo "<td>CASH</td>";
              }else if($inv_data->invoice_payment_type==2)
              {
                echo "<td>E-PAYMENT</td>";
              }else if($inv_data->invoice_payment_type==3)
              {
                echo "<td>".$inv_data->card_type."</td>";
              }
			          echo "<td>".$inv_data->invoice_transaction_id."</td>";
                echo "<td>-</td>";
                $ops_data = InvoiceSub::find_all_invoice_id_last($inv_data->id);
               
              if(!empty($ops_data->ops1_user)){
                echo "<td>".$ops_data->ops1_user()->name."</td>";
              }else{
                echo "<td> - </td>";
              }
              if(!empty($ops_data->ops2_user)){
                echo "<td>".$ops_data->ops2_user()->name."</td>";
              }else{
                echo "<td> - </td>";
              }
              echo "<td>".$inv_data->invoice_voucher."</td>";
              echo "<td>".$inv_data->invoice_branch()->name."</td>";
              if($inv_data->queue_number > 0){
                $queue = Queue::find_by_id($inv_data->queue_number);
                $qs = strtotime($queue->que_date_time);
                $qtime = date('H:i:s', $qs);
                echo "<td>".$qtime."</td>";
              }else{
                echo "<td>-</td>";
              }
              $bs = strtotime($inv_data->customer_id()->dob);
              $birthmonth = date('M', $bs);
              echo "<td>".$birthmonth."</td>";
              
              $sql3 = "SELECT `name` as `servicename` from invoice_sub where invoice_sub.invoice_id =".$inv_data->id; 
              $result3=mysqli_query($con,$sql3);         
              $servicename = '';
              if (mysqli_num_rows($result3) > 0) {
                while($row3 = mysqli_fetch_assoc($result3)) {
                  if($servicename == ''){
                    $servicename.= $row3['servicename'];
                  
                  }else{
                    $servicename.= ', '.$row3['servicename'];
                  }
                }
              }
              if(!empty($sql3)){
                echo "<td>".$servicename."</td>";
              }else{
                echo "<td> - </td>";
              }
              echo "</tr>";
              ++$sn;

            }
            else
            {
              echo "<tr>";
              echo "<td>".$sn."</td>";
              echo "<td>".$inv_data->invoice_number."</td>";
              echo "<td>".$inv_data->customer_id()->full_name."</td>";
              // get the date time seprately
              $s = strtotime($inv_data->invoice_date);
              $date = date('Y-m-d', $s);
              $time = date('H:i:s', $s);

              echo "<td style='white-space:nowrap'>".$date."</td>";
              echo "<td>".$time."</td>";
              if($inv_data->queue_number > 0){
                $queue = Queue::find_by_id($inv_data->queue_number);
                echo "<td>".$queue->queue_number."</td>";
              }else{
                echo "<td>-</td>";
              }
              echo "<td>".number_format($inv_data->invoice_total,2)."</td>";
              if($inv_data->invoice_payment_type==1)
              {
                echo "<td>CASH</td>";
              }else if($inv_data->invoice_payment_type==2)
              {
                echo "<td>E-PAYMENT</td>";
              }else if($inv_data->invoice_payment_type==3)
              {
                echo "<td>".$inv_data->card_type."</td>";
              }

              echo "<td>".$inv_data->invoice_transaction_id."</td>";
              echo "<td>-</td>";
              $ops_data = InvoiceSub::find_all_invoice_id_last($inv_data->id);
              
              if(!empty($ops_data->ops1_user)){
                echo "<td>".$ops_data->ops1_user()->name."</td>";
              }else{
                echo "<td> - </td>";
              }
              if(!empty($ops_data->ops2_user)){
                echo "<td>".$ops_data->ops2_user()->name."</td>";
              }else{
                echo "<td> - </td>";
              }
              echo "<td>".$inv_data->invoice_voucher."</td>";
              echo "<td>".$inv_data->invoice_branch()->name."</td>";
              if($inv_data->queue_number > 0){
                $queue = Queue::find_by_id($inv_data->queue_number);
                $qs = strtotime($queue->que_date_time);
                $qtime = date('H:i:s', $qs);
                echo "<td>".$qtime."</td>";
              }else{
                echo "<td>-</td>";
              }
              
              $bs = strtotime($inv_data->customer_id()->dob);
              $birthmonth = date('M', $bs);
              echo "<td>".$birthmonth."</td>";

              $sql3 = "SELECT `name` as `servicename` from invoice_sub where invoice_sub.invoice_id =".$inv_data->id; 
              $result3=mysqli_query($con,$sql3);         
              $servicename = '';
              if (mysqli_num_rows($result3) > 0) {
                while($row3 = mysqli_fetch_assoc($result3)) {
                  if($servicename == ''){
                    $servicename.= $row3['servicename'];
                  
                  }else{
                    $servicename.= ', '.$row3['servicename'];
                  }
                }
              }
              if(!empty($sql3)){
                echo "<td>".$servicename."</td>";
              }else{
                echo "<td> - </td>";
              }
              echo "</tr>";
              ++$sn;
            }
            // end content
          }
		    }
        ?>
      </tbody>
    </table>
    <!-- table ends -->
  </div>
</div>
</body>
</html>
