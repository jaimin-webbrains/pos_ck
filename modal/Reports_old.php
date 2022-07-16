<?php
// error_reporting(0);
require_once __DIR__.'/../util/initialize.php';

class Reports extends DatabaseObject{

    public static function get_quantity_by_year($class_name, $year, $p_code){
      global $database;
      $total_quantity = 0;
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;

      $object_array = $class_name::find_by_sql("SELECT quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year'");

      if($object_array){
        foreach ($object_array as $stock){
          $total_quantity = $stock->quantity + $total_quantity ;
        }
      }

      return $total_quantity;
    }

    public static function get_writeOff_quantity_by_year($class_name, $year, $p_code){
      global $database;
      $total_quantity = 0;
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;

      $object_array = $class_name::find_by_sql("SELECT write_off_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year'");

      if($object_array){
        foreach ($object_array as $stock){
          $total_quantity = $stock->write_off_quantity + $total_quantity ;
        }
      }

      return $total_quantity;
    }
    
    public static function get_stock_transfer_quantity_by_year($class_name, $year, $p_code){
      global $database;
      $total_quantity = 0;
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;

      $object_array = $class_name::find_by_sql("SELECT stock_transfer_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year'");

      if($object_array){
        foreach ($object_array as $stock){
          $total_quantity = $stock->stock_transfer_quantity + $total_quantity ;
        }
      }
      return $total_quantity;
    }

    public static function get_quantity_by_year_month_wise($class_name, $year, $p_code){
      global $database;
      
      $data_array = [];
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;
    
      for($month = 1; $month <= 12; $month++){
        $monthly_quantity = 0;
        $object_array = $class_name::find_by_sql("SELECT quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year' AND MONTH(datetime) = '$month'");
        
        if($object_array){
            foreach ($object_array as $stock){
                $monthly_quantity = $stock->quantity + $monthly_quantity ;
            }
        }
        $data_array[$month] = $monthly_quantity;
      }
      return $data_array;
    }

    public static function get_quantity_by_month_year($class_name,$month, $year, $p_code){
      global $database;
      $total_quantity = 0;
      $month = $database->escape_value($month);
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;

      $object_array = $class_name::find_by_sql("SELECT quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year' AND MONTH(datetime) = '$month'");

      if($object_array){
        foreach ($object_array as $stock){
          $total_quantity = $stock->quantity + $total_quantity ;
        }
      }

      return $total_quantity;
    }

    public static function get_quantity_by_year_month_day_wise($class_name, $month, $year, $p_code){
      global $database;
      
      $data_array = [];
      $month = $database->escape_value($month);
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;
      $days_in_month=cal_days_in_month(CAL_GREGORIAN,$_POST['search_month'],$_POST['search_year']);

      for($day = 1; $day <= $days_in_month; $day++){
        $daily_quantity = 0;
        $object_array = $class_name::find_by_sql("SELECT quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year' AND MONTH(datetime) = '$month' AND DAY(datetime) = '$day'");
        
        if($object_array){
            foreach ($object_array as $stock){
                $daily_quantity = $stock->quantity + $daily_quantity ;
            }
        }
        $data_array[$day] = $daily_quantity;
      }
      return $data_array;
    }

    public static function get_writeOff_quantity_by_month_year($class_name, $month, $year, $p_code){
      global $database;
      $total_quantity = 0;
      $month = $database->escape_value($month);
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;

      $object_array = $class_name::find_by_sql("SELECT write_off_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year' AND MONTH(datetime) = '$month'");

      if($object_array){
        foreach ($object_array as $stock){
          $total_quantity = $stock->write_off_quantity + $total_quantity ;
        }
      }

      return $total_quantity;
    }
    
    public static function get_stock_transfer_quantity_by_month_year($class_name, $month, $year, $p_code){
      global $database;
      $total_quantity = 0;
      $month = $database->escape_value($month);
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;

      $object_array = $class_name::find_by_sql("SELECT stock_transfer_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year' AND MONTH(datetime) = '$month'");

      if($object_array){
        foreach ($object_array as $stock){
          $total_quantity = $stock->stock_transfer_quantity + $total_quantity ;
        }
      }
      return $total_quantity;
    }

    public static function get_quantity_day_wise($class_name, $from_date, $to_date, $p_code){
        global $database;
        $total_quantity = 0;
        $from_date = $database->escape_value($from_date);
        $to_date = $database->escape_value($to_date);
        $p_code = $database->escape_value($p_code);
        $table_name = $class_name :: $table_name;

        $object_array = $class_name::find_by_sql("SELECT datetime,quantity FROM ".$table_name." WHERE p_code = '$p_code' AND DATE(datetime) BETWEEN '$from_date' AND '$to_date'");

        $period = new DatePeriod(
            new DateTime($from_date),
            new DateInterval('P1D'),
            new DateTime($to_date)
        );
        $data_array = [];
        foreach ($period as $key => $value) {
            $period_date = $value->format('Y-m-d');
            $qty = 0;
            if($object_array){
                foreach($object_array as $row){
                    $date = explode(' ',$row->datetime)[0];
                    if($date == $period_date){
                        $qty += $row->quantity;
                    }
                }
            }
            $data_array[$period_date] = $qty;
        }
        return $data_array;
    }

