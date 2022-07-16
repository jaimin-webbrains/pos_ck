<?php
date_default_timezone_set("Asia/Singapore");

require_once './../../util/initialize.php';

if(isset($_GET['allocate'])){
  $queue_data = Queue::find_by_id($_GET['allocate']);
  $queue_data->status = 1;
  $queue_data->allocated_date_time = date("Y-m-d h:i:s");
  try{

    $queue_data->save();
    Activity::log_action("Queue Allocated : ");
    $_SESSION["message"] = "Successfully Allocated.";
    Functions::redirect_to("../queue.php");
  } catch (Exception $exc) {

    $_SESSION["error"] = "Error..! Failed to Allocate.";
    Functions::redirect_to("../queue.php");

  }

}

if(isset($_GET['done'])){
  $queue_data = Queue::find_by_id($_GET['done']);
  $queue_data->status = 2;
  try{

    $queue_data->save();
    Activity::log_action("Queue DONE : ");
    $_SESSION["message"] = "Successfully Allocated.";
    Functions::redirect_to("../queue.php");
  } catch (Exception $exc) {

    $_SESSION["error"] = "Error..! Failed to Allocate.";
    Functions::redirect_to("../queue.php");

  }

}

if(isset($_GET['discard'])){
  $queue_data = Queue::find_by_id($_GET['discard']);
  $queue_data->status = 3;
  try{

    $queue_data->save();
    Activity::log_action("Queue DONE : ");
    $_SESSION["message"] = "Successfully Allocated.";
    Functions::redirect_to("../queue.php");
  } catch (Exception $exc) {

    $_SESSION["error"] = "Error..! Failed to Allocate.";
    Functions::redirect_to("../queue.php");

  }

}


if (isset($_POST['save'])) {
  $queue = new Queue();
  $queue->customer_id = trim($_POST['customer_id']);
  $queue->queue_type = trim($_POST['queue_type']);
  $user = User::find_by_id($_SESSION["user"]["id"]);
  $queue->branch_id = $user->branch_id;
  $today_date = date("Y-m-d");

  $last_number = 0;
  if($queue->queue_type == "creative"){
    $last_number = 1000;
  }else if($queue->queue_type == "stylist"){
    $last_number = 3000;
  }

  if( $que_data = Queue::find_by_type_last($queue->queue_type, $today_date) ){
    $last_number = $que_data->queue_number + 1;
  }else if($queue->queue_type == "creative"){
    ++$last_number;
  }else if($queue->queue_type == "stylist"){
    ++$last_number;
  }

  $queue->queue_number = $last_number;

  try {
    $queue->save();
    $last_insert_id = Queue::last_insert_id();
    Activity::log_action("Queue - saved : ");
    $_SESSION["message"] = "Successfully saved.";
    Functions::redirect_to("../queue_display.php?queue_details=".$last_insert_id);
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to save.";
    Functions::redirect_to("../queue.php");
  }
}

?>
