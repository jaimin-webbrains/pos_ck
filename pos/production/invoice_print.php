<?php
require_once './../util/initialize.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
  if(isset($_GET['invoice_id'])){
    $invoice = Invoice::find_by_id($_GET['invoice_id']);
    $user = User::find_by_id($_SESSION["user"]["id"]);
  }  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Invoice Print</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
  .recipient-address {
    padding-top: 100px;
    width: 340px;
    text-align: center;
  }
  .border_h1 {
      border-bottom: 1px solid #858585;
      margin-top: 5px;
      margin-bottom: 10px;
      width: 316px;
  }
  .b, strong {
      font-weight: bolder;
      font-size: 12px;
  }
  td{
    font-size:11px;
  }
</style>
<body>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<div class="container">
    <div class="row">
        <div class="col-md-12">          
          <p class="recipient-address">
             <strong>APT Professional Team Sdn.Bhd <?php echo $invoice->invoice_branch()->name; ?></strong><br>
             (<?php echo $user->registration_number; ?>)<br>
              <?php echo $user->address; ?><br>
              Tel:<?php echo $user->contact_no; ?>
          </p>
          <div class="col-md-3">
            <h1 class="border_h1"></h1>
            <h4>Cashier: <strong><?php echo $invoice->invoice_branch()->name; ?></strong></h4>
            <h4>Invoice no: <?php echo $invoice->invoice_number; ?></h4>
            <h4><strong>Date: <?php echo date('d/m/Y h:i:s A',strtotime($invoice->invoice_date)); ?></strong></h4>
            <h4>Customer: <strong><?php echo $invoice->customer_id()->full_name; ?></strong> </h4>
          </div>
        <div>
          <div class="col-md-12"> 
            <table>
              <thead>
                <tr>
                  <th><strong>Item Name</strong></th>
                  <th class='text-right'><strong>Qty&nbsp;&nbsp;&nbsp;</strong></th>
                  <th class='text-center'><strong>Price</strong></th>
                  <th class='text-right'><strong>Discount&nbsp;&nbsp;&nbsp;</strong></th>
                  <th class='text-right'><strong>Amount</strong></th>
                </tr>
              </thead>
                <tbody>
                  <?php 
                    $total_voucherr = 0;
                    $invoice_id = $_GET['invoice_id'];
                    $invoice_data = Invoice::find_by_id($invoice_id);
                    $invoice_voucher = $invoice_data->invoice_voucher;
                    $voucher = Voucher::find_by_voucher_number($invoice_voucher);
                    $invoice_total = 0;
                    foreach(InvoiceSub::find_all_invoice_id($invoice_id) as $sub_invoice_data){
                      $gross_total = 0;
                      $gross_total = $sub_invoice_data->sub_total;
                      if(!empty($voucher)){
                        if($voucher->voucher_value_type == 0){
                          $sym = '%';
                          $total_voucherr = $gross_total * $voucher->voucher_value/100;
                        }else{
                          $sym = '';
                          $total_voucherr = $voucher->voucher_value;
                        }
                      }
                      echo "<tr>";
                      echo "<td>".$sub_invoice_data->name."</td>";
                      echo "<td class='text-right'>".number_format($sub_invoice_data->qty)."&nbsp;&nbsp;&nbsp;</td>";
                      echo "<td class='text-center'>".number_format($sub_invoice_data->unit_price,2)."</td>";
                      echo "<td class='text-right'>".number_format($total_voucherr,2)."&nbsp;&nbsp;&nbsp;</td>";
                      echo "<td class='text-right'>".number_format($gross_total,2 )."</td>";
                      echo "</tr>";
                      $invoice_total = $invoice_total + $sub_invoice_data->sub_total;
                    }
                    $net_total = 0;
                    $net_total = $invoice_total;
                  ?>
                    <tfoot>
                      <tr>
                        <th><strong class="mt-2">Rounding Amt</strong></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                      <tr>
                        <th colspan="0" style="font-weight:700;font-size:12px;text-align: left;"><strong>Total Sales</strong></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="font-weight:700;font-size:10px;text-align: right;">&nbsp;<?php echo number_format($net_total,2)  ?></th>
                      </tr>
                      <tr>
                        <th>Credit (RM)</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                      <tr>
                        <th><strong>Balance</strong></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                      <tr>
                        <th style="font-size:10px;"><strong>TAX Summary</strong></th>
                        <th></th>
                        <th></th>
                        <th style="font-size:10px;"><strong>Amount (RM)&nbsp;&nbsp;&nbsp;</strong></th>
                        <th class='text-right' style="font-size:10px;"><strong>Tax (RM)</strong></th>
                        
                      </tr>
                      <!-- <tr>
                        <th>S=0%</th>
                        <th></th>
                        <th></th>
                        <th class='text-right'><?php //echo number_format($net_total,2); ?></th>
                        <th></th>
                      </tr>
                      <tr>
                        <th>Z=0%</th>
                        <th></th>
                        <th></th>
                        <th class='text-right'></th>
                        <th></th>
                      </tr> -->
                      <tr style="text-align:center;">
                       <td colspan="5" style="padding-top: 10px;">
                          <h5>Please send us your feedback</h5>
                          <h5>visit http://www.apt.com/contact-us-enquiry/</h5>
                       </td>
                        
                      </tr>
                    </tfoot>
              </tbody>
          </table>
        </div>   
    </div>
</div>

<script type="text/javascript">
  window.print();
</script>
</body>
</html>