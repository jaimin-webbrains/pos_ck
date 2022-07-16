<?php
date_default_timezone_set("Asia/Singapore");

require_once './../../util/initialize.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);


if(isset($_POST['row_qty_ops'])){

  $invoice_id = $_POST['invoice_id'];

  $row_data = InvoiceSub::find_by_id($_POST['row_qty_ops']);
  $row_data->ops1_user = $_POST['ops1'];
  $row_data->ops2_user = $_POST['ops2'];
  //$row_data->color = $_POST['color'];
  //$color_code = $_POST['check_color_code'];
  // $check_color_code = Colour::capture_code($color_code);
  // if(count($check_color_code) > 0) {


  if(!isset($_POST['color'])){
    try{
      $row_data->save();
      Activity::log_action("Invoice Column Updated: ");
      Functions::redirect_to("../invoice.php?invoice_id=".$invoice_id);

    } catch (Exception $exc) {
      $_SESSION["error"] = "Error..! Failed to Invoice Register Invoice.";
      Functions::redirect_to("../invoice.php");
    }
  }
  // if there is a color set in this realm
  if(isset($_POST['color'])){
    $checkCodeExists = ColourTube::capture_code($_POST['color']);
    if(count($checkCodeExists) > 0){
      foreach($checkCodeExists as $row);
      $row_data->color =$row->code;
      if($_POST['percentage'] == '')
      {
        $_SESSION["error"] = "Error..! Please fill the percentage amount.";
        Functions::redirect_to("../invoice.php?invoice_id=".$invoice_id);
      }
      else{  $row_data->percentage = $_POST['percentage']; }

      if($_POST['color2']  == '') {
        $row_data->color2 = 0;
        $row_data->percentage2 = 0;
      }
      else{
        $checkCodeExists2 = ColourTube::capture_code($_POST['color2']);
        if(count($checkCodeExists2) > 0)
        {
          if($_POST['color'] == $_POST['color2'])
          {
            $_SESSION["error"] = "Error..! Same code For the first and second color code detected";
            Functions::redirect_to("../invoice.php?invoice_id=".$invoice_id);
          }
          else{
            foreach($checkCodeExists2 as $rows);
            $row_data->color2 =$rows->code;
            if($_POST['percentage2'] == '')
            {
              $_SESSION["error"] = "Error..! Percentage for the second entry must not be empty";
              Functions::redirect_to("../invoice.php?invoice_id=".$invoice_id);
            }
            else{ $row_data->percentage2 = $_POST['percentage2']; }
          }
        }
        else{
          $_SESSION["error"] = "Error..! Code for the second color does not exist.";
          Functions::redirect_to("../invoice.php?invoice_id=".$invoice_id);
        }
      }
      if($_POST['color3'] == '') {
        $row_data->color3 = 0;
        $row_data->percentage3 = 0;
      }
      else{
        $checkCodeExists3 = ColourTube::capture_code($_POST['color3']);
        if(count($checkCodeExists3) > 0)
        {
          if(($_POST['color'] == $_POST['color2']) || ($_POST['color'] == $_POST['color3']) || ($_POST['color2'] == $_POST['color3']))
          {
            $_SESSION["error"] = "Error..! Either two or three same colour code detected! Please try again!";
            Functions::redirect_to("../invoice.php?invoice_id=".$invoice_id);
          }
          else{
            if($_POST['percentage3'] == '')
            {
              $_SESSION["error"] = "Error..! Percentage for the Third entry must not be empty";
              Functions::redirect_to("../invoice.php?invoice_id=".$invoice_id);
            }
            else{
              foreach($checkCodeExists3 as $rowss);
              $row_data->color3 =$rowss->code;
              $row_data->percentage3 = $_POST['percentage3'];
            }
          }
        }

        else{
          $_SESSION["error"] = "Error..! Colour code does not exist for the Third Colour that you entered";
          Functions::redirect_to("../invoice.php?invoice_id=".$invoice_id);
        }
      }
      //////////////////////////////////

      try{
        $row_data->save();
        Activity::log_action("Invoice Column Updated: ");
        Functions::redirect_to("../invoice.php?invoice_id=".$invoice_id);

      } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to Invoice Register Invoice.";
        Functions::redirect_to("../invoice.php");
      }
    }
    else{
      $_SESSION["error"] = "Error..! Code does not exist in the database.";
      Functions::redirect_to("../invoice.php?invoice_id=".$invoice_id);
    }
  }
}



