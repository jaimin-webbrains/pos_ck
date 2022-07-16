<?php
require_once __DIR__.'/../util/initialize.php';

class ServiceCategory extends DatabaseObject{
    protected static $table_name="service_category";
    protected static $db_fields=array();
    protected static $db_fk=array();

    public static function find_by_product_name($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE name = '$value' ");
        return $object_array;
    }

}

?>
