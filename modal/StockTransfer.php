<?php
require_once __DIR__.'/../util/initialize.php';

class StockTransfer extends DatabaseObject{
    public static $table_name = "stock_transfer";
    protected static $db_fields = array();
    protected static $db_fk = array();

    public static function find_transfer_by_code_date($start_date,$end_date,$p_code){
        global $database;
        $start_date = $database->escape_value($start_date);
        $end_date = $database->escape_value($end_date);
        $p_code = $database->escape_value($p_code);

        $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name."  WHERE p_code = '$p_code' AND DATE(datetime) BETWEEN '$start_date' AND '$end_date' ");
        $total_quantity = 0;
        if($object_array){
          foreach ($object_array as $stock){
            $total_quantity = $stock->stock_transfer_quantity + $total_quantity ;
          }
        }
        return $total_quantity;
    }

    public static function find_transfer_by_code_month($month,$year,$p_code){
        global $database;
        $month = $database->escape_value($month);
        $year = $database->escape_value($year);
        $p_code = $database->escape_value($p_code);

        $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE p_code = '$p_code' AND MONTH(datetime) = '$month' AND YEAR(datetime) = '$year'");
        $total_quantity = 0;
        if($object_array){
          foreach ($object_array as $stock){
            $total_quantity = $stock->stock_transfer_quantity + $total_quantity ;
          }
        }
        return $total_quantity;
    }

    public static function find_stock_transfer_by_dates_code_branch($start_date,$end_date,$branch_id,$p_code) {
      global $database;
      $start_date = $database->escape_value($start_date);
      $end_date = $database->escape_value($end_date);
      $branch_id = $database->escape_value($branch_id);
      $p_code = $database->escape_value($p_code);
      $branch_condition = '';
      if($branch_id != 0){
        $branch_condition = "AND branch_id = $branch_id ";
      }
      $object_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE p_code = '$p_code' AND DATE(datetime) BETWEEN '$start_date' AND '$end_date'".$branch_condition);
      
      $total_quantity = 0;
      if($object_array){
        foreach ($object_array as $stock){
          $total_quantity = $stock->stock_transfer_quantity + $total_quantity ;
        }
      }
      return $total_quantity;
    }

    public static function find_stock_transfer_by_code_month_branch($month,$year,$branch_id,$p_code) {
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
          $total_quantity = $stock->stock_transfer_quantity + $total_quantity ;
        }
      }
      return $total_quantity;
    }
}
?>
