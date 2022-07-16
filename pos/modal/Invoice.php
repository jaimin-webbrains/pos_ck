<?php
require_once __DIR__.'/../util/initialize.php';

class Invoice extends DatabaseObject{
  protected static $table_name="invoice";
  protected static $db_fields=array();
  protected static $db_fk=array("customer_id"=>"Customer","invoice_branch"=>"Branch","invoiced_by"=>"User", "epayment_operator"=>"EpaymentOperator");

  public function customer_id()
  {
    return parent::get_fk_object("customer_id");
  }

  public function invoice_branch()
  {
    return parent::get_fk_object("invoice_branch");
  }

  public function invoiced_by()
  {
    return parent::get_fk_object("invoiced_by");
  }

  public function epayment_operator()
  {
    return parent::get_fk_object("epayment_operator");
  }

  public static function find_all_invoice_id_payment_type_epayment($value, $value2, $value3){
      global $database;
      $value=$database->escape_value($value);
      $value=$database->escape_value($value2);
      $value=$database->escape_value($value3);

      $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id = '$value' AND invoice_payment_type = '$value2' AND epayment_operator = '$value3' ");
      return $object_array;
  }

  public static function find_all_pending($value){
    global $database;
    $value = $database->escape_value($value);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_status = 0 AND invoice_branch = '$value' ORDER BY id ASC ");
    return $object_array;
  }

  public static function find_all_branch($value){
    global $database;
    $value = $database->escape_value($value);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_status = 0 AND invoice_branch = '$value' ORDER BY id ASC ");
    return $object_array;
  }

  public static function find_last_invoice_before_this_month($value,$value2){
    global $database;
    $value=$database->escape_value($value);
    $value2=$database->escape_value($value2);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id < '$value' AND MONTH(invoice_date) = '$value2' ORDER BY id DESC LIMIT 1 ");
    return array_shift($object_array);
  }

  public static function find_by_invoice_number($value){
    global $database;
    $value=$database->escape_value($value);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_number = '$value' ");
    return $object_array;
  }

  public static function invoice_by_date_branch($value,$value2){
    global $database;
    $value  = $database->escape_value($value);
    $value2 = $database->escape_value($value2);
    $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE DATE(invoice_date) = '$value' AND invoice_branch = '$value2' ORDER BY invoice_date DESC");
    return $object_array;
  }

  public static function get_invoice_by_id($invoice_id){
    global $database;
    $invoice_id = $database->escape_value($invoice_id);

    $object_array = Invoice::find_by_sql("SELECT * FROM invoice WHERE id='$invoice_id'");
    return $object_array;
  }
}

?>
