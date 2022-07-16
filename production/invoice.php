<?php
require_once './../util/initialize.php';
require_once 'common/pos_header.php';
$user = User::find_by_id($_SESSION["user"]["id"]);
if(isset($_GET['invoice_id'])){
  $invoice = Invoice::find_by_id($_GET['invoice_id']);
}else{
  $_SESSION["error"] = "Oops..! Something Went Wrong.";
  Functions::redirect_to("../invoice_type.php");
}
?>


<style>
  select{
    padding:10px;
  }
  option{
    /* background-color: teal; */
    font-size: 25px;
    font-weight:700;
  }
</style>

<body>

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-8">

        <!-- content container starts -->
        <div class="container-fluid">
          <div class="row" id='info-bar'>
            <div class="col-sm-8">

              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <td colspan=2 >LOGGEDIN USER: <?php echo $user->name; ?> || Branch Name: <?php
                    $branch = Branch::find_by_id($user->branch_id);
                    echo $branch->name;
                    ?> || Code: <?php
                    $branch = Branch::find_by_id($user->branch_id);
                    echo $branch->code;
                    ?></td>
                  </tr>
                </tbody>
              </table>

            </div>
            <div class="col-sm-2">
              <table>
                <tbody>
                  <tr>
                    <td>Date: </td>
                    <td> <?php echo date("Y-m-d"); ?> </td>
                  </tr>
                  <tr>
                    <td>Time: </td>
                    <td> <?php echo date("h:i:s"); ?> </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-sm-2">
              <a href="index.php" class="btn btn-info" role="button"> <span class="fa fa-home"></span> </a>
              <a href="logout.php" class="btn btn-info" role="button"> <span class="fa fa-sign-out"></span> </a>
            </div>

            <?php
            // require_once 'common/mini_header.php';
            ?>

          </div>
        </div>
        <?php Functions::output_result(); ?>
        <div class="col-sm-12" id='grid-section'>
          <div class="form-group">
            <label>CUSTOMER: <?php echo $invoice->customer_id()->full_name; ?> / <?php echo $invoice->customer_id()->mobile; ?> / <?php echo $invoice->customer_id()->email; ?></label>

          </div>

          <hr/>
          <!-- table grid start -->
          <div style="min-height:400px;overflow:auto;">

            <table class="table table-striped grid-table">
              <thead>
                <tr>
                  <th>S/No</th>
                  <th>Name</th>
                  <th>Code</th>
                  <th>Unit Price</th>
                  <th>Qty</th>
                  <th>Sub Total</th>
                  <th>Ops1</th>
                  <th>Ops2</th>
                  <th>Color</th>
                </tr>
              </thead>
              <tbody style="min-height:400px;overflow:auto;">
                <?php
                $invoice_total = 0;
                $invoice_object = InvoiceSub::find_all_invoice_id($_GET['invoice_id']);
                $row_count = 1;
                foreach($invoice_object as $invoice_sub_data){
                  echo "<tr>";
                  echo "<td>".$row_count."</td>";
                  echo "<td>".$invoice_sub_data->name."</td>";
                  echo "<td>".$invoice_sub_data->code."</td>";
                  echo "<td>".$invoice_sub_data->unit_price."</td>";
                  // echo "<td><form method='post' action='proccess/invoice_process.php'><input type='hidden' name='invoice_id' value='".$_GET['invoice_id']."' /><input type='hidden' name='row_qty_update' value='".$invoice_sub_data->id."' /> <input type='text' name='qty' value='".$invoice_sub_data->qty."'> <button type='submit' class='btn btn-primary btn-xs'>Update</button></form> </td>";
                  echo "<td>".$invoice_sub_data->qty."</td>";
                  echo "<td>".$invoice_sub_data->sub_total."</td>";
                  echo "<td><form method='post' action='proccess/invoice_process.php'>
                      <input type='hidden' name='invoice_id' value='".$_GET['invoice_id']."' />
                      <input type='hidden' name='row_qty_ops' value='".$invoice_sub_data->id."' />

                  <select name='ops1'>";
                  echo "<option disabled selected> - SELECT - </opion>";
                  foreach(User::find_all_service_branch($user->branch_id) as $user_data){

                    if($invoice_sub_data->ops1_user == $user_data->id ){
                      echo "<option value='".$user_data->id."' selected>".$user_data->name."</option>";
                    }else{
                      echo "<option value='".$user_data->id."'>".$user_data->name."</option>";
                    }

                  }
                  echo " </select> </td>";

                  echo "<td><select name='ops2'>";
                  echo "<option disabled selected> - SELECT - </opion>";
                  foreach(User::find_all_service_branch($user->branch_id) as $user_data){
                    if($invoice_sub_data->ops2_user == $user_data->id ){
                      echo "<option value='".$user_data->id."' selected>".$user_data->name."</option>";
                    }else{
                      echo "<option value='".$user_data->id."'>".$user_data->name."</option>";
                    }
                  }

                  echo " </select> </td>";
                  if(($invoice_sub_data->item_type == 2) || ($invoice_sub_data->item_type == 4)){
                    $check = Colour::capture_code($invoice_sub_data->code);
                    if(!empty($check)){
                      echo "<td><input class='form-control' type='text' placeholder= 'tube code...' name='color' style='width: 100px;'></td>";
                      echo "<td><input class='form-control' type='number' placeholder='%' name='percentage' max='100' min='0'/></td>";

                        echo "<tr><td colspan='8'></td>
                        <td><input class='form-control' type='text' placeholder= 'tube code...' name='color2' style='width: 100px;'></td>";
                        echo "<td><input class='form-control' type='number' placeholder='%' name='percentage2' max='100' min='0' /></td></tr>
                        <tr><td colspan='8'></td>
                        <td><input class='form-control' type='text' placeholder= 'tube code...' name='color3' style='width: 100px;'></td>";
                        echo "<td><input class='form-control' type='number' placeholder='%' name='percentage3' max='100' min='0' /></td></tr>";
                    }
                  }
                  echo "<tr><td colspan=8></td><td><button type='submit' class='btn btn-primary btn-sm'><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Save </button> </form></td>";
                  echo "<td><a href='proccess/invoice_process.php?invoice_row_delete=".$invoice_sub_data->id."&&invoice_id=".$_GET['invoice_id']."' class='btn btn-sm btn-danger'><i class='fa fa-trash' aria-hidden='true'></i> Remove</a></td>";
                  echo "</tr>";

                  $invoice_total = $invoice_total + $invoice_sub_data->sub_total;
                  ++$row_count;
                }
                ?>
              </tbody>
            </table>
          </div>
          <!-- table grid end -->
          <?php
          $customer_id = $invoice->customer_id;
          $today = date('Y-m-d');
          $queue_number = 0;
          $queue_data = Queue::find_by_type_last_customer($customer_id,$today);
          if(!empty($queue_data)){
            $queue_number = $queue_data->id;
          }
          ?>

          <div class="col-sm-12">
            <div class="col-sm-12">
              <p style='font-size:30px;'> TOTAL:  <?php echo number_format($invoice_total,2); ?> </p>
              <hr/>
            </div>

            <div class="col-sm-3"><a type="button" style="background-color:transparent;box-shadow:none;" data-toggle="modal" data-target="#myModal"><img src="uploads/logos/2-01.png" style="width:100%;"></a></a></div>
            <div class="col-sm-3"> <a type="button" style="background-color:transparent;box-shadow:none;" data-toggle="modal" data-target="#myModal2"><img src="uploads/logos/2-02.png" style="width:100%;"></a> </div>
            <div class="col-sm-3"> <a type="button" style="background-color:transparent;box-shadow:none;" data-toggle="modal" data-target="#myModal3"><img src="uploads/logos/2-03.png" style="width:100%;"></a> </div>
            <div class="col-sm-3"> <a type="button" style="background-color:transparent;box-shadow:none;"><img src="uploads/logos/2-05.png" style="width:100%;"></a> </div>

            <!-- CASH MODEL BODY START -->
            <div id="myModal" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>CASH PAYMENT</b> <small style="background-color:black;color:white;padding:5px;"> CUSTOMER QUEUE:
                      <?php
                      echo $queue_number;
                      ?>
                    </small></h4>
                  </div>
                  <div class="modal-body">
                    <form action="proccess/invoice_process.php" method="post">

                      <input type="hidden" name='queue_number' value='<?php echo $queue_number;  ?>'>
                      <input type="hidden" name='cash_invoice_number' value='<?php echo $_GET['invoice_id'];  ?>'>
                      <input type="hidden" name='invoice_total' id="invoice_total" value='<?php echo $invoice_total;  ?>'>
                      <input type="hidden" name='invoice_type' value='1'>
                      <p style="font-size:30px;"> INVOICE TOTAL: <?php echo number_format($invoice_total,2); ?></p>


                      <input type="hidden" name="invoice_discount" value="0" required>
                      <div class="col-sm-6">

                        <div class="form-group">
                          <label>INVOICE NUMBER: </label>
                          <input type="text" class="form-control" name="invoice_number"  placeholder="INVOICE NUMBER" required>

                        </div>

                        <div class="form-group">
                          <label>CASH AMOUNT: </label>
                          <input type="text" class="form-control" id="invoice_payment" name="invoice_payment" value="<?php echo $invoice_total; ?>" placeholder="INVOICE PAYMENT" id="cashmod" required>
                        </div>

                        <div class="form-group">
                          <label>VOUCHER NUMBER: </label>
                          <input type="text" class="form-control" name="voucher_number" id="cash_voucher_number" value="" placeholder="VOUCHER NUMBER" >
						  <label id="voucher_number_error"></label>

                        </div>

                        <div class="form-group">
                          <button type="submit" id="cash_btn" class="btn btn-primary btn-block">SAVE INVOICE</button>
                        </div>

                      </div>
                    </form>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <!-- CASH MODEL BODY ENDS -->

            <!-- OTHER E-PAYMENTS START -->
            <div id="myModal2" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>OTHER E-PAYMENTS</b></h4>
                  </div>
                  <div class="modal-body">
                    <form action="proccess/invoice_process.php" method="post">

                      <input type="hidden" name='queue_number' value='<?php echo $queue_number;  ?>'>
                      <input type="hidden" name='cash_invoice_number' value='<?php echo $_GET['invoice_id'];  ?>'>
                      <input type="hidden" name='invoice_total' id="invoice_total1" value='<?php echo $invoice_total;  ?>'>
                      <input type="hidden" name='invoice_type' value='2'>
                      <p style="font-size:30px;"> INVOICE TOTAL: <?php echo number_format($invoice_total,2); ?></p>


                      <div class="col-sm-6">

                      <input type="hidden" name="invoice_discount" value="0" required>

                      <div class="form-group">
                        <label>INVOICE NUMBER: </label>
                        <input type="text" class="form-control" name="invoice_number" placeholder="INVOICE NUMBER" required>
                      </div>

                        <div class="form-group">
                          <label>TRANSACTION ID : </label>
                          <input type="text" class="form-control" name="invoice_transaction_id" placeholder="TRANSACTION ID" required>
                        </div>
						<div class="form-group">
                          <label> VOUCHER NUMBER : </label>
                          <input type="text" class="form-control" name="voucher_number" id="cash_voucher_number1" value=""  placeholder="VOUCHER NUMBER" >

						  						  <label id="voucher_number_error1"></label>
                        </div>
                        <div class="form-group">
                          <label>E-PAYMENT AMOUNT: </label>
                          <input type="text" class="form-control" id="epaymentamount" name="invoice_payment" placeholder="E-PAYMENT AMOUNT" required>
                       <label id="pay_error1"></label>

					   </div>

                        <div class="form-group">
                          <label> E PAYMENT OPERATOR : </label>
                          <select class="form-control" name="e_operator">
                            <?php
                            foreach(EpaymentOperator::find_all() as $data){
                              echo "<option value='".$data->id."'>".$data->name."</option>";
                            }
                            ?>
                          </select>
                        </div>



                        <div class="form-group">
                          <button type="submit" id="epayment_btn" class="btn btn-primary btn-block">SAVE INVOICE</button>
                        </div>

                      </div>
                    </form>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <!-- OTHER E-PAYMENTS ENDS -->

            <!-- OTHER E-PAYMENTS START -->
            <div id="myModal3" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>CREDIT CARD + VOUCHER</b></h4>
                  </div>
                  <div class="modal-body">
                    <form action="proccess/invoice_process.php" method="post">

                      <input type="hidden" name='queue_number' value='<?php echo $queue_number;  ?>'>
                      <input type="hidden" name='cash_invoice_number' value='<?php echo $_GET['invoice_id'];  ?>'>
                      <input type="hidden" name='invoice_total' id="invoice_total2" value='<?php echo $invoice_total;  ?>'>
                      <input type="hidden" name='invoice_type' value='3'>
                      <p style="font-size:30px;"> INVOICE TOTAL: <?php echo number_format($invoice_total,2); ?></p>


                      <div class="col-sm-6">

                        <input type="hidden" name="invoice_discount" value="0" required>

                        <div class="form-group">
                          <label>INVOICE NUMBER: </label>
                          <input type="text" class="form-control" name="invoice_number" placeholder="INVOICE NUMBER" required>
                        </div>

                        <div class="form-group">
                          <label>VOUCHER NUMBER: </label>
                          <input type="text" class="form-control" name="voucher_number" id="cash_voucher_number2" value="" placeholder="VOUCHER NUMBER" >


						  						  <label id="voucher_number_error2"></label>

                        </div>

                        <div class="form-group">
                          <label>CREDIT CARD AMOUNT : </label>
                          <input type="text" class="form-control" name="invoice_cash_paymnet" id="creditpaymentamount" placeholder="CREDIT CARD AMOUNT" required>
                        </div>
                         <div class="form-group">
                          <label>TRANSACTION ID : </label>
                          <input type="text" class="form-control" name="invoice_transaction_id" placeholder="TRANSACTION ID" required>
                        </div>
                        <div class="form-group">
                          <label>SELECT CARD TYPE : </label>
                        <input type="radio"  name="master_visa" placeholder="MASTER OR VISA" required value="MASTER"> MASTER CARD
						 <input  type="radio"  name="master_visa" placeholder="MASTER OR VISA" required value="VISA"> VISA CARD
                        </div>

                        <div class="form-group">
                          <label>CASH PAYMENT: </label>
                          <input type="text" class="form-control" id="invoice_payment2" name="invoice_payment" placeholder="INVOICE PAYMENT" required>
                        </div>


                        <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-block" id="credit_btn">SAVE INVOICE</button>
                        </div>

                      </div>
                    </form>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <!-- OTHER E-PAYMENTS ENDS -->


          </div>

        </div>
      </div>

      <div class="col-sm-4" style="margin-top:20px;">
        <div class="col-sm-12" id='product-section' style="min-height:840px;">
          <!-- <p style='font-size:30px;'> TOTAL:  <?php echo number_format($invoice_total,2); ?> </p> -->
          <!-- <h4>Category for brand, service</h4> -->
          <?php
          if(isset($_GET['service'])){
            ?>
            <div class="col-sm-12 select-section"> <a href="invoice.php?invoice_id=<?php echo $_GET['invoice_id']; ?>" class="btn btn-warning btn-block" style="padding:20px;font-size:25px;" role="button"> BACK </a> </div>

            <?php
            foreach( ServiceCategory::find_all() as $service_data ){
              ?>
              <div class="col-sm-6 select-section">
                <div class="col-sm-12" style="background-color:#2980b9;padding:5px;border-radius:5px;">
                  <a href="invoice.php?service_cat=<?php echo $service_data->id; ?>&&invoice_id=<?php echo $_GET['invoice_id']; ?>" style="width:100%;color:white;font-size:20px;padding:5px;" role="button"> <?php echo $service_data->name; ?> </a>
                </div>
              </div>
              <?php
            }
            ?>

            <?php
          }else if(isset($_GET['package'])){
            ?>
            <div class="col-sm-12 select-section"> <a href="invoice.php?invoice_id=<?php echo $_GET['invoice_id']; ?>" class="btn btn-warning btn-block" style="padding:20px;font-size:25px;" role="button"> BACK </a> </div>

            <?php
            foreach(ServiceCategory::find_all() as $package_data){
              ?>
              <div class="col-sm-6 select-section">
                <div class="col-sm-12" style="background-color:#2980b9;padding:5px;border-radius:5px;">
                  <a href="invoice.php?package_cat=<?php echo $package_data->id; ?>&&invoice_id=<?php echo $_GET['invoice_id']; ?>" style="width:100%;color:white;font-size:20px;padding:5px;" role="button"> <?php echo $package_data->name; ?> </a>
                </div>
              </div>
              <?php
            }
            ?>

            <?php
          }else if(isset($_GET['product'])){
            ?>
            <div class="col-sm-12 select-section"> <a href="invoice.php?invoice_id=<?php echo $_GET['invoice_id']; ?>" class="btn btn-warning btn-block" style="padding:20px;font-size:25px;" role="button"> BACK </a> </div>

            <?php
            foreach(Product::find_all_normal() as $product_data){
              ?>
              <div class="col-sm-6 select-section">
                <div class="col-sm-12" style="background-color:#2980b9;padding:5px;border-radius:5px;">
                  <a href="proccess/invoice_process.php?product=<?php echo $product_data->id; ?>&&invoice_id=<?php echo $_GET['invoice_id']; ?>" style="width:100%;color:white;font-size:20px;padding:5px;" role="button"> <?php echo $product_data->name; ?> </a>
                </div>
              </div>
              <?php
            }
            ?>

            <?php
          }else if(isset($_GET['product_other'])){
            ?>
            <div class="col-sm-12 select-section"> <a href="invoice.php?invoice_id=<?php echo $_GET['invoice_id']; ?>" class="btn btn-warning btn-block" style="padding:20px;font-size:25px;" role="button"> BACK </a> </div>

            <?php
            foreach(Product::find_all_other() as $product_data){
              ?>
              <div class="col-sm-6 select-section">
                <div class="col-sm-12" style="background-color:#2980b9;padding:5px;border-radius:5px;">
                  <a href="proccess/invoice_process.php?product=<?php echo $product_data->id; ?>&&invoice_id=<?php echo $_GET['invoice_id']; ?>" style="width:100%;color:white;font-size:20px;padding:5px;" role="button"> <?php echo $product_data->name; ?> </a>
                </div>
              </div>
              <?php
            }
            ?>

            <?php
          }else if(isset($_GET['service_cat'])){
            ?>
            <div class="col-sm-12 select-section"> <a href="invoice.php?service=2&&invoice_id=<?php echo $_GET['invoice_id']; ?>" class="btn btn-warning btn-block" style="padding:20px;font-size:25px;" role="button"> BACK </a> </div>

            <?php
            foreach(Service::find_all_cat_id($_GET['service_cat']) as $service_data){
              ?>
              <div class="col-sm-6 select-section">
                <div class="col-sm-12" style="background-color:#2980b9;padding:5px;border-radius:5px;">
                  <a href="proccess/invoice_process.php?service=<?php echo $service_data->id; ?>&&invoice_id=<?php echo $_GET['invoice_id']; ?>" style="width:100%;color:white;font-size:20px;padding:5px;" role="button"> <?php echo $service_data->name; ?> </a>
                </div>
              </div>
              <?php
            }
            ?>

            <?php
          }else if(isset($_GET['package_cat'])){
            ?>
            <div class="col-sm-12 select-section"> <a href="invoice.php?package=3&&invoice_id=<?php echo $_GET['invoice_id']; ?>" class="btn btn-warning btn-block" style="padding:20px;font-size:25px;" role="button"> BACK </a> </div>

            <?php
            foreach(Package::find_all_cat_id($_GET['package_cat']) as $package_data){
              ?>
              <div class="col-sm-6 select-section">
                <div class="col-sm-12" style="background-color:#2980b9;padding:5px;border-radius:5px;">
                  <a href="proccess/invoice_process.php?package=<?php echo $package_data->id; ?>&&invoice_id=<?php echo $_GET['invoice_id']; ?>" style="width:100%;color:white;font-size:20px;padding:5px;" role="button"> <?php echo $package_data->name; ?> </a>
                </div>
              </div>
              <?php
            }
            ?>

            <?php
          }else if(isset($_GET['redeem'])){
            ?>
            <div class="col-sm-12 select-section"> <a href="invoice.php?invoice_id=<?php echo $_GET['invoice_id']; ?>" class="btn btn-warning btn-block" style="padding:20px;font-size:25px;" role="button"> BACK </a> </div>

            <?php
            foreach(Redeem::find_all_customer_id($invoice->customer_id) as $redeem_data){
              ?>
              <div class="col-sm-6 select-section">
                <div class="col-sm-12" style="background-color:#2980b9;padding:5px;border-radius:5px;">
                  <a href="proccess/invoice_process.php?redeem=<?php echo $redeem_data->id; ?>&&invoice_id=<?php echo $_GET['invoice_id']; ?>" style="width:100%;color:white;font-size:20px;padding:5px;" role="button"> <?php echo $redeem_data->package_id()->name; ?> ||  <b style='color:yellow;'> Balance: <?php echo $redeem_data->balance; ?></b></a>
                </div>
              </div>
              <?php
            }

          }else{
            ?>
            <div class="col-sm-4 select-section"> <a href="invoice.php?product=1&&invoice_id=<?php echo $_GET['invoice_id']; ?>" class="btn btn-info btn-block" style="font-size:20px;" role="button"> Product </a> </div>
            <div class="col-sm-4 select-section"> <a href="invoice.php?service=2&&invoice_id=<?php echo $_GET['invoice_id']; ?>" class="btn btn-info btn-block" style="font-size:20px;" role="button"> Services </a> </div>
            <?php if($invoice->customer_id != 1){ ?>
              <div class="col-sm-4 select-section"> <a href="invoice.php?package=3&&invoice_id=<?php echo $_GET['invoice_id']; ?>" class="btn btn-info btn-block" style="font-size:20px;" role="button"> Packages </a> </div>
              <div class="col-sm-12 select-section"> <a href="invoice.php?redeem=2&&invoice_id=<?php echo $_GET['invoice_id']; ?>" class="btn btn-info btn-block" style="font-size:20px;" role="button"> Redeem </a> </div>
              <?php
            }
            ?>
            <div class="col-sm-12 select-section"> <a href="invoice.php?product_other=2&&invoice_id=<?php echo $_GET['invoice_id']; ?>" class="btn btn-info btn-block" style="font-size:20px;" role="button"> Other </a> </div>
            <?php
          }
          ?>
        </div>

      </div>
    </div>
  </div>




  <!-- content container ends -->
