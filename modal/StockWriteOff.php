<?php
require_once __DIR__.'/../util/initialize.php';

class StockWriteOff extends DatabaseObject{
    protected static $table_name = "stock_write_off";    
    protected static $db_fields = array();
    protected static $db_fk = array();

    public static function check_code($value) {
        global $database;
        $value = $database->escape_value($value);
        $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE p_code LIKE '%$value%' ");
        return $object_array;
    }

    public static function find_everything(){
        global $database;
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." ");
        return $object_array;
    }

    public static function find_by_code_date($value1, $value2) {
        global $database;
        $value1 =$database->escape_value($value1);
        $value2=$database->escape_value($value2);
        $object_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE p_code LIKE '%$value1%' AND DATE(datetime) = '$value2'");
        return $object_array;
    }
}

?>
