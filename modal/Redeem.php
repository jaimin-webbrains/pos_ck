<?php
require_once __DIR__.'/../util/initialize.php';

class Redeem extends DatabaseObject{
    protected static $table_name="redeem";
    protected static $db_fields=array();
    protected static $db_fk=array("customer_id"=>"Customer","package_id"=>"Package","invoice_id"=>"Invoice");

    public function customer_id()
    {
        return parent::get_fk_object("customer_id");
    }

    public function package_id()
    {
        return parent::get_fk_object("package_id");
    }

    public function invoice_id()
    {
        return parent::get_fk_object("invoice_id");
    }

    public static function find_all_customer_id($value){
      global $database;
      $value=$database->escape_value($value);
      $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE customer_id = '$value' and balance > 0 ORDER BY id ASC ");
      return $object_array;
    }

    public static function find_by_customer_id_invoice_id_item_id($value,$value2,$value3){
      global $database;
      $value=$database->escape_value($value);
      $value2=$database->escape_value($value2);
      $value3=$database->escape_value($value3);
      $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE customer_id='$value' AND invoice_id='$value2' AND package_id = '$value3' ");
      return array_shift($object_array);
    }



}

?>
