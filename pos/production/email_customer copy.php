<?php
require_once './../util/initialize.php';
  
  if(isset($_GET['invoice_id'])){
    $invoice = Invoice::find_by_id($_GET['invoice_id']);
    // echo '<pre>';
    // print_r($invoice);
    // die;
    $customer_email = $invoice->customer_id()->email;
    



    $mail_details = '
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
        padding-top: 60px;
        width: 315px;
        text-align: center;
    }
    .border_h1 {
        border-bottom: 1px solid #8b7b7b;
        margin-top: 10px;
        margin-bottom: 10px;
        width: 290px;
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
              <strong>APT Professional Team Sdn Bhd S.Velocity</strong><br>
                (683360-U)<br>
                Lot 2-21,2nd Floor Sunway Velocity Mall, Lingkaran SV,<br>
                Sunway Velocity,  55100 Kaula Lampu<br>
                Tel: 03-27152238
            </p>
            <div class="col-md-3">
              <h1 class="border_h1"></h1>
              <h5>Cashier: <strong> '.$invoice->invoice_branch()->name.' </strong></h5>
              <h5>Invoice no: '.$invoice->invoice_number.' </h5>
              <h5><strong>Date: '.date("d/m/Y h:i:s A",strtotime($invoice->invoice_date)).' </strong></h5>
              
              
              <h5>Customer: <strong> '.$invoice->customer_id()->full_name.'</strong> </h5>
            </div>
          <div>
            <div class="col-md-12"> 
                <table>
              <thead>
                <tr>
                  <th><strong>Item Name</strong></th>
                  <th class="text-right"><strong>Qty&nbsp;&nbsp;&nbsp;</strong></th>
                  <th class="text-center"><strong>Price</strong></th>
                  <th class="text-right"><strong>Discount&nbsp;&nbsp;&nbsp;</strong></th>
                  <th class="text-right"><strong>Amount</strong></th>
                </tr>
              </thead>
                  <tbody>
                  
                      '.$invoice_id = $_GET["invoice_id"];
                      $invoice_data = Invoice::find_by_id($invoice_id);
                      $invoice_total = 0;
                      foreach(InvoiceSub::find_all_invoice_id($invoice_id) as $sub_invoice_data){   
                     
                        $discount = 0;
                        $gross_total = 0;
                        $discount = 100 - $invoice_data->invoice_discount;
                        $gross_total = ($discount * $sub_invoice_data->sub_total)/100;
                        "<tr>";
                        "<td>".$sub_invoice_data->name."</td>";
                        "<td class='text-right'>".$sub_invoice_data->qty."&nbsp;&nbsp;&nbsp;</td>";
                        "<td class='text-center'>".$sub_invoice_data->unit_price."</td>";
                        "<td class='text-right'>".$invoice_data->invoice_discount."&nbsp;&nbsp;&nbsp;</td>";
                        "<td class='text-right>".$gross_total."</td>";
                        "</tr>";
                        $invoice_total = $invoice_total + $sub_invoice_data->sub_total;
                      }
                      $discount = 0;
                      $net_total = 0;
                      $discount = 100 - $invoice_data->invoice_discount;
                      $net_total = ($discount * $invoice_total)/100;
                      $invoice_data->invoice_discount."%".';
                    
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
                          <th style="font-weight:700;font-size:10px;text-align: right;">&nbsp; '.number_format($net_total,2).' </th>
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
                          <th class="text-right" style="font-size:10px;"><strong>Tax (RM)</strong></th>
                          
                        </tr>
                        <!-- <tr>
                          <th>S=0%</th>
                          <th></th>
                          <th></th>
                          <th class="text-right"> </th>
                          <th></th>
                        </tr>
                        <tr>
                          <th>Z=0%</th>
                          <th></th>
                          <th></th>
                          <th class="text-right"></th>
                          <th></th>
                        </tr> -->
                      </tfoot>
                </tbody>
            </table>
            </div>
            <div class="col-md-12 mt-2" style="padding: 0px 0px 0px 55px;">
              <h6 class="ml-5">Please send us your feedback</h6>
              <h6 class="ml-1">visit http://www.apt.com/contact-us-enquiry/</h6>
            </div>     
      </div>
  </div>
</body>
</html>
    ';

    

    // MAIL SECTION 
    // $mail_details = '<!DOCTYPE html>
    // <html lang="en" dir="ltr">
    //   <head>
    //     <meta charset="utf-8">
    //     <title></title>
    //     <style media="screen">
    //       .container {
    //         padding: 2px 16px;
            
    //       }
    //       .promo {
    //         background: #ccc;
    //         padding: 3px;
    //       }
    //       .expire {
    //         color: red;
    //       }
    //     </style>
    //   </head>
    //   <body>
    //   <div class="coupon">
    //     <div class="container">
    //       <h3>-APT INVOICE-</h3>
    //     </div>
    //     <div class="container">
    //       <h2><b>'.$invoice->customer_id()->full_name .'</b></h2>
    //       <h2><b>Date: '.date('d-m-Y', strtotime($invoice->invoice_date)).'</b></h2>
    //       <p>Invoice Number: '.$invoice->invoice_number.'</p>
    //       <p>Invoice Payment: '.$invoice->invoice_payment.'$</p>
    //     </div>
    //     <div class="container">
    //       <p>* Thank You... *</p>  
    //     </div>
    //   </div>';

      include('./../../smtp/PHPMailerAutoload.php');
      $mail= new PHPMailer(true);
      $mail->isSMTP();
      $mail->Host="smtp.gmail.com";
      $mail->Port=587;
      $mail->SMTPSecure="tls";
      $mail->SMTPAuth=true;
      $mail->Username="niravkharadi62@gmail.com";
      $mail->Password="welcome@123";
      $mail->SetFrom("niravkharadi62@gmail.com");
      $mail->addAddress($customer_email);
      $mail->IsHTML(true);
      $mail->Subject="APT System Invoice";
      $mail->Body=$mail_details;
      $mail->SMTPOptions=array('ssl'=>array(
          'verify_peer'=>false,
          'verify_peer_name'=>false,
          'allow_self_signed'=>false
      ));
      $mail->send();

      // $to = $customer_email;
      // $subject = "APT system invoice";

      // $headers = "From: donotreply@apt.com.my" . "\r\n";
      // $headers .= "Reply-To: aptmarketing66@gmail.com" . "\r\n";
      // $headers .= "CC: aptmarketing66@gmail.com" . "\r\n";
      // $headers .= "MIME-Version: 1.0" . "\r\n";
      // $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";

      // $message = $mail_details;
      // $mailSendingStatus = mail($to, $subject, $message, $headers);  
  } 
  $_SESSION["message"] = "Email Successfully Sent.";
  Functions::redirect_to("./../production/invoice_type.php"); 

?>
