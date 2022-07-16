<?php
require_once './../../util/initialize.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);


if(isset($_GET['inv_delete'])){
  $inv_del = Invoice::find_by_id($_GET['inv_delete']);
  try {
    if(empty($inv_del->epayment_operator)){
      $epayment_operator = 0;
    }else{
      $epayment_operator = $inv_del->epayment_operator;
    }
    $insert_sql = "INSERT INTO `deleted_invoices` (`invoice_id`, `invoice_date`, `customer_id`, `invoice_total`, `invoice_status`, `invoice_discount`, `invoice_branch`, `invoiced_by`, `invoice_payment`, `invoice_payment_type`, `invoice_transaction_id`, `invoice_voucher`, `invoice_cash_paymnet`, `invoice_number`, `sales_tax`, `service_tax`, `epayment_operator`, `e_voucher`, `invoice_process`, `queue_number`, `card_type`) VALUES ('$inv_del->id', '$inv_del->invoice_date', '$inv_del->customer_id', '$inv_del->invoice_total', '$inv_del->invoice_status', '$inv_del->invoice_discount', '$inv_del->invoice_branch', '$inv_del->invoiced_by', '$inv_del->invoice_payment', '$inv_del->invoice_payment_type', '$inv_del->invoice_transaction_id', '$inv_del->invoice_voucher', '$inv_del->invoice_cash_paymnet', '$inv_del->invoice_number', '$inv_del->sales_tax', '$inv_del->service_tax', '$epayment_operator', '$inv_del->e_voucher', '$inv_del->invoice_process', '$inv_del->queue_number', '$inv_del->card_type')";
    $insert_query=mysqli_query($con,$insert_sql);

    $inv_del->delete();
    Activity::log_action("Pending Invoice Deleted: ");
    $_SESSION["message"] = "Successfully Deleted.";
    Functions::redirect_to("../index.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to save.";
    Functions::redirect_to("../index.php");
  }
}
