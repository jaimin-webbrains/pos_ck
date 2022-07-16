<?php
require_once __DIR__.'/../util/initialize.php';

class InvoiceSub extends DatabaseObject{
    protected static $table_name="invoice_sub";
    protected static $db_fields=array();
    protected static $db_fk=array("invoice_id"=>"Invoice","ops1_user"=>"User","ops2_user"=>"User","color"=>"ColourTube","color2"=>"ColourTube","color3"=>"ColourTube");

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

    public function color()
    {
        return parent::get_fk_object("color");
    }
    public function color2()
    {
        return parent::get_fk_object("color2");
    }
    public function color3()
    {
        return parent::get_fk_object("color3");
    }

    public static function find_all_invoice_id($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_id = '$value' ");
        return $object_array;
    }


    public static function find_all_invoice_id_category($value,$value2){
        global $database;
        $value  = $database->escape_value($value);
        $value2 = $database->escape_value($value2);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_id = '$value' AND category = '$value2' ");
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
        $value2 = $database->escape_value($value2);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_id = '$value' AND code = '$value2' ");
        return array_shift($object_array);
      }

    public static function find_all_invoice_id_product_name_package($value, $value2){
      global $database;
      $value=$database->escape_value($value);
      $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_id = '$value' AND name = '$value2' AND item_type = 3 ");
      return array_shift($object_array);
    }

    public static function find_all_invoice_id_product_name_redeem($value, $value2){
      global $database;
      $value=$database->escape_value($value);
      $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_id = '$value' AND name = '$value2' AND item_type = 4 ");
      return array_shift($object_array);
    }

    public static function find_by_invoice_id_date_range($value, $value2){
        global $database;
        $value=$database->escape_value($value);
        $value2=$database->escape_value($value2);
        $object_array=self::find_by_sql("SELECT *.invoice_sub FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE DATE(invoice.invoice_date) BETWEEN '$value' AND '$value2' ");
        return $object_array;
    }

    public static function find_by_invoice_id_date_ops1_a($value, $value2){
        global $database;
        $value=$database->escape_value($value);
        $value2=$database->escape_value($value2);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE MONTH(invoice.invoice_date) = '$value' AND invoice_sub.ops1_user = '$value2' AND item_type > 1 ");
        return $object_array;
    }

    public static function find_by_invoice_id_date_ops2_a($value, $value2){
        global $database;
        $value=$database->escape_value($value);
        $value2=$database->escape_value($value2);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE MONTH(invoice.invoice_date) = '$value' AND invoice_sub.ops2_user = '$value2' AND item_type > 1 ");
        return $object_array;
    }

    public static function find_by_invoice_id_date_ops1_ops2_a($value, $value2){
        global $database;
        $value=$database->escape_value($value);
        $value2=$database->escape_value($value2);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE MONTH(invoice.invoice_date) = '$value' AND (invoice_sub.ops1_user = '$value2' AND invoice_sub.ops2_user = '$value2') AND item_type > 1 ");
        return $object_array;
    }

    public static function find_by_invoice_id_date_ops1_b($value, $value2){
        global $database;
        $value=$database->escape_value($value);
        $value2=$database->escape_value($value2);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE MONTH(invoice.invoice_date) = '$value' AND invoice_sub.ops1_user = '$value2' AND item_type = 1 ");
        return $object_array;
    }

    public static function find_by_invoice_id_date_ops2_b($value, $value2){
        global $database;
        $value=$database->escape_value($value);
        $value2=$database->escape_value($value2);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE MONTH(invoice.invoice_date) = '$value' AND invoice_sub.ops2_user = '$value2' AND item_type = 1 ");
        return $object_array;
    }

    public static function find_by_invoice_id_date_ops1_ops2_b($value, $value2){
        global $database;
        $value=$database->escape_value($value);
        $value2=$database->escape_value($value2);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE MONTH(invoice.invoice_date) = '$value' AND (invoice_sub.ops1_user = '$value2' AND invoice_sub.ops2_user = '$value2') AND item_type = 1 ");
        return $object_array;
    }

}

?>
