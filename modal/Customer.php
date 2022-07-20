<?php
require_once __DIR__.'/../util/initialize.php';

class Customer extends DatabaseObject{
    protected static $table_name="customer";
    protected static $db_fields=array();

    protected static $db_fk=array("customer_status"=>"CustomerStatus");

//    public $id;
//    public $name;

     public function customer_status()
    {
        return parent::get_fk_object("customer_status");
    }

    public static function check_contact($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE mobile LIKE '%$value%' ");
        return $object_array;
    }

    public static function check_email($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE email LIKE '$value%' ");
        return $object_array;
    }

    public static function find_all_customer(){
        global $database;
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id > 1  ");
        return $object_array;
    }

    public static function find_all_customer_birthday($value){
        global $database;
        $value=$database->escape_value($value);
        $value_min = $value - 01;
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE MONTH(dob) BETWEEN '$value_min' AND '$value' ORDER BY full_name ASC  ");
        return $object_array;

        
    }

    public static function find_all_customer_joinday($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE MONTH(join_date)= $value ORDER BY full_name ASC  ");
        return $object_array;
    }

    public static function find_by_custname($value){
        
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT full_name FROM ".self::$table_name." WHERE id='$value'");
        return array_shift($object_array);
    }

}

?>
