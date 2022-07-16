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
	<div class="container-fluid">
		<div class="row" id='info-bar'>
			<div class="col-sm-8">

				<table class="table table-bordered">
					<tbody>
						<tr>
							<td colspan=2 >LOGGEDIN USER: <?php echo $user->name; ?> || Branch Name: <?php
							//$branch = Branch::find_by_id($user->branch_id);
							//echo $branch->name;
							?> || Code: <?php
							//$branch = Branch::find_by_id($user->branch_id);
							//echo $branch->code;
							?></td>
						</tr>
					</tbody>
				</table>

			</div>

			<?php require_once 'common/mini_header.php'; ?>

		</div>
	</div>

	<div class="container-fluid">
		<div class="row">

			<div class="col-sm-12">
				<div class="col-sm-12">

					<?php Functions::output_result(); ?>

					<!-- invoice type selector -->
					
					<div class="col-sm-12" style="margin-bottom:20px;">
						<!-- <a href="daily_summary_2.php" class="btn btn-primary" target="_blank"> <i class="fa fa-print"></i> PRINT</a>
						<a href="daily_summary.php?type=1" class="btn btn-primary"> <i class="fa fa-send"></i> E-MAIL</a> -->
						<form class="form-inline" method="post" action="daily_summary.php">
						<div class="form-group">
							<label for="from_date">From Date:</label><br/>
							<input type="date" class="form-control" name="from_date" required>
						</div>
						<div class="form-group">
							<label for="to_date">To Date:</label><br/>
							<input type="date" class="form-control" name="to_date" required>
						</div>
							<div class="form-group col-md-2">
								<label for="from_date">Branch:</label><br/>
								<select class="form-control selectpicker"  data-live-search="true" name="branch_id" required>
								<?php
									echo "<option>SELECT</option>";
									foreach(Branch::find_all() as $branch_data){
										echo "<option value='".$branch_data->id."'>".$branch_data->name."</option>";
									}
								?>
								</select>
							</div>
							<div class="form-group">
								<br/>
								<button type="submit" class="btn btn-primary">FIND</button>
							</div> 	
						</form>
					</div>
					<?php 
					if(isset($_POST['from_date']) && isset($_POST['to_date']))
					{
						
						$branch = branch::find_by_id($_POST['branch_id']);
						echo 'Branch: '.$branch->name;

						$report_desc = "(".$_POST['from_date']." to ".$_POST['to_date'].")"; 
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Invoice Report '.$report_desc;
					}
					?>
					<?php
					
					
								// print_r($_POST['branch_id']);
								// die;
					$cat_object = ServiceCategory::find_all();
					$pro_object = ProductCategory::find_all();
					$pay_object = EpaymentOperator::find_all();
					$category_count = count($cat_object) + count($pro_object);
					$pay_count = count($pay_object);
					for($i = 0;$i < 16+$pay_count; $i++){
						$lastrow[$i] = 0;
					}
					$message='<table class="table table-bordered" style="font-size:11px;">
					<thead>
					<tr>
					<th rowspan="2">Invoice Number</th>
					<th rowspan="2">Customer Name</th>';
					foreach ($cat_object as $cat_data) {
						$message .= "<th rowspan='2' style='text-align:right;'>".$cat_data->name."</th>";
					}
					$message.='<th rowspan="2" style="text-align:right;">Affinity</th>
					<th rowspan="2" style="text-align:right;">Others</th>
					<th rowspan="2"  style="text-align:right;">Transaction ID</th>
					<th  rowspan="2" style="text-align:right;"> CASH </th>
					<th style="text-align:center;" colspan="'.$pay_count.'?>"> E-PAYMENT OPERATOR </th>
					<th style="text-align:center;" colspan="2">CARD</th>
					<th style="text-align:center;" rowspan="2">VOUCHER</th>
					<th style="text-align:center;" rowspan="2" > SUB TOTAL </th>
					</tr>
					<tr>';
					foreach($pay_object as $obj_data){
						$message .= "<th>".$obj_data->name."</th>";
					}
					$message .='<th style="text-align:center;">CARD</th>
					<th style="text-align:center;">CARD TYPE</th>
					</tr>
					</thead>';
					$message.='<tbody>';
					$today = date("Y-m-d");
					if(isset($_POST['branch_id'])){
						$branch_id = $_POST['branch_id'];
						$from_date = $_POST['from_date'];
						$to_date = $_POST['to_date'];
						
					}else{
						$branch_id = 0;
						$from_date = date("Y-m-d");
						$to_date = date("Y-m-d");
					}
				
					$today_invoices = Invoice::invoice_by_date_branch($from_date,$to_date,$branch_id);
					// echo '<pre>';
					// print_r($today_invoices);
					// die;
					$invoice_total = 0;
					foreach($today_invoices as $invoice_data){
						// echo '<pre>';
						// print_r($invoice_data);
						// die;
						
						$position = 0;
						$col = 0;
						$line_total = 0;
						$customer_id = $invoice_data->customer_id;
						$username = Customer::find_by_custname($customer_id);
						if($invoice_data->invoice_status==1){
							$message.= "<tr>";
							$message.="<td>".$invoice_data->invoice_number."</td>";
							$message.="<td>$username->full_name</td>";
							foreach ($cat_object as $cat_data) {

								$cat_data_total = 0;
								foreach(InvoiceSub::find_all_invoice_id_category($invoice_data->id, $cat_data->name) as $invSubData){
									$cat_data_total = $cat_data_total + $invSubData->sub_total;
								}
								$invoice_total = $invoice_total + $cat_data_total;
								$line_total = $line_total + $cat_data_total;

								$lastrow[$position] = $lastrow[$position] + $cat_data_total;
								$position++;
								$message .= "<td style='text-align:right;'>".number_format($cat_data_total,2)."</td>";
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
							$message .= "<td style='text-align:right;'>".number_format($pro_data_total_afinity,2)."</td>";
							$lastrow[$position] = $lastrow[$position] + $pro_data_total_other;
							$position++;
							$message .= "<td style='text-align:right;'>".number_format($pro_data_total_other,2)."</td>";
							if($invoice_data->invoice_transaction_id!=null)
							{

								$position++;
								$message .= "<td style='text-align:right;'>".$invoice_data->invoice_transaction_id."</td>";
							}else{
								$position++;
								$message .= "<td style='text-align:right;'>-</td>";
							}
							if($invoice_data->invoice_payment_type == 1){
								$message .= "<td style='text-align:right;'> ".number_format($invoice_data->invoice_payment,2)." </td>";
								$lastrow[$position] = $lastrow[$position] + $invoice_data->invoice_payment;
								$position++;
							}else if($invoice_data->invoice_payment_type == 3)
							{
								$message .= "<td style='text-align:right;'> ".number_format($invoice_data->invoice_payment,2)." </td>";
								$lastrow[$position] = $lastrow[$position] + $invoice_data->invoice_payment;
								$position++;
							}
							else{
								$message .= "<td style='text-align:right;'> - </td>";
								$position++;
							}
							if($invoice_data->invoice_payment_type == 2){

								foreach($pay_object as $obj_data){
									if($invoice_data->epayment_operator == $obj_data->id){
										$message .= "<td style='text-align:right;'> ".number_format($invoice_data->invoice_payment,2)." </td>";
										$lastrow[$position] = $lastrow[$position] + $invoice_data->invoice_payment;
										$position++;
									}else{
										$message .= "<td style='text-align:right;'> - </td>";
										$position++;
									}
								}

							}else{
								foreach($pay_object as $obj_data){
									$message .= "<td style='text-align:right;'> - </td>";
									$position++;
								}

							}
							if($invoice_data->invoice_payment_type == 3){
								if($invoice_data->card_type == "VISA"){

									$message .= "<td style='text-align:right;'> ".number_format(($invoice_data->invoice_cash_paymnet),2)." </td>";
									$lastrow[$position] = $lastrow[$position] + $invoice_data->invoice_cash_paymnet;
									$position++;


									$message .= "<td style='text-align:right;'>VISA</td>";
									$position++;
								}
								else if($invoice_data->card_type == "MASTER"){

									$message .= "<td style='text-align:right;'> ".number_format(($invoice_data->invoice_cash_paymnet),2)."</td>";
									$lastrow[$position] = $lastrow[$position] + $invoice_data->invoice_cash_paymnet;
									$position++;
									$message .= "<td style='text-align:right;'>MASTER</td>";
									$position++;
								}else if($invoice_data->card_type == "BANK"){

									$message .= "<td style='text-align:right;'> ".number_format(($invoice_data->invoice_cash_paymnet),2)."</td>";
									$lastrow[$position] = $lastrow[$position] + $invoice_data->invoice_cash_paymnet;
									$position++;
									$message .= "<td style='text-align:right;'>BANK</td>";
									$position++;
								}else{

									$message .= "<td style='text-align:right;'> - </td>";
									$message .= "<td style='text-align:right;'> - </td>";
									$position++;
									$position++;
								}
							}else{

								$message .= "<td style='text-align:right;'> - </td>";
								$message .= "<td style='text-align:right;'> - </td>";
								$position++;
								$position++;
							}
							if($invoice_data->invoice_voucher != NULL){
								$voucher = Voucher::find_by_voucher_number($invoice_data->invoice_voucher);
								// echo '<pre>';
								// print_r($voucher);
								if(!empty($voucher)){
									if($voucher->voucher_value_type == 0){
										$sym = '%';
										$total_voucherr = $line_total * $voucher->voucher_value/100;
									}else{
										$sym = '';
										$total_voucherr = $voucher->voucher_value;
									}
									$message .= "<td style='text-align:right;'> ".number_format($total_voucherr,2)."&nbsp;$sym</td>";

									$lastrow[$position] = $lastrow[$position] + $total_voucherr;
									$position++;

								}else{
									$message .= "<td style='text-align:right;'> - </td>";
									$position++;
								}
							}else{
								$message .= "<td style='text-align:right;'> - </td>";
								$position++;
							}
							$message .= "<td style='text-align:right;'>".number_format($line_total,2)."</td>";
							$lastrow[$position] = $lastrow[$position] + $line_total;
							$position++;
							$message .= "</tr>";
						}

					}
					$message .= "<tr style='font-size:11px;background-color:teal;color:white;'>";
					$message .= "<td style='text-align:right;'></td>";
					$message .= "<td style='text-align:right;'></td>";
					for($i = 0;$i < 16+$pay_count; $i++){
						$message .= "<td style='text-align:right;'>".number_format($lastrow[$i],2)."</td>";
					}
					$message .= "</tr>
					</tbody>
					</table>";
					echo $message;
					if(isset($_GET['type']))
					{
						$to = $_SESSION['user']['email'];
						$subject = "APT system Voucher";

						$headers = "From: webacreinfoway.it@gmail.com" . "\r\n";
						$headers .= "Reply-To: webacreinfoway.it@gmail.com" . "\r\n";
						$headers .= "CC: webacreinfoway.it@gmail.com" . "\r\n";
						$headers .= "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
						$mailSendingStatus = mail($to, $subject, $message, $headers);
						if($mailSendingStatus)
						{
							?>
							<script>
								window.onload=function()
								{
									alert("Email send Succesfully");
									window.location="index.php";
								}
							</script>
							<?php
						}
						else
						{
							?>
							<script>
								window.onload=function()
								{
									alert("Email Not Send");
									window.location="index.php";
								}
							</script>
							<?php  
						}
					}
          // echo $category_count;
					?>

					<!-- <table class="table table-bordered" style="font-size:11px;">
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
							for($i = 0;$i < 19; $i++){
								echo "<td style='text-align:right;'>".number_format($lastrow[$i],2)."</td>";
							}
							echo "</tr>";


							?>
						</tbody>
					</table> -->

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
</html>