// finalize on cash
if(isset($_POST['cash_invoice_number'])){



  $queue_number = $_POST['queue_number'];
  $invoice_id = $_POST['cash_invoice_number'];
  $invoice_data = Invoice::find_by_id($invoice_id);
  $invoice_object = InvoiceSub::find_all_invoice_id($invoice_id);
  $branch_data = Branch::find_by_id($invoice_data->invoice_branch);

  $object = Invoice::find_by_invoice_number($_POST['invoice_number']);
  if(count($object) > 0 ){

    $_SESSION["error"] = "Error..! Failed Finalize! Invoice number already exists.";
    Functions::redirect_to("../invoice.php?invoice_id=".$invoice_id);
  }

  $status = 0;

  foreach ($invoice_object as $inv_datas) {
    if($inv_datas->ops1_user == NULL || $inv_datas->ops2_user == NULL){
      $status = 1;
    }
  }

  if($status == 1){
    $_SESSION["error"] = "Please Set All the ops1 and ops2 users.";
    Functions::redirect_to("../invoice.php?invoice_id=".$invoice_id);
  }else{

    // get the branch COG
    $cog = $branch_data->cog; //need to get it from the database
    $cog_dis = 100 - $cog;
    $cog_dis = $cog_dis/100;

    $commision1_cal_total = 0;
    $commision2_cal_total = 0;

    foreach($invoice_object as $invoice_sub_data){

      $save_id = $invoice_sub_data->id;
      $pos1_user = $invoice_sub_data->ops1_user;
      $pos2_user = $invoice_sub_data->ops2_user;




      if(isset($_POST[$pos1_user])){
        $row_update = InvoiceSub::find_by_id($invoice_sub_data->id);
        $row_update->ops1_user = $_POST[$pos1_user];
        $row_update->save();
      }

      if(isset($_POST[$pos2_user])){
        $row_update = InvoiceSub::find_by_id($invoice_sub_data->id);
        $row_update->ops2_user = $_POST[$pos2_user];
        $row_update->save();
      }

      if($invoice_sub_data->item_type == 3){
        $redeem = new Redeem();
        $redeem->customer_id = $invoice_data->customer_id;
        $redeem->package_id = $invoice_sub_data->item_id;
        $package_data = Package::find_by_id($invoice_sub_data->item_id);
        $redeem->qty = $package_data->qty;
        $redeem->balance = $package_data->qty;
        $redeem->invoice_id = $invoice_data->id;
        $redeem->save();
      }

      // calculate totals for commision implementation
      if($invoice_sub_data->item_type == 2 || $invoice_sub_data->item_type == 3 || $invoice_sub_data->item_type == 4 ){
        $commision1_cal_total = $commision1_cal_total + $invoice_sub_data->sub_total;
      }else{
        $commision2_cal_total = $commision2_cal_total + $invoice_sub_data->sub_total;
      }

      $month = date('m');

      //-------------------------FOR OPS1 USER------------------------------------------

      // for ops1 calculation
      $sub_total_a = 0;
      $past_ops1_total_a = 0;
      $past_ops2_total_a = 0;
      $past_ops1_ops2_total_a = 0;
      // get value for commision a
      foreach(InvoiceSub::find_by_invoice_id_date_ops1_a($month, $pos1_user) as $invoice_sub_data){
        $past_ops1_total_a = $past_ops1_total_a + $invoice_sub_data->ops1;
      }
      foreach(InvoiceSub::find_by_invoice_id_date_ops2_a($month, $pos1_user) as $invoice_sub_data){
        $past_ops2_total_a = $past_ops2_total_a + $invoice_sub_data->ops2;
      }
      // foreach(InvoiceSub::find_by_invoice_id_date_ops1_ops2_a($month, $invoice_sub_data->ops1_user) as $invoice_sub_data){
      //   $past_ops1_ops2_total_a = $past_ops1_ops2_total_a + $invoice_sub_data->ops1 + $invoice_sub_data->ops2;
      // }

      $sub_total_b = 0;
      $past_ops1_total_b = 0;
      $past_ops2_total_b = 0;
      $past_ops1_ops2_total_b = 0;

      $sub_total_b_spe = 0;
      $past_ops1_total_b_spe = 0;
      $past_ops2_total_b_spe = 0;
      $past_ops1_ops2_total_b_spe = 0;
      // get value for commision b
      foreach(InvoiceSub::find_by_invoice_id_date_ops1_b($month, $pos1_user) as $invoice_sub_data){
        if($invoice_sub_data->category == "1" ){
          $past_ops1_total_b_spe = $past_ops1_total_b_spe + $invoice_sub_data->ops1;
        }

        if($invoice_sub_data->category == "2" ){
          $past_ops1_total_b_spe = $past_ops1_total_b_spe + $invoice_sub_data->ops1;
        }

        $past_ops1_total_b = $past_ops1_total_b + $invoice_sub_data->ops1;
      }
      foreach(InvoiceSub::find_by_invoice_id_date_ops2_b($month, $pos1_user) as $invoice_sub_data){
        if($invoice_sub_data->category == "1" || $invoice_sub_data->category == "2" ){
          $past_ops2_total_b_spe = $past_ops2_total_b_spe + $invoice_sub_data->ops1;
        }
        $past_ops2_total_b = $past_ops2_total_b + $invoice_sub_data->ops2;
      }
      // foreach(InvoiceSub::find_by_invoice_id_date_ops1_ops2_b($month, $invoice_sub_data->ops1_user) as $invoice_sub_data){
      //   if($invoice_sub_data->category == "1" || $invoice_sub_data->category == "2" ){
      //     $past_ops1_ops2_total_b_spe = $past_ops1_ops2_total_b_spe + $invoice_sub_data->ops1;
      //   }
      //   $past_ops1_ops2_total_b = $past_ops1_ops2_total_b + $invoice_sub_data->ops1 + $invoice_sub_data->ops2;
      // }

      $sub_total_a = $past_ops1_total_a + $past_ops2_total_a + $past_ops1_ops2_total_a;
      $sub_total_b = $past_ops1_total_b + $past_ops2_total_b + $past_ops1_ops2_total_b;
      $sub_total_b_spe = $past_ops1_total_b_spe + $past_ops2_total_b_spe + $past_ops1_ops2_total_b_spe;

      $sub_total_b = $sub_total_b - $sub_total_b_spe;

      $final_commision_ops1_a= 0;
      // calculate commision ops1 calculation
      $sub_total_a = $sub_total_a * $cog_dis;
      if($sub_total_a <= 6000){
        $final_commision_ops1_a = $sub_total_a * 0.3;
      }else if($sub_total_a <= 12000){
        $final_commision_ops1_a = 1800 + (($sub_total_a - 6001) * 0.33);
      }else if($sub_total_a <= 18000){
        $final_commision_ops1_a = 1800 + 1980 + (($sub_total_a - 12001) * 0.36);
      }else if($sub_total_a <= 24000){
        $final_commision_ops1_a = 1800 + 1980 + 2160 + (($sub_total_a - 18001) * 0.39);
      }else if($sub_total_a <= 30000){
        $final_commision_ops1_a = 1800 + 1980 + 2160 + 2340 + (($sub_total_a - 24001) * 0.42);
      }else if($sub_total_a <= 36000){
        $final_commision_ops1_a = 1800 + 1980 + 2160 + 2340 + 2520 + (($sub_total_a - 30001) * 0.45);
      }else if($sub_total_a > 36000){
        $final_commision_ops1_a = 1800 + 1980 + 2160 + 2340 + 2520 + 2700 + (($sub_total_a - 36001) * 0.50);
      }
      // end of calculation commision ops1 calculation

      $final_commision_ops1_b = 0;
      // calculation commicion2
      // echo "<br/>".$sub_total_b_spe;
      if($sub_total_b_spe <= 2000 ){
        $final_commision_ops1_b = $sub_total_b_spe * 0.15;
      }else if($sub_total_b_spe <= 3000){
        $final_commision_ops1_b = 300 + (($sub_total_b_spe - 2001) * 0.20);
      }else if($sub_total_b_spe > 3000 ){
        $final_commision_ops1_b = 300 + 200 + (($sub_total_b_spe - 3001) * 0.25);
      }
      // end of calculation commision2

      $ops1_user_commision_a = 0;
      $ops1_user_commision_b = 0;

      $final_commision_ops1_a = $final_commision_ops1_a;
      $final_commision_ops1_b = $final_commision_ops1_b;

      $ops1_user_commision_a = $final_commision_ops1_a;
      $ops1_user_commision_b = $final_commision_ops1_b + ($sub_total_b * 0.1);

      $final_commision_ops1_a = $final_commision_ops1_a;
      $final_commision_ops1_b = $final_commision_ops1_b;

      //-------------------------------FOR OPS2 USER------------------------------------

      // for ops2 calculation
      $sub_total_a = 0;
      $past_ops1_total_a = 0;
      $past_ops2_total_a = 0;
      $past_ops1_ops2_total_a = 0;

      // get value for commision a
      foreach(InvoiceSub::find_by_invoice_id_date_ops1_a($month, $pos2_user) as $invoice_sub_data){
        $past_ops1_total_a = $past_ops1_total_a + $invoice_sub_data->ops1;
      }
      foreach(InvoiceSub::find_by_invoice_id_date_ops2_a($month, $pos2_user) as $invoice_sub_data){
        $past_ops2_total_a = $past_ops2_total_a + $invoice_sub_data->ops2;
      }

      $sub_total_b = 0;
      $past_ops1_total_b = 0;
      $past_ops2_total_b = 0;
      $past_ops1_ops2_total_b = 0;
      $sub_total_b_spe = 0;
      $past_ops1_total_b_spe = 0;
      $past_ops2_total_b_spe = 0;
      $past_ops1_ops2_total_b_spe = 0;

      // get value for commision b
      foreach(InvoiceSub::find_by_invoice_id_date_ops1_b($month, $pos1_user) as $invoice_sub_data){
        if($invoice_sub_data->category == "1"){
          $past_ops1_total_b_spe = $past_ops1_total_b_spe + $invoice_sub_data->ops1;
        }

        if($invoice_sub_data->category == "2"){
          $past_ops1_total_b_spe = $past_ops1_total_b_spe + $invoice_sub_data->ops1;
        }

        $past_ops1_total_b = $past_ops1_total_b + $invoice_sub_data->ops1;
      }

      foreach(InvoiceSub::find_by_invoice_id_date_ops2_b($month, $pos1_user) as $invoice_sub_data){
        if($invoice_sub_data->category == "1"){
          $past_ops2_total_b_spe = $past_ops2_total_b_spe + $invoice_sub_data->ops1;
        }

        if($invoice_sub_data->category == "2" ){
          $past_ops2_total_b_spe = $past_ops2_total_b_spe + $invoice_sub_data->ops1;
        }

        $past_ops2_total_b = $past_ops2_total_b + $invoice_sub_data->ops2;
      }

      $sub_total_a = $past_ops1_total_a + $past_ops2_total_a + $past_ops1_ops2_total_a;
      $sub_total_b = $past_ops1_total_b + $past_ops2_total_b + $past_ops1_ops2_total_b;
      $sub_total_b_spe = $past_ops1_total_b_spe + $past_ops2_total_b_spe + $past_ops1_ops2_total_b_spe;

      $sub_total_b = $sub_total_b - $sub_total_b_spe;

      // calculate commision ops1 calculation
      $final_commision_ops1_a= 0;
      $sub_total_a = $sub_total_a * $cog_dis;
      if($sub_total_a <= 6000){
        $final_commision_ops1_a = $sub_total_a * 0.3;
      }else if($sub_total_a <= 12000){
        $final_commision_ops1_a = 1800 + (($sub_total_a - 6001) * 0.33);
      }else if($sub_total_a <= 18000){
        $final_commision_ops1_a = 1800 + 1980 + (($sub_total_a - 12001) * 0.36);
      }else if($sub_total_a <= 24000){
        $final_commision_ops1_a = 1800 + 1980 + 2160 + (($sub_total_a - 18001) * 0.39);
      }else if($sub_total_a <= 30000){
        $final_commision_ops1_a = 1800 + 1980 + 2160 + 2340 + (($sub_total_a - 24001) * 0.42);
      }else if($sub_total_a <= 36000){
        $final_commision_ops1_a = 1800 + 1980 + 2160 + 2340 + 2520 + (($sub_total_a - 30001) * 0.45);
      }else if($sub_total_a > 36000){
        $final_commision_ops1_a = 1800 + 1980 + 2160 + 2340 + 2520 + 2700 + (($sub_total_a - 36001) * 0.50);
      }
      // end of calculation commision ops1 calculation

      $final_commision_ops1_b = 0;
      // calculation commicion2

      // if($sub_total_b_spe <= 2000 ){
      //   $final_commision_ops1_b = $sub_total_b_spe * 0.15;
      // }else if($sub_total_b_spe <= 3000){
      //   $final_commision_ops1_b = 300 + (($sub_total_b_spe - 2001) * 0.20);
      // }else if($sub_total_b_spe > 3000 ){
      //   $final_commision_ops1_b = 300 + 200 + (($sub_total_b_spe - 3001) * 0.25);
      // }
      $final_commision_ops1_b = $sub_total_b_spe * 0.15;
      // end of calculation commision2

      // end of ops1 calculation
      $ops2_user_commision_a = $final_commision_ops1_a;
      $ops2_user_commision_b = $final_commision_ops1_b + ($sub_total_b * 0.1);

      // store the calculated data
      $inv_sub_data = InvoiceSub::find_by_id($save_id);
      $inv_sub_data->ops1_commision_a = $ops1_user_commision_a;
      $inv_sub_data->ops1_commision_b = $ops1_user_commision_b;
      $inv_sub_data->ops2_commision_a = $ops2_user_commision_a;
      $inv_sub_data->ops2_commision_b = $ops2_user_commision_b;
      $inv_sub_data->save();

    }

    // ----------------------END OF LOOP----------------------------

    $invoice_data->invoice_status = 1;
    $invoice_data->invoice_discount = $_POST['invoice_discount'];
    $invoice_data->invoice_payment = $_POST['invoice_payment'];
    $invoice_data->invoice_payment_type = $_POST['invoice_type'];

    if( $invoice_data->invoice_payment_type == 2 ){
      $invoice_data->invoice_transaction_id = $_POST['invoice_transaction_id'];
      $invoice_data->epayment_operator = $_POST['e_operator'];
      $invoice_data->e_voucher = $_POST['voucher_number'];
    }

    if( $invoice_data->invoice_payment_type == 3 ){
      $invoice_data->invoice_transaction_id = $_POST['invoice_transaction_id'];
      $invoice_data->invoice_voucher = $_POST['voucher_number'];
      $invoice_data->invoice_cash_paymnet = $_POST['invoice_cash_paymnet'];
    }

    $invoice_total = 0;
    $invoice_dis = 100 - $_POST['invoice_discount'];
    $invoice_dis = $invoice_dis/100;
    $invoice_total = $_POST['invoice_total'] * $invoice_dis;


    $invoice_total = 0;
    foreach(InvoiceSub::find_all_invoice_id($invoice_data->id) as $subdata){

      if($subdata->item_type != 4){
        $invoice_total = $invoice_total + ($subdata->unit_price * $subdata->qty);
      }

    }

    $invoice_data->invoice_total = $invoice_total;


    $invoice_data->invoice_total = $invoice_total;

    $settings_obj = SystemSettings::find_by_id(1);

    $reward_point_direct = 0;
    $reward_point_refer = 0;
    $reward_point_direct = ($invoice_total * $settings_obj->direct_commision) / 100;
    $reward_point_refer = ($invoice_total * $settings_obj->refer_commision) / 100;

    // reward direct point process start
    $reward = new RewardPoint();
    $reward->customer_id = $invoice_data->customer_id;
    $reward->invoice_id = $invoice_data->id;
    $reward->reward_points = $reward_point_direct;
    $reward->save();
    // reward pont end


    // reward referal point process start
    if( $parent = Referral::find_master($invoice_data->customer_id) ){
      $parent = $parents->parent_customer;
      $reward = new RewardPoint();
      $reward->customer_id = $invoice_data->customer_id;
      $reward->invoice_id = $invoice_data->id;
      $reward->reward_points = $reward_point_refer;
      $reward->referal_id = $parent;
      $reward->save();
    }
    // reward pont end

    try{

      $invoice_data->queue_number = $queue_number;
      if($queue_number > 0){
        $qdata = Queue::find_by_id($queue_number);
        $qdata->status = 2;
        $qdata->save();
      }

      $invoice_data->invoice_number = $_POST['invoice_number'];
      if($_POST['voucher_number'] != NULL){
        $invoice_data->invoice_voucher = $_POST['voucher_number'];
      }

      if(isset($_POST['master_visa'])){
        if($_POST['master_visa'] != NULL){
          $invoice_data->card_type = $_POST['master_visa'];
        }
      }

      // echo $invoice_data->id;





      $invoice_data->save();
      $service_type="SELECT * from invoice_sub WHERE sub_total=(select max(sub_total) AS aa from invoice_sub WHERE invoice_id='$invoice_id' and item_type=2) AND invoice_id='$invoice_id' AND item_type=2";
      $service_query=mysqli_query($con,$service_type);
      $service_rows=mysqli_num_rows($service_query);
      $service_fetch=mysqli_fetch_array($service_query);
      $package_type="SELECT * from invoice_sub WHERE sub_total=(select max(sub_total) AS aa from invoice_sub WHERE invoice_id='$invoice_id' and item_type=3) AND invoice_id='$invoice_id' AND item_type=3";
      $package_query=mysqli_query($con,$package_type);
      $package_rows=mysqli_num_rows($package_query);
      $package_fetch=mysqli_fetch_array($package_query);
      $product_type="SELECT * from invoice_sub WHERE sub_total=(select max(sub_total) AS aa from invoice_sub WHERE invoice_id='$invoice_id' and item_type=1) AND invoice_id='$invoice_id' AND item_type=1";
      $product_query=mysqli_query($con,$product_type);
      $product_rows=mysqli_num_rows($product_query);
      $product_fetch=mysqli_fetch_array($product_query);
      $redeem_type="SELECT * from invoice_sub WHERE sub_total=(select max(sub_total) AS aa from invoice_sub WHERE invoice_id='$invoice_id' and item_type=1) AND invoice_id='$invoice_id' AND item_type=4";
      $redeem_query=mysqli_query($con,$product_type);
      $redeem_rows=mysqli_num_rows($product_query);
      $redeem_fetch=mysqli_fetch_array($product_query);

      if($service_rows>0)
      {

        $voucher_query=mysqli_query($con,"Select * from invoice JOIN voucher ON invoice.invoice_voucher=voucher.voucher_number where invoice.id='$invoice_id'");
        $voucher_fetch=mysqli_fetch_array($voucher_query);
        $code=$service_fetch['code'];
        $service_rate="select * from service where code='$code'";
        $service_rate_query=mysqli_query($con,$service_rate);
        $service_rate_fetch=mysqli_fetch_array($service_rate_query);
        $ops1=$service_rate_fetch['ops_1'];
        $ops2=$service_rate_fetch['ops_2'];
        $ops1_id=$service_fetch['ops1_user'];
        $ops2_id=$service_fetch['ops2_user'];
        // $ops1 = ($voucher_fetch['voucher_value'] * $ops1)/100;
        // $ops2 = ($voucher_fetch['voucher_value'] * $ops2)/100;
        if($voucher_fetch['voucher_value_type'] == 0){
          $invoice_total = $voucher_fetch['invoice_total'];
          $voucher_value = $voucher_fetch['voucher_value'];
          $final_voucher_value = ($invoice_total*$voucher_value)/100;
          $ops1 = ($final_voucher_value * $ops1)/100;
          $ops2 = ($final_voucher_value * $ops2)/100;
        }else{
          $ops1 = ($voucher_fetch['voucher_value'] * $ops1)/100;
          $ops2 = ($voucher_fetch['voucher_value'] * $ops2)/100;
        }
        if($ops1>0)
        {
          $insert_query=mysqli_query($con,"insert into user_voucher_commission (invoice_id,user_id,voucher_value) values ('$invoice_id','$ops1_id','$ops1')");
        }
        if($ops2>0)
        {
          $insert_query=mysqli_query($con,"insert into user_voucher_commission (invoice_id,user_id,voucher_value) values ('$invoice_id','$ops2_id','$ops2')");
        }


      }else if($package_rows>0)
      {
        $voucher_query=mysqli_query($con,"Select * from invoice JOIN voucher ON invoice.invoice_voucher=voucher.voucher_number where invoice.id='$invoice_id'");
        $voucher_fetch=mysqli_fetch_array($voucher_query);
        $code=$package_fetch['code'];
        $service_rate="select * from service where code='$code'";
        $service_rate_query=mysqli_query($con,$service_rate);
        $service_rate_fetch=mysqli_fetch_array($service_rate_query);
        $ops1=$service_rate_fetch['ops_1'];
        $ops2=$service_rate_fetch['ops_2'];
        $ops1_id=$package_fetch['ops1_user'];
        $ops2_id=$package_fetch['ops2_user'];
        // $ops1 = ($voucher_fetch['voucher_value'] * $ops1)/100;
        // $ops2 = ($voucher_fetch['voucher_value'] * $ops2)/100;
        if($voucher_fetch['voucher_value_type'] == 0){
          $invoice_total = $voucher_fetch['invoice_total'];
          $voucher_value = $voucher_fetch['voucher_value'];
          $final_voucher_value = ($invoice_total*$voucher_value)/100;
          $ops1 = ($final_voucher_value * $ops1)/100;
          $ops2 = ($final_voucher_value * $ops2)/100;
        }else{
          $ops1 = ($voucher_fetch['voucher_value'] * $ops1)/100;
          $ops2 = ($voucher_fetch['voucher_value'] * $ops2)/100;
        }
        if($ops1>0)
        {
          $insert_query=mysqli_query($con,"insert into user_voucher_commission (invoice_id,user_id,voucher_value) values ('$invoice_id','$ops1_id','$ops1')");
        }
        if($ops2>0)
        {
          $insert_query=mysqli_query($con,"insert into user_voucher_commission (invoice_id,user_id,voucher_value) values ('$invoice_id','$ops2_id','$ops2')");
        }
      }else if($product_rows>0)
      {
        $voucher_query=mysqli_query($con,"Select * from invoice JOIN voucher ON invoice.invoice_voucher=voucher.voucher_number where invoice.id='$invoice_id'");
        $voucher_fetch=mysqli_fetch_array($voucher_query);
        $code=$product_fetch['code'];
        $service_rate="select * from product where code='$code'";
        $service_rate_query=mysqli_query($con,$service_rate);
        $service_rate_fetch=mysqli_fetch_array($service_rate_query);
        $ops1=$service_rate_fetch['ops_1'];
        $ops2=$service_rate_fetch['ops_2'];
        $ops1_id=$product_fetch['ops1_user'];
        $ops2_id=$product_fetch['ops2_user'];
        // $ops1 = ($voucher_fetch['voucher_value'] * $ops1)/100;
        // $ops2 = ($voucher_fetch['voucher_value'] * $ops2)/100;
        if($voucher_fetch['voucher_value_type'] == 0){
          $invoice_total = $voucher_fetch['invoice_total'];
          $voucher_value = $voucher_fetch['voucher_value'];
          $final_voucher_value = ($invoice_total*$voucher_value)/100;
          $ops1 = ($final_voucher_value * $ops1)/100;
          $ops2 = ($final_voucher_value * $ops2)/100;
        }else{
          $ops1 = ($voucher_fetch['voucher_value'] * $ops1)/100;
          $ops2 = ($voucher_fetch['voucher_value'] * $ops2)/100;
        }
        if($ops1>0)
        {
          $insert_query=mysqli_query($con,"insert into user_voucher_commission (invoice_id,user_id,voucher_value) values ('$invoice_id','$ops1_id','$ops1')");
        }
        if($ops2>0)
        {
          $insert_query=mysqli_query($con,"insert into user_voucher_commission (invoice_id,user_id,voucher_value) values ('$invoice_id','$ops2_id','$ops2')");
        }

      }
      Activity::log_action("Invoice Successfully Saved: ");
      if(isset($_POST['voucher_number']))
      {
        $voucher_no=$_POST['voucher_number'];
        $update_voucher="Update voucher set voucher_status=1 where voucher_number='$voucher_no'";
        $query=mysqli_query($con,$update_voucher);
      }
      Functions::redirect_to("../invoice_continue.php?invoice_id=".$invoice_id);
    } catch (Exception $exc) {
      $_SESSION["error"] = "Error..! Failed to Invoice Register Invoice.";
      Functions::redirect_to("../index.php");
    }

    // echo "invoice_saved successfully";
  }
}

