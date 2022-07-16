<?php
require_once __DIR__.'/../util/initialize.php';

class Voucher extends DatabaseObject{
    protected static $table_name="voucher";
    protected static $db_fields=array();
    protected static $db_fk=array("customer_id"=>"Customer");

    public function customer_id(){
        return parent::get_fk_object("customer_id");
    }

    public static function find_all_desc(){
        global $database;
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." ORDER BY id DESC ");
        return $object_array;
    }

    public static function find_by_type($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE voucher_type = '$value' ORDER BY id DESC ");
        return $object_array;
    }

    public static function find_by_voucher_number($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE voucher_number = '$value' ");
        // echo '<pre>';
        // print_r($object_array);
        // die;
        return array_shift($object_array);

    }

    public static function STAF_MAX_NUMBER(){
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE voucher_number LIKE 'STAFF%' ORDER BY id DESC  LIMIT 1");
        return $object_array;
    }

}

?>