</body>
</html>
<script>
  var voucher_list;
  var min_e_payment=0;
  var simpleTest = '<?php echo $invoice_total; ?>';
  var invoice_payment_var=0;
  var sub_text=0;
  $.ajax({
      url :"view_voucher_detail.php",
      cache:false,
      success:function(data){
       voucher_list = JSON.parse(data);
	   var voucher_number_ar=arrayColumn(voucher_list, 'voucher_number');
	   var voucher_value_ar=arrayColumn(voucher_list, 'voucher_value');
	   console.log(voucher_number_ar);
	   $("#cash_voucher_number").on('input', function(){
		   console.log($(this).val());
		   if(voucher_number_ar.indexOf($(this).val())>=0)
		   {

			   var subtext=$('#invoice_total').val()-voucher_value_ar[voucher_number_ar.indexOf($(this).val())];
			   sub_text=subtext;
			   console.log(subtext);
			   if(subtext>0)
			   {
					$('#invoice_payment').val(subtext);
			   }else{
				   $('#invoice_payment').val(0);
			   }
			   $('#voucher_number_error').text("Voucher Number is Valid (Voucher Value="+voucher_value_ar[voucher_number_ar.indexOf($(this).val())]+")");
			    $("#applyvoucher").css({"display": "initial"});
		   }
		   else{
			   $('#voucher_number_error').text("Voucher Number is Not Valid");
			   if(parseInt($("#invoice_payment").val())==parseInt($('#invoice_total').val()) || parseInt($("#invoice_payment").val())>parseInt($('#invoice_total').val()))
					{
						$("#cash_btn").attr("disabled", false);
						   console.log("sqa");
					}else{
						$("#cash_btn").attr("disabled", true);
						   console.log("sqb");
					}
		   }
		   });
		 $('#invoice_payment').on('input', function(){
			 //console.log("ssdffdffdfdf");
			 if($('#cash_voucher_number').val()=="")
			   {
				   if(parseInt($(this).val())==parseInt($('#invoice_total').val()) || parseInt($(this).val())>parseInt($('#invoice_total').val()))
					{
						$("#cash_btn").attr("disabled", false);
						   console.log("sqa");
					}else{
						$("#cash_btn").attr("disabled", true);
						   console.log("sqb");
					}
			   }else{
				   if(parseInt($(this).val())==parseInt(sub_text) || parseInt($(this).val())>parseInt(sub_text))
					{
						$("#cash_btn").attr("disabled", false);
						   console.log("sqa2");
					}else{
						$("#cash_btn").attr("disabled", true);
						   console.log("sqb2");
					}
			   }
		 });
		$("#cash_voucher_number2").on('input', function(){
		   console.log($(this).val());
		   if(voucher_number_ar.indexOf($(this).val())>=0)
		   {
			   invoice_payment_var=$('#invoice_payment2').val();
			   voucher_value=voucher_value_ar[voucher_number_ar.indexOf($(this).val())];
			   var subtext=$('#invoice_total2').val()-voucher_value_ar[voucher_number_ar.indexOf($(this).val())];
			   sub_text=subtext;
			   console.log(subtext);
			   if(subtext>0)
			   {
					$('#creditpaymentamount').val(subtext);
					$('#invoice_payment2').val(0);
			   }else{
				   $('#creditpaymentamount').val(0);
				   $('#invoice_payment2').val(0);
			   }
			   $("#credit_btn").attr("disabled", false);
			   $('#voucher_number_error2').text("Voucher Number is Valid (Voucher Value="+voucher_value_ar[voucher_number_ar.indexOf($(this).val())]+")");
			    $("#applyvoucher").css({"display": "initial"});
		   }
		   else{
			   $('#voucher_number_error2').text("Voucher Number is Not Valid");
			   if((parseInt($('#creditpaymentamount').val())+parseInt($("#invoice_payment2").val()))==parseInt($('#invoice_total2').val()) || (parseInt($('#creditpaymentamount').val())+parseInt($("#invoice_payment2").val()))>parseInt($('#invoice_total2').val()))
					{
						$("#credit_btn").attr("disabled", false);
						   console.log("sqa");
					}else{
						$("#credit_btn").attr("disabled", true);
						   console.log("sqb");
					}
		   }
		   });
		   $('#creditpaymentamount').on('input',function(){

			   if($('#cash_voucher_number2').val()!="")
			   {
				   var cash_remind=parseInt(voucher_value)-parseInt($(this).val());
				   //console.log((parseInt(cash_remind)+parseInt($(this).val())+parseInt(sub_text)));
				   if((parseInt($(this).val())+parseInt(voucher_value))==parseInt($('#invoice_total2').val()) || (parseInt($(this).val())+parseInt(voucher_value))>parseInt($('#invoice_total2').val()))
					{
						var cash_remind=parseInt(sub_text)-$(this).val();
						if(cash_remind>0)
						{
							$('#invoice_payment2').val(cash_remind);
						}else{
							$('#invoice_payment2').val(0);
						}
						//$("#credit_btn").attr("disabled", false);
						 //  console.log("sqa");
					}else{
						var cash_remind=parseInt(sub_text)-$(this).val();
						if(cash_remind>0)
						{
							$('#invoice_payment2').val(cash_remind);
						}else{
							$('#invoice_payment2').val(0);
						}
						//$("#credit_btn").attr("disabled", true);
						 //  console.log(cash_remind+" "+$(this).val());
					}
			   }else{
				   var cash_remind=$('#invoice_total2').val()-$(this).val();
			   if(cash_remind>0)
			   {
					$('#invoice_payment2').val(cash_remind);
			   }else{
				   $('#invoice_payment2').val(0);

			   }
				   if((parseInt(cash_remind)+parseInt($(this).val()))==parseInt($('#invoice_total2').val()) || (parseInt(cash_remind)+parseInt($(this).val()))>parseInt($('#invoice_total2').val()))
					{
						$("#credit_btn").attr("disabled", false);
						   console.log("sqa");
					}else{
						$("#credit_btn").attr("disabled", true);
						   console.log(cash_remind+$(this).val());
					}
			   }
			   //console.log("cash remind "+cash_remind);


		   });
		   $('#invoice_payment2').on('input',function(){
			   if($('#cash_voucher_number2').val()=="")
			   {
				   if((parseInt($('#creditpaymentamount').val())+parseInt($(this).val()))==parseInt($('#invoice_total2').val()) || (parseInt($('#creditpaymentamount').val())+parseInt($(this).val()))>parseInt($('#invoice_total2').val()))
					{
						$("#credit_btn").attr("disabled", false);
						   console.log("sqa");
					}else{
						$("#credit_btn").attr("disabled", true);
						   console.log("sqb");
					}
			   }else{
				   if((parseInt($(this).val())+parseInt($("#creditpaymentamount").val()))==parseInt(sub_text) || (parseInt($(this).val())+parseInt($("#creditpaymentamount").val()))>parseInt(sub_text))
					{
						$("#credit_btn").attr("disabled", false);
						   console.log("sqa2");
					}else{
						$("#credit_btn").attr("disabled", true);
						   console.log("sqb2");
					}
			   }

		   });
		$("#cash_voucher_number1").on('input', function(){
		   console.log($(this).val());
		   if(voucher_number_ar.indexOf($(this).val())>=0)
		   {
			   min_e_payment=$('#invoice_total1').val()-voucher_value_ar[voucher_number_ar.indexOf($(this).val())];
			   $('#voucher_number_error1').text("Voucher Number is Valid"+"( Voucher Value="+voucher_value_ar[voucher_number_ar.indexOf($(this).val())]+")");
			    $("#applyvoucher").css({"display": "initial"});
				if(min_e_payment>0)
			   {
					$('#epaymentamount').val(min_e_payment);
			   }else{
				   $('#epaymentamount').val(0);
			   }
				if($("#epaymentamount").val()>=min_e_payment )
				   {
					   $('#epayment_btn').attr("disabled", false);
					   console.log("valid amount1");
            //  console.log('Shohan');
            //  console.log(min_e_payment)
					 $('#pay_error1').text("Valid");
				   }else {
					   $('#epayment_btn').attr("disabled", true);
					   console.log("Invalid amount1");
					  $('#pay_error1').text("Invalid Ammount");
				   }
		   }
		   else{
			   $('#voucher_number_error1').text("Voucher Number is Not Valid");
			   var aa=$('#invoice_total1').val();
			   //console.log(aa+" "$("#epaymentamount").val()==aa);
			   if(parseInt($("#epaymentamount").val())== parseInt(aa) || parseInt($("#epaymentamount").val())>parseInt(aa) )
				   {
					   $('#epayment_btn').attr("disabled", false);
					   console.log("valid amount2");
					   $('#pay_error1').text("Valid Ammount");
				   }else {
					   $('#epayment_btn').attr("disabled", true);
					   console.log("Invalid amount2");
					    $('#pay_error1').text("Invalid Ammount");
				   }
		   }
		   });
		   $('#epaymentamount').on('input',function(){
			   if($('#cash_voucher_number1').val()!="")
			   {
           // invoice_total
				   if($(this).val()>=min_e_payment)
				   {
					   $('#epayment_btn').attr("disabled", false);
             //console.log(min_e_payment);
					   console.log("valid amount1");
					 $('#pay_error1').text("Valid");
				   }else {
					   $('#epayment_btn').attr("disabled", true);
					   console.log("Invalid amount1");
					  $('#pay_error1').text("Invalid Ammount");
				   }
			   }else{
				   var aa=$('#invoice_total1').val();
				   console.log($('#invoice_total1').val());
				   if($(this).val()==aa || $(this).val()>aa )
				   {
					   $('#epayment_btn').attr("disabled", false);
					   console.log("valid amount2");
					   $('#pay_error1').text("Valid Ammount");
				   }else {
					   $('#epayment_btn').attr("disabled", true);
					   console.log("Invalid amount2");
					    $('#pay_error1').text("Invalid Ammount");
				   }
			   }
		   });
     }
   });
   function arrayColumn(array, columnName) {
		return array.map(function(value,index) {
			return value[columnName];
		});
	}

  </script>
