<?php
require_once './../util/initialize.php';
$voucher_number = $_REQUEST['voucher_number'];
// echo $voucher_number;
$invoice_payment = $_REQUEST['invoice_payment'];
$invoice_total = $_REQUEST['invoice_total'];
$voucher_data = Voucher::find_by_voucher_number($voucher_number);
if(!empty($voucher_data)){
  $voucher_value = $voucher_data->voucher_value;
}else{
  $voucher_value = 0;
}
echo "<b style='font-size:20px;color:green;'>Claming Voucher Value: ".number_format($voucher_value,2)."<b>";
?>
<input type="hidden" id='epay_voucher_total' name='voucher_total' value='<?php echo $voucher_value; ?>'>
<input type="hidden" id='epay_paid_total' name='paid_total' value='<?php echo $invoice_payment + $voucher_value; ?>'>
<input type="hidden" id='epay_invoice_total' name='invoice_total' value='<?php echo $invoice_total; ?>'>