    public static function get_quantity_by_day($class_name, $from_date, $to_date, $p_code){
        global $database;
        $total_quantity = 0;
        $from_date = $database->escape_value($from_date);
        $to_date = $database->escape_value($to_date);
        $p_code = $database->escape_value($p_code);
        $table_name = $class_name :: $table_name;

        $object_array = $class_name::find_by_sql("SELECT quantity FROM ".$table_name." WHERE p_code = '$p_code' AND DATE(datetime) BETWEEN '$from_date' AND '$to_date'");
        
        if($object_array){
            foreach ($object_array as $stock){
            $total_quantity = $stock->quantity + $total_quantity ;
            }
        }

        return $total_quantity;
    }

    public static function get_writeOff_quantity_by_day($class_name, $from_date, $to_date, $p_code){
        global $database;
        $total_quantity = 0;
        $from_date = $database->escape_value($from_date);
        $to_date = $database->escape_value($to_date);
        $p_code = $database->escape_value($p_code);
        $table_name = $class_name :: $table_name;

        $object_array = $class_name::find_by_sql("SELECT write_off_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND DATE(datetime) BETWEEN '$from_date' AND '$to_date'");
        
        if($object_array){
            foreach ($object_array as $stock){
            $total_quantity = $stock->write_off_quantity + $total_quantity ;
            }
        }
        
        return $total_quantity;
    }

    public static function get_stock_transfer_quantity_by_day($class_name, $from_date, $to_date, $p_code){
        global $database;
        $total_quantity = 0;
        $from_date = $database->escape_value($from_date);
        $to_date = $database->escape_value($to_date);
        $p_code = $database->escape_value($p_code);
        $table_name = $class_name :: $table_name;

        $object_array = $class_name::find_by_sql("SELECT stock_transfer_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND DATE(datetime) BETWEEN '$from_date' AND '$to_date'");
        
        if($object_array){
            foreach ($object_array as $stock){
            $total_quantity = $stock->stock_transfer_quantity + $total_quantity ;
            }
        }
        
        return $total_quantity;
    }

    //With Branches

    public static function get_stock_transfer_quantity_by_year_month_wise($class_name, $year, $branch_id, $p_code){
      global $database;
      
      $data_array = [];
      $branch_condition = '';
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;
      
      if($branch_id != NULL){
        $branch_condition = "AND branch_id = $branch_id ";
      }

      for($month = 1; $month <= 12; $month++){
        $monthly_quantity = 0;
        $object_array = $class_name::find_by_sql("SELECT stock_transfer_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year' AND MONTH(datetime) = '$month'".$branch_condition);
        
        if($object_array){
            foreach ($object_array as $stock){
                $monthly_quantity = $stock->stock_transfer_quantity + $monthly_quantity ;
            }
        }
        $data_array[$month] = $monthly_quantity;
      }
      return $data_array;
    }

    public static function get_stock_transfer_quantity_by_branch_year_month_day_wise($class_name, $month, $year, $branch_id, $p_code){
      global $database;
      
      $data_array = [];
      $branch_condition = '';
      $month = $database->escape_value($month);
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;
      $days_in_month=cal_days_in_month(CAL_GREGORIAN,$_POST['search_month'],$_POST['search_year']);
      
      if($branch_id != NULL){
        $branch_condition = "AND branch_id = $branch_id ";
      }

      for($day = 1; $day <= $days_in_month; $day++){
        $daily_quantity = 0;
        $object_array = $class_name::find_by_sql("SELECT stock_transfer_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year' AND MONTH(datetime) = '$month' AND DAY(datetime) = '$day'".$branch_condition);
        
        if($object_array){
            foreach ($object_array as $stock){
                $daily_quantity = $stock->stock_transfer_quantity + $daily_quantity ;
            }
        }
        $data_array[$day] = $daily_quantity;
      }
      return $data_array;
    }

    public static function get_stock_transfer_quantity_by_branch_day_wise($class_name, $from_date, $to_date, $branch_id,$p_code){
        global $database;
        $total_quantity = 0;
        $branch_condition = '';
        $from_date = $database->escape_value($from_date);
        $to_date = $database->escape_value($to_date);
        $p_code = $database->escape_value($p_code);
        $table_name = $class_name :: $table_name;

        if($branch_id != NULL){
          $branch_condition = "AND branch_id = $branch_id ";
        }

        $object_array = $class_name::find_by_sql("SELECT datetime,stock_transfer_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND DATE(datetime) BETWEEN '$from_date' AND '$to_date'".$branch_condition);

        $period = new DatePeriod(
            new DateTime($from_date),
            new DateInterval('P1D'),
            new DateTime($to_date)
        );
        $data_array = [];
        foreach ($period as $key => $value) {
            $period_date = $value->format('Y-m-d');
            $qty = 0;
            if($object_array){
                foreach($object_array as $row){
                    $date = explode(' ',$row->datetime)[0];
                    if($date == $period_date){
                        $qty += $row->stock_transfer_quantity;
                    }
                }
            }
            $data_array[$period_date] = $qty;
        }
        return $data_array;
    }

