<?php

//require_once './../util/initialize.php';
//
//function echoObjects($value) {
//    echo Functions::print_r_value($value);
//}
//
//ini_set('max_execution_time', 500);
//
//global $db;
//$db->start_transaction();
//try {
//    echo "Inventory....<br/>";
//    foreach (Batch::find_all() as $batch) {
//        $inventories = Inventory::find_all_by_batch_id($batch->id);
//        if (count($inventories) > 1) {
//            $new_inventory = array_shift($inventories);
//            foreach ($inventories as $inventory) {
//                $invoice_inventorys = InvoiceInventory::find_all_by_inventory_id($inventory->id);
//                foreach ($invoice_inventorys as $invoice_inventory) {
//                    $invoice_inventory->inventory_id = $new_inventory->id;
//                    $invoice_inventory->save();
//                }
//                $deliverer_inventorys = DelivererInventory::find_all_by_inventory_id($inventory->id);
//                foreach ($deliverer_inventorys as $deliverer_inventory) {
//                    $deliverer_inventory->inventory_id = $new_inventory->id;
//                    $deliverer_inventory->save();
//                }
//
//                $new_inventory->qty = (int) $new_inventory->qty + (int) $inventory->qty;
//                $inventory->delete();
//            }
//
//            $new_inventory->save();
//        }
//    }
//    
//    echo "inventory ok <br/>";
//    echo "DelivererInventory/InvoiceInventory....<br/>";
//    foreach (Inventory::find_all() as $inventory) {
//        foreach (Deliverer::find_all() as $deliverer) {
//            $deliverer_inventorys = DelivererInventory::find_all_by_deliverer_id_inventory_id($deliverer->id, $inventory->id);
//            if (count($deliverer_inventorys) > 1) {
//                $new_deliverer_inventory = array_shift($deliverer_inventorys);
//
//                foreach ($deliverer_inventorys as $deliverer_inventory) {
//                    $new_deliverer_inventory->qty = (int) $new_deliverer_inventory->qty + (int) $deliverer_inventory->qty;
//                    $deliverer_inventory->delete();
//                }
//
//                $new_deliverer_inventory->save();
//            }
//        }
//        
//        foreach (Invoice::find_all() as $invoice) {
//            $invoice_inventorys = InvoiceInventory::find_all_by_invoice_id_inventory_id($invoice->id, $inventory->id);
//
//            if (count($invoice_inventorys) > 1) {
//                $new_invoice_inventory = array_shift($invoice_inventorys);
//
//                foreach ($invoice_inventorys as $invoice_inventory) {
//                    $new_invoice_inventory->qty = (int) $new_invoice_inventory->qty + (int) $invoice_inventory->qty;
//                    $invoice_inventory->delete();
//                }
//
//                $new_invoice_inventory->save();
//            }
//        }
//    }
//    echo "DelivererInventory/InvoiceInventory ok <br/>";
//
//    $db->commit();
//    echo "done.";
//} catch (Exception $exc) {
//    $db->rollback();
//    echo $exc;
//}

