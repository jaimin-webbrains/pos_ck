<?php
require_once __DIR__.'/../util/initialize.php';

class Queue extends DatabaseObject{
    protected static $table_name="queue";
    protected static $db_fields=array();
    protected static $db_fk=array("customer_id"=>"Customer","branch_id"=>"Branch");

    public function customer_id()
    {
        return parent::get_fk_object("customer_id");
    }

    public function branch_id()
    {
        return parent::get_fk_object("branch_id");
    }

    public static function find_by_type_last_customer($value,$value2){
      global $database;
      $value=$database->escape_value($value);
      $value2=$database->escape_value($value2);
      $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE customer_id='$value' AND allocated = 0  AND DATE(que_date_time)='$value2' ORDER BY id DESC LIMIT 1 ");
      return array_shift($object_array);
    }

    public static function find_by_type_last($value,$value2){
      global $database;
      $value=$database->escape_value($value);
      $value2=$database->escape_value($value2);
      $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE queue_type='$value' AND DATE(que_date_time)='$value2' ORDER BY id DESC LIMIT 1 ");
      return array_shift($object_array);
    }

    public static function find_all_today($value){
      global $database;
      $value=$database->escape_value($value);
      $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE DATE(que_date_time)='$value' ");
      return $object_array;
    }
    public static function find_all_today_branch($value,$value2){
      global $database;
      $value=$database->escape_value($value);
      $value2=$database->escape_value($value2);
      $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE DATE(que_date_time)='$value' AND branch_id = '$value2' ");
      return $object_array;
    }

    public static function find_all_today_branch_pending_creative($value,$value2){
      global $database;
      $value=$database->escape_value($value);
      $value2=$database->escape_value($value2);
      $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE DATE(que_date_time)='$value' AND branch_id = '$value2' AND status = 1 AND queue_type = 'creative' ORDER BY id DESC LIMIT 1 ");
      return $object_array;
    }

    public static function find_all_today_branch_pending_stylist($value,$value2){
      global $database;
      $value=$database->escape_value($value);
      $value2=$database->escape_value($value2);
      $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE DATE(que_date_time)='$value' AND branch_id = '$value2' AND status = 1 AND queue_type = 'stylist' ORDER BY id DESC LIMIT 1 ");
      return $object_array;
    }

    public static function find_all_today_branch_pending_online($value,$value2){
      global $database;
      $value=$database->escape_value($value);
      $value2=$database->escape_value($value2);
      $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE DATE(que_date_time)='$value' AND branch_id = '$value2' AND status = 1 AND queue_type = 'online' ORDER BY id DESC LIMIT 1 ");
      return $object_array;
    }

    public static function find_current_running_branch($value,$value2){
      global $database;
      $value=$database->escape_value($value);
      $value2=$database->escape_value($value2);
      $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE DATE(que_date_time)='$value' AND branch_id = '$value2' AND status = 1 ");
      return $object_array;
    }


    public static function find_date_range($value,$value2){
      global $database;
      $value=$database->escape_value($value);
      $value2=$database->escape_value($value2);
      $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE DATE(que_date_time) BETWEEN '$value' AND '$value2' ORDER BY id ASC ");
      return $object_array;
    }

}

?>
