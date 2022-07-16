<?php
require_once './../util/initialize.php';
  
  if(isset($_GET['invoice_id'])){
    $invoice = Invoice::find_by_id($_GET['invoice_id']);
    // $invoice_sub = InvoiceSub::find_all_invoice_id($_GET['invoice_id']);

    // $invoice_total = 0;
    // $invoice_total = $invoice_total + $invoice_sub->sub_total;
    
    // $discount = 0;
    // $net_total = 0;
    // $discount = 100 - $invoice->invoice_discount;
    // $net_total = ($discount * $invoice_total)/100;
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
<body>
  
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<div class="container">
    <div class="row">
        <div class="col-xs-12">         
          

          <div class="col-xs-4" style="text-align: left;">
             <p class="font-weight-bold mb-1"><h3 style="font-weight:700;">Invoice Number: <?php echo $invoice->invoice_number; ?></h3></p>
             <p class="font-weight-bold mb-1"><h3 style="font-weight:700;">Invoice Date: <?php echo $invoice->invoice_date; ?></h3></p>
          </div>

          <div class="col-xs-4"></div>

           <div class="col-xs-4" style="text-align: left;">
             <p class="font-weight-bold mb-1"><h3 style="font-weight:700;">Customer Name: <?php echo $invoice->customer_id()->full_name; ?></h3></p>
              <p class="font-weight-bold mb-1"><h3 style="font-weight:700;">Invoice Branch: <?php echo $invoice->invoice_branch()->name; ?></h3></p>
           </div>
           <br>
      

        <div>
          
           <table class="table table-dark">
          <thead>
            <tr>
              <th style="font-weight:700;">Code</th>
              <th style="font-weight:700;">Qty</th>
              <th style="font-weight:700;">Unit Price</th>
              <th style="font-weight:700;">Sub Total</th>
              <th style="font-weight:700;">Discount</th>
              <th style="font-weight:700;">Gross Total</th>
              
              
            </tr>
          </thead>
          <tbody>
            <?php 
              $invoice_id = $_GET['invoice_id'];
              $invoice_data = Invoice::find_by_id($invoice_id);

              $invoice_total = 0;

            

            foreach(InvoiceSub::find_all_invoice_id($invoice_id) as $sub_invoice_data){             
              echo "<tr>";
              echo "<td>".$sub_invoice_data->code."</td>";
              echo "<td >".$sub_invoice_data->qty."</td>";
              echo "<td >".$sub_invoice_data->unit_price."</td>";
              echo "<td>".$sub_invoice_data->sub_total."</td>";
              echo "<td>".$invoice_data->invoice_discount."</td>";
              
              $discount = 0;
              $gross_total = 0;
              $discount = 100 - $invoice_data->invoice_discount;
              $gross_total = ($discount * $sub_invoice_data->sub_total)/100;
              echo "<td>".$gross_total."</td>";
              echo "</tr>";

              $invoice_total = $invoice_total + $sub_invoice_data->sub_total;
             }
            
              $discount = 0;
              $net_total = 0;
              $discount = 100 - $invoice_data->invoice_discount;
              $net_total = ($discount * $invoice_total)/100;
           
              // echo "<td> ".number_format($invoice_total,2)." </td>";
              // echo "<td  style='text-align:left;'> ".$invoice_data->invoice_discount."%</td>";

             ?>
             <tfoot>
               <tr>
                <th colspan="5" style="font-weight:700;font-size:20px;text-align: center;">Net Total </th>
                <th style="text-align: left;"> <?php echo number_format($net_total,2)  ?></th>
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