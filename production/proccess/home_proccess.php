<?php

require_once './../../util/initialize.php';

function get_invoices($months) {
    $final_array = array();
    foreach ($months as $value) {
        $sub_total = 0;
        foreach (Invoice::find_all_by_month($value) as $invoice) {
            $sub_total += $invoice->net_amount;
        }
        $final_array[] = $sub_total;
    }
    return $final_array;
}

function get_returns($months) {
    $final_array = array();
    foreach ($months as $value) {
        $sub_total = 0;
        foreach (ProductReturn::find_all_by_month($value) as $product_return) {
            foreach (ProductReturnBatch::find_all_by_product_return_id($product_return->id) as $product_return_batch) {
                $sub_total += ($product_return_batch->qty * $product_return_batch->unit_price);
            }
        }
        $final_array[] = $sub_total;
    }
    return $final_array;
}

function get_payments($months) {
    $final_array = array();
    foreach ($months as $value) {
        $sub_total = 0;
        foreach (Payment::find_all_by_month($value) as $payment) {
            $sub_total += $payment->amount;
        }
        $final_array[] = $sub_total;
    }
    return $final_array;
}

if (isset($_POST['data_reuest'])) {
    $months = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
    $array = array();
    $array['invoices'] = get_invoices($months);
    $array['returns'] = get_returns($months);
    $array['payments'] = get_payments($months);
    echo json_encode($array);
}

//$months = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
//$array = array();
//$array['invoices'] = get_invoices($months);
//$array['returns'] = get_returns($months);
//$array['payments'] = get_payments($months);
////json_encode($array);
//Functions::print_r_value($array);
