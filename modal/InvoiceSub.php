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

  public static function find_by_invoice_id_date_range_product_branch($value, $value2, $value3){
    global $database;
    $value = $database->escape_value($value);
    $value2 = $database->escape_value($value2);
    $value3 = $database->escape_value($value3);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.code = '$value' AND invoice.invoice_branch = '$value2' AND DATE(invoice.invoice_date) = '$value3' ");
    return $object_array;
  }

  public static function find_by_invoice_id_date_range_branch($value2, $value3){
    global $database;
    $value2 = $database->escape_value($value2);
    $value3 = $database->escape_value($value3);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type > 2  AND invoice.invoice_branch = '$value2' AND DATE(invoice.invoice_date) = '$value3' ");
    return $object_array;
  }

  public static function find_all_invoice_id_last($value){
    global $database;
    $value=$database->escape_value($value);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_id = '$value' ORDER BY id DESC LIMIT 1 ");
    return array_shift($object_array);
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

  public static function find_by_invoice_id_date_range_cat($value, $value2, $value3, $value4){
    global $database;
    $value=$database->escape_value($value);
    $value2=$database->escape_value($value2);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.ref_id = '$value4' AND invoice_sub.item_type != 1 AND DATE(invoice.invoice_date) BETWEEN '$value' AND '$value2' ");
    return $object_array;
  }
  public static function find_by_invoice_id_date_range_cat1($value, $value2, $value3, $value4){
    global $database;
    $value=$database->escape_value($value);
    $value2=$database->escape_value($value2);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.ref_id = '$value4' AND invoice_sub.item_type != 1 AND DATE(invoice.invoice_date) BETWEEN '$value' AND '$value2' GROUP BY code,invoice_id");
    // echo "SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.ref_id = '$value4' AND invoice_sub.item_type != 1 AND DATE(invoice.invoice_date) BETWEEN '$value' AND '$value2' GROUP BY code,invoice_id";
    return $object_array;
  }

  public static function find_by_invoice_id_date_range($value, $value2, $value3){
    global $database;
    $value=$database->escape_value($value);
    $value2=$database->escape_value($value2);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE DATE(invoice.invoice_date) BETWEEN '$value' AND '$value2' ");
    return $object_array;
  }

  public static function find_by_invoice_id_date_range_invoice($value, $value2, $value3){
    global $database;
    $value=$database->escape_value($value);
    $value2=$database->escape_value($value2);
    $object_array=self::find_by_sql("SELECT DISTINCT invoice_id FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice.invoice_status=1 AND DATE(invoice.invoice_date) BETWEEN '$value' AND '$value2'  AND (ops1_user='$value3' or ops2_user='$value3')   ");
    return $object_array;
  }

  public static function find_by_invoice_id_date_range_invoice1($value, $value2, $value3){
    global $database;
    $value=$database->escape_value($value);
    $value2=$database->escape_value($value2);
    $object_array=self::find_by_sql("SELECT DISTINCT invoice_id FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice.invoice_status=1 AND (DATE(invoice.invoice_date) BETWEEN '$value' AND '$value2') AND (ops1_user='$value3' or ops2_user='$value3')   ");

    return $object_array;
  }

  public static function find_by_invoice_id_date_range_pro($value, $value2, $value3, $value4){
    global $database;
    $value=$database->escape_value($value);
    $value2=$database->escape_value($value2);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.ref_id = '$value4' AND invoice_sub.item_type = 1 AND DATE(invoice.invoice_date) BETWEEN '$value' AND '$value2' ");
    return $object_array;
  }

  public static function find_by_invoice_id_date_range_last($value, $value2, $value3){
    global $database;
    $value = $database->escape_value($value);
    $value2 = $database->escape_value($value2);
    $value3 = $database->escape_value($value3);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE (invoice_sub.ops1_user = '$value' OR invoice_sub.ops2_user = '$value') AND DATE(invoice.invoice_date) BETWEEN '$value2' AND '$value3' ORDER BY invoice.invoice_date DESC LIMIT 1 ");
    return array_shift($object_array);
  }

  public static function find_by_invoice_id_date_range_last_2($value, $value2, $value3){
    global $database;
    $value = $database->escape_value($value);
    $value2 = $database->escape_value($value2);
    $value3 = $database->escape_value($value3);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE (invoice_sub.ops1_user = '$value' OR invoice_sub.ops2_user = '$value') AND DATE(invoice.invoice_date) BETWEEN '$value2' AND '$value3' ORDER BY invoice.invoice_date DESC ");
    return $object_array;
  }

  // report data query
  public static function find_by_customer_cat($value, $value2, $value3, $value4, $value5){
    global $database;
    $value =$database->escape_value($value);
    $value2=$database->escape_value($value2);
    $value3=$database->escape_value($value3);
    $value4=$database->escape_value($value4);
    $value5=$database->escape_value($value5);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice.customer_id = '$value' AND invoice.invoice_branch  = '$value5' AND invoice_sub.category = '$value2' AND DATE(invoice.invoice_date) BETWEEN '$value3' AND '$value4' ");
    return $object_array;
  }

  public static function find_by_type_cat($value, $value2, $value3, $value4, $value5){
    global $database;
    $value =$database->escape_value($value);
    $value2=$database->escape_value($value2);
    $value3=$database->escape_value($value3);
    $value4=$database->escape_value($value4);
    $value5=$database->escape_value($value5);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type = '$value' AND invoice.invoice_branch  = '$value5' AND invoice_sub.category = '$value2' AND invoice.invoice_status = 1 AND DATE(invoice.invoice_date) BETWEEN '$value3' AND '$value4' ");
    return $object_array;
  }

  public static function find_by_type_code($value, $value2, $value3, $value4){
    global $database;
    $value =$database->escape_value($value);
    $value2=$database->escape_value($value2);
    $value3=$database->escape_value($value3);
    $value4=$database->escape_value($value4);
    // $query="SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type = '$value' AND invoice.invoice_branch  = '$value4' AND invoice_sub.code = '$value2' AND DATE(invoice.invoice_date) = '$value3'";
    // var_dump($query);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type = '$value' AND invoice.invoice_branch  = '$value4' AND invoice_sub.code = '$value2' AND DATE(invoice.invoice_date) = '$value3' ");
    return $object_array;
  }

  public static function find_by_type_code_without_branch($value, $value2, $value3){
      global $database;
      $value =$database->escape_value($value);
      $value2=$database->escape_value($value2);
      $value3=$database->escape_value($value3);
      $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type = '$value' AND invoice_sub.code = '$value2' AND DATE(invoice.invoice_date) = '$value3' ");
      return $object_array;
  }

  public static function find_by_type_branch_code_type_date_range($value, $value2, $value3, $value4, $value5){
    global $database;
    $value =$database->escape_value($value);
    $value2=$database->escape_value($value2);
    $value3=$database->escape_value($value3);
    $value4=$database->escape_value($value4);
    $value5=$database->escape_value($value5);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type = '$value' AND invoice.invoice_branch  = '$value3' AND invoice_sub.code = '$value2' AND invoice.invoice_date BETWEEN '$value4' AND '$value5'");

    return $object_array;
  }

  public static function find_by_type_branch_code_type_date_range_without_branch($value, $value2, $value3, $value4){
  
    global $database;
    $value =$database->escape_value($value);
    $value2=$database->escape_value($value2);
    $value3=$database->escape_value($value3);
    $value4=$database->escape_value($value4);
    // $query = "SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type = '$value' AND invoice_sub.code = '$value2' AND invoice.invoice_date BETWEEN '$value3' AND '$value4'";
    // var_dump($query);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type = '$value' AND invoice_sub.code = '$value2' AND invoice.invoice_date BETWEEN '$value3' AND '$value4'");
    return $object_array;
  }

  public static function find_by_invoice_id_date_range_user($value, $value2, $value4){
    global $database;
    $value=$database->escape_value($value);
    $value2=$database->escape_value($value2);
    $value4=$database->escape_value($value4);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE DATE(invoice.invoice_date) BETWEEN '$value' AND '$value2' AND (invoice_sub.ops1_user = '$value4' OR invoice_sub.ops2_user = '$value4') ");
    return $object_array;
  }

   public static function find_by_invoice($value){
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

}

?>