    public static function get_quantity_by_branch_year_month_wise($class_name, $year, $branch_id, $p_code){
      global $database;
      
      $data_array = [];
      $branch_condition = '';
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;
    
      if($branch_id != NULL){
          $branch_condition = "AND branch_id = $branch_id ";
      }

      for($month = 1; $month <= 12; $month++){
        $monthly_quantity = 0;
        $object_array = $class_name::find_by_sql("SELECT quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year' AND MONTH(datetime) = '$month'".$branch_condition);
        
        if($object_array){
            foreach ($object_array as $stock){
                $monthly_quantity = $stock->quantity + $monthly_quantity ;
            }
        }
        $data_array[$month] = $monthly_quantity;
      }
      return $data_array;
    }

    public static function get_quantity_by_branch_year_month_day_wise($class_name, $month, $year, $branch_id, $p_code){
      global $database;
      
      $data_array = [];
      $branch_condition = '';
      $month = $database->escape_value($month);
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;
      $days_in_month=cal_days_in_month(CAL_GREGORIAN,$_POST['search_month'],$_POST['search_year']);
      
      if($branch_id != NULL){
        $branch_condition = "AND branch_id = $branch_id ";
      }

      for($day = 1; $day <= $days_in_month; $day++){
        $daily_quantity = 0;
        $object_array = $class_name::find_by_sql("SELECT quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year' AND MONTH(datetime) = '$month' AND DAY(datetime) = '$day'".$branch_condition);
        
        if($object_array){
            foreach ($object_array as $stock){
                $daily_quantity = $stock->quantity + $daily_quantity ;
            }
        }
        $data_array[$day] = $daily_quantity;
      }
      return $data_array;
    }

    public static function get_quantity_by_branch_day_wise($class_name, $from_date, $to_date, $branch_id,$p_code){
        global $database;
        $total_quantity = 0;
        $branch_condition = '';
        $from_date = $database->escape_value($from_date);
        $to_date = $database->escape_value($to_date);
        $p_code = $database->escape_value($p_code);
        $table_name = $class_name :: $table_name;

        if($branch_id != NULL){
          $branch_condition = "AND branch_id = $branch_id ";
        }

        $object_array = $class_name::find_by_sql("SELECT datetime,quantity FROM ".$table_name." WHERE p_code = '$p_code' AND DATE(datetime) BETWEEN '$from_date' AND '$to_date'".$branch_condition);

        $period = new DatePeriod(
            new DateTime($from_date),
            new DateInterval('P1D'),
            new DateTime($to_date)
        );
        $data_array = [];
        foreach ($period as $key => $value) {
            $period_date = $value->format('Y-m-d');
            $qty = 0;
            if($object_array){
                foreach($object_array as $row){
                    $date = explode(' ',$row->datetime)[0];
                    if($date == $period_date){
                        $qty += $row->quantity;
                    }
                }
            }
            $data_array[$period_date] = $qty;
        }
        return $data_array;
    }

    public static function get_write_off_quantity_by_branch_year_month_day_wise($class_name, $month, $year, $branch_id, $p_code){
      global $database;
      
      $data_array = [];
      $branch_condition = '';
      $month = $database->escape_value($month);
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;
      $days_in_month=cal_days_in_month(CAL_GREGORIAN,$_POST['search_month'],$_POST['search_year']);
      
      if($branch_id != NULL){
        $branch_condition = "AND branch_id = $branch_id ";
      }

      for($day = 1; $day <= $days_in_month; $day++){
        $daily_quantity = 0;
        $object_array = $class_name::find_by_sql("SELECT write_off_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year' AND MONTH(datetime) = '$month' AND DAY(datetime) = '$day'".$branch_condition);
        
        if($object_array){
            foreach ($object_array as $stock){
                $daily_quantity = $stock->write_off_quantity + $daily_quantity ;
            }
        }
        $data_array[$day] = $daily_quantity;
      }
      return $data_array;
    }

    public static function get_write_off_quantity_by_branch_year_month_wise($class_name, $year, $branch_id, $p_code){
      global $database;
      
      $data_array = [];
      $branch_condition = '';
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;
    
      if($branch_id != NULL){
          $branch_condition = "AND branch_id = $branch_id ";
      }

      for($month = 1; $month <= 12; $month++){
        $monthly_quantity = 0;
        $object_array = $class_name::find_by_sql("SELECT write_off_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year' AND MONTH(datetime) = '$month'".$branch_condition);
        
        if($object_array){
            foreach ($object_array as $stock){
                $monthly_quantity = $stock->write_off_quantity + $monthly_quantity ;
            }
        }
        $data_array[$month] = $monthly_quantity;
      }
      return $data_array;
    }

