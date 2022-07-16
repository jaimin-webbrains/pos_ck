<?php
require_once __DIR__.'/../util/initialize.php';

class Product extends DatabaseObject{
  protected static $table_name="product";
  protected static $db_fields=array();
  protected static $db_fk=array("brand"=>"ProductCategory");

  public function brand(){
    return parent::get_fk_object("brand");
  }

  public static function find_last_data(){
    global $database;
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." ORDER BY id DESC LIMIT 1 ");
    return array_shift($object_array);

  }

  public static function check_code($value){
    global $database;
    $value=$database->escape_value($value);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE code LIKE '$value%' ");
    return $object_array;
  }

  public static function find_all_normal(){
    global $database;
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE brand != 1 ");
    return $object_array;
  }

  public static function find_all_other(){
    global $database;
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE brand = 1 ");
    return $object_array;
  }



}

?>