if(isset($_GET['customer_id'])){
  $user_details = User::find_by_id($_SESSION["user"]["id"]);
  $invoice = new Invoice();
  $invoice->customer_id = trim($_GET['customer_id']);
  $invoice->invoice_total = 0;
  $invoice->invoice_status = 0;
  $invoice->invoice_discount = 0;
  $invoice->invoice_payment = 0;
  $invoice->invoiced_by  = $user_details->id;
  $invoice->invoice_branch  = $user_details->branch_id;

  $invoice_number = 0;
  $next_invoice = Invoice::find_all_branch($user_details->branch_id);
  $invoice_number = count($next_invoice);
  ++$invoice_number;

  $invoice_number = $user_details->branch_id()->code.sprintf("%06d", $invoice_number);
  $invoice->invoice_number = $invoice_number;

  // allocate the queue
  // $queue_data = Queue::find_by_id($_GET['done']);
  // $queue_data->status = 2;

  try {
    $invoice->save();
    // $queue_data->save();
    $invoice_id = Invoice::last_insert_id();

    Activity::log_action("Invoice Registered: ");
    Functions::redirect_to("../invoice.php?invoice_id=".$invoice_id);
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to Invoice Register Invoice.";
    Functions::redirect_to("../invoice_type.php");
  }

}