    public static function get_write_off_quantity_by_branch_day_wise($class_name, $from_date, $to_date, $branch_id, $p_code){
        global $database;
        $total_quantity = 0;
        $branch_condition = '';
        $from_date = $database->escape_value($from_date);
        $to_date = $database->escape_value($to_date);
        $p_code = $database->escape_value($p_code);
        $table_name = $class_name :: $table_name;

        if($branch_id != NULL){
          $branch_condition = "AND branch_id = $branch_id ";
        }

        $object_array = $class_name::find_by_sql("SELECT datetime,write_off_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND DATE(datetime) BETWEEN '$from_date' AND '$to_date'".$branch_condition);

        $period = new DatePeriod(
            new DateTime($from_date),
            new DateInterval('P1D'),
            new DateTime($to_date)
        );
        $data_array = [];
        foreach ($period as $key => $value) {
            $period_date = $value->format('Y-m-d');
            $qty = 0;
            if($object_array){
                foreach($object_array as $row){
                    $date = explode(' ',$row->datetime)[0];
                    if($date == $period_date){
                        $qty += $row->write_off_quantity;
                    }
                }
            }
            $data_array[$period_date] = $qty;
        }
        return $data_array;
    }

    //
    public static function get_quantity_by_year_month_wise_year($year, $p_code,$branch_id){
      global $database;
      
      $data_array = [];
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $branch_condition = '';
      if($branch_id != 0){
        $branch_condition = "AND invoice.invoice_branch = $branch_id ";
      }

      for($month = 1; $month <= 12; $month++){
        $monthly_quantity = 0;
        $monthly_volume  = 0;
        $object_array=InvoiceSub::find_by_sql("SELECT * FROM invoice_sub INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type = 1 AND invoice_sub.code = '$p_code' AND YEAR(invoice.invoice_date) = '$year' AND MONTH(invoice.invoice_date) = '$month' ".$branch_condition);
        
        if(count($object_array) > 0){
          foreach($object_array as $obj)
          {
            $monthly_volume = $monthly_volume + $obj->qty;
          }
        }    
        $data_array[$month] = $monthly_volume;
      }

      return $data_array;
    }

    public static function get_quantity_by_year_month_day_wise_Sales($month, $year, $p_code,$branch_id){
      global $database;
      
      $data_array = [];
      $month = $database->escape_value($month);
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $days_in_month=cal_days_in_month(CAL_GREGORIAN,$_POST['search_month'],$_POST['search_year']);

      $branch_condition = '';
      if($branch_id != 0){
        $branch_condition = "AND invoice.invoice_branch = $branch_id ";
      }

      for($day = 1; $day <= $days_in_month; $day++){
        $daily_quantity = 0;
        $monthly_volume  = 0;
        
        $object_array=InvoiceSub::find_by_sql("SELECT * FROM invoice_sub INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type = 1 AND invoice_sub.code = '$p_code' AND YEAR(invoice.invoice_date) = '$year' AND MONTH(invoice.invoice_date) = '$month' AND DAY(invoice.invoice_date) = '$day' ".$branch_condition);
        
        if(count($object_array) > 0){
          foreach($object_array as $obj)
          {
            $monthly_volume = $monthly_volume + $obj->qty;
          }
        }
        $data_array[$day] = $monthly_volume;
      }
      return $data_array;
    }

    public static function get_quantity_day_wise_Sales($from_date, $to_date, $p_code, $branch_id){
      global $database;
      
      $total_quantity = 0;
      $from_date = $database->escape_value($from_date);
      $to_date = $database->escape_value($to_date);
      $p_code = $database->escape_value($p_code);

      $branch_condition = '';
      if($branch_id != 0){
        $branch_condition = "AND invoice.invoice_branch = $branch_id ";
      }

      $object_array = InvoiceSub::find_by_sql("SELECT invoice_sub.* FROM invoice_sub LEFT JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type = 1 AND invoice_sub.code = '$p_code' AND DATE(invoice.invoice_date) BETWEEN '$from_date' AND '$to_date' ".$branch_condition);
    
      $period = new DatePeriod(
          new DateTime($from_date),
          new DateInterval('P1D'),
          new DateTime($to_date)
      );
      $data_array = [];
      foreach ($period as $key => $value) {
          $period_date = $value->format('Y-m-d');
          $qty2 = 0;
          if($object_array){
              foreach($object_array as $row){
                $object_array_invoice = Invoice::find_by_sql("SELECT * FROM invoice LEFT JOIN invoice_sub ON invoice.id = invoice_sub.invoice_id WHERE invoice.id = $row->invoice_id");
                  $date = explode(' ',$object_array_invoice[0]->invoice_date)[0];
                  if($date == $period_date){
                    $qty2 += $row->qty;
                }
              }
          }
          $data_array[$period_date] = $qty2;
        }
        return $data_array;
    }
    public static function get_quantity_by_year_branch($class_name, $year, $branch_id, $p_code){
      global $database;
      $total_quantity = 0;
      $branch_condition = '';
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;

      if($branch_id != NULL){
        $branch_condition = "AND branch_id = $branch_id ";
      }

      $object_array = $class_name::find_by_sql("SELECT quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year'".$branch_condition);

      if($object_array){
        foreach ($object_array as $stock){
          $total_quantity = $stock->quantity + $total_quantity ;
        }
      }

      return $total_quantity;
    }

