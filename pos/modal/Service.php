<?php
require_once __DIR__.'/../util/initialize.php';

class Service extends DatabaseObject{
    protected static $table_name="service";
    protected static $db_fields=array();

    protected static $db_fk=array("category"=>"ServiceCategory");

//    public $id;
//    public $name;

     public function category()
    {
        return parent::get_fk_object("category");
    }

    public static function find_all_cat_id($value){
      global $database;
      $value=$database->escape_value($value);
      $object_array=self::find_by_sql(" SELECT * FROM ".self::$table_name." WHERE category='$value' ");
      return $object_array;
    }

    public static function find_by_code($value){
      global $database;
      $value=$database->escape_value($value);
      $object_array=self::find_by_sql(" SELECT * FROM ".self::$table_name." WHERE code = '$value' ");
      return array_shift($object_array);
    }

}

?>
