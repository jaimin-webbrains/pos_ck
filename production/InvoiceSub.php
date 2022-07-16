<?php
require_once __DIR__.'/../util/initialize.php';

class InvoiceSub extends DatabaseObject{
    protected static $table_name="invoice_sub";
    protected static $db_fields=array();
    protected static $db_fk=array("invoice_id"=>"Invoice","ops1_user"=>"User","ops2_user"=>"User");

    public function invoice_id()
    {
        return parent::get_fk_object("invoice_id");
    }

    public function ops1_user()
    {
        return parent::get_fk_object("ops1_user");
    }

    public function ops2_user()
    {
        return parent::get_fk_object("ops2_user");
    }

    public static function find_all_invoice_id($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_id = '$value' ");
        return $object_array;
    }

    public static function find_all_invoice_id_product_name($value, $value2){
      global $database;
      $value=$database->escape_value($value);
      $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_id = '$value' AND name = '$value2' ");
      return array_shift($object_array);
    }

    public static function find_all_invoice_id_product_code($value, $value2){
        global $database;
        $value=$database->escape_value($value);
        $value2=$database->escape_value($value2);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_id = '$value' AND code = '$value2' ");
        return array_shift($object_array);
      }

}

?>
