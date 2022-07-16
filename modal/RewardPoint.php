<?php
require_once __DIR__.'/../util/initialize.php';

class RewardPoint extends DatabaseObject{

    protected static $table_name="reward_point";
    protected static $db_fields=array();
    protected static $db_fk=array("customer_id"=>"Customer","referal_id"=>"Customer");

    public function customer_id()
    {
        return parent::get_fk_object("customer_id");
    }

    public function referal_id()
    {
        return parent::get_fk_object("referal_id");
    }

    public static function find_all_by_customer_id($value){
      global $database;
      $value=$database->escape_value($value);
      $object_array=self::find_by_sql(" SELECT * FROM ".self::$table_name." WHERE customer_id='$value' ");
      return $object_array;
    }

}
?>
