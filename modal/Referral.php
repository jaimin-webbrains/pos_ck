<?php
require_once __DIR__.'/../util/initialize.php';

class Referral extends DatabaseObject{
    protected static $table_name="referral";
    protected static $db_fields=array();
    protected static $db_fk=array("parent_customer"=>"Customer","child_customer"=>"Customer");

    public function parent_customer()
    {
        return parent::get_fk_object("parent_customer");
    }

    public function child_customer()
    {
        return parent::get_fk_object("child_customer");
    }

    public static function find_master($value){
      global $database;
      $value=$database->escape_value($value);
      $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE child_customer = '$value' ");
      return array_shift($object_array);
    }

}

?>