if(isset($_POST['invoice_init'])){
  $user_details = User::find_by_id($_SESSION["user"]["id"]);
  $invoice = new Invoice();
  $invoice->customer_id = trim($_POST['customer_id']);
  $invoice->invoice_total = 0;
  $invoice->invoice_status = 0;
  $invoice->invoice_discount = 0;
  $invoice->invoice_payment = 0;
  $invoice->invoiced_by  = $user_details->id;
  $invoice->invoice_branch  = $user_details->branch_id;

  $invoice_number = 0;
  $next_invoice = Invoice::find_all_branch($user_details->branch_id);
  $invoice_number = count($next_invoice);
  ++$invoice_number;

  $invoice_number = $user_details->branch_id()->code.sprintf("%06d", $invoice_number);
  $invoice->invoice_number = $invoice_number;

  try {
    $invoice->save();
    $invoice_id = Invoice::last_insert_id();

    Activity::log_action("Invoice Registered: ");
    Functions::redirect_to("../invoice.php?invoice_id=".$invoice_id);
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to Invoice Register Invoice.";
    // echo $exc;
    Functions::redirect_to("../invoice_type.php");
  }

}


if(isset($_GET['product'])){
  $product_details = Product::find_by_id($_GET['product']);

  $check_object = InvoiceSub::find_all_invoice_id_product_name($_GET['invoice_id'], $product_details->name);

  if( count($check_object) > 0 ){
    $current_qty = $check_object->qty;
    $check_object->qty = $current_qty + 1;
    // $check_object->sub_total = $check_object->sub_total + $check_object->sub_total;
    $check_object->sub_total = $check_object->unit_price * ($current_qty + 1);

    $check_object->ops1 = $check_object->ops1 + $check_object->ops1;
    $check_object->ops2 = $check_object->ops2 + $check_object->ops2;

    try{
      $check_object->save();
      Activity::log_action("Item Added To The Grid");
      Functions::redirect_to("../invoice.php?invoice_id=".$_GET['invoice_id']);
    } catch (Exception $exc) {
      $_SESSION["error"] = "Error..! Failed to Invoice Register Invoice.";
      Functions::redirect_to("../invoice.php?invoice_id=".$_GET['invoice_id']);
    }


  }else{
    $invoice_sub = new InvoiceSub();
    $invoice_sub->invoice_id = $_GET['invoice_id'];
    $invoice_sub->s_no = $product_details->service_no;
    $invoice_sub->name = $product_details->name;
    $invoice_sub->category = $product_details->brand;
    $invoice_sub->code = $product_details->code;
    $invoice_sub->unit_price = $product_details->price;
    $invoice_sub->qty = 1;
    // (cklim) $invoice_sub->sub_total = ($invoice_sub->unit_price *1);
    $invoice_sub->sub_total = ($invoice_sub->unit_price + $invoice_sub->sub_total);
    $ops1 = $product_details->ops_1;
    $ops1 = ($invoice_sub->unit_price * $ops1)/100;
    $ops2 = $product_details->ops_2;
    $ops2 = ($invoice_sub->unit_price * $ops2)/100;
    $invoice_sub->ops1 = $ops1;
    $invoice_sub->ops2 = $ops2;
    $invoice_sub->item_type = 1;
    $invoice_sub->ref_id = $product_details->brand;

    try{
      $invoice_sub->save();
      Activity::log_action("Item Added To The Grid");
      Functions::redirect_to("../invoice.php?invoice_id=".$_GET['invoice_id']);
    } catch (Exception $exc) {
      $_SESSION["error"] = "Error..! Failed to Invoice Register Invoice.";
      Functions::redirect_to("../invoice.php?invoice_id=".$_GET['invoice_id']);
    }

  }

}

