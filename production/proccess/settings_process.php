<?php
require_once './../../util/initialize.php';

if (isset($_POST['update'])) {
    $data = SystemSettings::find_by_id(1);
    $data->refer_commision = trim($_POST['direct_commision']);
    $data->direct_commision = trim($_POST['refer_commision']);
    $data->point_voucher = $_POST['point_voucher'];
    $data->expiry_month = $_POST['expiry_month'];
    $data->min_voucher_point = $_POST['min_voucher_point'];
    $data->max_voucher_discount = $_POST['max_voucher_discount'];
    $data->service = $_POST['service'];
    $data->gst = $_POST['gst'];
    
    

    try {
        $data->save();
        Activity::log_action("Settings - updated:");
        $_SESSION["message"] = "Successfully updated.";
        Functions::redirect_to("./../settings.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to update.";
        Functions::redirect_to("./../settings.php");
    }

}