    public static function get_writeOff_quantity_by_year_branch($class_name, $year, $branch_id, $p_code){
      global $database;
      $total_quantity = 0;
      $branch_condition = '';
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;

      if($branch_id != NULL){
        $branch_condition = "AND branch_id = $branch_id ";
      }

      $object_array = $class_name::find_by_sql("SELECT write_off_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year'".$branch_condition);

      if($object_array){
        foreach ($object_array as $stock){
          $total_quantity = $stock->write_off_quantity + $total_quantity ;
        }
      }

      return $total_quantity;
    }

    public static function get_stock_transfer_quantity_by_year_branch($class_name, $year, $branch_id, $p_code){
      global $database;
      $total_quantity = 0;
      $branch_condition = '';
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;

      if($branch_id != NULL){
        $branch_condition = "AND branch_id = $branch_id ";
      }

      $object_array = $class_name::find_by_sql("SELECT stock_transfer_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year'".$branch_condition);

      if($object_array){
        foreach ($object_array as $stock){
          $total_quantity = $stock->stock_transfer_quantity + $total_quantity ;
        }
      }

      return $total_quantity;
    }

    public static function find_S_R_product_usage_by_year_branch_month_wise($year, $branch_id, $p_code, $item_type){
        global $database;
        $year = $database->escape_value($year);
        $branch_id = $database->escape_value($branch_id);
        $p_code = $database->escape_value($p_code);
        
        $data_array = [];
        $branch_condition = '';
        if($branch_id != NULL){
          $branch_condition = "AND invoice.invoice_branch = '$branch_id' ";
        }

        $total_volume = 0;
        foreach(ProductUsageServices::find_all() as $service_product){
          $product_codes = explode(",", $service_product->p_use_code);
          $product_volumes = explode(",", $service_product->volume);

          foreach($product_codes as $key=>$value){
            $product_code = trim($value);

            if($product_code == $p_code){
              for($month = 1; $month <= 12; $month++){
                $monthly_volume = 0;
                $object_array=InvoiceSub::find_by_sql("SELECT * FROM invoice_sub INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type = '$item_type' AND invoice_sub.code = '$service_product->p_code' AND MONTH(invoice.invoice_date) = '$month' AND YEAR(invoice.invoice_date) = '$year' ".$branch_condition);

                
                

                if(count($object_array) > 0){
                  $monthly_volume = 0;
                  foreach($object_array as $obj){
                    $monthly_volume = $monthly_volume + $product_volumes[$key] * $obj->qty;
                  }
                }
                $data_array[$month] = $monthly_volume;
              }
            }
          }
        }
        return $data_array;
    }

    public static function get_quantity_by_month_year_branch($class_name, $month, $year, $branch_id, $p_code){
      global $database;
      $total_quantity = 0;
      $branch_condition = '';
      $month = $database->escape_value($month);
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;

      if($branch_id != NULL){
        $branch_condition = "AND branch_id = $branch_id ";
      }

      $object_array = $class_name::find_by_sql("SELECT quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year' AND MONTH(datetime) = '$month' ".$branch_condition);
      if($object_array){
        foreach ($object_array as $stock){
          $total_quantity = $stock->quantity + $total_quantity ;
        }
      }

      return $total_quantity;
    }

    public static function find_S_R_product_usage_by_year_branch_month_day_wise($month, $year, $branch_id, $p_code, $item_type){
        global $database;
        $year = $database->escape_value($year);
        $branch_id = $database->escape_value($branch_id);
        $p_code = $database->escape_value($p_code);

        $data_array = [];
        $branch_condition = '';
        if($branch_id != NULL){
          $branch_condition = "AND invoice.invoice_branch = '$branch_id' ";
        }
        $days_in_month=cal_days_in_month(CAL_GREGORIAN,$_POST['search_month'],$_POST['search_year']);
        $daily_volume = 0;
        $total_volume = 0;
        foreach(ProductUsageServices::find_all() as $service_product){
          $product_codes = explode(",", $service_product->p_use_code);
          $product_volumes = explode(",", $service_product->volume);

          foreach($product_codes as $key=>$value){
            $product_code = trim($value);

            if($product_code == $p_code){
              for($day = 1; $day <= $days_in_month; $day++){
                $daily_volume = 0;
                $object_array=InvoiceSub::find_by_sql("SELECT * FROM invoice_sub INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type = '$item_type' AND invoice_sub.code = '$service_product->p_code' AND MONTH(invoice.invoice_date) = '$month' AND YEAR(invoice.invoice_date) = '$year' AND DAY(invoice.invoice_date) = '$day'".$branch_condition);

                if(count($object_array) > 0){
                  $daily_volume = 0;
                  foreach($object_array as $obj){
                    $daily_volume = $daily_volume + $product_volumes[$key] * $obj->qty;
                  }
                }
                $data_array[$day] = $daily_volume;
              }
            }
          }
        }
        return $data_array;
    }

