<?php
require_once __DIR__.'/../util/initialize.php';

class Customer extends DatabaseObject{
    protected static $table_name="customer";
    protected static $db_fields=array();
    protected static $db_fk=array("customer_status"=>"CustomerStatus");

     public function customer_status()
    {
        return parent::get_fk_object("customer_status");
    }

    public static function find_by_custname($value){
        
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT full_name FROM ".self::$table_name." WHERE id='$value'");
        return array_shift($object_array);
    }

}
?>
