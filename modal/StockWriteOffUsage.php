<?php
require_once __DIR__.'/../util/initialize.php';

class StockWriteOffUsage extends DatabaseObject{
    public static $table_name = "stock_writeoff_usage";
    protected static $db_fields = array();
    protected static $db_fk = array();

    public static function find_by_date($value) {
      global $database;
      $value = $database->escape_value($value);
      $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name."  WHERE DATE(datetime) = '$value' ");
      return $object_array;
    }

    public static function find_by_dates_code($value,$value2,$value3,$value4) {
      global $database;
      $value = $database->escape_value($value);
      $value2 = $database->escape_value($value2);
      $value3 = $database->escape_value($value3);
      $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name."  WHERE p_code = '$value3' AND branch_id = '$value4' AND DATE(datetime) BETWEEN '$value' AND '$value2' ");
      return $object_array;
    }

    public static function find_by_date_branch($value, $value3) {
      global $database;
      $value = $database->escape_value($value);
      $value3 = $database->escape_value($value3);
      $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name."  WHERE branch_id = '$value3' AND DATE(datetime) = '$value' ");
      return $object_array;
    }

    public static function find_by_dates($value,$value2) {
      global $database;
      $value = $database->escape_value($value);
      $value2 = $database->escape_value($value2);
      $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name."  WHERE DATE(datetime) BETWEEN '$value' AND '$value2' ");
      return $object_array;
    }

    public static function find_by_dates_branch($value,$value2,$value3) {
      global $database;
      $value = $database->escape_value($value);
      $value2 = $database->escape_value($value2);
      $value3 = $database->escape_value($value3);
      $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name."  WHERE branch_id = '$value3' AND DATE(datetime) BETWEEN '$value' AND '$value2' ");
      return $object_array;
    }

    public static function find_by_month($value) {
      global $database;
      $value = $database->escape_value($value);
      $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name."  WHERE MONTH(datetime) = '$value' ");
      return $object_array;
    }

    public static function find_by_month_branch($value, $value3) {
      global $database;
      $value = $database->escape_value($value);
      $value3 = $database->escape_value($value3);
      $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name."  WHERE branch_id = '$value3' AND MONTH(datetime) = '$value' ");
      return $object_array;
    }

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

    public static function find_stock_waveoff_usage_by_code_date($start_date,$end_date,$p_code){
        global $database;
        $start_date = $database->escape_value($start_date);
        $end_date = $database->escape_value($end_date);
        $p_code = $database->escape_value($p_code);

        $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name."  WHERE p_code = '$p_code' AND DATE(datetime) BETWEEN '$start_date' AND '$end_date' ");
        $total_quantity = 0;
        if($object_array){
          foreach ($object_array as $stock){
            $total_quantity = $stock->write_off_quantity + $total_quantity ;
          }
        }
        return $total_quantity;
    }

    public static function find_stock_waveoff_usage_by_code_month($month,$year,$p_code){
      global $database;
      $month = $database->escape_value($month);
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);

      $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE p_code = '$p_code' AND MONTH(datetime) = '$month' AND YEAR(datetime) = '$year'");
      $total_quantity = 0;
      if($object_array){
        foreach ($object_array as $stock){
          $total_quantity = $stock->write_off_quantity + $total_quantity ;
        }
      }
      return $total_quantity;
    }

    public static function find_stock_waveoff_usage_by_dates_code_branch($start_date,$end_date,$branch_id,$p_code) {
      global $database;
      $start_date = $database->escape_value($start_date);
      $end_date = $database->escape_value($end_date);
      $branch_id = $database->escape_value($branch_id);
      $p_code = $database->escape_value($p_code);
      $branch_condition = '';
      if($branch_id != 0){
        $branch_condition = "AND branch_id = $branch_id ";
      }

      $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name."  WHERE p_code = '$p_code' AND DATE(datetime) BETWEEN '$start_date' AND '$end_date' ".$branch_condition);
      
      $total_quantity = 0;
      if($object_array){
        foreach ($object_array as $stock){
          $total_quantity = $stock->write_off_quantity + $total_quantity ;
        }
      }
      return $total_quantity;
    }

    public static function find_stock_waveoff_usage_by_code_month_branch($month,$year,$branch_id,$p_code) {
      global $database;
      $month = $database->escape_value($month);
      $year = $database->escape_value($year);
      $branch_id = $database->escape_value($branch_id);
      $p_code = $database->escape_value($p_code);

      $branch_condition = '';
      if($branch_id != 0){
        $branch_condition = "AND branch_id = $branch_id ";
      }
      $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE p_code = '$p_code' AND MONTH(datetime) = '$month' AND YEAR(datetime) = '$year' ".$branch_condition);
      
      $total_quantity = 0;
      if($object_array){
        foreach ($object_array as $stock){
          $total_quantity = $stock->write_off_quantity + $total_quantity ;
        }
      }
      return $total_quantity;
    }
}

?>