    public static function get_stock_transfer_quantity_by_year_month_branch($class_name, $month, $year, $branch_id, $p_code){
      global $database;
      $total_quantity = 0;
      $branch_condition = '';
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;

      if($branch_id != NULL){
        $branch_condition = "AND branch_id = $branch_id ";
      }

      $object_array = $class_name::find_by_sql("SELECT stock_transfer_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year' AND MONTH(datetime) = '$month' ".$branch_condition);

      if($object_array){
        foreach ($object_array as $stock){
          $total_quantity = $stock->stock_transfer_quantity + $total_quantity ;
        }
      }

      return $total_quantity;
    }

    public static function get_write_off_transfer_quantity_by_year_month_branch($class_name, $month, $year, $branch_id, $p_code){
      global $database;
      $total_quantity = 0;
      $branch_condition = '';
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;

      if($branch_id != NULL){
        $branch_condition = "AND branch_id = $branch_id ";
      }

      $object_array = $class_name::find_by_sql("SELECT write_off_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year' AND MONTH(datetime) = '$month' ".$branch_condition);

      if($object_array){
        foreach ($object_array as $stock){
          $total_quantity = $stock->write_off_quantity + $total_quantity ;
        }
      }

      return $total_quantity;
    }

    public static function get_quantity_by_year_month_branch($class_name, $month, $year, $branch_id, $p_code){
      global $database;
      $total_quantity = 0;
      $branch_condition = '';
      $year = $database->escape_value($year);
      $p_code = $database->escape_value($p_code);
      $table_name = $class_name :: $table_name;

      if($branch_id != NULL){
        $branch_condition = "AND branch_id = $branch_id ";
      }

      $object_array = $class_name::find_by_sql("SELECT quantity FROM ".$table_name." WHERE p_code = '$p_code' AND YEAR(datetime) = '$year' AND MONTH(datetime) = '$month' ".$branch_condition);

      if($object_array){
        foreach ($object_array as $stock){
          $total_quantity = $stock->quantity + $total_quantity ;
        }
      }

      return $total_quantity;
    }

    //

    public static function get_quantity_by_day_branch($class_name, $from_date, $to_date, $branch_id, $p_code){
        global $database;
        $total_quantity = 0;
        $branch_condition = '';
        $from_date = $database->escape_value($from_date);
        $to_date = $database->escape_value($to_date);
        $p_code = $database->escape_value($p_code);
        $table_name = $class_name :: $table_name;

        if($branch_id != NULL){
          $branch_condition = "AND branch_id = $branch_id ";
        }

        $object_array = $class_name::find_by_sql("SELECT quantity FROM ".$table_name." WHERE p_code = '$p_code' AND DATE(datetime) BETWEEN '$from_date' AND '$to_date' ".$branch_condition);
        
        if($object_array){
            foreach ($object_array as $stock){
              $total_quantity = $stock->quantity + $total_quantity ;
            }
        }

        return $total_quantity;
    }

    public static function find_S_R_product_usage_by_year_day_wise($from_date, $to_date, $branch_id, $p_code, $item_type){
        global $database;
        // $year = $database->escape_value($year);
        $branch_id = $database->escape_value($branch_id);
        $p_code = $database->escape_value($p_code);

        $data_array = [];
        $branch_condition = '';
        if($branch_id != NULL){
          $branch_condition = "AND invoice.invoice_branch = '$branch_id' ";
        }

        $period = new DatePeriod(
            new DateTime($from_date),
            new DateInterval('P1D'),
            new DateTime($to_date)
        );
        
        $daily_volume = 0;
        $total_volume = 0;
        foreach(ProductUsageServices::find_all() as $service_product){
          $product_codes = explode(",", $service_product->p_use_code);
          $product_volumes = explode(",", $service_product->volume);
          
          foreach($product_codes as $key1=>$value1){
            $product_code = trim($value1);

            if($product_code == $p_code){
              foreach ($period as $key => $value) {
                $period_date = $value->format('Y-m-d');
                
                $object_array=InvoiceSub::find_by_sql("SELECT invoice_sub.*, invoice.invoice_date FROM invoice_sub LEFT JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type = '$item_type' AND invoice_sub.code = '$service_product->p_code' AND DATE(invoice.invoice_date) BETWEEN '$from_date' AND '$to_date' ".$branch_condition);
                
                if(count($object_array) > 0){
                  $daily_volume = 0;
                  foreach($object_array as $row){
                    $pro = Invoice::find_by_id($row->invoice_id);
                    $date = explode(' ',$pro->invoice_date)[0];
                    if($date == $period_date){
                        $daily_volume = $daily_volume + $product_volumes[$key1] * $row->qty;
                        // $daily_volume += $row->qty;
                    }
                  }
                }
                $data_array[$period_date] = $daily_volume;
              }
            }
          }
        }
        return $data_array;
    }