if(isset($_GET['service'])){
  $service_dat = Service::find_by_id($_GET['service']);

  $invoice_sub = new InvoiceSub();
  $invoice_sub->invoice_id = $_GET['invoice_id'];
  $invoice_sub->s_no = $service_dat->service_no;
  $invoice_sub->name = $service_dat->name;
  $invoice_sub->category = $service_dat->category()->name;
  $invoice_sub->code = $service_dat->code;
  $invoice_sub->unit_price = $service_dat->price;
  $invoice_sub->qty = 1;
  $invoice_sub->sub_total = ($invoice_sub->unit_price * 1);

  $ops1 = $service_dat->ops_1;
  $ops1 = ($invoice_sub->unit_price * $ops1)/100;
  $ops2 = $service_dat->ops_2;
  $ops2 = ($invoice_sub->unit_price * $ops2)/100;

  $invoice_sub->ops1 = $ops1;
  $invoice_sub->ops2 = $ops2;
  $invoice_sub->item_type = 2;
  $invoice_sub->ref_id = $service_dat->category;

  try{
    $invoice_sub->save();
    Activity::log_action("Item Added To The Grid");
    Functions::redirect_to("../invoice.php?invoice_id=".$_GET['invoice_id']);
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to Invoice Register Invoice.";
    Functions::redirect_to("../invoice.php?invoice_id=".$_GET['invoice_id']);
  }

}

