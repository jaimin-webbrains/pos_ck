<?php
require_once __DIR__.'/../util/initialize.php';

class DeletedInvoiceItems extends DatabaseObject{
    protected static $table_name = "deleted_invoices_items";    
    protected static $db_fields = array();
    protected static $db_fk = array("invoice_id"=>"Invoice");

    public static function find_all_invoice_id($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_id = '$value' ");
        return $object_array;
    }
}

?>
