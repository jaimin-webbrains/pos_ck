<?php
require_once './../util/initialize.php';

$search = $_GET['search'];

$all_customers = Customer::find_by_sql("SELECT * FROM customer WHERE (full_name LIKE '%$search%' OR mobile LIKE '%$search%' OR email LIKE '%$search%')");

// echo '<pre>';
// print_r("SELECT * FROM customer WHERE full_name LIKE '%mohsin%'");
// die;


echo json_encode($all_customers);