    public static function get_writeOff_quantity_by_day_branch($class_name, $from_date, $to_date, $branch_id, $p_code){
        global $database;
        $total_quantity = 0;
        $branch_condition = '';
        $from_date = $database->escape_value($from_date);
        $to_date = $database->escape_value($to_date);
        $p_code = $database->escape_value($p_code);
        $table_name = $class_name :: $table_name;

        if($branch_id != NULL){
          $branch_condition = "AND branch_id = $branch_id ";
        }

        $object_array = $class_name::find_by_sql("SELECT write_off_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND DATE(datetime) BETWEEN '$from_date' AND '$to_date' ".$branch_condition);
        
        if($object_array){
            foreach ($object_array as $stock){
              $total_quantity = $stock->write_off_quantity + $total_quantity ;
            }
        }

        return $total_quantity;
    }

    public static function get_stock_transfer_quantity_by_day_branch($class_name, $from_date, $to_date, $branch_id, $p_code){
        global $database;
        $total_quantity = 0;
        $branch_condition = '';
        $from_date = $database->escape_value($from_date);
        $to_date = $database->escape_value($to_date);
        $p_code = $database->escape_value($p_code);
        $table_name = $class_name :: $table_name;

        if($branch_id != NULL){
          $branch_condition = "AND branch_id = $branch_id ";
        }

        $object_array = $class_name::find_by_sql("SELECT stock_transfer_quantity FROM ".$table_name." WHERE p_code = '$p_code' AND DATE(datetime) BETWEEN '$from_date' AND '$to_date' ".$branch_condition);
        
        if($object_array){
            foreach ($object_array as $stock){
              $total_quantity = $stock->stock_transfer_quantity + $total_quantity ;
            }
        }

        return $total_quantity;
    }

    public static function find_S_R_colour_usage_by_year_branch_month_wise($year, $branch_id, $p_code, $item_type){
        global $database;
        $year = $database->escape_value($year);
        $branch_id = $database->escape_value($branch_id);
        $p_code = $database->escape_value($p_code);

          // print_r($branch_id);
          // die;
        $data_array = [];
        $branch_condition = '';
        if($branch_id != NULL){
          $branch_condition = "AND invoice.invoice_branch = '$branch_id' ";
        }
        
        for($month=1; $month<=12; $month++) {
          
          $item_data=InvoiceSub::find_by_sql("SELECT * FROM invoice_sub INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type = '$item_type' AND (invoice_sub.color = '$p_code' OR invoice_sub.color2 = '$p_code' OR invoice_sub.color3 = '$p_code' OR invoice_sub.color4 = '$p_code' OR invoice_sub.color5 = '$p_code') AND MONTH(invoice.invoice_date) = '$month' AND YEAR(invoice.invoice_date) = '$year' ".$branch_condition);

          // print_r();

            // print_r("SELECT * FROM invoice_sub INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type = '$item_type' AND (invoice_sub.color = '$p_code' OR invoice_sub.color2 = '$p_code' OR invoice_sub.color3 = '$p_code' OR invoice_sub.color4 = '$p_code' OR invoice_sub.color5 = '$p_code') AND MONTH(invoice.invoice_date) = '$month' AND YEAR(invoice.invoice_date) = '$year' ".$branch_condition);
            // die; 
          
          $month_total = 0;
          foreach($item_data as $item){
            $percentage = 0;
            if($item->color == $p_code){
              $percentage = $item->percentage;
            }
            if($item->color2 == $p_code){
              $percentage = $item->percentage2;
            }
            if($item->color3 == $p_code){
              $percentage = $item->percentage3;
            }
            if($item->color4 == $p_code){
              $percentage = $item->percentage4;
            }
            if($item->color5 == $p_code){
              $percentage = $item->percentage5;
            }
            //  print_r($item);

            $color_tube = ColourTube::find_by_sql("SELECT * FROM colour_tube where code = '$p_code'");
            $month_total = $month_total+(floatval($percentage) * floatval($color_tube[0]->capacity) * 0.01) * $item->qty ;
            // print_r("SELECT * FROM colour_tube where code = '$p_code'");
            // die;  
          }

          $data_array[$month] = $month_total;
        }

        return $data_array;
    }

