<?php
require_once './../util/initialize.php';
require_once 'common/pos_header.php';
$user = User::find_by_id($_SESSION["user"]["id"]);
?>
<style media="screen">
.b1{
  font-weight: 700;
}
</style>
<body>
  <!-- content container starts -->

  <?php
  $branch = Branch::find_by_id($user->branch_id);
  ?>


  <div class="container-fluid">
    <div class="row">

      <div class="col-sm-12">
        <div class="col-sm-12" style="margin-top:20px;">

          <?php Functions::output_result(); ?>

          <!-- invoice type selector -->

          <?php

          
          $cat_object = ServiceCategory::find_all();
          $pro_object = ProductCategory::find_all();
          $pay_object = EpaymentOperator::find_all();
          $category_count = count($cat_object) + count($pro_object);
          $pay_count = count($pay_object);
		  for($i = 0;$i < 16+$pay_count; $i++){
            $lastrow[$i] = 0;
          }

          // echo $category_count;
          ?>

<table class="table table-bordered" style="font-size:11px;">
						<thead>
							<tr>
								<th rowspan='2'>Invoice Number</th>
								<?php
								foreach ($cat_object as $cat_data) {
									echo "<th rowspan='2' style='text-align:right;'>".$cat_data->name."</th>";
								}
								?>
								<th rowspan='2' style='text-align:right;'>Affinity</th>
								<th rowspan='2' style='text-align:right;'>Others</th>
								<th rowspan='2'  style='text-align:right;'>Transaction ID</th>
								<th  rowspan="2" style='text-align:right;'> CASH </th>
								<th style="text-align:center;" colspan="<?php echo $pay_count; ?>"> E-PAYMENT OPERATOR </th>
								<th style="text-align:center;" colspan="2">CARD</th>
								<th style="text-align:center;" rowspan="2">VOUCHER</th>


								<th style="text-align:center;" rowspan="2" > SUB TOTAL </th>
							</tr>
							<tr>
								<?php
								foreach($pay_object as $obj_data){
									echo "<th>".$obj_data->name."</th>";
								}
								?>





								<th style="text-align:center;">CARD</th>
								<th style="text-align:center;">CARD TYPE</th>





							</tr>
						</thead>
						<tbody>
							<?php
							$today = date("Y-m-d");
							$today_invoices = Invoice::invoice_by_date_branch($today,$branch->id);
							$invoice_total = 0;

							foreach($today_invoices as $invoice_data){
								$position = 0;
								$col = 0;
								$line_total = 0;
								if($invoice_data->invoice_total>0){
									echo "<tr>";
									echo "<td>".$invoice_data->invoice_number."</td>";
									foreach ($cat_object as $cat_data) {

										$cat_data_total = 0;
										foreach(InvoiceSub::find_all_invoice_id_category($invoice_data->id, $cat_data->name) as $invSubData){
											$cat_data_total = $cat_data_total + $invSubData->sub_total;
										}
										$invoice_total = $invoice_total + $cat_data_total;
										$line_total = $line_total + $cat_data_total;

										$lastrow[$position] = $lastrow[$position] + $cat_data_total;
										$position++;
										echo "<td style='text-align:right;'>".number_format($cat_data_total,2)."</td>";
									}
									$pro_data_total_afinity = 0;
									$pro_data_total_other = 0;
									foreach ($pro_object as $pro_data) {
										$pro_data_total = 0;
										foreach(InvoiceSub::find_all_invoice_id_category($invoice_data->id, $pro_data->id) as $invSubData2){
											$pro_data_total = $pro_data_total + $invSubData2->sub_total;
										}
										$invoice_total = $invoice_total + $pro_data_total;
										$line_total = $line_total + $pro_data_total;
										if($pro_data->id == 6){
											$pro_data_total_afinity = $pro_data_total_afinity + $pro_data_total;
										}else{
											$pro_data_total_other = $pro_data_total_other + $pro_data_total;
										}

									}
									$lastrow[$position] = $lastrow[$position] + $pro_data_total_afinity;
									$position++;
									echo "<td style='text-align:right;'>".number_format($pro_data_total_afinity,2)."</td>";
									$lastrow[$position] = $lastrow[$position] + $pro_data_total_other;
									$position++;
									echo "<td style='text-align:right;'>".number_format($pro_data_total_other,2)."</td>";
									if($invoice_data->invoice_transaction_id!=null)
									{

										$position++;
										echo "<td style='text-align:right;'>".$invoice_data->invoice_transaction_id."</td>";
									}else{
										$position++;
										echo "<td style='text-align:right;'>-</td>";
									}
                // cash payment
									if($invoice_data->invoice_payment_type == 1){
										echo "<td style='text-align:right;'> ".number_format($invoice_data->invoice_payment,2)." </td>";
										$lastrow[$position] = $lastrow[$position] + $invoice_data->invoice_payment;
										$position++;
									}else if($invoice_data->invoice_payment_type == 3)
									{
										echo "<td style='text-align:right;'> ".number_format($invoice_data->invoice_payment,2)." </td>";
										$lastrow[$position] = $lastrow[$position] + $invoice_data->invoice_payment;
										$position++;
									}
									else{

										echo "<td style='text-align:right;'> - </td>";

										$position++;

									}
                // end of cash payment

                // epayment
									if($invoice_data->invoice_payment_type == 2){

										foreach($pay_object as $obj_data){
											if($invoice_data->epayment_operator == $obj_data->id){
												echo "<td style='text-align:right;'> ".number_format($invoice_data->invoice_payment,2)." </td>";
												$lastrow[$position] = $lastrow[$position] + $invoice_data->invoice_payment;
												$position++;
											}else{
												echo "<td style='text-align:right;'> - </td>";
												$position++;
											}
										}

									}else{
										foreach($pay_object as $obj_data){
											echo "<td style='text-align:right;'> - </td>";
											$position++;
										}

									}
                // end of epayment


                // card payment
									if($invoice_data->invoice_payment_type == 3){
										if($invoice_data->card_type == "VISA"){

											echo "<td style='text-align:right;'> ".number_format(($invoice_data->invoice_cash_paymnet),2)." </td>";
											$lastrow[$position] = $lastrow[$position] + $invoice_data->invoice_cash_paymnet;
											$position++;


											echo "<td style='text-align:right;'>VISA</td>";
											$position++;
										}
										else if($invoice_data->card_type == "MASTER"){

											echo "<td style='text-align:right;'> ".number_format(($invoice_data->invoice_cash_paymnet),2)." </td>";
											$lastrow[$position] = $lastrow[$position] + $invoice_data->invoice_cash_paymnet;
											$position++;
											echo "<td style='text-align:right;'>MASTER</td>";
											$position++;
										}else{

											echo "<td style='text-align:right;'> - </td>";
											echo "<td style='text-align:right;'> - </td>";

											$position++;
											$position++;
										}




									}else{

										echo "<td style='text-align:right;'> - </td>";
										echo "<td style='text-align:right;'> - </td>";



										$position++;
										$position++;
									}
                // end of card payment
									if($invoice_data->invoice_voucher != NULL){
										$voucher = Voucher::find_by_voucher_number($invoice_data->invoice_voucher);
										if(!empty($voucher)){
											echo "<td style='text-align:right;'> ".number_format($voucher->voucher_value,2)." </td>";
											$lastrow[$position] = $lastrow[$position] + $voucher->voucher_value;
											$position++;

										}else{
											echo "<td style='text-align:right;'> - </td>";
											$position++;
										}
									}else{
										echo "<td style='text-align:right;'> - </td>";
										$position++;
									}

									echo "<td style='text-align:right;'>".number_format($line_total,2)."</td>";
									$lastrow[$position] = $lastrow[$position] + $line_total;
									$position++;

									echo "</tr>";
								}

							}

							echo "<tr style='font-size:11px;background-color:teal;color:white;'>";
							echo "<td style='text-align:right;'></td>";
							for($i = 0;$i < 16+$pay_count; $i++){
								echo "<td style='text-align:right;'>".number_format($lastrow[$i],2)."</td>";
							}
							echo "</tr>";


							?>
						</tbody>
					</table>

          <?php
          // print_r($report_array);
          ?>
          <!-- end of invoice type selector -->
        </div>
      </div>

    </div>
  </div>

</form>
<!-- content container ends -->
</body>
<script>
  window.print();
</script>
</html>