if(isset($_GET['package'])){
  $service_dat = Package::find_by_id($_GET['package']);

  $invoice_sub = new InvoiceSub();
  $invoice_sub->invoice_id = $_GET['invoice_id'];
  $invoice_sub->s_no = $service_dat->service_no;
  $invoice_sub->name = $service_dat->name;
  $invoice_sub->category = $service_dat->category()->name;
  $invoice_sub->code = $service_dat->code;
  $invoice_sub->unit_price = $service_dat->package_price;
  $invoice_sub->qty = 1;
  $invoice_sub->sub_total = ($invoice_sub->unit_price * 1);

  $ops1 = $service_dat->ops_1;
  $ops1 = ($invoice_sub->unit_price * $ops1)/100;
  $ops2 = $service_dat->ops_2;
  $ops2 = ($invoice_sub->unit_price * $ops2)/100;

  $invoice_sub->ops1 = $ops1;
  $invoice_sub->ops2 = $ops2;
  $invoice_sub->item_type = 3;
  $invoice_sub->ref_id = $service_dat->category;
  $invoice_sub->item_id = $service_dat->id;

  try{

    $invoice_sub->save();
    Activity::log_action("Item Added To The Grid");
    Functions::redirect_to("../invoice.php?invoice_id=".$_GET['invoice_id']);
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to Invoice Register Invoice.";
    Functions::redirect_to("../invoice.php?invoice_id=".$_GET['invoice_id']);
  }

}


