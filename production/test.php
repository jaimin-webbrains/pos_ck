<?php
ini_set('display_errors', 1);
require_once './../util/initialize.php';

function echoObjects($value) {
    echo Functions::print_r_value($value);
}

echoObjects("################################################################################################################################");
//echoObjects($_SESSION);
echoObjects("################################################################################################################################");

//echoObjects(Inventory::aaa());
//echoObjects(DelivererInventory::find_all_by_deliverer_id(2));
//
//$db_deliverer_inventorys = DelivererInventory::find_all_by_deliverer_id($deliverer_id);
//$deliverer_inventorys = array();
//foreach ($db_deliverer_inventorys as $deliverer_inventory) {
//    $deliverer_inventorys[] = $deliverer_inventory->to_array();
//}
//
//echoObjects($deliverer_inventorys);

function post(){
    
}

//$obj=Product::find_all_by_order_by_name();
// $obj= DelivererInventory::find_all_by_deliverer_id_and_product_id_batch_asc(2,7);

// echoObjects(Batch::find_all_by_name_asc());