    public static function find_S_R_colour_usage_by_year_branch_month_day_wise($month, $year, $branch_id, $p_code, $item_type){
        global $database;
        $month = $database->escape_value($month);
        $year = $database->escape_value($year);
        $branch_id = $database->escape_value($branch_id);
        $p_code = $database->escape_value($p_code);
       
        $data_array = [];
        $branch_condition = '';
        if($branch_id != NULL){
          $branch_condition = "AND invoice.invoice_branch = '$branch_id' ";
        }
        
        $days_in_month=cal_days_in_month(CAL_GREGORIAN,$_POST['search_month'],$_POST['search_year']);

        for($day = 1; $day <= $days_in_month; $day++){
          
          $item_data=InvoiceSub::find_by_sql("SELECT * FROM invoice_sub INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type = '$item_type' AND (invoice_sub.color = '$p_code' OR invoice_sub.color2 = '$p_code' OR invoice_sub.color3 = '$p_code' OR invoice_sub.color4 = '$p_code' OR invoice_sub.color5 = '$p_code') AND MONTH(invoice.invoice_date) = '$month' AND DAY(invoice.invoice_date) = '$day' AND YEAR(invoice.invoice_date) = '$year' ".$branch_condition);

          $month_total = 0;
          foreach($item_data as $item){
            $percentage = 0;
            if($item->color == $p_code){
              $percentage = $item->percentage;
            }
            if($item->color2 == $p_code){
              $percentage = $item->percentage2;
            }
            if($item->color3 == $p_code){
              $percentage = $item->percentage3;
            }
            if($item->color4 == $p_code){
              $percentage = $item->percentage4;
            }
            if($item->color5 == $p_code){
              $percentage = $item->percentage5;
            }

            $color_tube = ColourTube :: find_by_sql("SELECT * FROM colour_tube where code = '$p_code'");
            $month_total = $month_total+(floatval($percentage) * floatval($color_tube[0]->capacity) * 0.01) * $item->qty ;
          }

          $data_array[$day] = $month_total;
        }

        return $data_array;
    }

    public static function find_S_R_colour_usage_by_year_branch_day_wise($from_date, $to_date, $branch_id, $p_code, $item_type){
        global $database;
        $from_date = $database->escape_value($from_date);
        $to_date = $database->escape_value($to_date);
        $p_code = $database->escape_value($p_code);
        $branch_id = $database->escape_value($branch_id);

        $data_array = [];
        $branch_condition = '';
        if($branch_id != NULL){
          $branch_condition = "AND invoice.invoice_branch = '$branch_id' ";
        }
        
        $period = new DatePeriod(
            new DateTime($from_date),
            new DateInterval('P1D'),
            new DateTime($to_date)
        );

        foreach ($period as $key => $value) {
          $period_year = $value->format('Y');
          $period_month = $value->format('m');
          $period_day = $value->format('d');
          $period_date = $value->format('Y-m-d');

          $item_data=InvoiceSub::find_by_sql("SELECT * FROM invoice_sub INNER JOIN invoice ON invoice_sub.invoice_id = invoice.id WHERE invoice_sub.item_type = '$item_type' AND (invoice_sub.color = '$p_code' OR invoice_sub.color2 = '$p_code' OR invoice_sub.color3 = '$p_code' OR invoice_sub.color4 = '$p_code' OR invoice_sub.color5 = '$p_code') AND MONTH(invoice.invoice_date) = '$period_month' AND DAY(invoice.invoice_date) = '$period_day' AND YEAR(invoice.invoice_date) = '$period_year' ".$branch_condition);

          $month_total = 0;
          foreach($item_data as $item){
            $percentage = 0;
            if($item->color == $p_code){
              $percentage = $item->percentage;
            }
            if($item->color2 == $p_code){
              $percentage = $item->percentage2;
            }
            if($item->color3 == $p_code){
              $percentage = $item->percentage3;
            }
            if($item->color4 == $p_code){
              $percentage = $item->percentage4;
            }
            if($item->color5 == $p_code){
              $percentage = $item->percentage5;
            }

            $color_tube = ColourTube :: find_by_sql("SELECT * FROM colour_tube where code = '$p_code'");
            $month_total = $month_total+(floatval($percentage) * floatval($color_tube[0]->capacity) * 0.01) * $item->qty ;
          }

          $data_array[$period_date] = $month_total;
        }

        return $data_array;
    }

    public static function getCancelledBillRecordsByYear($year, $branch_id){
      global $database;
      $branch_condition = '';
      $year = $database->escape_value($year);

      if($branch_id != NULL){
        $branch_condition = "AND invoice_branch = $branch_id ";
      }
      $object_array = CancelledBill::find_by_sql("SELECT * FROM deleted_invoices WHERE YEAR(invoice_date) = '$year'".$branch_condition);

      return $object_array;
    }

    public static function getCancelledBillRecordsByMonthYear($month, $year, $branch_id){
      global $database;
      $branch_condition = '';
      $year = $database->escape_value($year);
      $month = $database->escape_value($month);

      if($branch_id != NULL){
        $branch_condition = "AND invoice_branch = $branch_id ";
      }
      $object_array = CancelledBill::find_by_sql("SELECT * FROM deleted_invoices WHERE YEAR(invoice_date) = '$year' AND MONTH(invoice_date) = '$month'".$branch_condition);

      // echo "<pre>";
      // print_r($object_array);
      // die;
      return $object_array;
    }

    public static function getCancelledBillRecordsByDates($from_date, $to_date, $branch_id){
      global $database;
      $branch_condition = '';
      $from_date = $database->escape_value($from_date);
      $to_date = $database->escape_value($to_date);

      if($branch_id != NULL){
        $branch_condition = "AND invoice_branch = $branch_id ";
      }
      $object_array = CancelledBill::find_by_sql("SELECT * FROM deleted_invoices WHERE DATE(invoice_date) BETWEEN '$from_date' AND '$to_date' ".$branch_condition);

      // echo "<pre>";
      // print_r($object_array);
      // die;
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
