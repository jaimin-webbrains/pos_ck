<?php
require_once './../../util/initialize.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);


if(isset($_GET['inv_delete'])){
  
  $inv_del = Invoice::find_by_id($_GET['inv_delete']);

  $inv_del_items = InvoiceSub::find_all_invoice_id($inv_del->id);
  // echo '<pre>';
  // print_r($inv_del_items);
  // die;
  try {
    if(empty($inv_del->epayment_operator)){
      $epayment_operator = 0;
    }else{
      $epayment_operator = $inv_del->epayment_operator;
    }
    $insert_sql = "INSERT INTO `deleted_invoices` (`invoice_id`, `invoice_date`, `customer_id`, `invoice_total`, `invoice_status`, `invoice_discount`, `invoice_branch`, `invoiced_by`, `invoice_payment`, `invoice_payment_type`, `invoice_transaction_id`, `invoice_voucher`, `invoice_cash_paymnet`, `invoice_number`, `sales_tax`, `service_tax`, `epayment_operator`, `e_voucher`, `invoice_process`, `queue_number`, `card_type`) VALUES ('$inv_del->id', '$inv_del->invoice_date', '$inv_del->customer_id', '$inv_del->invoice_total', '$inv_del->invoice_status', '$inv_del->invoice_discount', '$inv_del->invoice_branch', '$inv_del->invoiced_by', '$inv_del->invoice_payment', '$inv_del->invoice_payment_type', '$inv_del->invoice_transaction_id', '$inv_del->invoice_voucher', '$inv_del->invoice_cash_paymnet', '$inv_del->invoice_number', '$inv_del->sales_tax', '$inv_del->service_tax', '$epayment_operator', '$inv_del->e_voucher', '$inv_del->invoice_process', '$inv_del->queue_number', '$inv_del->card_type')";
    $insert_query=mysqli_query($con,$insert_sql);

      // echo '<pre>';
      // print_r($insert_query);
      // die;

    foreach($inv_del_items as $inv_del_item){
      // echo '<pre>';
      // print_r($inv_del_item);
      // die;
      if(empty($inv_del_item->percentage)){
        $percentage = 0;
      }else{
        $percentage = $inv_del_item->percentage;
      }
      if(empty($inv_del_item->percentage2)){
        $percentage2 = 0;
      }else{
        $percentage2 = $inv_del_item->percentage2;
      }
      if(empty($inv_del_item->percentage3)){
        $percentage3 = 0;
      }else{
        $percentage3 = $inv_del_item->percentage3;
      }
      if(empty($inv_del_item->percentage4)){
        $percentage4 = 0;
      }else{
        $percentage4 = $inv_del_item->percentage4;
      }
      if(empty($inv_del_item->percentage5)){
        $percentage5 = 0;
      }else{
        $percentage5 = $inv_del_item->percentage5;
      }
      if(empty($inv_del_item->item_id)){
        $item_id = 0;
      }else{
        $item_id = $inv_del_item->item_id;
      }
      if(empty($inv_del_item->package_invoice_id)){
        $package_invoice_id = 0;
      }else{
        $package_invoice_id = $inv_del_item->package_invoice_id;
      }

      mysqli_query($con,"INSERT INTO `deleted_invoices_items`(`invoice_id`,`s_no`,`name`,`category`,`code`,`unit_price`,`qty`,`sub_total`,`ops1`,`ops2`,`item_type`,`ops1_user`,`ops2_user`,`color`,`percentage`,`color2`,`percentage2`,`color3`,`percentage3`,`color4`,`percentage4`,`color5`,`percentage5`,`item_id`,`package_invoice_id`,`ref_id`,`ops1_commision_a`,`ops1_commision_b`,`ops2_commision_a`,`ops2_commision_b`) VALUES ('$inv_del_item->invoice_id','$inv_del_item->s_no','$inv_del_item->name','$inv_del_item->category','$inv_del_item->code','$inv_del_item->unit_price','$inv_del_item->qty','$inv_del_item->sub_total','$inv_del_item->ops1','$inv_del_item->ops2','$inv_del_item->item_type','$inv_del_item->ops1_user','$inv_del_item->ops2_user','$inv_del_item->color','$percentage','$inv_del_item->color2','$percentage2','$inv_del_item->color3','$percentage3','$inv_del_item->color4','$percentage4','$inv_del_item->color5','$percentage5','$item_id','$package_invoice_id','$inv_del_item->ref_id','$inv_del_item->ops1_commision_a','$inv_del_item->ops1_commision_b','$inv_del_item->ops2_commision_a','$inv_del_item->ops2_commision_b')");
    }
    $inv_del->delete();
    Activity::log_action("Pending Invoice Deleted: ");
    $_SESSION["message"] = "Successfully Deleted.";
    Functions::redirect_to("../index.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to save.";
    Functions::redirect_to("../index.php");
  }
}
