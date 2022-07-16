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

  public static function find_all_pending($value){
    global $database;
    $value = $database->escape_value($value);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_status = 0 AND invoice_branch = '$value' ORDER BY id ASC ");
    return $object_array;
  }

  public static function find_by_branch_date($value,$value2){
    global $database;
    $value = $database->escape_value($value);
    $value2 = $database->escape_value($value2);
    $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_status = 1 AND invoice_branch = '$value2' AND DATE(invoice_date) = '$value' ORDER BY id ASC ");
    // echo "SELECT * FROM ".self::$table_name." WHERE invoice_status = 1 AND invoice_branch = '$value2' AND DATE(invoice_date) = '$value' ORDER BY id ASC";
    return $object_array;
  }

  public static function find_by_branch_month($value,$value2){
    global $database;
    $value = $database->escape_value($value);
    $value2 = $database->escape_value($value2);
    $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_status = 1 AND invoice_branch = '$value2' AND MONTH(invoice_date) = '$value' ORDER BY id ASC ");
    return $object_array;
  }

  public static function find_all_branch($value){
    global $database;
    $value = $database->escape_value($value);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_status = 0 AND invoice_branch = '$value' ORDER BY id ASC ");
    return $object_array;
  }

  public static function find_all_customer_invoice_total($value){
    global $database;
    $value = $database->escape_value($value);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_status = 1 AND customer_id = '$value' ORDER BY id ASC ");
    return $object_array;
  }

  public static function find_all_queue($value){
    global $database;
    $value = $database->escape_value($value);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE queue_number = '$value' ORDER BY id ASC ");
    return $object_array;
  }

  public static function find_all_by_date_range($value,$value2,$branch_id){
    global $database;
    $value = $database->escape_value($value);
    $value2 = $database->escape_value($value2);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_branch = '$branch_id' AND invoice_status = 1 AND DATE(invoice_date) BETWEEN '$value' AND '$value2' ORDER BY `invoice_date` DESC ");
    return $object_array;
  }

  public static function find_all_by_date_range_banch($value,$value2,$value3){
    global $database;
    $value = $database->escape_value($value);
    $value2 = $database->escape_value($value2);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE invoice_branch = '$value3' AND invoice_status = 1 AND DATE(invoice_date) BETWEEN '$value' AND '$value2' ORDER BY `invoice_date` DESC ");
    return $object_array;
  }

  public static function invoice_by_date_branch($value,$value3,$value2){
    global $database;
    $value  = $database->escape_value($value);
    $value3 = $database->escape_value($value3);
    $value2 = $database->escape_value($value2);


    $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE DATE(invoice_date) BETWEEN '$value' AND '$value3' AND invoice_branch = '$value2' ORDER BY invoice_date DESC");
    // echo '<pre>';
    // print_r($object_array);
    // die;
    return $object_array;
  }

  public static function find_by_invoice_customer_total($value){
    global $database;
    $value  = $database->escape_value($value);
    $res = $database->doQuery("SELECT COUNT(*) FROM " . static::$table_name." WHERE id = '$value'");
    $count = $res[0][0];
    return $count;

  }

//   public static function row_count() {
//     global $database;
//     $res = $database->doQuery("SELECT COUNT(*) FROM " . static::$table_name);
//     $count = $res[0][0];
//     return $count;
// }

  public static function get_invoice_by_branch_amount_cash($branch_id){
    global $database;
    $invoice_payment_type = 1;
    $branch_id = $database->escape_value($branch_id);
    $invoice_payment_type = $database->escape_value($invoice_payment_type);
    $object_array = $database->doQuery("SELECT SUM(invoice_total) as total FROM invoice WHERE invoice_branch='$branch_id' AND invoice_payment_type='$invoice_payment_type'");
    $count = $object_array[0][0];
    return $count;
  }

  public static function get_invoice_by_branch_amount_e($branch_id){
    global $database;
    $invoice_payment_type = 2;
    $branch_id = $database->escape_value($branch_id);
    $invoice_payment_type = $database->escape_value($invoice_payment_type);
    $object_array = $database->doQuery("SELECT SUM(invoice_total) as total FROM invoice WHERE invoice_branch='$branch_id' AND invoice_payment_type='$invoice_payment_type'");
    $count = $object_array[0][0];
    return $count;
  }

  public static function get_invoice_by_branch_amount_credit($branch_id){
    global $database;
    $invoice_payment_type = 3;
    $branch_id = $database->escape_value($branch_id);
    $invoice_payment_type = $database->escape_value($invoice_payment_type);
    $object_array = $database->doQuery("SELECT SUM(invoice_total) as total FROM invoice WHERE invoice_branch='$branch_id' AND invoice_payment_type='$invoice_payment_type'");
    $count = $object_array[0][0];
    return $count;
  }
  public static function find_by_customer($from,$to,$branch_id){
    global $database;
    $from  = $database->escape_value($from);
    $to = $database->escape_value($to);
    $branch_id  = $database->escape_value($branch_id);
    $object_array=self::find_by_sql("SELECT customer_id FROM ".self::$table_name." WHERE invoice_status = 1 AND invoice_branch='$branch_id' AND DATE(invoice_date) BETWEEN '$from' AND '$to' GROUP BY customer_id");
    return $object_array;
  }

}

?>