if(isset($_GET['redeem'])){
  $redeem_data = Redeem::find_by_id($_GET['redeem']);
  $service_dat = Package::find_by_id($redeem_data->package_id);

  // new amendment that get the OPS data from the service. not from the package
  $service_datss = Service::find_by_code($service_dat->code);

  $invoice_sub = new InvoiceSub();
  $invoice_sub->invoice_id = $_GET['invoice_id'];
  $invoice_sub->s_no = $service_dat->service_no;
  $invoice_sub->name = $service_dat->name;
  $invoice_sub->category = $service_dat->category()->name;
  $invoice_sub->code = $service_dat->code;

  $total_commision = $service_dat->ops_1 + $service_dat->ops_2;
  $subtotal = $service_dat->package_price;

  $cal = 0;
  $cal = 100 - $total_commision;
  $subtotal = $subtotal * ($cal / 100);

  $subtotal = $subtotal / $redeem_data->qty;

  $invoice_sub->unit_price = $subtotal;
  $invoice_sub->qty = 1;

  $invoice_sub->sub_total = 0;

  $ops1 = $service_datss->ops_1;
  $ops1 = ($subtotal * $ops1)/100;
  $ops2 = $service_datss->ops_2;
  $ops2 = ($subtotal * $ops2)/100;

  $invoice_sub->ops1 = $ops1;
  $invoice_sub->ops2 = $ops2;
  $invoice_sub->item_type = 4;
  $invoice_sub->ref_id = $service_dat->category;
  $invoice_sub->item_id = $service_dat->id;
  $invoice_sub->package_invoice_id = $redeem_data->invoice_id;

  $redeem_data->balance = $redeem_data->balance - 1;


  try{
    $redeem_data->save();
    $invoice_sub->save();
    Activity::log_action("Item Added To The Grid");
    Functions::redirect_to("../invoice.php?invoice_id=".$_GET['invoice_id']);
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to Invoice Register Invoice.";
    Functions::redirect_to("../invoice.php?invoice_id=".$_GET['invoice_id']);
  }
  // }

}




if(isset($_GET['invoice_row_delete'])){
  $invoice_row = InvoiceSub::find_by_id($_GET['invoice_row_delete']);



  try{

    if($invoice_row->item_type == 4){

      $invoice = Invoice::find_by_id($_GET['invoice_id']);

      $redeem_data = Redeem::find_by_customer_id_invoice_id_item_id($invoice->customer_id, $invoice_row->package_invoice_id, $invoice_row->item_id);
      $redeem_data->balance = $redeem_data->balance + 1;
      $redeem_data->save();
    }

    $invoice_row->delete();
    Activity::log_action("Successfully Deleted");
    Functions::redirect_to("../invoice.php?invoice_id=".$_GET['invoice_id']);
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to Invoice Register Invoice.";
    Functions::redirect_to("../invoice.php?invoice_id=".$_GET['invoice_id']);
  }

}
