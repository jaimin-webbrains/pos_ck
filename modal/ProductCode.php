<?php
require_once __DIR__.'/../util/initialize.php';

class ProductCode extends DatabaseObject{
    protected static $table_name="product";
    protected static $db_fields=array();
    protected static $db_fk=array();

    public static function find_by_product_code($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE code = '$value' ");
        return $object_array;
    }

}

?>