<?php
require_once __DIR__.'/../util/initialize.php';

class Advertisment extends DatabaseObject{
    protected static $table_name="advertisment";
    protected static $db_fields=array();
     protected static $db_fk=array("");

     public static function find_last_advertisment_video(){
         global $database;
         $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE type = 2 ORDER BY id DESC LIMIT 1 ");
         return array_shift($object_array);
     }

     // public static function find_last_advertisment_image(){
     //     global $database;
     //     $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE type = 1 ORDER BY id DESC LIMIT 1 ");
     //     return array_shift($object_array);
     // }


     public static function find_last_advertisment_image(){
         global $database;
         $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE type = 1 ORDER BY id DESC LIMIT 1 ");
         return array_shift($object_array);
     }

     public static function find_all_by_images(){
       global $database;
       $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE type = 1 ");
       return $object_array;
     }


}

?>
