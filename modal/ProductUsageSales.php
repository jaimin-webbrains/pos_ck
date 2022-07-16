<?php
require_once __DIR__.'/../util/initialize.php';

class ProductUsageSales extends DatabaseObject{
    protected static $table_name="product_usage_logistic";
    protected static $db_fields=array();
    protected static $db_fk=array();
    public static function check_code($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE p_code LIKE '%$value%' ");
        return $object_array;
    }
    public static function capture_code($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE p_use_code LIKE '%$value%'");
        return $object_array;
    }
    public static function check_name($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE p_volume LIKE '$value%' ");
        return $object_array;
    }
    public static function get_usage_amount($value,$value2,$value3,$value4){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE p_code = '$value' AND p_use_code LIKE '%$value2%' AND p_month = '$value3' AND p_year = '$value4'");
        return $object_array;
    }
    public static function find_by_use_id($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id = '$value' ");
        return $object_array;
    }
    public static function find_max_id(){
        global $database;
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." ORDER BY id DESC LIMIT 1");
            return !empty($object_array) ? array_shift($object_array) : false;
        return array_shift($object_array);
    }
    public static function find_by_month($value){
        global $database;
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE p_month = '$value'");
            return !empty($object_array) ? array_shift($object_array) : false;
        return array_shift($object_array);
    }
    public static function find_by_year($value){
        global $database;
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE p_year = '$value'");
            return !empty($object_array) ? array_shift($object_array) : false;
        return array_shift($object_array);
    }
    public static function find_by_month_and_year($value,$value2){
        global $database;
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE p_month = '$value' AND p_year = '$value2'");
        return $object_array;
    }
    public static function find_code_and_year($value,$value2){
        global $database;
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE p_code = '$value' AND p_year = '$value2'");
        return $object_array;
    }
    public static function find_by_code_month_and_year($value,$value1,$value2){
        global $database;
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE p_code = '$value' AND p_month = '$value1' AND p_year = '$value2'");
        return $object_array;
    }
    public static function find_everything(){
        global $database;
        //$value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." ");
        return $object_array;
      }
    public static function getNextCode() {
        $auto_increment=parent::getAutoIncrement();
        return $auto_increment;
    }
}

?>
